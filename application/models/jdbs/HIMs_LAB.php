<?php

if (defined('BASEPATH')) {
    require_once(APPPATH . 'libraries/orr/Jdo.php');
} else {
    exit('No direct script access allowed');
}

/**
 * Description of HIMs_REG
 * ฐานข้อมูลระบบการตรวจทางห้องปฏิบัติการ HIMs V5
 * @author suchart bunhachirat
 */
class HIMs_LAB extends CI_Model {

    private $JDO = NULL;

    public function __construct() {
        parent::__construct();
        $this->JDO = new \Orr\Jdo('orrconn', 'xoylfk', 'jdbc:as400://10.1.99.2/trhpfv5');
    }

    /**
     * ข้อมูลบันทึกการส่งตรวจแลป
     * @param array $keys
     * @return array
     */
    public function fatchRequest(array $keys) {
        $cur_thdate = date("Ymd") + 5430000;
        $sql = 'SELECT DISTINCT "LABRQOV5PF"."LRQDOCNO" "document_id", "LABRQOV5PF"."LRQIOPD" "visit_status", "LABRQOV5PF"."LRQVN" "vn", "LABRQOV5PF"."LRQVNSEQ" "vn_seq", "LABRQOV5PF"."LRQAN" "an", "LABRQDV5PF"."LRDHN" "hn", "LRQRQODTE" - 5430000 "request_date", "LRQRQOTIM" * 100 "request_time", "LABRQOV5PF"."LRQRQODR" "request_doctor_id", "LABRQDV5PF"."LRDLABTYP" "request_lab_type", "LABRQDV5PF"."LRDLABCOD" "request_lab_id", "LABRQOV5PF"."LRQFILNO" "file_no", "LRQCFMDTE" - 5430000 "checkin_date", "LRQCFMTIM" * 100 "checkin_time", "LABRQOV5PF"."LRQFODDTE" "eat_thdate", \'\' "eat_date", "LRQFODTIM" * 100 "eat_time", NOW( ) "update_time" FROM "TRHPFV5"."LABRQOV5PF" "LABRQOV5PF", "TRHPFV5"."LABRQDV5PF" "LABRQDV5PF" WHERE "LABRQOV5PF"."LRQDOCNO" = "LABRQDV5PF"."LRDDOCNO" AND "LABRQOV5PF"."LRQFILNO" > \'0\'';
        if (!is_null($keys['hn'])) {
            $sql .= ' AND "LABRQDV5PF"."LRDHN" = \'' . $keys['hn'] . '\'';
        } else {
            $sql .= ' AND "LABRQOV5PF"."LRQRQODTE" = ' . $cur_thdate;
        }
        return $this->cacheFatch('his_lab_request', $this->JDO->query($sql));
    }

    /**
     * เก็บข้อมูล API ที่ใช้งานบ่อย
     * @param type $table
     * @param array $data
     * @return array
     */
    private function cacheFatch($table, array $data) {
        $db_ = $this->load->database('theptarin', TRUE);
        foreach ($data as $value) {
            ($value['eat_thdate'] > 25601225) ? $value['eat_date'] = $value['eat_thdate'] - 5430000 : NULL;
            $db_->replace($table, $value);
        }
        return $data;
    }

}
