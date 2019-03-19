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
 * RPC Service Methods
 */
class ServerMethods {

    public $error = null;

    /**
     * ข้อมูลการรับบริการทั้งหมดตาม HN.
     * @param type $hn
     * @return array
     */
    public function getByHn($hn) {
        $ci = & get_instance();
        $ci->load->model('jdbs/HIMs_OPD');
        $HIMs_OPD = new HIMs_OPD();
        return $HIMs_OPD->fatchVisit(['hn' => $hn]);
    }

    /**
     * ข้อมูลการรับบริการตามผู้รับบริการ และหน่วยงาน วันนี้
     * @param string $hn
     * @param string $div_id
     * @return array
     */
    public function getByHnDiv($hn, $div_id) {
        $ci = & get_instance();
        $ci->load->model('jdbs/HIMs_OPD');
        $HIMs_OPD = new HIMs_OPD();
        return $HIMs_OPD->fatchVisit(['hn' => $hn, 'div_id' => $div_id]);
    }

    /**
     * ข้อมูลรับบริการวันนี้
     * @return array
     */
    public function getToday() {
        $ci = & get_instance();
        $ci->load->model('jdbs/HIMs_OPD');
        $HIMs_OPD = new HIMs_OPD();
        return $HIMs_OPD->fatchVisit([]);
    }

}

/**
 * HIS OPD Visit RPC Sever
 * @author Suchart Bunhachirat <suchartbu@gmail.com>
 */
class OpdVisitRpcS extends CI_Controller {

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
