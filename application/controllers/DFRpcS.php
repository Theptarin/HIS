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

    public function divide($dividend, $divisor, $int = false) {

        if (!$divisor) {
            $this->error = 'Cannot divide by zero';
        } else {
            $quotient = $dividend / $divisor;
            return $int ? (int) $quotient : $quotient;
        }
    }

    /**
     * ค่าแพทย์ผู้ป่วยนอก
     * @param json $idx_ ['document_id' => "DF00000001", 'document_thdate' => "25620501", 'document_time' => "1309", 'hn' => "460028", 'vn' => "0001", 'vn_seq' => "02", 'requester_id' => "ITIT", 'doctor_id' => "1104", 'df_price' => "800", 'df_quantity' => "1", 'div_id' => "O10", 'contract_type' => "1", 'contract_code' => "", 'program_id' => "DFRequest"];
     * @return array
     */
    public function setDfOpd($idx_json) {
        $idx_ = json_decode(json_encode($idx_json), true); 
        $ci = & get_instance();
        $ci->load->model('jdbs/HIMs_IPS');
        $HIMs = new HIMs_IPS();
        return $HIMs->insDfOpd($idx_);
    }

}

/**
 * Description of RequesterRpcS
 * HIS Patient RPC Server
 * @author suchart bunhachirat
 */
class DFRpcS extends CI_Controller {

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
