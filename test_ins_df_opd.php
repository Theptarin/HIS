<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
chdir(__DIR__);
ini_set('default_charset', 'UTF-8');
ini_set('display_errors', '1');
require_once 'vendor/autoload.php';
# set the url of the server
$url = 'http://10.1.88.4/HIS/index.php/DFRpcS';
//$url = 'http://61cd1fe0.ngrok.io/HIS/index.php/DFRpcS';
# create our client object, passing it the server url
$Client = new JsonRpc\Client($url);
# set up our rpc call with a method and params
$success = false;


//$idx_ = ['document_id' => "DF00000001", 'document_thdate' => "25620501", 'document_time' => "1309", 'hn' => "460028", 'vn' => "0001", 'vn_seq' => "02", 'requester_id' => "ITIT", 'doctor_id' => "1104", 'df_price' => "800", 'df_quantity' => "1", 'div_id' => "O10", 'contract_type' => "1", 'contract_code' => "", 'program_id' => "DFRequest"];
$success = $Client->call('setDfOpd', [$idx_]);
//$success = $Client->call('divide', [42,5]);

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ทะเบียนยา(JsonRPC)</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>ทะเบียนยา HIMs(JsonRPC)</h1>
            </div>
            <?php
            echo '<b>Json RPC:</b> ', $url;
            echo '<br /><br />';

            echo '<b>result:</b> ', print_r($Client->result, 1);
            echo '<br /><br />';

            echo '<b>error:</b> ', $Client->error;
            echo '<br /><br />';

            echo '<b>output:</b> ', $Client->output;
            ?>
        </div>
    </body>
</html>
