<?php
if (!defined('BASEPATH')) exit('Access denied.');


class Signin extends X10_Controller {
    private $lookup_max_min = 30;

    public function index() {
        $this->init_template('Sign-in');

        # retrieve any PRG data and provide to template
        $prg = $this->retrieve_redirect(['email', 'password']);
        $this->with('prg', $prg);

        $this->view_template('page/signin/index');
    }

    public function error404() {
        http_response_code(404);
        $this->init_template('Page Not Found');
        $this->view_template('page/main/error404');
    }

    public function do_sign_in() {
        # disallow attempt if already logged in
        $this->auth->redirect_if_auth();

        # form not actually submitted
        if (!$this->input->post('do_signin'))
            $this->redirect_error('sign-in', false);  # redirect back to the sign-in page with no error message

        # validate submitted form fields
        $this->form_validation->set_rules('email', 'email address', 'required|maxlength[255]');
        $this->form_validation->set_rules('password', 'password', 'required|maxlength[255]');

        if (!$this->form_validation->run()) {
            # define our error message and an array of field-specific errors
            $errmsg = validation_errors();
            # redirect back with the error message
            $this->redirect_error('sign-in', $errmsg);
        }

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        # attempt auth against backend
        $res = $this->accounting->auth->attempt($email, $password);
        if (empty($res) || $res->is_error()) {
            $errmsg = $res->get_error();

            # a nicer message, perhaps
            if ($errmsg == "Email or Password Invalid")
                $errmsg = 'Invalid credentials provided.';

            $this->redirect_error('sign-in', $errmsg);
        }

        # we're successful - start session
        $data = $res->get_data();
        if (!$data) {
            $this->redirect_error(
                'sign-in', 'An unexpected error has occurred.');
        }

        $user_id = intval($data->userid);

        # generate a random session ID (for logs ONLY right now)
        $sess_id_bytes = openssl_random_pseudo_bytes(12, $safe);
        if (!$safe) {
            $errmsg = 'Unable to generate session ID, try again.';
            $this->redirect_error('sign-in', $errmsg);
        }

        # used for logging/tracking user activity
        $sess_id = $user_id .'-'. bin2hex($sess_id_bytes);

        # start the session
        $res = $this->auth->start_session($sess_id, $user_id, $email);
        if (!$res) {
            # something went wrong retrieving the user
            $errmsg = 'Unable to start session, please try again.';
            $this->redirect_error('sign-in', $errmsg);
        }

        $this->redirect_success('dashboard', "You're now signed in.");
    }

    public function do_sign_out() {
        # disallow attempt if not logged in
        $this->auth->redirect_if_not_auth();

        # XXX: Fix this, require POST to actually log out
        // if (!$this->input->post('do_sign_out'))
        //     $this->redirect_error('Error', false);  # redirect back to index

        $this->auth->end_session();

        $this->redirect_success('sign-in', "You're now signed out.");
    }

    # landing page from failed login, form to enter email for reset pass link
    public function reset_password() {
        $this->auth->redirect_if_auth('dashboard');

        $this->init_template('Reset Password');

        $prg = $this->retrieve_redirect(['email']);
        $this->with('prg', $prg);

        $this->view_template('page/signin/reset');
    }

    public function do_send_reset_password() {
        # disallow attempt if already logged in
        $this->auth->redirect_if_auth();

        # form not actually submitted
        if (!$this->input->post('do_resetpassword'))
            $this->redirect_error('sign-in/reset-password', false);

        # validate submitted form fields
        $this->form_validation->set_rules(
            'email', 'email address', 'required|maxlength[255]');

        if (!$this->form_validation->run()) {
            # redirect back with the error message
            $errmsg = validation_errors();
            $this->redirect_error('sign-in/reset-password', $errmsg);
        }

        # attempt reset with backend
        $email = $this->input->post('email');

        $res = $this->accounting->auth->reset($email);
        if (empty($res) || $res->is_error()) {
            $errmsg = $res->get_error();
            $this->redirect_error('sign-in/reset-password', $errmsg);
        }

        # we're successful - start session
        $data = $res->get_data();
        if (!$data) {
            $this->redirect_error(
                'sign-in/reset-password', 'An unexpected error has occurred.');
        }

        $this->session->set_userdata(
            'xv_pwdreset_email', strtolower(trim($email)));

        $this->redirect_success(
            'sign-in/reset-password', 'Please check your email inbox.');
    }

    # landing page from failed login, form to enter email for reset pass link
    public function complete_reset_password() {
        $this->auth->redirect_if_auth('dashboard');

        $this->init_template('Complete Reset Password');

        $prg = $this->retrieve_redirect(['email']);
        $this->with('prg', $prg);

        $this->view_template('page/signin/reset');
    }

    public function do_confirm_reset_password($token=false) {
        # disallow attempt if already logged in
        $this->auth->redirect_if_auth();

        $sess_email = $this->session->userdata('xv_pwdreset_email');

        # form not actually submitted
        if (empty($token) || empty($sess_email))
            $this->redirect_error(
                'sign-in/reset-password', "Invalid link, please try again.");

        # reset with backend
        $res = $this->accounting->auth->reset_complete($sess_email, $token);
        if (empty($res) || $res->is_error()) {
            $errmsg = $res->get_error();
            $this->redirect_error('sign-in/reset-password', $errmsg);
        }

        $this->redirect_success(
            'sign-in/reset-password',
            "Your password has been reset and sent to your inbox.");
    }

    protected function login_rate_limit($identifier) {
        # rate limit
        $max = 12;
        $period = 120;
        $key_ident = substr(md5($identifier), 0, 12);
        $key_ip = $_SERVER['REMOTE_ADDR'];
        if ($this->rate_limited($max, $period, $key_ident)
                || $this->rate_limited($max, $period, $key_ip)) {
            return true;
        }
        return false;
    }

}
