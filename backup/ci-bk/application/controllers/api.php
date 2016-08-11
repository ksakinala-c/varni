<?php if (!defined('BASEPATH')) exit('Access denied.');

class Api extends X10_Controller {
    public function email($uri_email='') {
        $this->form_validation->set_error_delimiters('', '');

        $success = $message = $data = false;

        do
        {
            $uri_email = trim(strtolower($uri_email));
            if (empty($uri_email)) {
                $message = 'Invalid email address';
                break;
            }

            $email = str_replace('_', '@', $uri_email);

            # verify existence in WHMCS
            $do_create = false;
            $res = $this->accounting->auth->email_exists($email);

            if (!empty($res) && $res->is_error() && (
                    $res->get_error() == "Client Not Found")) {
                $do_create = true;
            }
            else if ($res->is_error()) {
                $message = 'Unable to retrieve API response from backend';
                break;
            }

            if (!$do_create) {
                $message = 'Account already exists';
                break;
            }

            # create client account
            $rand_pass = rand_string();  # TODO: Replace this to be better
            $res = $this->accounting->account->create(
                $email, $rand_pass, ['skipvalidation' => true]);

            if (empty($res) || $res->is_error()) {
                $message = 'Error creating account: '. $res->get_error();
                break;
            }

            $success = true;
            $message = 'Created account';
        }
        while (false);

        sleep(1);
        $this->ajax_output($success, $message, $data);
    }
}

function rand_string() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 10; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}
