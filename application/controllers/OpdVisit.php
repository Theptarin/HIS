<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * ทะเบียนการรับบริการผู้ป่วยนอก
 *
 * @author Suchart Bunhachirat <suchartbu@gmail.com>
 */
class OpdVisit extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $url = 'http://10.1.88.4/HIS/index.php/OpdVisitRpcS';
        $this->load->library('vendor/json_rpc_client', ['url' => $url, 'transport' => NULL]);
    }

    public function index() {
        $this->json_rpc_client->call('getToday', []) ? $this->setMyView() : exit();
    }

    private function setMyView() {
        $data_list = json_decode(json_encode($this->json_rpc_client->result), TRUE);
        // Load the SmartGrid Library
        $this->load->library('SmartGrid/Smartgrid');
        // Column settings
        $columns = ['visit_date' => ['header' => "วันที่มา", 'type' => "label", 'align' => "left"], 'hn' => ['header' => "HN.", 'type' => "label", 'align' => "left"], 'vn' => ['header' => "VN.", 'type' => "label", 'align' => "left"]
            , 'div_id' => ['header' => "รหัสคลินิก", 'type' => "label", 'align' => "left"],'doctor_id' => ['header' => "รหัสแพทย์", 'type' => "label", 'align' => "left"]];
        // Config settings, optional
        $config = array("page_size" => 10);
        // Set the grid
        $this->smartgrid->set_grid($data_list, $columns, $config);
        // Render the grid and assign to data array, so it can be print to on the view
        $data['grid_html'] = $this->smartgrid->render_grid();
        // Load view
        $this->load->view('HisPatient_', $data);
    }

}
