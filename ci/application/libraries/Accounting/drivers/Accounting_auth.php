<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Accounting_auth extends CI_Driver
{
    private $whmcs;

    public function __construct()
    {
        $this->whmcs = get_instance()->whmcs;
    }

    public function __call($method, $args) {
        $cat_args = [];
        foreach ($args as $arg) {
            if (is_array($arg)) {
                $arg = array_map(function($value) {
                    return (gettype($value) == 'object') ? serialize($value) : strval($value);
                }, $arg);
                $arg = implode('_', $arg);
            } else {
                $arg = (gettype($arg) == 'object') ? serialize($arg) : strval($arg);
            }
            $cat_args[] = $arg;
        }
        $cat_args_params = compact_print_r($args, true);
        $cat_args = implode('_', $cat_args);

        # hash request info for cache fn
        list($_, $cls) = explode('_', __CLASS__);
        $fn_req_hash = $cls . '-'. $method .'-'. md5($cat_args) .'.txt';
        $fn_param_hash = $fn_req_hash .'-params';

        $hidden_method = '_hidden_'. $method;
        $result = call_user_func_array(array($this, $hidden_method), $args);

        // # then cache the resulting text into local file
        // file_put_contents(REQ_CACHE_DIR . $fn_req_hash, serialize($result));
        // file_put_contents(REQ_CACHE_DIR . $fn_param_hash, $cat_args_params);

        return $result;
    }

    public function _hidden_attempt($email, $password)
    {
        $fields = array();
        $fields['email'] = $email;
        $fields['password2'] = $password;
        $res_obj = $this->call('validatelogin', $fields);
        if ($res_obj->is_success()) $this->client_log('Successfully authenticated for frontend.');
        return $res_obj;
    }

    public function _hidden_reset($emailaddress)
    {
        if (empty($emailaddress))
        {
            return false;
        }
        $fields = array();
        $fields['useremail'] = $emailaddress;
        $res_obj = $this->call('cdpclientinitresetpass', $fields, true);
        return $res_obj;
    }

    public function _hidden_email_exists($email)
    {
        if (empty($email))
        {
            return false;
        }
        $fields = array();
        $fields['email'] = $email;
        return $this->call('getclientsdetails', $fields);
    }

    public function _hidden_reset_complete($emailaddress, $resetkey)
    {
        if (empty($emailaddress) || empty($resetkey))
        {
            return false;
        }
        $fields = array();
        $fields['useremail'] = $emailaddress;
        $fields['resetkey']  = $resetkey;
        return $this->call('cdpclientcompleteresetpass', $fields, true);
    }

    private function call($action, $fields, $type=false) {
        return $this->whmcs->send($action, $fields, $type);
    }

    public function _hidden_client_log($description) {

        $userid = get_instance()->auth->get_userid($no_redir=true);
        if (empty($userid)) {
            return;
        }

        $fields = array();
        $fields['userid'] = intval($userid);
        $fields['description'] = trim($description);
        $fields['ip'] = $_SERVER['REMOTE_ADDR'];
        $res = $this->call('logactivity', $fields);

        if ($res->is_error()) {
            $message = 'Unable to log message: '. $res->get_error() .'. Description: '. $description;
            $extra = get_instance()->x10_security->get_dump();
            $extra['ip'] = $_SERVER['REMOTE_ADDR'];
            Rollbar::report_message($message, 'warning', $extra);
            return;
        }
    }
}