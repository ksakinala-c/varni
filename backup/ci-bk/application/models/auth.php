<?php
if (!defined('BASEPATH')) exit('Access denied.');


class Auth extends CI_Model {
    const LOGIN_URL = '/sign-in';
    const REF_INT = 1800;  # refresh token every (seconds)

    private $fields = [
        'xv_token', 'xv_token_refresh',
        'xv_sess_id', 'xv_acct_id', 'xv_sess_ts', 'xv_email',
        'xv_passwd', 'xv_uname',
    ];

    private function is_datetime($v) {
        return is_object($v) && get_class($v) == 'DateTime';
    }

    private function write_session($name_or_array, $value=false) {
        # if caller passed an array of name=value pairs to write to auth session
        if (is_array($name_or_array)) {
            $write_arr = $name_or_array;

            # validate keys and values
            foreach ($write_arr as $k => $v) {
                # skip validation of datetime objects, it's okay to serialize them
                if ($this->is_datetime($v)) continue;

                if (!is_string($k) || !is_scalar($v)) {
                    print 'Invalid key or value to write_session key: '. $k;
                    exit;
                }
            }
        }

        # if caller passed a single, specific field name and value to write
        else {
            if ((!is_string($name_or_array) || !is_scalar($value)) && !$this->is_datetime($value)) {
                print 'Invalid key or value to write_session key: '. $name_or_array;
                exit;
            }
            $write_arr = [$name_or_array => $value];
        }

        $this->session->set_userdata($write_arr);
        return true;
    }

    private function retrieve_session() {
        # fetch all CI session data (may include things that we shouldn't see)
        $sess_all_data = $this->session->all_userdata();

        # return only session data that belongs to us, that we wrote
        $fields = array_fill_keys($this->fields, false);  # [all fields = false]
        $our_fields = array_intersect_key($sess_all_data, $fields);

        # merge the 'default' array (fields and their values false for all) with
        # the session auth fields that exist, so caller can rely on all fields
        # existing, even if possibly not set in actual session or empty
        $auth_fields = array_merge($fields, $our_fields);

        return $auth_fields;
    }

    public function start_session(
            $sess_id, $acct_id, $email, $uname = false, $passwd = false,
            $auth_token = false, $contact_id = 0) {

        # parameters from backend may be sourced from SimpleXMLElement etc -
        # you must always ensure they are scalar, otherwise sessions will break!

        # XXX: sess_id is for LOGS ONLY currently!
        # XXX: auth_token is unused 2016-03
        # XXX: contact_id is unused 2016-03

        # create new session array with empty (false) values for all fields
        $auth_fields = array_fill_keys($this->fields, false);

        # encrypt password before storing in session
        if (!empty($passwd)) {
            $e_passwd = $this->encrypt->encode(strval($passwd));
            $b64e_passwd = base64_encode($e_passwd);
        } else {
            $b64e_passwd = false;
        }

        $int = new DateInterval('PT'. self::REF_INT .'S');
        $auth_fields['xv_token_refresh'] = date_add(date_create(), $int);

        $auth_fields['xv_sess_ts'] = time();
        $auth_fields['xv_sess_id'] = strval($sess_id);
        $auth_fields['xv_acct_id'] = intval($acct_id);
        $auth_fields['xv_cntct_id'] = $contact_id;
        $auth_fields['xv_token'] = strval($auth_token);
        $auth_fields['xv_email'] = strval($email);
        $auth_fields['xv_uname'] = strval($uname);
        $auth_fields['xv_passwd'] = $b64e_passwd;

        return $this->write_session($auth_fields);
    }

    public function token_refresh_needed() {
        $af = $this->retrieve_session();
        $refresh_at = $af['xv_token_refresh'];

        # sanity check that the refresh field is a DateTime object
        if (!$this->is_datetime($refresh_at)) {
            # something is wrong, return that caller should refresh
            return true;
        }

        $now = new DateTime("now");
        return $now >= $refresh_at;
    }

    public function update_auth_token($token) {
        # sanity check token
        if (empty($token)) {
            return false;
        }

        # create future token refresh datetime
        $int = new DateInterval('PT'. self::REF_INT .'S');
        $refresh_at = date_add(date_create(), $int);

        $auth_fields = [];
        $auth_fields['xv_token_refresh'] = $refresh_at;
        $auth_fields['xv_token'] = $token;

        return $this->write_session($auth_fields);
    }

    public function end_session() {
        # create new session array with empty (false) values for all fields
        $sdata = array_fill_keys($this->fields, false);

        # overwrite all existing values
        return $this->write_session($sdata);
    }

    public function is_authenticated() {
        $af = $this->retrieve_session();

        $is_auth = (!empty($af['xv_acct_id']) && !empty($af['xv_sess_id']));

        # TODO: Validate session ID to account ID

        return $is_auth;
    }

    public function get_auth_token() {
        if (!$this->is_authenticated()) {
            return;
        }

        $af = $this->retrieve_session();
        $token = $af['xv_token'];
        if (empty($token)) {
            return false;
        }
        return $token;
    }

    public function redirect_if_auth($url=false) {
        if (!$this->is_authenticated()) {
            return;
        }

        if (empty($url))
            $url = site_url();

        redirect($url);
        exit;
    }

    public function redirect_if_not_auth($url=self::LOGIN_URL) {
        if ($this->is_authenticated()) {
            return;
        }

        redirect($url);
        exit;
    }

    public function dump_session() {
        $auth_fields = $this->retrieve_session();
        return $auth_fields;
    }

    public function get_userid($no_redir=false) {
        if (!$no_redir) {
            $this->redirect_if_not_auth();
        }

        $auth_fields = $this->retrieve_session();
        return $auth_fields['xv_acct_id'];
    }

    public function get_contactid($no_redir=false) {
        if (!$no_redir) {
            $this->redirect_if_not_auth();
        }

        $auth_fields = $this->retrieve_session();
        return $auth_fields['xv_cntct_id'];
    }

}
