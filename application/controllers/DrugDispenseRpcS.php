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
     * ยาที่เคยจ่ายกับผู้ป่วย
      [discription_2] => วันละ 2 ครั้ง หลังอาหารเช้า เย็น
      [discription_1] => รับประทานครั้งละ 1 เม็ด
      [drug_id] => DTRHI00
      [visit_status] => O
      [quantity] => 15
      [hn] => 365656
      [discription_3] => ทานยาแล้วอาจง่วงนอน ยาแก้แพ้
      [document_date] => 20160412
      [vn] => 29602
      [drug_trade_name] => RHINOPHEN-C TAB
      [document_id] => 5904120321
      [an] => 0
     * @param type $hn
     * @return type
     */
    public function getByHn($hn) {
        $ci = & get_instance();
        $ci->load->model('jdbs/HIMs_PRX');
        $HIMs = new HIMs_PRX();
        return $HIMs->fatchDispense(['hn' => $hn]);
    }

}

/**
 * Description of RequesterRpcS
 * HIS Patient RPC Server
 * @author suchart bunhachirat
 */
class DrugDispenseRpcS extends CI_Controller {

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
