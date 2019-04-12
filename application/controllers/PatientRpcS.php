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
 * Description of ServerMethods
 * Our methods class
 */
class ServerMethods {

    public $error = null;

    /**
     * ข้อมูลตาม HN.
     * @param sting $hn
     * @return array
     */
    public function getByHn($hn) {
        $ci = & get_instance();
        $ci->load->model('jdbs/HIMs_REG');
        $HIMs_REG = new HIMs_REG();
        return $HIMs_REG->fatchPatient(['hn' => $hn]);
    }

    /**
     * ข้อมูลตาม ชื่อ และ นามสกุล
     * @param sting $hn
     * @return array
     */
    public function getByName($fname, $lname) {
        $ci = & get_instance();
        $ci->load->model('jdbs/HIMs_REG');
        $HIMs_REG = new HIMs_REG();
        return $HIMs_REG->fatchPatient(['fname' => $fname, 'lname' => $lname]);
    }

}

/**
 * Description of PatientRpcS
 * HIS Patient RPC Server
 * @author suchart bunhachirat
 */
class PatientRpcS extends CI_Controller {

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
