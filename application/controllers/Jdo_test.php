<?php

/**
 * กำหนดที่เก็บไฟล์ Model ที่ใช้งาน
 */
if (defined('BASEPATH')) {
    //require_once(APPPATH . 'models/jdbs/TTRPF.php');
} else {
    exit('No direct script access allowed');
}

/**
 * Description of Jdo_test
 *
 * @author it
 */
class Jdo_test extends CI_Controller {

    public function index() {
        $this->load->model('jdbs/ttrpf');
        
        foreach ($this->Ttrpf->Select() as $value) {
            print $value['id'] . "\t";
            print $value['name'] . "\n";
        }
    }

}
