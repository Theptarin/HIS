<?php

if (defined('BASEPATH')) {
    chdir(__DIR__);
    ini_set('default_charset', 'UTF-8');

    # we don't want any PHP errors being output
    ini_set('display_errors', '0');
    # so we will log them. Exceptions will be logged as well
    ini_set('log_errors', '1');
    ini_set('error_log', 'server-errors.log');
} else {
    exit('No direct script access allowed');
}

/**
 * Register Server API
 */
class ServerMethods {

    public $error = null;
    /**
     * Principal Code
     * @return array
     */
    public function getPrincipalCode($code) {
        $ci = & get_instance();
        $ci->load->model('IMC_ICD10');
        $IMC = new IMC_ICD10();
        return $IMC->facthICD10Principal(['code' => $code]);
    }
    
    public function getPrincipalSearch($search) {
        $ci = & get_instance();
        $ci->load->model('IMC_ICD10');
        $IMC = new IMC_ICD10();
        return $IMC->facthICD10Principal(['search' => $search]);
    }

}

/**
 * IMC ICD10 OPD RPC Server
 * @author suchart bunhachirat
 */
class Icd10OpdRpcS extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        # set up our method handler class
        $methods = new ServerMethods();

        # create our server object, passing it the method handler class
        $this->load->library('vendor/json_rpc_server', ['methodHandler' => $methods]);

        # and tell the server to do its stuff
        $this->json_rpc_server->receive();
    }

}
