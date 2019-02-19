<?php

if (defined('BASEPATH')) {
    //require_once(APPPATH . 'models/jdbs/HIMs_REG.php');
} else {
    exit('No direct script access allowed');
}

/**
 * Description of HIS_patient
 * ทะเบียนประวัติผู้ป่วย JsonRPC Server
 * @author suchart bunhachirat
 */
class HisPatient extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $url = 'http://10.1.99.19/HIS/index.php/HisPatientRpcS';
        $this->load->library('vendor/json_rpc_client', ['url' => $url, 'transport' => NULL]);
    }

    public function index() {
        echo 'HisPatient';
    }

    public function hn($hn) {
        $this->json_rpc_client->call('getByHn', [$hn]) ? $this->setMyView() : exit();
    }

    public function name($fname, $lname) {
        $this->json_rpc_client->call('getByName', [$fname, $lname]) ? $this->setMyView() : exit();
    }

    private function setMyView() {
        $data_list = json_decode(json_encode($this->json_rpc_client->result), TRUE);
        // Load the SmartGrid Library
        $this->load->library('SmartGrid/Smartgrid');
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
        $this->load->view('HisPatient_', $data);
    }

    public function viewData($fname = 'สุ', $lname = 'บ') {
        $url = 'http://10.1.99.19/HIS/index.php/HisPatientRpcS';
        $this->load->library('vendor/json_rpc_client', ['url' => $url, 'transport' => NULL]);
        $client = $this->json_rpc_client;
        //$Client->call('getByHn', [$hn]) ? 'true' : 'false';
        $client->call('getByName', [$fname, $lname]) ? 'true' : 'false';
        //print_r(json_decode(json_encode($Client->result),TRUE));
        $data_list = json_decode(json_encode($client->result), TRUE);
        // Load the SmartGrid Library
        $this->load->library('SmartGrid/Smartgrid');
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
        $this->load->view('HisPatient_', $data);
    }

    public function JsonClient() {
        //$url = 'http://10.1.99.19/HIS/index.php/RPCServer';
        $url = 'http://10.1.99.19/HIS/index.php/HisPatientRpcS';
        # create our client object, passing it the server url
        //$this->load->library('vendor/json_rpc_client', [$url]);
        //$success = false;
        # create our client object, passing it the server url
        //$Client = new JsonRpc\Client($url);
        $this->load->library('vendor/json_rpc_client', ['url' => $url, 'transport' => NULL]);

        # set up our rpc call with a method and params
        //$method = 'divide';
        //$params = array(42, 6);
        //$success = false;
        $Client = $this->json_rpc_client;
        //$success = $Client->call('divide', [42,5]);
        //$success = $this->json_rpc_client->call($method, $params);

        /*
          # notify
          $success = $Client->notify($method);
         */

        /*
          # batch sending
          $Client->batchOpen();
          $Client->call($method, $params);
          $Client->notify($method, $params);
          $Client->call($method, $params);
          $Client->notify($method, $params);
          $Client->call($method, $params);
          $success = $Client->batchSend();
         */

        echo '<form method="GET">';
        echo '<input type="submit" value="Run Example"> Last run: ' . date(DATE_RFC822);
        echo '</form>';
        echo '<pre>';

        echo '<b>return:</b> ';
        //echo $Client->call('divide', [42, 5]) ? 'true' : 'false';
        echo $Client->call('getByHn', ['365656']) ? 'true' : 'false';
        echo '<br /><br />';

        echo '<b>result:</b> ', print_r($Client->result, 1);
        echo '<br /><br />';

        echo '<b>batch:</b> ', print_r($Client->batch, 1);
        echo '<br /><br />';

        echo '<b>error:</b> ', $Client->error;
        echo '<br /><br />';

        echo '<b>RPCUrl:</b> ', $url;
        echo '<br /><br />';

        echo '<b>output:</b> ', $Client->output;
    }

}
