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
$url = 'http://10.1.88.4/HIS/index.php/Icd10OpdRpcS';
//$url = 'http://61cd1fe0.ngrok.io/HIS/index.php/Icd10OPDRpcS';
# create our client object, passing it the server url
$Client = new JsonRpc\Client($url);
# set up our rpc call with a method and params
$success = false;

/**
 * ค้นข้อมูลรหัส E10.1 
 */
//$success = $Client->call('getPrincipalCode', ['E10.1']);
/**
 * ค้นหาด้วยรหัสและชื่อทั้งหมด E10.1 
 */
$success = $Client->call('getPrincipalSearch', ['%dial']);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ICD10 Principal (JsonRPC)</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>ICD10 Principal IMC (JsonRPC)</h1>
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
