<?php

if (defined('BASEPATH')) {
    //require_once(APPPATH . 'models/jdbs/HIMs_REG.php');
} else {
    exit('No direct script access allowed');
}

/**
 * Description of TestCachData
 *
 * @author it
 */
class TestCachData extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->database();
        $query = $this->db->query("SELECT * FROM theptarin_api.patient");
        echo "TestCachData";
        print_r($query->result_array());
    }

}
