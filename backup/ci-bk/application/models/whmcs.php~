<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!class_exists('WHMCSException')) {
    class WHMCSException extends Exception {}
}

class WHMCS extends CI_Model
{
    private $multi_send_handles = array();

    private $_whmcs_url;
    private $_whmcs_username;
    private $_whmcs_passhash;
    private $ignreport_user = false;
    private $last_query = false;

    public function initialize(array $cred)
    {
        $this->_whmcs_url = $cred['url'];
        $this->_whmcs_username = $cred['usr'];
        $this->_whmcs_passhash = $cred['pwd'];
    }

    public function ignreport_error_user($ignore=true) {
        $this->ignreport_user = $ignore;
    }

    // Send normal synchronous WHMCS API request
    public function send($req, $fields=array(), $expect_xml=false, $dump=false)
    {
        $fields["action"]       = $req;
        $fields["responsetype"] = "json";

        # for error and session tracking
        $ci =& get_instance();
        $fields['x_sessionid'] = $ci->session->userdata('x_sessid');
        $fields['x_requestid'] = $ci->session->userdata('x_requestid');

        # for error reporting
        $this->last_query = json_encode($fields);

        $fields["username"] = $this->_whmcs_username;
        $fields["password"] = $this->_whmcs_passhash;

        $query_str = http_build_query($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_whmcs_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query_str);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $res_raw = curl_exec($ch);

        # check return code in case of some random fun error
        $resp_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($resp_code != 200) {
            $r = new stdClass;
            $r->result = 'error';
            $r->fatal = true;
            $r->message = "Connection Error: [HTTP {$resp_code}] ". strip_tags($res_raw);
            $obj = new AccountingResponse($r);
        }

        elseif (curl_error($ch))
        {
            $r = new stdClass;
            $r->result = 'error';
            $r->fatal = true;
            $r->message = "Connection Error: [". curl_errno($ch) .'] '. curl_error($ch);
            print $r->message;
            exit;
            $obj = new AccountingResponse($r);
        }

        else {
            # returns JSON or XML object
            $obj = $this->objectify_result($res_raw, $expect_xml);
        }

        if ($obj->is_error() && !$this->ignreport_user) {
            $this->report_error($obj);
        }

        curl_close($ch);
        $this->last_query = false;

        return $obj;
    }

    // Send WHMCS parallel API request
    public function send_parallel($id, $action, $fields=array(), $expect_xml=false)
    {

        $fields["username"] = $this->_whmcs_username;
        $fields["password"] = $this->_whmcs_passhash;
        $fields["action"]   = $action;
        $fields["responsetype"] = "json";

        $query_str = http_build_query($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_whmcs_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query_str);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $this->multi_send_handles[$id] = array($ch, $expect_xml);
    }

    public function exec_parallel()
    {

        if (empty($this->multi_send_handles))
        {
            return false;
        }

        $mh = curl_multi_init();
        foreach ($this->multi_send_handles as $id => $chr)
        {
           curl_multi_add_handle($mh, $chr[0]); # $chr[0] contains the CURL object
        }

        // execute the handles
        $active = null;
        do
        {
            $chs = curl_multi_exec($mh, $active);
        }
        while ($chs == CURLM_CALL_MULTI_PERFORM);

        // wait on handles to return
        while ($active && $chs == CURLM_OK)
        {
           if (curl_multi_select($mh) != -1)
           {
              do
              {
                 $chs = curl_multi_exec($mh, $active);
              }
              while ($chs == CURLM_CALL_MULTI_PERFORM);
           }
        }

        # grab results of each reqest
        $results = array();
        foreach ($this->multi_send_handles as $id => $req)
        {
            $results[$id] = curl_multi_getcontent($req[0]);
            $results[$id] = $this->objectify_result($results[$id], $req[1]); # JSON or XML object
        }

        # cleanup
        foreach ($this->multi_send_handles as $id => $req) {
           curl_multi_remove_handle($mh, $req[0]);
        }
        $this->multi_send_handles = array();
        curl_multi_close($mh);

        return $results;
    }

    private function objectify_result($res_raw, $expect_xml=false)
    {
       # JSON
       if (!$expect_xml)
       {
          $data = json_decode($res_raw);
          return new AccountingResponse($data);
       }

       # XML
       try
       {
           $xml_obj = new SerializableSimpleXMLElement($res_raw);
           return new AccountingResponse($xml_obj);
       }
       catch (Exception $e) {
           $r = new stdClass;
           $r->result = 'error';
           $r->message = sprintf("Unable to parse XML: %s", $res_raw);
           return new AccountingResponse($r);
       }
    }

    private function report_error($resp_obj)
    {
        # redirect('error');
        # return;
        # print '<pre>';
        # print_r($resp_obj);
        # print '</pre>';
    }
}


class SerializableSimpleXMLElement {
    private $sxe_object = null;
    private $xml_str = null;

    public function __construct($data, $options=0, $data_is_url=false, $ns='', $is_prefix=false) {
        $this->sxe_object = new SimpleXMLElement(
            $data, $options, $data_is_url, $ns, $is_prefix);
    }

    public function __call($method, $args) {
        return call_user_func_array(array($this->sxe_object, $method), $args);
    }

    public function __get($name) {
        return $this->sxe_object->{$name};
    }

    public function __isset($name) {
        return isset($this->sxe_object->{$name});
    }

    public function __set($name, $value) {
        $this->sxe_object->{$name} = $value;
    }

    public function __unset($name) {
        unset($this->sxe_object->{$name});
    }

    public function __sleep() {
        if (!is_null($this->sxe_object)) {
            $this->xml_str = $this->sxe_object->asXML();
        }
        return ['xml_str'];
    }

    public function __wakeup() {
        if (!is_null($this->xml_str)) {
            $this->sxe_object = simplexml_load_string($this->xml_str);
        }
    }
}
