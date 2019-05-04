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

    public $error = NULL;

    public function divide($dividend, $divisor, $int = false) {

        if (!$divisor) {
            $this->error = 'Cannot divide by zero';
        } else {
            $quotient = $dividend / $divisor;
            return $int ? (int) $quotient : $quotient;
        }
    }

    /**
     * บันทึกค่าแพทย์ผู้ป่วยนอก
     * ค่าที่ต้องส่งเพื่อบันทึกค่าแพทย์ผู้ป่วยนอกเป็นอะเรย์
     * - document_id(string 10) : หมายเลขเอกสาร DF + [RUNING NUMBER] เป็นคีย์หลักเพื่อตรวจสอบแก้ไขข้อมูล
     * - document_thdate(int 8) : พ.ศ.เดือนวัน ที่สร้างเอกสาร
     * - document_time(int 4) : ชม.นาที
     * - hn (bigint) : หมายเลขประจำตัวผู้ป่วย
     * - vn (int) : ลำดับที่รับบริการผู้ป่วยนอก
     * - vn_seq (int 2) : ลำดับการเข้ารับบริการตามจุดของผู้ป่วย
     * - requester_id (string 6) : รหัสผู้บันทึกข้อมูล
     * - ips_id (string 2) : รหัสประเภทค่าแพทย์
     * - doctor_id (string 5) : รหัสแพทย์
     * - df_price (currency 6) : ค่าธรรมเนียมแพทย์
     * - df_quantity (int) : ค่าเริ่มต้น 1 (ไม่ส่งก็ได้)
     * - div_id (string 3) : รหัสหน่วยงาน
     * - contract_type (string) : ประเภทคู่สัญญามาจาก VN. (ไม่ส่งก็ได้)
     * - contract_code (string) : รหัสคู่สัญญามาจาก VN. (ไม่ส่งก็ได้)
     * - program_id () : รหัสโปรแกรมค่าเริ่มต้นเป็น DFRpcS (ไม่ส่งก็ได้)
     * @param json $idx_json ['document_id' => "DF00000001", 'document_thdate' => "25620501", 'document_time' => "1309", 'hn' => "460028", 'vn' => "0001", 'vn_seq' => "02", 'requester_id' => "ITIT", 'doctor_id' => "1104", 'df_price' => "800", 'df_quantity' => "1", 'div_id' => "O10", 'contract_type' => "1", 'contract_code' => "", 'program_id' => "DFRequest"];
     * @return array
     */
    public function setDfOpd($idx_json) {
        try {
            $idx_ = json_decode(json_encode($idx_json), true);
            $ci = & get_instance();
            $ci->load->model('jdbs/HIMs_IPS');
            $HIMs = new HIMs_IPS();
            $HIMs->insDfOpd($idx_);
        } catch (Exception $exc) {
            $this->error = $exc->getTraceAsString();
        }
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
