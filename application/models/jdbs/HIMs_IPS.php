<?php

if (defined('BASEPATH')) {
    require_once(APPPATH . 'libraries/orr/Jdo.php');
} else {
    exit('No direct script access allowed');
}

/**
 * Description of HIMs_REG
 * ฐานข้อมูลระบบต้อนรับเวชระเบียน HIMs V5
 * @author suchart bunhachirat
 */
class HIMs_IPS extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * เพิ่มเอกสารค่าธรรมเนียมแพทย์
     * - document_id(string 10) : หมายเลขเอกสาร DF + [RUNING NUMBER] เป็นคีย์หลักเพื่อตรวจสอบแก้ไขข้อมูล
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
     * @param array $idx_
     * @return boolean
     * @throws Exception
     */
    public function insDfOpd(array $idx_) {
        if (empty($this->fatchDfDoc($idx_))) {
            $jdo = new \Orr\Jdo('orrconn', 'xoylfk', 'jdbc:as400://10.1.99.2/trhpfv5');
            $idx_['document_thdate'] = date("Ymd") + 5430000;
            $idx_['document_time'] = date("Hi");
            $idx_['hims_thdate'] = substr($idx_['document_thdate'], 2);
            $data_ipsrqov5pf = ['IRQDOCDTE' => $idx_['document_thdate'], 'IRQDOCNO' => $idx_['document_id'], 'IRQDOCTIM' => $idx_['document_time'], 'IRQIOPD' => "O", 'IRQHN' => $idx_['hn'], 'IRQVN' => $idx_['vn'], 'IRQVNSEQ' => $idx_['vn_seq'], 'IRQRQODIV' => $idx_['div_id'], 'IRQRQODR' => $idx_['doctor_id'], 'IRQRQOUSR' => $idx_['requester_id'], 'IRQDRCOD' => $idx_['doctor_id'], 'IRQDRFAMT' => $idx_['df_price'] * $idx_['df_quantity'], 'IRQSTSFLG' => "2", 'IRQHLDFLG' => "", 'IRQCONTYP' => $idx_['contract_type'], 'IRQCONCOD' => $idx_['contract_code'], 'IRQSECNAM' => $idx_['requester_id'], 'IRQSECDTE' => "620416"];
            $jdo->insert("IPSRQOV5PF", $data_ipsrqov5pf);
            $data_ipsrqdv5pf = ['IRDDOCDTE' => $idx_['document_thdate'], 'IRDDOCNO' => $idx_['document_id'], 'IRDIPSTYP' => "DF", 'IRDIPSCOD' => $idx_['ips_id'], 'IRDTOTAMT' => $idx_['df_price'] * $idx_['df_quantity'], 'IRDDRFAMT' => $idx_['df_price'], 'IRDIPSQTY' => $idx_['df_quantity'], 'IRDSECNAM' => $idx_['requester_id'], 'IRDSECDTE' => $idx_['hims_thdate'], 'IRDSECTIM' => $idx_['document_time'], 'IRDHN' => $idx_['hn'], 'IRDSECPGM' => $idx_['program_id'], 'IRDMECCOD' => $idx_['doctor_id'], 'IRDCFMDTE' => $idx_['document_thdate']];
            $jdo->insert("IPSRQDV5PF", $data_ipsrqdv5pf);
            $data_obldetv5pf_df = ['OBDDOCDTE' => $idx_['document_thdate'], 'OBDDOCTIM' => $idx_['document_time'], 'OBDDOCTYP' => "12", 'OBDDOCNO' => $idx_['document_id'], 'OBDHN' => $idx_['hn'], 'OBDVN' => $idx_['hims_thdate'] . $idx_['vn'] . $idx_['vn_seq'], 'OBDRCPCOD' => "35", 'OBDCHRCOD' => "2", 'OBDPRDNO' => "DF" . $idx_['ips_id'], 'OBDDIVCOD' => $idx_['div_id'], 'OBDTOTQTY' => $idx_['df_quantity'], 'OBDPRDUP' => "0", 'OBDTOTAMT' => "0", 'OBDPAYAMT' => "0", 'OBDDRFLG' => "", 'OBDDRCOD' => $idx_['doctor_id'], 'OBDDRMOD' => "", 'OBDRQODIV' => $idx_['div_id'], 'OBDRQODR' => $idx_['doctor_id'], 'OBDCONTYP' => $idx_['contract_type'], 'OBDCONCOD' => $idx_['contract_code'], 'OBDSECNAM' => $idx_['requester_id'], 'OBDSECDTE' => $idx_['hims_thdate'], 'OBDSECTIM' => $idx_['document_time'], 'OBDSECPGM' => $idx_['program_id'], 'OBDSECNAML' => $idx_['doctor_id'], 'OBDSECDTEL' => $idx_['hims_thdate'], 'OBDSECTIML' => $idx_['document_time']];
            $jdo->insert("OBLDETV5PF", $data_obldetv5pf_df);
            $jdo->insert("OBLDETTMPF", $data_obldetv5pf_df);
            $data_obldetv5pf_dfd = ['OBDDOCDTE' => $idx_['document_thdate'], 'OBDDOCTIM' => $idx_['document_time'], 'OBDDOCTYP' => "12", 'OBDDOCNO' => $idx_['document_id'], 'OBDHN' => $idx_['hn'], 'OBDVN' => $idx_['hims_thdate'] . $idx_['vn'] . $idx_['vn_seq'], 'OBDRCPCOD' => "35", 'OBDCHRCOD' => "900", 'OBDPRDNO' => "DF" . $idx_['ips_id'] . ".D", 'OBDDIVCOD' => $idx_['div_id'], 'OBDTOTQTY' => $idx_['df_quantity'], 'OBDPRDUP' => $idx_['df_price'], 'OBDTOTAMT' => $idx_['df_price'] * $idx_['df_quantity'], 'OBDPAYAMT' => "0", 'OBDDRFLG' => "1", 'OBDDRCOD' => $idx_['doctor_id'], 'OBDDRMOD' => "1", 'OBDRQODIV' => $idx_['div_id'], 'OBDRQODR' => $idx_['doctor_id'], 'OBDCONTYP' => $idx_['contract_type'], 'OBDCONCOD' => $idx_['contract_code'], 'OBDSECNAM' => $idx_['requester_id'], 'OBDSECDTE' => $idx_['hims_thdate'], 'OBDSECTIM' => $idx_['document_time'], 'OBDSECPGM' => $idx_['program_id'], 'OBDSECNAML' => $idx_['doctor_id'], 'OBDSECDTEL' => $idx_['hims_thdate'], 'OBDSECTIML' => $idx_['document_time']];
            $jdo->insert("OBLDETV5PF", $data_obldetv5pf_dfd);
            $jdo->insert("OBLDETTMPF", $data_obldetv5pf_dfd);
            return TRUE;
        } else {
            throw new Exception('เอกสารที่ต้องการเพิ่มมีอยู่แล้ว | ' . print_r($idx_, TRUE));
        }
    }

    public function fatchDfDoc(array $key_) {
        $sql = "SELECT * FROM IPSRQOV5PF";
        if (!is_null($key_['document_id'])) {
            $sql .= " WHERE IRQDOCNO = '" . $key_['document_id'] . "'";
        } else {
            $sql .= " WHERE IRQDOCNO LIKE 'D%'";
        }
        $jdo = new \Orr\Jdo('orrconn', 'xoylfk', 'jdbc:as400://10.1.99.2/trhpfv5');
        return $jdo->query($sql);
    }

    /**
     * ลบเอกสารตามหมายเลขเอกสาร
     * @param array $idx_
     * @return boolean
     * @throws Exception
     */
    public function delDfOpd(array $idx_) {
        if ($this->chkDfDoc($idx_) AND $idx_['document_thdate'] - 5430000 == date("Ymd")) {
            $jdo = new \Orr\Jdo('orrconn', 'xoylfk', 'jdbc:as400://10.1.99.2/trhpfv5');
            $key_ipsrqov5pf = ['IRQDOCNO' => $idx_['document_id'], 'IRQDOCDTE' => $idx_['document_thdate']];
            $jdo->delete("IPSRQOV5PF", $key_ipsrqov5pf);
            $key_ipsrqdv5pf = ['IRDDOCNO' => $idx_['document_id'], 'IRDDOCDTE' => $idx_['document_thdate']];
            $jdo->delete("IPSRQDV5PF", $key_ipsrqdv5pf);
            $key_obldetv5pf = ['OBDDOCNO' => $idx_['document_id'], 'OBDDOCDTE' => $idx_['document_thdate']];
            $jdo->delete("OBLDETV5PF", $key_obldetv5pf);
            $jdo->delete("OBLDETTMPF", $key_obldetv5pf);
            return TRUE;
        } else {
            throw new Exception('ข้อมูลเอกสารที่ต้องการลบไม่ถูกต้อง | ' . print_r($idx_, TRUE));
        }
    }

    /**
     * ตรวจสอบเอกสารว่ามีอยู่จริง
     * @param array $key_
     * @return boolean
     * @throws Exception
     */
    public function chkDfDoc(array $key_) {
        if (empty($this->fatchDfDoc($key_))) {
            throw new Exception('ไม่พบเอกสารที่ต้องการ | ' . print_r($key_, TRUE));
        }
        return TRUE;
    }

}
