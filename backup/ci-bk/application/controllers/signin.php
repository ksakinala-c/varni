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

    // public function index() {
    //     $this->init_template('Sign-in');
    //     if ($this->x10_security->is_authorized()) {
    //         redirect('index');
    //         return;
    //     }
    //     # stdClass object with fields (default empty), used to write output
    //     # submitted form values on error
    //     $form_names = ['identifier', 'password'];
    //     $post = (object) array_fill_keys($form_names, false);
    //     # if we're returning from form submission
    //     $prg = $this->session->flashdata('prg_persist');
    //     # if the form submit failed for any reason
    //     if ($prg && !$prg['success']) {
    //         # update values used as form values so the user doesn't have to
    //         # re-type it all for one failure. take POST'd values from past
    //         # login attempt, updates $post
    //         $post = $this->prg_assign_post(
    //             $form_names, $post, $prg['post']);
    //     }
    //     # user completed a password reset, be nice and prefill their form email
    //     $resetpass_complete = $this->session->flashdata('resetpass_complete');
    //     if (!empty($resetpass_complete)) {
    //         $post->identifier = htmlentities($resetpass_complete);
    //     }
    //     $this->with('post', $post);
    //     $this->with('message', $prg['message']);
    //     $this->with('error', $prg['error']);
    //     $this->with('validation_errors', $prg['validation_errors']);
    //     $this->view_template('page/login/login.php');
    // }

    // # page shown after reset form submitted and client was emailed
    // public function forgotten_submitted() {
    //     $this->init_template('Password Reset Requested');

    //     # already logged in
    //     if ($this->x10_security->is_authorized()) {
    //         redirect('index');
    //         return;
    //     }

    //     # stdClass object with fields (default empty), used to write output
    //     # submitted form values on error
    //     $form_names = ['identifier'];
    //     $post = (object) array_fill_keys($form_names, false);
    //     $prg = $this->session->flashdata('prg_persist');

    //     # if the form submit failed for any reason
    //     if ($prg && !$prg['success']) {
    //         $post = $this->prg_assign_post(
    //             $form_names, $post, $prg['post']);
    //     }

    //     $resetpass_identifier = $this->session->userdata('resetpass_identifier');
    //     if (empty($resetpass_identifier) || $post->identifier != $resetpass_identifier) {
    //         redirect('forgotten');
    //         return;
    //     }

    //     $this->with('post', $post);
    //     $this->view_template('page/login/resetsent.php');
    // }

    // # landing page from failed login, form to enter email for reset pass link
    // public function forgotten() {
    //     $this->init_template('Account Login');

    //     if ($this->x10_security->is_authorized()) {
    //         redirect('index');
    //         return;
    //     }

    //     $form_names = ['identifier'];
    //     $post = (object) array_fill_keys($form_names, false);
    //     $prg = $this->session->flashdata('prg_persist');

    //     # if the form submit failed for any reason
    //     if ($prg && !$prg['success']) {
    //         # update values used as form values so the user doesn't have to
    //         # re-type it all for one failure. take POST'd values from past
    //         # login attempt, updates $post
    //         $post = $this->prg_assign_post(
    //             $form_names, $post, $prg['post']);
    //     }

    //     $this->with('post', $post);
    //     $this->with('message', $prg['message']);
    //     $this->with('error', $prg['error']);
    //     $this->with('validation_errors', $prg['validation_errors']);  # array
    //     $this->view_template('page/login/reset.php');
    // }

    // # page from link in password reset email, providing form to enter new password
    // public function reset($key = false) {
    //     $this->init_template('Account Login');

    //     if ($this->x10_security->is_authorized() || empty($key)) {
    //         redirect('index');
    //         return;
    //     }

    //     # email address from session needs to exist matching the reset request,
    //     # i.e., same browser and session must have requested the reset
    //     $resetpass_identifier = $this->session->userdata('resetpass_identifier');
    //     if (empty($resetpass_identifier)) {
    //         redirect('login/forgotten');
    //         return;
    //     }

    //     # stdClass object with fields (default empty), used to write output
    //     # submitted form values on error
    //     $form_names = ['identifier'];
    //     $post = (object) array_fill_keys($form_names, false);

    //     # if we're returning from form submission
    //     $prg = $this->session->flashdata('prg_persist');

    //     # if the form submit failed for any reason
    //     if ($prg && !$prg['success']) {
    //         $post = $this->prg_assign_post(
    //             $form_names, $post, $prg['post']);
    //     }

    //     $this->with('post', $post);
    //     $this->with('message', $prg['message']);
    //     $this->with('error', $prg['error']);
    //     $this->with('key', form_prep($key));
    //     $this->with('validation_errors', $prg['validation_errors']);
    //     $this->view_template('page/login/resetfinal.php');
    // }

    // public function logout() {
    //     if ($this->x10_security->is_authorized()) {
    //         $this->x10_security->end_session();
    //     }
    //     redirect('signin');
    // }

    // protected function start_session($userid, $email, $contactid = false) {
    //     # successfully authenticated
    //     $sessid = uniqid(); // This is used only for logs currently

    //     $this->x10_security->set_session(
    //         $sessid, $userid, $email, '', $contactid);

    //     $this->accounting->auth->client_log('Signed in.');
    // }

    // public function do_reset()
    // {
    //     if ($this->x10_security->is_authorized())
    //     {
    //         redirect('index');
    //         exit;
    //     }

    //     # attempt sign in
    //     $message = false;
    //     $error = false;

    //     do
    //     {
    //         if (!$this->input->post('do_reset'))
    //             break;

    //         $this->form_validation->set_rules('key', 'reset key', 'trim|required|maxlength[255]');
    //         $this->form_validation->set_rules('identifier', 'email address', 'trim|required|maxlength[255]');

    //         if (!$this->form_validation->run())
    //             break;

    //         $identifier = strtolower(trim($this->input->post('identifier')));
    //         if ($this->login_rate_limit($identifier)) {
    //             $error = 'Please wait 2 minutes.';
    //             break;
    //         }

    //         $key = trim($this->input->post('key'));

    //         $resetpass_identifier = $this->session->userdata('resetpass_identifier');
    //         if (empty($resetpass_identifier) || $identifier != $resetpass_identifier)
    //         {
    //             $error = "Invalid information provided.<br />Please ensure you are using the same web browser that initiated the request.";
    //             break;
    //         }

    //         # attempt reset with accounting
    //         $result = $this->accounting->auth->reset_complete($identifier, $key);
    //         if ($result->is_error()) {

    //             $this->session->set_userdata('resetpass_identifier', false);
    //             $error = "Invalid information provided. Please try your request again.";
    //             break;
    //         }

    //         $this->session->set_flashdata('resetpass_complete', $identifier);

    //         $message = 'Password recovery successful. Please check your inbox for your new password.';
    //         $this->prg_persist($message, $error, validation_errors());
    //         redirect('signin');
    //         return;

    //     } while (false);

    //     $this->prg_persist($message, $error, validation_errors());
    //     redirect('login/forgotten');
    // }

    // public function do_forgotten()
    // {
    //     if ($this->x10_security->is_authorized())
    //     {
    //         redirect('index');
    //         exit;
    //     }

    //     # attempt sign in
    //     $message = false;
    //     $error = false;

    //     do
    //     {
    //         if (!$this->input->post('do_forgotten'))
    //             break;

    //         $this->form_validation->set_rules('identifier', 'email address', 'required|maxlength[255]');

    //         if (!$this->form_validation->run())
    //             break;

    //         $identifier = strtolower(trim($this->input->post('identifier')));
    //         if ($this->login_rate_limit($identifier)) {
    //             $error = 'Please wait 2 minutes.';
    //             break;
    //         }

    //         # attempt reset with accounting
    //         $result = $this->accounting->auth->reset($identifier);
    //         if ($result->is_error() && $result->get_error() == "Invalid email address provided.") {
    //             $error = 'Invalid information provided.';
    //             break;
    //         }

    //         elseif ($result->is_error()) {
    //             $error = $result->get_error();
    //             break;
    //         }

    //         $this->session->set_userdata('resetpass_identifier', $identifier);

    //         $message = 'Please check your email inbox.';
    //         $this->prg_persist($message, $error, validation_errors());
    //         redirect('login/forgotten_submitted');
    //         return;

    //     } while (false);

    //     $this->prg_persist($message, $error, validation_errors());
    //     redirect('login/forgotten');
    // }

}
