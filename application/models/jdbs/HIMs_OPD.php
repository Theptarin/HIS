<?php

if (defined('BASEPATH')) {
    require_once(APPPATH . 'libraries/orr/JDO.php');
} else {
    exit('No direct script access allowed');
}

/**
 * ข้อมูลงานผู้ป่วยนอก
 * @author Suchart Bunhachirat <suchartbu@gmail.com>
 */
class HIMs_OPD extends CI_Model {

    private $JDO = NULL;

    public function __construct() {
        parent::__construct();
    }

    /**
     * ข้อมูลการรับบริการผู้ป่วยนอก
     * hn = เลขประจำตัวผู้รับบริการ
     * div_id = รหัสหน่วยงานรับบริการ
     * มี hn กับ div_id คืนรายการข้อมูลรับบริการประจำวันนี้
     * มี hn คืนข้อมูลการรับบริการผู้ป่วยนอกทั้งหมดของผู้บริการ
     * ไม่กำหนด คืนข้อมูลการรับบริการประจำวันนี้ทั้งหมด
     * @param array $keys
     * @return array
     */
    public function fatchVisit(array $keys) {
        $cur_thdate = date("Ymd") + 5430000;
        $sql = 'SELECT "OPDAPPV5PF"."OAPREGDTE" "visit_thdate", "OAPREGDTE" - 5430000 "visit_date", "OPDAPPV5PF"."OAPHN" "hn", "OAPVN" * 100 + "OAPSEQNO" "vn", "OPDAPPV5PF"."OAPDIVCOD" "div_id", "OPDAPPV5PF"."OAPDRCOD" "doctor_id", RTRIM( "DMSPRENAM" ) "doctor_prefix", RTRIM( "DMSNAME" ) "doctor_fname", RTRIM( "DMSSURNAM" ) "doctor_lname", "DRMASV5PF"."DMSSEX" "doctor_sex", "OPDAPPV5PF"."OAPCRDSTS" "card_status" FROM "TRHPFV5"."OPDAPPV5PF" "OPDAPPV5PF", "TRHPFV5"."DRMASV5PF" "DRMASV5PF" WHERE "OPDAPPV5PF"."OAPDRCOD" = "DRMASV5PF"."DMSDRCOD" ';
        if (!is_null($keys['hn']) AND ! is_null($keys['div_id'])) {
            $sql .= 'AND "OPDAPPV5PF"."OAPHN" = \'' . $keys['hn'] . '\' AND "OPDAPPV5PF"."OAPREGDTE" = ' . $cur_thdate . ' AND "OPDAPPV5PF"."OAPDIVCOD" = \'' . $keys['div_id'] . '\'';
        } else if (!is_null($keys['hn'])) {
            $sql .= 'AND "OPDAPPV5PF"."OAPHN" = \'' . $keys['hn'] . '\'';
        } else {
            $sql .= 'AND "OPDAPPV5PF"."OAPREGDTE" = ' . $cur_thdate;
        }
        $this->JDO = new \orr\JDO('orrconn', 'xoylfk', 'jdbc:as400://10.1.99.2/trhpfv5');
        //echo $sql;
        return $this->JDO->query($sql);
    }

}
