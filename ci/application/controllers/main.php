<?php
if (!defined('BASEPATH')) exit('Access denied.');

class Main extends X10_Controller {
    public function __construct() {
        parent::__construct();
        $this->ensure_session();
    }

    public function dashboard() {
        $this->init_template('Dashboard');

        $user = $this->load_user();
        $this->with('user', $user);

        $services = $this->load_services(ACTIVE);
        $this->with('services', $services);

        $tickets = $this->load_tickets()->tickets;
        $tickets = array_slice($tickets, 0, 5);
        $this->with('tickets', $tickets);

        # retrieve any PRG data and provide to template
        $prg = $this->retrieve_redirect();
        $this->with('prg', $prg);

        # example with user authentication/sessions
        $signed_in = $this->auth->is_authenticated() === true;
        $this->with('is_signed_in', $signed_in);

        # show template
        $this->view_template('page/main/dashboard');
    }

    public function error500() {
        http_response_code(500);
        $this->init_template('Server Error');

        # XXX: Temporary
        print '<pre>';
        debug_print_backtrace(3);
        print '</pre>';
        $this->view_template('page/main/error500');
    }

    public function error404() {
        http_response_code(404);
        $this->init_template('Page Not Found');
        $this->view_template('page/main/error404');
    }
}
