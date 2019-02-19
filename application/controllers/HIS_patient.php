<?php

if (defined('BASEPATH')) {
    //require_once(APPPATH . 'models/jdbs/HIMs_REG.php');
} else {
    exit('No direct script access allowed');
}

/**
 * Description of HIS_patient
 * ทะเบียนประวัติผู้ป่วย
 * @author suchart bunhachirat
 */
class HIS_patient extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($hn = NULL, $fname = NULL, $lname = NULL) {
        $keys = ['hn' => $hn, 'fname' => $fname, 'lname' => $lname];
        // Load HIMs Model 
        $this->load->model('jdbs/HIMs_REG');
        // Load the SmartGrid Library
        $this->load->library('SmartGrid/Smartgrid');
        // Data as array
        $data_list = $this->HIMs_REG->fatchDataPatient($keys);
        // Column settings
        $columns = ['hn' => ['header' => "HN.", 'type' => "label", 'align' => "left"], 'fname' => ['header' => "ชื่อ", 'type' => "label", 'align' => "left"]
            , 'lname' => ['header' => "นามสกุล", 'type' => "label", 'align' => "left"]];
        // Config settings, optional
        $config = array("page_size" => 10);
        // Set the grid
        $this->smartgrid->set_grid($data_list, $columns, $config);
        // Render the grid and assign to data array, so it can be print to on the view
        $data['grid_html'] = $this->smartgrid->render_grid();
        // Load view
        $this->load->view('HIS_patient_', $data);
    }

    public function hn($hn) {
        $this->index($hn);
    }

    public function name($fname,$lname) {
        $this->index(NULL,$fname,$lname);
    }
    
    public function fname($fname) {
        $this->index(NULL,$fname,NULL);
    }

}
