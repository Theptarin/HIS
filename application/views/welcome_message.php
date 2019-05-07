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

            h2 {
                color: #444;
                background-color: transparent;
                border-bottom: 1px solid #D0D0D0;
                font-size: 16px;
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

            <h2>ICD10 Principal IMC(Icd10OpdRpcS)</h2>
            <div id="body">
                คืน Array ICD10 | 
                $success = $Client->call('getPrincipalCode', ['E10.1']); : ค้นข้อมูลจากรหัส ICD10 E10.1 | 
                $success = $Client->call('getPrincipalSearch', ['%dial']); : ค้นข้อมูลที่มีคำว่า dial ทั้งในรหัส และชื่อ
            </div>

            <div id="body">
                <p>ICD10 Principal : <a href="test_icd10_principal.php">ค้นข้อมูลที่มีคำว่า dial</a></p>
                <code>test_icd10_principal.php</code>
            </div>

            
            <h2>ประวัติยาที่เคยจ่ายให้ผู้ป่วย(DrugDispenseRpcS)</h2>
            <div id="body">
                ข้อมูลการจ่ายให้ผู้ป่วย
                [discription_2] => วันละ 2 ครั้ง หลังอาหารเช้า เย็น
                [discription_1] => รับประทานครั้งละ 1 เม็ด
                [drug_id] => DTRHI00
                [visit_status] => O
                [quantity] => 15
                [hn] => 365656
                [discription_3] => ทานยาแล้วอาจง่วงนอน ยาแก้แพ้
                [document_date] => 20160412
                [vn] => 29602
                [drug_trade_name] => RHINOPHEN-C TAB
                [document_id] => 5904120321
                [an] => 0
            </div>

            <div id="body">
                <p>ข้อมูลการจ่ายยาให้ : <a href="test_drug_dispense.php">HN.365656</a></p>
                <code>test_drug_dispense.php</code>
            </div>

            <h2>ข้อมูลการส่งตรวจแลป(LabRequestRpcS)</h2>
            <div id="body">
                UPDATE his_lab_request | 
                $success = $Client->call('getByHn', ['365656']) : เรียกใช้ข้อมูล HN. 365656 | 
                $success = $Client->call('getToday', []) : เรียกใช้ข้อมูลประจำวัน
            </div>

            <div id="body">
                <p>ข้อมูลส่งตรวจแลป : <a href="test_lab_request.php">วันนี้</a></p>
                <code>test_lab_request.php</code>
            </div>

            <h2>บันทึกค่าแพทย์ผู้ป่วยนอก(DFRpcS)</h2>
            <div id="body">
                /**
                * ค่าที่ต้องส่งเพื่อบันทึกค่าแพทย์ผู้ป่วยนอกเป็นอะเรย์
                * - document_id(string 10) : หมายเลขเอกสาร DF + [RUNING NUMBER] เป็นคีย์หลักเพื่อตรวจสอบแก้ไขข้อมูล
                * - document_thdate(int 8) : พ.ศ.เดือนวัน ที่สร้างเอกสาร
                * - document_time(int 4) : ชม.นาที
                * - hn (bigint) : หมายเลขประจำตัวผู้ป่วย
                * - vn (int) : ลำดับที่รับบริการผู้ป่วยนอก
                * - vn_seq (int 2) : ลำดับการเข้ารับบริการตามจุดของผู้ป่วย
                * - requester_id (string 6) : รหัสผู้บันทึกข้อมูล
                * - ips_id (string 2) : รหัสประเภทค่าแพทย์
                * - doctor_id (string 5) : รหัสแพทย์
                * - df_price (currency 6) : ค่าธรรมเนียมแพทย์
                * - df_quantity (int) : ค่าเริ่มต้น 1 (ไม่ส่งก็ได้)
                * - div_id (string 3) : รหัสหน่วยงาน
                * - contract_type (string) : ประเภทคู่สัญญามาจาก VN. (ไม่ส่งก็ได้)
                * - contract_code (string) : รหัสคู่สัญญามาจาก VN. (ไม่ส่งก็ได้)
                * - program_id () : รหัสโปรแกรมค่าเริ่มต้นเป็น DFRpcS (ไม่ส่งก็ได้)
                */
            </div>

            <div id="body">
                <p>บันทึกค่าแพทย์ : <a href="test_ins_df_opd.php">DF00000001</a></p>
                <code>test_ins_df_opd.php</code>
            </div>

            <h2>ลบค่าแพทย์ผู้ป่วยนอก(DFRpcS)</h2>
            <div id="body">
                /**
                * ค่าที่ต้องส่งเพื่อลบค่าแพทย์ผู้ป่วยนอกเป็นอะเรย์
                * - document_id(string 10) : หมายเลขเอกสาร DF + [RUNING NUMBER] เป็นคีย์หลักเพื่อตรวจสอบลบข้อมูล
                * - document_thdate(int 8) : พ.ศ.เดือนวัน ที่สร้างเอกสาร คีย์เพื่อตรวจสอบที่อีกชั้น
                */
            </div>

            <div id="body">
                <p>ลบค่าแพทย์ : <a href="test_rmv_df_opd.php">DF00000001</a></p>
                <code>test_rmv_df_opd.php</code>
            </div>

            <h2>ทะเบียนยา (DrugRpcS)</h2>
            <div id="body">
                มี รหัส ชื่อการค้า ชื่อสามัญ
            </div>

            <div id="body">
                <p>ข้อมูลยา : <a href="test_drug.php">ทั้งหมด</a></p>
                <code>test_drug.php</code>
            </div>

            <h2>ทะเบียนผู้ป่วยที่แพ้ยา (DrugAllergyRpcS)</h2>
            <div id="body">
                มี HN. ยา กลุ่ม ชื่อสามัญ อาการที่แพ์ วันที่บันทึก
            </div>

            <div id="body">
                <p>ข้อมูลแพ้ยาตาม : <a href="test_drug_allergy.php">HN. 168348 </a></p>
                <code>test_drug_allergy.php</code>
            </div>

            <h2>ทะเบียนผู้รับบริการ (PatientRpcS)</h2>
            <div id="body">
                เช่น ชื่อ นามสกุล เพศ วันเดือนปีเกิด ผู้รับบริการ เป็นต้น
            </div>
            <div id="body">

                <p>ข้อมูลผู้รับบริการตาม : <a href="test_patient.php">HN. 365656 </a></p>
                <code>test_patient.php</code>

                <p>รายการผู้รับบริการตาม : <a href="index.php/HisPatient/hn/365656">HN. 365656 </a></p>
                <code>index.php/HisPatient/hn/365656</code>

                <p>รายการผู้รับบริการตาม : <a href="index.php/HisPatient/name/%E0%B9%82/%E0%B8%88">ชื่อ โ นามสกุล จ </a></p>
                <code>index.php/HisPatient/name/%E0%B9%82/%E0%B8%88</code>
            </div>

            <h2>ทะเบียนการรับบริการผู้ป่วยนอก (OpdVisitRpcS)</h2>
            <div id="body">
                เช่น วัน เวลาที่ คลินิก แพทย์ เป็นต้น
            </div>
            <div id="body">
                <p>ข้อมูลการรับบริการผู้ป่วยนอกตาม : <a href="test_opd_visit.php">HN. 460028 DIV DP1 </a></p>
                <code>test_opd_visit.php</code>

                <p>รายการการรับบริการผู้ป่วยนอก ภายใน : <a href="index.php/OpdVisit">วันนี้</a></p>
                <code>index.php/OpdVisit</code>

                <p>รายการการรับบริการผู้ป่วยนอก : <a href="index.php/OpdVisit/hn/365656">HN. 365656 </a></p>
                <code>index.php/OpdVisit/hn/365656</code>
            </div>

            <h2>ทะเบียนผู้รับผิดชอบข้อมูล (RequesterRpcS)</h2>
            <div id="body">
                เช่น ชื่อ นามสกุล
            </div>
            <div id="body">
                <p>เรียกตามรหัสผู้รับผิดชอบข้อมูล(Requester): <a href="test_requester.php">Requester</a></p>
                <code>test_requester.php</code>
            </div>

            <div id="body">
                <p>ตัวอย่างโดย CodeIgniter</p>

                <p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>
            </div>
        </div>

        <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
    </div>

</body>
</html>