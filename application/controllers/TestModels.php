<?php

if (defined('BASEPATH')) {
    //require_once(APPPATH . 'models/jdbs/HIMs_REG.php');
} else {
    exit('No direct script access allowed');
}

/**
 * Models Testing
 * @author suchart bunhachirat
 */
class TestModels extends CI_Controller {

    public function index() {
        echo 'This is TestModels.';
    }

    public function insDfOpd() {
        $idx_ = ['document_id' => "DF00000001", 'document_thdate' => "25620503", 'document_time' => "0119", 'hn' => "460028",
            'vn' => "0001", 'vn_seq' => "02", 'requester_id' => "ITIT", 'ips_id' => "21", 'doctor_id' => "1104", 'df_price' => "123456",
            'df_quantity' => "1", 'div_id' => "O10", 'contract_type' => "1", 'contract_code' => "", 'program_id' => "DFRequest"];
        $idx_['hims_thdate'] = substr($idx_['document_thdate'], 2);
        $ci = & get_instance();
        $ci->load->model('jdbs/HIMs_IPS');
        $HIMs = new HIMs_IPS();
        print_r($HIMs->insDfOpd($idx_));
    }

    public function fatchDrugAllergy($hn = "168348") {
        $ci = & get_instance();
        $ci->load->model('jdbs/HIMs_PRX');
        $HIMs = new HIMs_PRX();
        print_r($HIMs->fatchDrugAllergy(['hn' => $hn]));
    }

}
