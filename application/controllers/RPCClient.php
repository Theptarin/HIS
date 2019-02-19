<?php

if (defined('BASEPATH')) {
    chdir(__DIR__);
    ini_set('default_charset', 'UTF-8');
    ini_set('display_errors', '1');
} else {
    exit('No direct script access allowed');
}

/**
 * Description of RPCClient
 *
 * @author it
 */
class RPCClient extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $url = 'http://10.1.99.19/HIS/index.php/RPCServer';
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
        echo $Client->call('divide', [42,10]) ? 'true' : 'false';
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
