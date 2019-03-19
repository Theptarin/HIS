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
     * @param array $keys
     * @return array
     */
    public function fatchVisit(array $keys) {
        $sql = "SELECT OAPREGDTE visit_thdate, OAPREGDTE - 5430000 visit_date, OAPHN hn, OAPVN * 100 + OAPSEQNO vn, OAPDIVCOD div_id, OAPDRCOD doctor_id, OAPCRDSTS card_status FROM TRHPFV5.OPDAPPV5PF OPDAPPV5PF ";
        $cur_thdate = date("Ymd") + 5430000;
        if (!is_null($keys['hn']) AND ! is_null($keys['div_id'])) {
            $sql .= "WHERE OAPHN = '" . $keys['hn'] . "' AND OAPDIVCOD = '" . $keys['div_id'] . "' AND OAPREGDTE = '" . $cur_thdate . "'";
        } else if (!is_null($keys['hn'])) {
            $sql .= "WHERE OAPHN = '" . $keys['hn'] . "'";
        } else {
            $sql .= "WHERE OAPREGDTE = '" . $cur_thdate . "'";
        }
        $this->JDO = new \orr\JDO('orrconn', 'xoylfk', 'jdbc:as400://10.1.99.2/trhpfv5');
        //echo $sql;
        return $this->JDO->query($sql);
    }

}
