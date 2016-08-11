<?php

class X10_Session extends CI_Session {
    public function sess_update()
    {
        $CI = get_instance();
        if (!$CI->input->is_ajax_request()) {
            parent::sess_update();
        }
    }

}