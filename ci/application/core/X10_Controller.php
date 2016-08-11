<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

define('UNPAID', 'Unpaid');
define('FREE_COST', '$0.00 USD');
define('UPGRADE', 'upgrade');
define('PRODUCT', 'product');
define('ORDER', 'order');
define('ADDON', 'addon');
define('COMPLETED', 'Completed');
define('OTHER_PRODUCT_SERVICE', 'Other Product/Service');
define('HTTP_OK', 200);
define('FILEPICKER_URL', 'https://www.filepicker.io/api/file/');
define('AWS_S3_URL', 'https://s3.amazonaws.com/x10frontend/');
define('ATTACH_KEYWORD', 'Attachment');

class X10_Controller extends CI_Controller {
    const REQUIRE_HTTPS = false;
    const TPL_HEADER = 'inc/header';
    const TPL_FOOTER = 'inc/footer';

    private $account_cache = false;
    private $services_cache = [];

    # XXX: Get rid of these
    protected $td = array();
    private $_title = false;
    private $_hl = false;
    protected $prg_result = array();
    protected $packages = array();
    protected $products = array();
    protected $product_to_package = array();

    public function __construct() {
        parent::__construct();
        $this->load->driver('pp');
        $this->load->driver('accounting');

        # for POST data auth against CSRF, sometimes the token is needed for AJAX
        $this->with('csrf_value', $this->security->get_csrf_token_name());
        $this->with('csrf_name', $this->security->get_csrf_hash());

        $this->form_validation->set_error_delimiters('<span>', '</span>');
    }

    protected function init_template($title='') {
        $hl = ($this->uri->segment(1)) ? $this->uri->segment(1) : 'home';
        $this->vvars['_hl'] = $hl;
        $this->vvars['_environment'] = ENVIRONMENT;
        $this->vvars['_year'] = date('Y');
        $this->vvars['_title'] = $title;
    }

    protected function https_or_redirect() {
        # replace HTTP with HTTPS in URL, redirect
        if (ENVIRONMENT != 'development' && self::REQUIRE_HTTPS == true) {
            if ($_SERVER['SERVER_PORT'] != 443) {
                $new_url = str_replace('http://', 'https://', current_url());
                redirect($new_url);
                exit;
            }
        }
    }

    protected function rate_limited($service, $maxreq, $sec) {
        # returns true if requested service exceeds $maxreq requests in $sec
        # count of attempts persists with each new attempt
        if (function_exists('apc_exists')) {
            $k = strval($service) . $_SERVER['REMOTE_ADDR'];
            $cnt = apc_exists($k) ? intval(apc_fetch($key)): 0;
            apc_store($k, ++$cnt, $sec);
            return $cnt >= $maxreq;
        }
        return false;
    }

    protected function redirect_success($url, $msg, $data=false) {
        $msg_error = false;
        $errors = [];
        $this->persist_redirect($url, $msg, $msg_error, $errors, $data);
    }

    protected function redirect_fatal_error($errors = array(), $data = false) {
        $msg_success = false;
        $msg = 'A fatal error has occurred processing your request.';

        if (!is_array($errors)) {
            $errors = array('string' => $errors);
        }

        $this->persist_redirect('error', $msg_success, $msg, $errors, $data);
    }
    protected function redirect_error(
            $url, $msg, $errors=array(), $data=false) {
        $msg_success = false;
        if (!is_array($errors)) {
            $errors = array('string' => $errors);
        }
        $this->persist_redirect($url, $msg_success, $msg, $errors, $data);
    }

    protected function persist_redirect(
            $url, $msg_success = false, $msg_error = false,
            array $errors = array(), $data = false) {

        // var_dump($url, $msg_success, $msg_error, $errors, $data);
        // exit;

        # persist message(s) and data through redirect to $url

        # non-false value of $msg_success implies successful form result
        if ($msg_success && ($msg_error !== false || !empty($errors))) {
            # don't let redirect target have a logic failure, this is either
            # success or an error, so wipe error values if success is stated
            $msg_error = false;
            $errors = [];
        }

        # build array to persist through a redirect to $redir_url
        $post_data = $this->input->post();
        if (empty($post_data)) {
            $post_data = [];
            $was_submitted = false;
        } else {
            $was_submitted = true;
        }

        $prg_arr = [];
        $prg_arr['success'] = $msg_success !== false;
        $prg_arr['msg_success'] = $msg_success;  # string success message
        $prg_arr['msg_error'] = $msg_error;      # string error message
        $prg_arr['errors'] = $errors;            # array of error messages
        $prg_arr['data'] = $data;
        $prg_arr['form_data'] = $post_data;
        $prg_arr['was_submitted'] = $was_submitted;

        $this->session->set_flashdata('prg_arr', $prg_arr);

        if ($url == 'error') {
            compact_print_r($prg_arr);
            print 'redirect to '. base_url($url);
            exit;
        }

        redirect(base_url($url));
    }

    protected function retrieve_redirect(array $req_keys=array()) {
        $prg_arr = $this->session->flashdata('prg_arr');

        # no PRG flashdata found, that's OK
        if ($prg_arr === false) {
            # return similar to case with PRG data, but indicate there wasn't a form submission
            $prg_arr = ['was_submitted' => false, 'form_data' => []];
            foreach ($req_keys as $key)
                $prg_arr[$key] = false;  # mark POST fields as empty

            return $prg_arr;
        }

        # remove values not requested by caller, sanitize those that were
        foreach ($prg_arr['form_data'] as $post_key => $post_value) {
            if (!in_array($post_key, $req_keys)) {
                unset($prg_arr['form_data'][$post_key]);
            } else {
                $prg_arr[$post_key] = htmlentities($post_value);
            }
        }

        return $prg_arr;
    }

    protected function with($name, $value) {
        # add a template variable as $name having $value
        $this->vvars[strval($name)] = $value;
        return $this;
    }

    protected function build_template_parts(array $vars=array()) {
        # overwrite any global template vars with local vars
        $lv = array_merge($this->vvars, $vars);

        $this->vvars['_header'] = $this->pp->parse(self::TPL_HEADER, $lv, true);
        $this->vvars['_footer'] = $this->pp->parse(self::TPL_FOOTER, $lv, true);
    }

    protected function view_template($template_name, array $vars=array()) {
        if (empty($this->vvars['_header']) || empty($this->vvars['_footer'])) {
            $this->build_template_parts();
        }

        # overwrite any global template vars with local vars
        $vars = array_merge($this->vvars, $vars);
        $vars['page_header'] = $this->vvars['_header'];
        $vars['page_footer'] = $this->vvars['_footer'];

        $this->pp->parse($template_name, $vars);
    }

    protected function ajax_output($success, $message='', $data=false) {
        $arr = [
            'success' => $success,
            'message' => $message,
            'data' => $data];
        print json_encode($arr);
    }

    public function secure() {
        if (ENVIRONMENT != 'development')
        {
            $CI =& get_instance();
            $CI->config->config['base_url'] = str_replace('http://', 'https://', $CI->config->config['base_url']);
            if ($_SERVER['SERVER_PORT'] != 443) {
                $this->data['secured'] == 1;
                redirect($CI->uri->uri_string());
            }
        }
    }

    protected function friendly_name($method) {
        # friendly payment method name
        switch ($method) {
        case METHOD_MAIL:
            $paymentmethod_f = 'Mail In';
            break;
        case METHOD_PAYPAL_BA:
        case METHOD_PAYPAL:
            $paymentmethod_f = 'PayPal';
            break;
        case METHOD_CARD_ST:
        case METHOD_CARD_PP:
        case METHOD_CARD_QG:
            $paymentmethod_f = 'Credit Card';
            break;
        default:
            $paymentmethod_f = 'PayPal';
            break;
        }
        return $paymentmethod_f;
    }

    protected function ensure_session() {
        # redirect if local cookie-based session expired
        $this->auth->redirect_if_not_auth();
    }

    protected function load_user($use_cached=true) {

        if ($use_cached && isset($this->account_cache) && !empty($this->account_cache)) {
            return $this->account_cache;
        }

        # load the user from backend
        $userid = $this->auth->get_userid();
        $res = $this->accounting->account->get($userid, true);
        if (empty($res) || $res->is_error()) {
            $this->redirect_fatal_error('load_user');
            return;
        }

        # kick out user if their account is closed
        $user_data = $res->get_data()->client;
        if (strval($user_data->status) == STATUS_CLOSED) {
            $this->auth->end_session();
            $this->redirect_error('sign-in', 'Your session has expired.');
            return;
        }

        $this->account_cache = $user_data;
        $this->with('account', $user_data);
        $this->with('stats', $res->get_data()->stats);
        return $user_data;
    }

    public function load_services($filter_status = ALL, $use_cached = true) {

        if ($use_cached) {
            # used cached load_services result for the requested TYPE, if found
            if (isset($this->services_cache)
                    && is_array($this->services_cache)
                    && isset($this->services_cache[$filter_status])) {
                return $this->services_cache[$filter_status];
            }
        }

        $userid = $this->auth->get_userid();

        # load the user's services from backend
        $res = $this->accounting->services->get($userid);
        if (empty($res) || $res->is_error()) {
            $this->redirect_fatal_error('load_services');
        }

        # filter the fetched services to be status `$status`
        $res_products = isset($res->get_data()->products->product)
            ? $res->get_data()->products->product : false;

        $svc_filtered = [];

        if (!empty($res_products)) {
            foreach ($res_products as $svc) {
                # consider only those which are the XV license product group
                if (strtolower($svc->groupname) != strtolower(LICENSE_GROUP)) {
                    continue;
                }

                switch ($filter_status) {
                case ALL:
                    $svc_filtered[] = $svc;
                    break;

                case DISCONTINUED:
                    if ($svc->status != STATUS_CANCELED
                            && $svc->status != STATUS_FRAUD
                            && $svc->status != STATUS_TERMINATED) {
                       continue;
                    }
                    $svc_filtered[] = $svc;
                    break;

                # active here means "anything that isn't canceled or fraud"
                case ACTIVE:
                default:
                    if ($svc->status == STATUS_CANCELED
                            || $svc->status == STATUS_FRAUD
                            || $svc->status == STATUS_TERMINATED) {
                       break;
                    }
                    $svc_filtered[] = $svc;
                    break;
                }
            }
        }

        # if totalresults differs from svc_filtered count, we know some have
        # been filtered from this view
        $filtered = count($svc_filtered) != $svc_meta->totalresults;

        # template to know whether to display "discontinued" services
        $this->with('services_filtered', $filtered);

        # fetch an array of XV products available (currently just one) 2016-03
        $products = $this->get_products();

        # massage service objects into nice array to work with in controllers
        $services = [];

        foreach ($svc_filtered as $svc) {
            $is_active = $svc->status == 'Active';

            $svc->id = intval($svc->id);
            $svc->pid = intval($svc->pid);
            $svc->actions_allowed = $is_active;
            $svc->canceled = null;  # XXX: this is updated later to be correct

            $svc->product = $products[$svc->pid];
            $svc->product_type = 'Licensing';

            # re-arrange config options to an array indexed by ID
            $svc_cos = $svc->configoptions;
            $svc->configoptions = [];

            foreach ($svc_cos->configoption as $co) {
                $co->id = intval($co->id);
                $svc->configoptions[$co->id] = $co;
            }

            # re-arrange custom fields to an array indexed by lowercase name
            $svc_cfs = $svc->customfields;
            $svc->customfields = [];

            foreach ($svc_cfs->customfield as $cf) {
                $cf->id = intval($cf->id);
                $svc->customfields[strtolower($cf->name)] = $cf;
            }

            # determine service renewal info that is actually meaningful to us
            $dt_now = new DateTime(date('Y-m-d'));
            $dt_end = new DateTime(date('Y-m-d', strtotime($svc->nextduedate)));
            $svc->nextduedate_timestamp = strtotime($svc->nextduedate);
            $svc->nextdue_remaining_days = $dt_end->diff($dt_now)->format("%a");

            # product-specific metadata tweaks
            if ($svc->pid === LICENSE_PACKAGE) {
                # re-arrange tier name/per-seat-cost string (usage) into parts
                $cost_each_raw = $svc->configoptions[SEAT_TIER_OPT]->value;
                list($tier, $cost_each) = explode(' $', $cost_each_raw);
                $svc->tier = $tier;

                # coerce allowed seats
                $agents = $svc->configoptions[SEATS_OPT]->value;
                $svc->seats = intval($agents);
                $svc->seats_cost_each = rtrim($cost_each, ' USD');

                # license key
                $svc->key = (isset($svc->customfields[KEY_CF]->value))
                    ? $svc->customfields[KEY_CF]->value : null;

                $svc->product_title = 'License Key';
                $svc->package_id = SEATS_OPT;
            }

            $services[$svc->id] = $svc;
        }

        krsort($services);

        # cache the constructed service array for later re-use
        $this->services_cache[$filter_status] = $services;

        return $services;
    }

    protected function load_tickets($id = false) {
        $userid = $this->auth->get_userid();
        $dept_map = $this->arrays->departments_short_map;

        # retrieve them all
        if (empty($id)) {

            $tickets = $this->accounting->support->load_tickets($userid);
            if (!$tickets) {
                return false;
            }

            foreach ($tickets->tickets as $i => $ticket) {

                if ($ticket->status == 'In Progress')
                    $ticket->status_class = 'in-progress';
                else if ($ticket->status == 'On Hold')
                    $ticket->status_class = 'on-hold';
                else
                    $ticket->status_class = $ticket->status;

                $ticket->department_f = isset($dept_map[$ticket->deptid])
                    ? $dept_map[$ticket->deptid] : 'Unknown';

                $tickets->tickets[$i] = $ticket;
            }

            $this->with('tickets', $tickets);
            return $tickets;
        }

        # load single ticket
        else {
            $ticket = $this->accounting->support->load_ticket($userid, $id);
            if (!$ticket) {
                return false;
            }


            if ($ticket->status == 'In Progress')
                $ticket->status_class = 'in-progress';
            else if ($ticket->status == 'On Hold')
                $ticket->status_class = 'on-hold';
            else
                $ticket->status_class = $ticket->status;

            $ticket->department_f = isset($dept_map[$ticket->deptid])
                ? $dept_map[$ticket->deptid] : 'Unknown';

            $this->with('ticket', $ticket);
            return $ticket;
        }
    }

    public function insecure() {
        $CI =& get_instance();
        $CI->config->config['base_url'] = str_replace('https://', 'http://', $CI->config->config['base_url']);
        if ($_SERVER['SERVER_PORT'] != 80) {
            redirect($CI->uri->uri_string());
        }
    }

    protected function prg_persist($message, $error, $validation_errors=array(), $data=array()) {
        # message implies success
        if ($message && $error) $error = '';

        $arr = [
            'message' => $message,
            'error' => $error,
            'data' => $data,
            'success' => !($validation_errors || $error),
            'post' => $this->input->post(),
            'validation_errors' => $validation_errors];
        $this->session->set_flashdata('prg_persist', $arr);
    }

    protected function prg_assign_post($keys, $obj, array $arr) {
        foreach ($keys as $key) # for each key name provided
        {
            # if this exists as object prop and array index
            if (isset($obj->$key) && isset($arr[$key]))
            {
                $obj->$key = htmlentities($arr[$key]);
            }
        }
        return $obj;
    }

    protected function fetch_ba_update($ref) {
        # customer linked to PayPal with billing agreement, get that information
        $obj = new stdClass;
        $obj->name = '';
        $obj->email = '';
        $obj->disallow = true;
        $obj->status = 'Error retrieving.';
        if (empty($ref)) {
            return $obj;
        }
        $bares = $this->accounting->account->fetch_paypal_baupdate($ref);
        if ($bares->is_error()) {
            $obj->status = 'Error retrieving.';
        }
        elseif ($bares->get_data()->ACK == 'Failure' && $bares->get_data()->L_ERRORCODE0 == 10201) {
            $obj->status = 'Canceled by buyer.';
        }
        elseif ($bares->get_data()->ACK == 'Success') {
            $data = $bares->get_data();
            # for some reason not all successful billing agreements have a proper FIRSTNAME and LASTNAME returned
            if (isset($data->FIRSTNAME) || isset($data->LASTNAME)) {
                $obj->name = urldecode($data->FIRSTNAME) . ' ' . urldecode($data->LASTNAME);
                $obj->name = trim($obj->name);
            }
            $obj->email = urldecode($data->EMAIL);
            $obj->status = 'Active';
            $obj->disallow = false;
        }
        else {
            $code = isset($bares->get_data()->L_ERRORCODE0) ? $bares->get_data()->L_ERRORCODE0 : '0';
            $obj->status = 'Error retrieving, code '. $code .'.';
        }
        return $obj;
    }

    protected function load_orders($filter_by=false) {
        $userid = $this->x10_security->get_userid();

        $res = $this->accounting->order->get($userid);
        if ($res->is_error()) {
            redirect('error');
            return;
        }

        $orders = array();
        if (!empty($res->get_data()->orders)) {
            foreach ($res->get_data()->orders->order as $order) {
                $id = intval($order->id);
                if ($order->status == STATUS_CANCELED) {
                    $order->status = STATUS_CANCELED;
                    $order->status_style_class = STATUS_CANCELED;
                } else if ($order->status == STATUS_FRAUD) {
                    $order->status = 'Closed';
                    $order->status_style_class = STATUS_CANCELED;
                } else if ($order->status == STATUS_ACTIVE) {
                    $order->status_style_class = STATUS_PAID;
                } else if ($order->status == STATUS_PENDING
                           && $order->paymentstatus == STATUS_UNPAID) {
                    $order->status = STATUS_UNPAID;
                    $order->status_style_class = STATUS_UNPAID;
                } else if ($order->status == STATUS_PENDING) {
                    $order->status = 'Pending';
                    $order->status_style_class = STATUS_PAID;
                }

                $order->type = false;
                $order->services_ordered = array();
                if (!empty($order->lineitems)) {
                    foreach ($order->lineitems->lineitem as $lineitem) {
                        if (!empty($lineitem->producttype)) {
                            if ($lineitem->producttype == OTHER_PRODUCT_SERVICE) {
                                $lineitem->producttype = PRODUCT;
                            }
                            $order->type = strtolower($lineitem->producttype);
                        }
                        $order->services_ordered[] = $lineitem->producttype;
                    }
                }

                $order->id = intval($order->id);
                $order->ordernum = intval($order->ordernum);

                $order->services_ordered = (!empty($order->services_ordered))
                              ? implode(', ', $order->services_ordered) : '';
                $orders[$order->id] = $order;

                if ($order->ordernum === $filter_by) {
                    break;
                }
            }
        }

        krsort($orders);

        # re-assign in ID order DESC with order number as index
        $_orders = array();
        foreach ($orders as $order) {
            $_orders[$order->ordernum] = $order;
        }

        $this->td['orders'] = $_orders;
        return $_orders;
    }

    private function fetch_product($product_id) {
        $seat_tiers_co = $this->config->item('seat_tiers_co', 'xvarnishdefines');
        $seat_tiers_cosub = $this->config->item('seat_tiers_cosub', 'xvarnishdefines');
        $seat_tiers = $this->config->item('seat_tiers', 'xvarnishdefines');

        $products_configoptions = [SEATS_OPT];
        $products_addons = [SEATS_OPT];
        $products_addons_options = [SEATS_OPT];

        $res = $this->accounting->products->get($product_id);
        if ($res->is_error()) {
            print $res->get_error();
            exit;
        }

        $products = $res->get_data()->products->product;
        if (empty($products)) {
            print 'Empty product array!';
            exit;
        }

        $product = clone $products[0];
        $product->addons = array();
        $product->packages = array();
        $product->tiers = array('seats' => array());
        $product->customfields = $product->customfields->customfield;
        $configoptions = $product->configoptions->configoption;
        unset($product->description);

        # base pricing: with licenses the pricing here is 0, added cost comes
        # per addon - e.g., +1 additional seat
        $bp = new stdClass;
        $bp->monthly = floatval($product->pricing->USD->monthly);
        $bp->annually = floatval($product->pricing->USD->annually);
        if ($bp->monthly < 0) { $bp->monthly = 0.0; }
        if ($bp->annually < 0) { $bp->annually = 0.0; }
        $product->base_pricing = $bp;
        unset($product->pricing);

        foreach ($configoptions as $configopt) {
            # THESE ARE REFERENCES BECAUSE SIMPLEXML BLOWS. DO NOT MODIFY W/O
            # COPYING PROPERTIES INDIVIDUALLY
            # packages
            if (in_array($configopt->id, $products_configoptions)) {
                foreach ($configopt->options->option as $package) {
                    $product->packages[intval($package->id)] = $package;
                }
            }

            # addons
            if (in_array($configopt->id, $products_addons)) {
                foreach ($configopt->options->option as $addon) {
                    if (in_array($addon->id, $products_addons_options)) {
                        $addon->configopt_id = $configopt->id;
                        $product->addons[intval($addon->id)] = $addon;
                    }
                }
            }

            if (in_array($configopt->id, $seat_tiers_co)) {
                foreach ($configopt->options->option as $tier) {
                    if (in_array($tier->id, $seat_tiers_cosub['seats'])) {
                        $tier->configopt_id = $configopt->id;
                        $product->tiers['seats'][intval($tier->id)] = $tier;
                    }
                }
            }
        }

        unset($product->configoptions);

        # flatten tiers
        foreach ($product->tiers as $tier_type => $tiers) {
            foreach ($tiers as $tier_id => $tier) {
                $new_tier = new stdClass;
                $pricing = new stdClass;
                $pricing->monthly = $tier->pricing->USD->monthly;
                $pricing->annually = $tier->pricing->USD->annually;
                $new_tier->id = intval($tier->id);
                $new_tier->name = strval($tier->name);
                $new_tier->pricing = $pricing;
                $new_tier->configopt_id = $tier->configopt_id;

                if ($tier_type == 'seats') {
                    $new_tier->min = $seat_tiers[$new_tier->name]['min'];
                    $new_tier->max = $seat_tiers[$new_tier->name]['max'];
                    $new_tier->hidden = isset($seat_tiers[$new_tier->name]['hidden']) && !empty($seat_tiers[$new_tier->name]['hidden']);
                }

                $product->tiers[$tier_type][$tier_id] = $new_tier;
            }
        }

        # flatten addons
        foreach ($product->addons as $addon_id => $addon) {
            $new_addon = new stdClass;
            $pricing = new stdClass;
            $pricing->monthly = $addon->pricing->USD->monthly;
            $pricing->annually = $addon->pricing->USD->annually;
            $new_addon->id = intval($addon->id);
            $new_addon->name = strval($addon->name);
            $new_addon->configopt_id = $addon->configopt_id;
            $new_addon->pricing_tiers = (isset($addon->pricing_tiers)) ? $addon->pricing_tiers : new stdClass;

            # move tiers into addon
            if ($addon_id == SEATS_OPT) {
                $new_addon->pricing_tiers = $product->tiers['seats'];
            }

            $product->addons[$addon_id] = $new_addon;
        }

        # flatten packages
        foreach ($product->packages as $index => $package) {
            $new_package = new stdClass;
            $new_package->id = intval($package->id);
            $new_package->name = strval($package->name);
            $base_pricing = new stdClass;

            # if licensing, move product->base_pricing into package
            if (in_array($product->pid, array(LICENSE_GROUP))) {
                $base_pricing->monthly = $product->base_pricing->monthly;
                $base_pricing->annually = $product->base_pricing->annually;
            } else {
                $base_pricing->monthly = 0.0;
                $base_pricing->annually = 0.0;
            }

            $new_package->pricing = $base_pricing;
            unset($product->base_pricing);
            $product->packages[$index] = $new_package;
        }

        return $product;
    }

    protected function build_product_to_package() {
        if (!empty($this->product_to_package)) {
            return $this->product_to_package;
        }

        $products = $this->get_products();
        $product_to_package = array();

        foreach ($products as $product_id => $product) {
            foreach ($product->packages as $package) {
                $product_to_package[$package->product_id] = $package->id;
            }
        }

        $this->product_to_package = $product_to_package;
        return $product_to_package;
    }

    public function build_simple_packages_array() {
        if (!empty($this->packages)) {
            return $this->packages;
        }

        $prod2pkg = array(); # stores product IDs to package IDs for easy relations later
        $packages = array();
        $products = $this->get_products();
        foreach ($products as $product_id => $product) {
            foreach ($product->packages as $package) {
                $np = new stdClass;
                $np->id = intval($package->id);
                $np->name = strval($package->name);
                if ($np->name == 'License Seats') {
                    $np->name = 'xVarnish Standard Edition';
                }
                $np->pricing = $package->pricing;
                $np->product_id = intval($product->pid);
                $np->group_id = intval($product->gid);
                $np->product_type = $product->type;
                $np->paytype = $product->paytype;
                $np->module = $product->module;
                $np->addons = $product->addons;
                $np->tiers = $product->tiers;

                foreach ($np->addons as $aoid => $ao) {
                    switch ($aoid) {
                        case SEATS_OPT:
                            $ao->description = 'Amount of servers licensed.';
                            break;
                        default:
                            $ao->description = 'Unknown';
                            break;
                    }
                    $np->addons[$aoid] = $ao;
                }

                $packages[$np->id] = $np;
                $prod2pkg[$np->product_id] = $np->id;
            }
        }

        $this->product_to_package = $prod2pkg;
        $this->packages = $packages;
        return $packages;
    }

    private function get_products() {
        if (!empty($this->products)) {
            return $this->products;
        }
        $this->products = [LICENSE_PACKAGE => $this->fetch_product(LICENSE_PACKAGE)];
        return $this->products;
    }
}
