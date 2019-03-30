<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Welcome to Theptarin HIS JsonRPC (MDC-04)</title>

        <style type="text/css">

            ::selection { background-color: #E13300; color: white; }
            ::-moz-selection { background-color: #E13300; color: white; }

            body {
                background-color: #fff;
                margin: 40px;
                font: 13px/20px normal Helvetica, Arial, sans-serif;
                color: #4F5155;
            }

            a {
                color: #003399;
                background-color: transparent;
                font-weight: normal;
            }

            h1 {
                color: #444;
                background-color: transparent;
                border-bottom: 1px solid #D0D0D0;
                font-size: 19px;
                font-weight: normal;
                margin: 0 0 14px 0;
                padding: 14px 15px 10px 15px;
            }

            code {
                font-family: Consolas, Monaco, Courier New, Courier, monospace;
                font-size: 12px;
                background-color: #f9f9f9;
                border: 1px solid #D0D0D0;
                color: #002166;
                display: block;
                margin: 14px 0 14px 0;
                padding: 12px 10px 12px 10px;
            }

            #body {
                margin: 0 15px 0 15px;
            }

            p.footer {
                text-align: right;
                font-size: 11px;
                border-top: 1px solid #D0D0D0;
                line-height: 32px;
                padding: 0 10px 0 10px;
                margin: 20px 0 0 0;
            }

            #container {
                margin: 10px;
                border: 1px solid #D0D0D0;
                box-shadow: 0 0 8px #D0D0D0;
            }
        </style>
    </head>
    <body>

        <div id="container">
            <h1>เว็บเซอร์วิสโรงพยาบาลเทพธารินทร์ ระบบสารสนเทศบริหารงานโรงพยาบาล</h1>

            <div id="body">
                               
                <p>ทดสอบเรียกทะเบียนผู้รับบริการ: <a href="test_patient.php">HN. 365656 </a></p>
                <code>test_patient.php</code>
                
                <p>ทดสอบเรียกข้อมูลการรับบริการผู้ป่วยนอก: <a href="test_opd_visit.php">HN. 460028 DIV DP1 </a></p>
                <code>test_opd_visit.php</code>
                
                <p>ทดสอบเรียกทะเบียนผู้บันทึกข้อมูล: <a href="test_requester.php">Requester</a></p>
                <code>test_requester.php</code>
                
                <p>ทะเบียนผู้รับบริการประจำ: <a href="index.php/OpdVisit">วันนี้</a></p>
                <code>index.php/OpdVisit</code>
                
                <p>ตัวอย่างการใช้เรียกข้อมูลผู้รับบริการของโรงพยาบาล: <a href="index.php/HisPatient/hn/365656">HN. 365656 </a></p>
                <code>index.php/HisPatient/hn/365656</code>
                
                <p>ตัวอย่างการใช้เรียกข้อมูลผู้รับบริการของโรงพยาบาล: <a href="index.php/HisPatient/name/%E0%B9%82/%E0%B8%88">ชื่อ โ นามสกุล จ </a></p>
                <code>index.php/HisPatient/name/%E0%B9%82/%E0%B8%88</code>
                
                <p>ตัวอย่างการเรียกใช้ข้อมูลที่ 10.1.107.4 มาที่เซิร์ฟเวอร์ 10.1.99.19 นี้: <a href="http://10.1.107.4/ThepJasonRPC/HisPatient.php">คลิกที่นี่</a></p>
                <code>http://10.1.107.4/ThepJasonRPC/HisPatient.php</code>

                <p>ตัวอย่างโดย CodeIgniter</p>

                <p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>
            </div>

            <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
        </div>

    </body>
</html>