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
$url = 'http://10.1.88.4/HIS/index.php/DrugRpcS';
//$url = 'http://61cd1fe0.ngrok.io/HIS/index.php/DrugRpcS';
# create our client object, passing it the server url
$Client = new JsonRpc\Client($url);
# set up our rpc call with a method and params
$success = false;

/**
 * ค้นหาข้อมูลด้วย HN. 168348
 */
$success = $Client->call('getNow', [TRUE]);

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
