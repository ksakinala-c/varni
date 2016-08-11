<?php
if (!defined('BASEPATH')) exit('Access denied.');


class Account extends X10_Controller {
    public function __construct() {
        parent::__construct();
        $this->ensure_session();  # verify session for accessing this controller
    }

    public function index() {
        $this->init_template('Manage Account');

        $user = $this->load_user();

        # retrieve any PRG data and provide to template
        $prg = $this->retrieve_redirect([
                'firstname', 'email', 'lastname', 'companyname', 'phonenumber',
                'address1', 'address2', 'city', 'state', 'postcode',
                'country']);

        if (!$prg['was_submitted']) {
            $prg['firstname'] = $user->firstname;
            $prg['lastname'] = $user->lastname;
            $prg['companyname'] = $user->companyname;
            $prg['phonenumber'] = $user->phonenumber;
            $prg['address1'] = $user->address1;
            $prg['address2'] = $user->address2;
            $prg['city'] = $user->city;
            $prg['state'] = $user->state;
            $prg['postcode'] = $user->postcode;
            $prg['country'] = $user->country;
        }

        # generate and output template
        $this->with('user', $user);
        $this->with('prg', $prg);
        $this->with('countries', $this->arrays->country);
        $this->view_template('page/account/index.php');
    }

    public function do_address_update() {
        # form not actually submitted
        if (!$this->input->post('do_account_addressupdate'))
            $this->redirect_error('account', false);

        # validate submitted form fields
        $this->form_validation->set_rules('companyname', 'company name', 'trim');
        $this->form_validation->set_rules('firstname', 'first name', 'trim|required');
        $this->form_validation->set_rules('lastname', 'last name', 'trim|required');
        $this->form_validation->set_rules('company', 'last name', 'trim');
        $this->form_validation->set_rules('address1', 'address', 'trim|required');
        $this->form_validation->set_rules('address2', 'address', 'trim');
        $this->form_validation->set_rules('city', 'city', 'trim|required|ucwords');
        $this->form_validation->set_rules('postcode', 'postal code', 'trim|required');
        $this->form_validation->set_rules('state', 'state', 'trim|required|ucwords');
        $this->form_validation->set_rules('country', 'country', 'trim|required|ucwords');
        $this->form_validation->set_rules('phonenumber', 'phone number', 'trim|required');

        if (!$this->form_validation->run()) {
            $errmsg = validation_errors();
            $this->redirect_error('account', $errmsg);
        }

        $userid = $this->auth->get_userid();

        # update billing address
        $fields = [];
        $fields['companyname'] = $this->input->post('companyname');
        $fields['firstname'] = $this->input->post('firstname');
        $fields['lastname'] = $this->input->post('lastname');
        $fields['address1'] = $this->input->post('address1');
        $fields['address2'] = $this->input->post('address2');
        $fields['city'] = $this->input->post('city');
        $fields['postcode'] = $this->input->post('postcode');
        $fields['state'] = $this->input->post('state');
        $fields['country'] = $this->input->post('country');
        $fields['phonenumber'] = $this->input->post('phonenumber');

        $userid = $this->auth->get_userid();
        $res = $this->accounting->account->update_address($userid, $fields);

        # ensure successful retrieval
        if (empty($res) || $res->is_error()) {
            $errmsg = $res->get_error();
            $this->redirect_error('account', $errmsg);
        }

        $msg = 'Your changes have been saved.';
        $this->redirect_success('account', $msg);
    }

    public function update() {
        switch ($this->input->post('action')) {
        case 'password':
            return $this->_update_password();
        case 'email':
            return $this->_update_email();
        default:
            return $this->ajax_output(false, 'Invalid action.');
        }
    }

    private function _update_password() {
        $account = $this->load_user();

        $this->form_validation->set_rules(
            'password', 'new password',
            'required|min_length[8]');

        $this->form_validation->set_rules(
            'confirmpassword', 'password confirmation',
            'required|matches[password]');

        $this->form_validation->set_rules(
            'currentpassword', 'current account password',
            'required|callback_validate_password');

        if (!$this->form_validation->run()) {
            return $this->ajax_output(false, validation_errors());
        }

        $password = $this->input->post('password');
        $is_contact = $this->auth->is_contact();

        if (!$is_contact) {
            $userid = $this->auth->get_userid();
            $res = $this->accounting->account->update_password(
                $userid, $password);
        }
        else {
            $contactid = $this->auth->get_contactid();
            $res = $this->accounting->account->update_contact_password(
                $contactid, $password);
        }

        if (empty($res) || $res->is_error()) {
            return $this->ajax_output(false, 'An error has occurred.');
        }

        return $this->ajax_output(
            true, 'Your account password has been updated.');
    }

    private function _update_email() {
        $user = $this->load_user();

        $email = strtolower(trim($user->email));
        if (empty($email)) {
            return $this->ajax_output(false, 'An error has occurred.');
        }

        $this->form_validation->set_rules(
            'email', 'email address',
            'trim|required|strtolower|valid_email');
        $this->form_validation->set_rules(
            'currentpassword', 'current account password',
            'required|callback_validate_password');

        if (!$this->form_validation->run()) {
            return $this->ajax_output(false, validation_errors());
        }

        if ($email == $this->input->post('email')) {
            return $this->ajax_output(false, 'Please make a change.');
        }

        $email = strtolower(trim($this->input->post('email')));

        $userid = $this->auth->get_userid();
        $res = $this->accounting->account->update_emailaddress($userid, $email);
        if (empty($res) || $res->is_error()) {

            if (strtolower($res->get_error()) == 'duplicate email address') {
                $errmsg = 'Sorry, that email address is not available.';
            } else {
                $errmsg = 'An error has occurred.';
            }

            return $this->ajax_output(false, $errmsg);
        }

        return $this->ajax_output(true, 'Your email address has been updated.');
    }

    public function validate_password($password) {
        $user = $this->load_user();
        $email = $user->email;

        if (empty($email)) {
            $this->form_validation->set_message(
                'validate_password', 'An error has occurred.');
            return false;
        }

        $res = $this->accounting->auth->attempt($email, $password);
        if ($res->is_error()) {
            $this->form_validation->set_message(
                'validate_password', 'Invalid current password provided.');
            return false;
        }

        return true;
    }
}
