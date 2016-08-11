<?php
if (!defined('BASEPATH')) exit('Access denied.');


class Support extends X10_Controller {

    public function __construct() {
        parent::__construct();
        $this->ensure_session();

        # load the account, this
        $this->with('user', $this->load_user());
    }

    public function index() {
        $this->init_template('Support Helpdesk');

        $tickets = $this->load_tickets();

        $this->with('tickets', $tickets);
        $this->view_template('page/support/index');
    }

    public function open() {
        $this->init_template('Open Support Ticket');

        $services = $this->load_services();

        # clean up service titles for ticket creation 'service list' dropdown
        foreach ($services as $id => $service) {
            $key = (!empty($service->key)) ? ' &minus; '. $service->key : false;
            $seats = (isset($service->seats)) ? intval($service->seats) : 0;
            $seats = $seats . ' ' . (($seats === 1) ? ' Server' : ' Servers');

            # we're American!
            $status = ($service->status == 'Cancelled')
                ? 'Canceled' : $service->status;

            $services[$id] = sprintf('%s &minus; %s with %s%s',
                                     strtoupper($status),
                                     'xVarnish License Key',
                                     $seats,
                                     $key);
        }

        $departments = $this->arrays->departments;

        # retrieve any PRG data and provide to template
        $prg = $this->retrieve_redirect([
            'subject', 'message', 'department', 'service']);

        # check for GET vars: department ID and service ID (used in some links!)
        $get_svc_id = intval($this->input->get('service'));
        $get_dept_id = intval($this->input->get('dept'));

        # if GET params provided and the form hasn't already been submitted, use
        if (empty($prg->service) && !empty($get_svc_id)) {
            $prg['service'] = $get_svc_id;
        }

        if (empty($prg->department) && !empty($get_dept_id)) {
            $prg['department'] = $get_dept_id;
        }

        $this->with('prg', $prg);
        $this->with('services', $services);
        $this->with('departments', $departments);

        $this->view_template('page/support/open');
    }

    public function ticket($id = false) {
        $id = abs(intval($id));
        if (empty($id)) {
            $this->redirect_error('support', 'Invalid ticket requested.');
        }

        # fetch the requested ticket
        $ticket = $this->load_tickets($id);
        if (!$ticket) {
            $this->redirect_error('support', 'Invalid ticket requested.');
        }

        $this->init_template('Ticket #'. $ticket->tid, 'support');

        # load ticket attachments
        $attachments = $this->accounting->support->fetch_attachments($ticket);

        # some flags to help display errors/warnings
        $was_just_opened = $this->session->flashdata('created');
        $last_attach_errored = $this->session->flashdata('attach_error');

        # retrieve any PRG data and provide to template
        $prg = $this->retrieve_redirect(['message']);

        $this->with('prg', $prg);
        $this->with('attachments', $attachments);
        $this->with('ticket', $ticket);
        $this->with('was_just_opened', $was_just_opened);
        $this->with('attach_error', $last_attach_errored);
        $this->view_template('page/support/ticket');
    }

    public function do_open_ticket() {
        # form not actually submitted
        if (!$this->input->post('do_support_openticket'))
            $this->redirect_error('support/open', 'Improper form submission.');

        $this->form_validation->set_rules(
            'subject', 'subject', 'required|max_length[200]');
        $this->form_validation->set_rules(
            'department', 'department', 'required|integer');
        $this->form_validation->set_rules(
            'service', 'service', 'integer');
        $this->form_validation->set_rules(
            'message', 'message', 'required|max_length[10000]');

        if (!$this->form_validation->run()) {
            # define our error message and an array of field-specific errors
            $errmsg = validation_errors();
            # redirect back with the error message
            $this->redirect_error('support/open', $errmsg);
        }

        $userid = $this->auth->get_userid();
        $ticket_message = $this->input->post('message');
        $service = intval($this->input->post('service'));
        $subject = $this->input->post('subject');
        $department = intval($this->input->post('department'));

        # open a ticket
        $res = $this->accounting->support->create_ticket(
            $userid, $department, $subject, $ticket_message, $service);

        # something went wrong
        if (empty($res) || $res->is_error()) {
            $errmsg = $res->get_error();
            $this->redirect_error('support/open', $errmsg);
        }

        # the behind-the-scenes, incremental ticket ID the user does not see
        $id = intval($res->get_data()->id);

        # the random six-digit ticket ID the user sees
        $tid = intval($res->get_data()->tid);

        # iterate over attachments and validate/add them to ticket
        $attachment = $this->input->post('attachment');
        if (!empty($attachment)) {
            foreach ($attachment as $inkblob) {
                $inkblob = json_decode($inkblob, true);
                $r = $this->ticket_save_attachment($id, $inkblob);
                if (!$r) {
                        continue;
                }
            }
        }

        # XXX: This may not be necessary now, TODO verify and maybe remove it
        $this->session->set_flashdata('created', true);

        $msg = 'Your support ticket has been created.';
        $this->redirect_success('support/ticket/'. $tid, $msg);
    }

    public function do_close_ticket($tid = 0) {
        $tid = abs(intval($tid));
        if (empty($tid)) {
            $this->redirect_error('support', 'Invalid ticket requested.');
        }

        # fetch the requested ticket
        $ticket = $this->load_tickets($tid);
        if (!$ticket) {
            $this->redirect_error('support', 'Invalid ticket requested.');
        }

        $userid = $this->auth->get_userid();
        $id = intval($ticket->ticketid);

        # form not actually submitted
        if (!$this->input->post('do_closeticket'))
            $this->redirect_error('support', 'Invalid ticket requested.');


        $res = $this->accounting->support->close_ticket($tid, $id);
        if ($res->is_error()) {
            $errmsg = $result->get_error();
            $this->redirect_error('sign-in', $errmsg);
        }

        $msg = 'The support ticket has been closed.';
        $this->redirect_success('support/ticket/'. $tid, $msg);
    }

    public function do_ticket_reply($tid = 0) {
        $tid = abs(intval($tid));
        if (empty($tid)) {
            $this->redirect_error('support', 'Invalid ticket requested.');
        }

        # fetch the requested ticket
        $ticket = $this->load_tickets($tid);
        if (!$ticket) {
            $this->redirect_error('support', 'Invalid ticket requested.');
        }

        $userid = $this->auth->get_userid();
        $id = intval($ticket->ticketid);

        # close ticket if button was pressed. it is sharing the same form as
        # do_ticket_reply, so just redirect here (no post required)
        if ($this->input->post('do_close')) {
            $this->session->set_flashdata('do_close', true);
            redirect('support/do_close_ticket/'. $tid);
            return;
        }

        # form not actually submitted
        if (!$this->input->post('do_ticketreply'))
            $this->redirect_error('support/ticket/'. $tid, 'No reply provided.');

        $this->form_validation->set_rules(
            'message', 'reply message',
            'required|trim|html_entities|max_length[10000]');

        if (!$this->form_validation->run()) {
            # define our error message and an array of field-specific errors
            $errmsg = validation_errors();
            # redirect back with the error message
            $this->redirect_error('support/ticket/'. $tid, $errmsg);
        }

        $ticket_message = $this->input->post('message');
        $res = $this->accounting->support->reply_ticket($id, $userid, $ticket_message);
        if ($res->is_error()) {
            $errmsg = $result->get_error();
            $this->redirect_error('support/ticket/'. $tid, $errmsg);
        }

        $msg = 'Your message has been added to the ticket.';
        $this->redirect_success('support/ticket/'. $tid, $msg);
    }

    public function do_attachment($tid = 0) {
        $message = false;
        $error = false;
        $tid = intval($tid);

        if (empty($tid)) {
            redirect('support');
            return;
        }

        $ticket = $this->load_tickets($tid);
        if (!$ticket) {
            redirect('support');
            return;
        }

        $userid = $this->auth->get_userid();
        $id = intval($ticket->ticketid);

        # iterate over attachments and validate/add them to ticket
        $attachment = $this->input->post('attachment');
        if (!empty($attachment)) {
            foreach ($attachment as $inkblob) {
                $inkblob = json_decode($inkblob, true);
                $r = $this->ticket_save_attachment($id, $inkblob);
                if ($r) {
                    return $this->ajax_output(true, 'Attached file.');
                }
            }
        }
        return $this->ajax_output(false, 'Not attached.');
    }

    private function ticket_save_attachment($ticketid, array $inkblob) {

        if (!isset($inkblob['inkurl']) || empty($inkblob['inkurl'])) {
            return false;
        }

        $url = $inkblob['inkurl'];

        # validate filepicker.io URL
        if (mb_substr($url, 0, 35) != FILEPICKER_URL || !ctype_alnum(mb_substr($url, 36))) {
            return false;
        }

        # ensure we can load the provided file key from filepicker.io
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD');
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_URL, $url);
        $res = curl_exec($ch);
        $status = intval(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        curl_close($ch);

        if ($status != HTTP_OK) {
            return false;
        }

        $res = $this->accounting->support->attachment($ticketid, $inkblob);

        if ($res->is_error()) {
            return false;
        }

        return true;
    }
}
