<?php

class XVarnishError extends Exception {}

class XVarnish {
    public $js_api_key = false;
    private $ci = false;
    private $sift_client = false;
    const PRODUCTION_SEATS = 1;
    const TESTING_SEATS = 2;

    public function seat_ident($key, $server_hash, $server_ip, $seat_type, $prefix='') {
        # A simple hash routine to be able to refer to specific license activations
        # with a single identifier.  Including the session ID and user ID so they
        # slightly change over time, but there is no security involved in this ident.
        $s = $prefix . $server_hash . $server_ip . $seat_type;
        return sha1($s);
    }

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->config->load('xvarnish');

        require_once APPPATH .'third_party/xVarnish/licensing.php';
        require_once APPPATH .'third_party/xVarnish/admin.php';

        // $RSA_KEY = '/root/testactivate/clientrsa.pem';
        $api_url = $this->ci->config->item('api_url', 'xvarnish');
        $this->laclient = $la = new LicensingAdmin($api_url);
    }

    private function prepare_license($lo) {
        # Adds or updated values on License objects retrieved from API prior
        # to returning to caller
        if (!empty($lo->activations)) {
            foreach ($lo->activations as $i => $avn) {
                # add a simple identifier to an activation so we can nicely
                # refer to it in URLs and such
                $prefix .= $this->ci->auth->get_userid();
                $avn->ident = $this->seat_ident(
                    $key, $avn->server_hash, $avn->server_ip, $avn->type, $prefix);

                # include fingerprint repr with hex
                $avn->server_hash = rtrim(chunk_split($avn->server_hash, 2, ':'), ':');
                $lo->activations[$i] = $avn;
            }
        }

        return $lo;
    }

    public function create_license($userId) {
        $res = $this->laclient->createLicense($userId);
        if (!$res['success']) {
            throw new XVarnishError($res['message']);
        }
        $license_key = $res['licenseKey'];
        return $license_key;
    }

    public function fetch_license($key) {
        $license = $this->laclient->getLicense($key);
        if (empty($license)) {
            return false;
        }
        return $this->prepare_license($license);
    }

    public function fetch_auditlog($key) {
        $log = $this->laclient->getLicenseAuditLog($key);
        return $log;
    }

    public function update_seats($key, $type, $numSeats=0) {
        $res = $this->laclient->setLicenseFeatures(
            $key, $type, intval($numSeats));
        if (!$res['success']) {
            throw new XVarnishError($res['message']);
        }
        return $res;
    }

    public function deactivate_seat($key, $avn) {
        $license = $this->fetch_license($key);
        if (!$license) {
            throw new XVarnishError('License not found');
        }

        $found_avn = false;
        foreach ($license->activations as $i => $_avn) {
            if ($_avn->ident === $avn->ident) {
                $found_avn = $avn;
                unset($license->activations[$i]);
                break;
            }
        }
        if (!$found_avn) {
            throw new XVarnishError('Activation not found');
        }

        $avn->server_hash = str_replace(':', '', $avn->server_hash);
        $res = $this->laclient->deactivateSeat($key, $avn);
        if (!$res) {
            throw new XVarnishError('Unable to deactivate seat');
        }
        return $license;
    }
}
