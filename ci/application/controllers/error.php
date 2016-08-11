<?php
if (!defined('BASEPATH')) exit('Access denied.');


class Error extends X10_Controller {
    public function index() {
        $this->init_template('Error');
        $this->view('page/error/report');
    }
}
