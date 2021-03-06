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
$url = 'http://10.1.88.8/HIS/index.php/OpdVisitRpcS';
//$url = 'http://e4d4bb07.ngrok.io/HIS/index.php/OpdVisitRpcS';
# create our client object, passing it the server url
$Client = new JsonRpc\Client($url);
# set up our rpc call with a method and params
$success = false;
/**
 * ค้นหาข้อมูลด้วย HN. 365656 เพื่อทดสอบการเชื่อมระบบ
 */
//$success = $Client->call('getByHn', ['365656']);

/**
 * ค้นหาข้อมูลด้วย HN. 460028 และ div_id DP1 เพื่อทดสอบการเชื่อมระบบ
 */
$success = $Client->call('getByHnDiv', ['782761','O10']);

/**
 * ค้นหาข้อมูลด้วย HN. 365656 เพื่อทดสอบการเชื่อมระบบ
 */
//$success = $Client->call('getToday', []);

/**
 * ค้นหาข้อมูลด้วย ชื่อและนามสกุล
 */
//$success = $Client->call('getByName', ['โน', 'จิ']);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>การรับบริการผู้ป่วยนอกโรงพยาบาลเทพธารินทร์(JsonRPC)</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>ข้อมูลการรับบริการผู้ป่วยนอก(JsonRPC)</h1>
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
