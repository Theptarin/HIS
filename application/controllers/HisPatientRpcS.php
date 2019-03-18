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

    public function divide($dividend, $divisor, $int = false) {

        if (!$divisor) {
            $this->error = 'Cannot divide by zero';
        } else {
            $quotient = $dividend / $divisor;
            return $int ? (int) $quotient : $quotient;
        }
    }
    
    public function getByHn($hn) {
        $ci = & get_instance();
        $ci->load->model('jdbs/HIMs_REG');
        $HIMs_REG = new HIMs_REG();
        return $HIMs_REG->fatchDataPatient(['hn' => $hn]);
    }
    
    public function getByName($fname,$lname) {
        $ci = & get_instance();
        $ci->load->model('jdbs/HIMs_REG');
        $HIMs_REG = new HIMs_REG();
        return $HIMs_REG->fatchDataPatient(['fname' => $fname , 'lname' => $lname]);
    }
    /**
     * สำหรับทดสอบการเรียกใช้ข้อมูล HN. ทดสอบ
     * @param type $hn
     * @return array
     */
    public function getByHnTest($hn=0){
        $data[0] = [];
        $data[199] = ['prename' => 'คุณ','fname'=>'เทพ','lname'=>'ธารินทร์','hn'=>'199','vn' => '44444444','cid' => '1409900181748','sex' => '1','birthday' => '1985-12-31'];
        $data[299] = ['prename' => '001','fname'=>'ข้อมูลfname','lname'=>'ข้อมูลlname','hn'=>'299','vn' => '88889999','cid' => '44998834938','sex' => '2','birthday' => '2000-10-30'];
        //return [['fname'=>'ชื่อเพื่อทดสอบ','lname'=>'นามสกุลเพื่อทดสอบ','hn'=>'199'],['fname'=>'ข้อมูลfname','lname'=>'ข้อมูลlname','hn'=>'299']];
        return ($hn == 0)?[]:[$data[$hn]];
    }

}

/**
 * Description of HisPatientRpcS
 * HIS Patient RPC Server
 * @author suchart bunhachirat
 */
class HisPatientRpcS extends CI_Controller {

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
