<?php
if (!defined('BASEPATH')) exit('Access denied.');


class Services extends X10_Controller {

    public function __construct() {
        parent::__construct();
        $this->ensure_session();
    }

    public function index() {
        $this->init_template('Manage License');

        # 'view discontinued licenses' link
        $discontinued = $this->input->get('discontinued') !== false;
        $this->with('viewing_discontinued', $discontinued);

        $type = (empty($discontinued)) ? ACTIVE : DISCONTINUED;
        $services = $this->load_services($type);
        $this->with('services', $services);

        $this->view('page/services/index.php');
    }

    public function order() {
        $this->init_template('Order License Key');
        $this->view_template('page/services/order.php');
    }

    public function deactivate($uri_key = '', $uri_identhash = '') {
        $uri_key = trim(strtolower($uri_key));
        if (empty($uri_key)) {
            $this->redirect_error('dashboard', 'Invalid license key.');
        }

        $services = $this->load_services(ALL, true);
        $found_svc = false;
        if (!empty($services)) {
            foreach ($services as $svc) {
                if ($svc->key === $uri_key) {
                    $found_svc = $svc;
                    break;
                }
            }
        }
        if (!$found_svc) {
            $this->redirect_error('dashboard', 'Invalid license key.');
        }

        $this->init_template('Deactivate Server');

        # verify there is an activation matching parameters
        $license = $this->xvarnish->fetch_license($svc->key);
        $found_avn = false;
        if (!empty($license->activations)) {
            foreach ($license->activations as $avn) {
                if ($avn->ident === $uri_identhash) {
                    $found_avn = $avn;
                    break;
                }
            }
        }

        if (!$license || !$found_avn) {
            $this->redirect_error('license/'. $uri_key, 'Invalid activation.');
        }

        $packages = $this->build_simple_packages_array();
        $product_to_package = $this->build_product_to_package();

        # generate and output template
        $this->with('activation', $avn)
             ->with('license', $license)
             ->with('packages', $packages)
             ->with('product_to_package', $product_to_package)
             ->with('service', $found_svc);
        $this->view_template('page/services/deactivate.php');
    }

    public function service($uri_key='') {
        $uri_key = trim(strtolower($uri_key));
        if (empty($uri_key)) {
            $this->redirect_error('dashboard', 'Invalid license key.');
        }

        $services = $this->load_services(ALL, true);
        $found_svc = false;
        if (!empty($services)) {
            foreach ($services as $svc) {
                if ($svc->key === $uri_key) {
                    $found_svc = $svc;
                    break;
                }
            }
        }

        if (!$found_svc) {
            $this->redirect_error('dashboard', 'Invalid license key.');
        }

        $this->init_template('License Details');

        $license = $this->xvarnish->fetch_license($svc->key);
        if (!$license) {
            $this->redirect_error('dashboard', 'Invalid license key.');
        }

        $packages = $this->build_simple_packages_array();

        # generate and output template
        $this->with('packages', $packages)
             ->with('license', $license)
             ->with('service', $found_svc);
        $this->view_template('page/services/service.php');
    }

    public function history($uri_key = '') {
        $uri_key = trim(strtolower($uri_key));
        if (empty($uri_key)) {
            $this->redirect_error('dashboard', 'Invalid license key.');
        }

        $services = $this->load_services(ALL, true);
        $found_svc = false;
        if (!empty($services)) {
            foreach ($services as $svc) {
                if ($svc->key === $uri_key) {
                    $found_svc = $svc;
                    break;
                }
            }
        }

        if (!$found_svc) {
            $this->redirect_error('dashboard', 'Invalid license key.');
        }

        $this->init_template('License History');

        $license = $this->xvarnish->fetch_license($svc->key);
        if (!$license) {
            $this->redirect_error('dashboard', 'Invalid license key.');
        }

        $log = $this->xvarnish->fetch_auditlog($svc->key);

        # generate and output template
        $this->with('log', array_reverse($log))
             ->with('license', $license)
             ->with('service', $found_svc);
        $this->view_template('page/services/history.php');
    }

    public function do_deactivate($uri_key='', $uri_identhash='') {
        $uri_key = trim(strtolower($uri_key));
        if (empty($uri_key)) {
            redirect('dashboard');
        }

        $services = $this->load_services(ALL, true);
        $found_svc = false;
        if (!empty($services)) {
            foreach ($services as $svc) {
                if ($svc->key === $uri_key) {
                    $found_svc = $svc;
                    break;
                }
            }
        }
        if (!$found_svc) {
            redirect('dashboard');
        }

        # verify there is an activation matching parameters
        $license = $this->xvarnish->fetch_license($svc->key);
        $found_avn = false;
        if (!empty($license->activations)) {
            foreach ($license->activations as $avn) {
                if ($avn->ident === $uri_identhash) {
                    $found_avn = $avn;
                    break;
                }
            }
        }

        if (!$license || !$found_avn) {
            redirect('dashboard');
        }

        try {
            $res = $this->xvarnish->deactivate_seat($svc->key, $found_avn);
        } catch (XVarnishError $e) {
            print 'ERROR 3 <br />';
            exit;
            redirect('error');
        }

        # result
        $message = 'Server deactivated';
        $extra_data = ['deleted_activation' => $found_avn];
        redirect('license/'. $uri_key);
    }

    public function do_deactivate_all($uri_key='') {
        $uri_key = trim(strtolower($uri_key));
        if (empty($uri_key)) {
            redirect('dashboard');
        }

        //loop through all the selected servers to deactivate;
        foreach($this->input->post('servers') as $selectedServer) {
            $services = $this->load_services(ALL, true);
            $found_svc = false;
            if (!empty($services)) {
                foreach ($services as $svc) {
                    if ($svc->key === $uri_key) {
                        $found_svc = $svc;
                        break;
                    }
                }
            }
            if (!$found_svc) {
                redirect('dashboard');
            }

            # verify there is an activation matching parameters
            $license = $this->xvarnish->fetch_license($svc->key);
            $found_avn = false;
            if (!empty($license->activations)) {
                foreach ($license->activations as $avn) {
                    if ($avn->ident === $selectedServer) {
                        $found_avn = $avn;
                        break;
                    }
                }
            }

            if (!$license || !$found_avn) {
                redirect('dashboard');
            }

            try {
                $res = $this->xvarnish->deactivate_seat($svc->key, $found_avn);
            } catch (XVarnishError $e) {
                print 'ERROR 3 <br />';
                exit;
                redirect('error');
            }
        }

        # result
        $message = 'Server deactivated';
        $extra_data = ['deleted_activation' => $found_avn];
        redirect('license/'. $uri_key);
    }

    private function gen_uuid($len=8) {
        // source: http://stackoverflow.com/a/1516430/2002144
        $hex = md5("xvarnish is bananas!" . uniqid("", true));
        $pack = pack('H*', $hex);
        $uid = base64_encode($pack);
        $uid = ereg_replace("[^A-Z0-9]", "", strtoupper($uid));
        if ($len < 4) $len = 4;
        if ($len > 128) $len = 128;
        while (strlen($uid) < $len) {
            $uid = $uid . gen_uuid(22);
        }
        return substr($uid, 0, $len);
    }

    public function do_order() {
        $this->load_user();
        $seats = 1;

        $services = $this->load_services(ACTIVE, true);
        $found_svc = false;
        if (!empty($services)) {
            # print 'ERROR 6 <br />';
            # exit;
            redirect('dashboard');
        }

        # verify that we have a 'client account key' in their client's CF
        $xvclient_id = false;
        foreach ($this->account->customfields as $cf) {
            if (intval($cf->id) === XVUID_CFID) {
                $xvclient_id = strtoupper(trim($cf->value));
                break;
            }
        }

        if (empty($xvclient_id)) {
            # assign a new account key for this client into the WHMCS CF
            $xvclient_id = $this->gen_uuid(6);

            $fields = ['customfields' => base64_encode(
                serialize([XVUID_CFID => $xvclient_id]))];

            $userid = $this->auth->get_userid();
            $res = $this->accounting->account->update($userid, $fields);
            if ($res->is_error()) {
                print 'ERROR 7 <br />';
                exit;
                redirect('error');
            }
        }

        try {
            $license_key = $this->xvarnish->create_license($xvclient_id);
            $this->xvarnish->update_seats(
                $license_key, XVarnish::PRODUCTION_SEATS, $seats);
        } catch (XVarnishError $e) {
            print 'ERROR 8 <br />';
            exit;
            redirect('error');
        }

        # add license service to WHMCS
        $user_id = $this->auth->get_userid();
        $res = $this->accounting->order->license(
            $user_id, $license_key, $seats);
        $message = 'License key provisioned successfully';
        $this->prg_persist(
            $message, false, false, array('license_key' => $license_key, 'seats' => $seat));
        redirect('license/'. $license_key);
    }

    public function modify($uri_key = 0) {
        $uri_key = trim(strtolower($uri_key));
        if (empty($uri_key)) {
            redirect('services');
        }

        $services = $this->load_services(ALL, true);
        $found_svc = false;
        if (!empty($services)) {
            foreach ($services as $svc) {
                if ($svc->key === $uri_key) {
                    $found_svc = $svc;
                    break;
                }
            }
        }
        if (!$found_svc) {
            redirect('dashboard');
        }

        $this->init_template('Modify License Key');

        $license = $this->xvarnish->fetch_license($svc->key);
        $packages = $this->build_simple_packages_array();
        $product_to_package = $this->build_product_to_package();

        # generate and output template
        $this->with('license', $license)
             ->with('packages', $packages)
             ->with('product_to_package', $product_to_package)
             ->with('service', $found_svc);
        $this->view_template('page/services/service_modify.php');
    }

    # XXX: There shouldn't be any need to understand or modify this function.
    private function _dynamic_field_names($package_id) {
        $packages = $this->build_simple_packages_array();

        // term_215: monthly
        if (!isset($packages[$package_id])) {
            print 'Package ID error';
            return;
        }

        # addons
        $current_package = $packages[$package_id];
        $addons = array();
        foreach ($packages as $package_id => $package) {
            foreach ($current_package->addons as $addon_id => $addon) {
                $post_value = $this->input->post('package_addon_' . $addon_id);
                $addon->form_value = intval($post_value);
                $addons[$addon_id] = $addon;
            }
        }

        return $addons;
    }

    # XXX: There shouldn't be any need to understand or modify this function.
    public function do_modify($uri_key = 0) {
        $uri_key = trim(strtolower($uri_key));
        if (empty($uri_key)) {
            redirect('services');
        }

        $services = $this->load_services(ALL, true);
        $found_svc = false;
        if (!empty($services)) {
            foreach ($services as $svc) {
                if ($svc->key === $uri_key) {
                    $found_svc = $svc;
                    break;
                }
            }
        }
        if (!$found_svc) {
            redirect('dashboard');
        }

        $package_id = $found_svc->package_id;
        $new_addon_values = $this->_dynamic_field_names($package_id);

        # verify we're not changing product IDs
        $packages = $this->build_simple_packages_array();
        $new_package_id = intval($this->input->post('package'));
        $package = $packages[$new_package_id];

        if ($found_svc->pid != $package->product_id) {
            redirect('error');
            return;
        }

        # build upgrade AddOrder fields
        $fields = array();
        $fields['serviceid'] = $found_svc->id;
        $fields['type'] = 'configoptions';

        # addons
        $addons_cost = 0.0;
        $configoptions = array();
        $addons = array();
        foreach ($package->addons as $addon_id => $addon) {
            $form_value = $this->input->post('package_addon_' . $addon_id);

            $form_value = intval($form_value);
            $addon->form_value = $form_value;
            $addon->addon_each_cost = 0.0;
            $addon->addon_cost = 0.0;

            $tier_co_id = '';
            $tier_co_value = '';

            foreach ($addon->pricing_tiers as $tier_id => $tier) {

                // holdover for future tiers
                $select_lock_tier = false;

                $select_tier = $form_value >= $tier->min && (
                    $form_value <= $tier->max && empty($tier->hidden));
                $select_lock_tier = !empty($lock_tier) && (
                    $lock_tier === $tier->name);

                if ($select_tier || $select_lock_tier) {

                    $tier_co_id = $tier->configopt_id;
                    $tier_co_value = $tier->id;
                    switch ($found_svc->billingcycle) {
                        case 'annually':
                            $addons_cost += $tier->pricing->annually * $form_value;
                            $addon->addon_each_cost = $tier->pricing->annually;
                            $addon->addon_cost = $tier->pricing->annually * $form_value;
                            break;
                        default:
                            $addons_cost += $tier->pricing->monthly * $form_value;
                            $addon->addon_each_cost = $tier->pricing->monthly;
                            $addon->addon_cost = $tier->pricing->monthly * $form_value;
                            break;
                    }

                    # if tier was selected via select_lock_tier, break
                    # otherwise keep iterating in case select_lock_tier is set
                    if ($select_lock_tier) {
                        break;
                    }
                }
            }

            $configoptions[$addon->configopt_id] = $form_value;
            $configoptions[$tier_co_id] = $tier_co_value;
            $addons[$addon_id] = $addon;
        }

        if (empty($configoptions)) {
            redirect('error');
        }

        # $settings = $this->load_settings();
        $fields["configoptions"] = $configoptions;
        $fields["paymentmethod"] = 'paypal'; # $settings->paymentmethod;
        $fields['priceoverride'] = 0.0;

        $user_id = $this->auth->get_userid();
        $res = $this->accounting->order->modification($user_id, $found_svc->id, $fields);

        if ($res->is_error()) {
            redirect('error');
            return;
        }

        $order_id = intval($res->get_data()->orderid);
        $order_number = intval($res->get_data()->order_number);
        # $invoice_id = intval($res->get_data()->invoiceid); # do not rely on this, not guaranteed to exist

        if (empty($order_number)) {
            redirect('error');
            return;
        }

        # submit change to licensing server also
        try {
            $this->xvarnish->update_seats(
                $found_svc->key, XVarnish::PRODUCTION_SEATS, $configoptions[SEATS_OPT]);
        } catch (XVarnishError $e) {
            print 'ERROR 5 <br />';
            exit;
            redirect('error');
        }

        $message = 'Your modification to '. intval($configoptions[SEATS_OPT]) .' seats has been ordered';
        $this->prg_persist(
            $message, false, false, array('license_key' => $found_svc->key, 'seats' => $configoptions[SEATS_OPT]));

        $this->prg_persist($message, false, false);
        redirect("license/{$found_svc->key}");
    }

}
