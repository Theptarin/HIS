<?php

/**
 * กำหนดที่เก็บไฟล์ Model ที่ใช้งาน
 */
if (defined('BASEPATH')) {
    require_once(APPPATH . 'models/jdbs/TTRPF.php');
} else {
    exit('No direct script access allowed');
}

/**
 * Description of Jdbc_test
 *
 * @author it
 */
class Jdbc_test extends CI_Controller {

    private $jdb_ttrpf = null;

    public function __construct() {
        parent::__construct();
        $this->jdb_ttrpf = new \model\Ttrpf('orrconn','xoylfk');
    }
    
    public function index(){
        echo 'Index of Jdbc_test => ';
        echo 'function Insert(id,name) => ';
        echo 'function Update(id,name) => ';
        echo 'function Update(id) ';
    }
    
    public function Insert($id,$name='ค่าเริ่มต้นภาษาไทย'){
        print_r($this->jdb_ttrpf->InsertJdbc_test($id,$name));
    }
    /**
     * ไม่แจ้งข้อผิดพลาดเมื่อไม่มีข้อมูลให้ update
     */
    public function Update(){
        print_r($this->jdb_ttrpf->UpdateJdbc_test());
    }
    /**
     * ไม่แจ้งข้อผิดพลาดเมื่อไม่มีข้อมูลให้ delete
     */
    public function Delete($id){
        print_r($this->jdb_ttrpf->DeleteJdbc_test($id));
    }
    /**
     * ปรับปรุงให้ส่งข้อมูลกลับมาเป็น Json
     */
    public function Select(){
        print_r($this->jdb_ttrpf->SelectJdbc_test());
    }

}
