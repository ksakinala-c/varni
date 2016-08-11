<?php
if (!defined('BASEPATH')) exit('Access denied.');


class Announcements {
    public function index() {
        $this->init_template('Recent Announcements');

        $entries = $this->load_announcements(8);
        $this->with('announcements', $entries)
             ->view('page/announcements/index.php');
    }

    private function load_announcements($amount=0) {
        $res = $this->accounting->support->announcements($amount);
        if (empty($res) || $res->is_error()) {
            redirect('error');
        }

        $entries = [];

        # verify announcements returned
        $data = $res->get_data();
        if (is_object($data) && isset($data->announcements->announcement)) {
            # data->announcements->announcement is an array
            $entries = $data->announcements->announcement;
        }

        return $entries;
    }
}
