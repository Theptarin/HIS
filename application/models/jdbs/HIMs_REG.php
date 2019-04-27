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
class HIMs_REG extends CI_Model {

    private $JDO = NULL;

    public function __construct() {
        parent::__construct();
    }

    /**
     * ข้อมูลผู้ป่วย
     * @param array $keys
     * @return array
     */
    public function fatchPatient(array $keys) {
        $sql = 'SELECT "REGMASV5PF"."RMSHNREF" "hn", "PREFIX"."NAME" "prefix", TRIM ( "REGMASV5PF"."RMSNAME" ) "fname", TRIM ( "REGMASV5PF"."RMSSURNAM" ) "lname", "REGMASV5PF"."RMSSEX" "sex", ( "RMSBTHYY" - 543 ) * 10000 + ( "RMSBTHMM" * 100 ) + "RMSBTHDD" "birthday_date", "REGMASV5PF"."RMSIDNO" "idcard" FROM "TRHPFV5"."REGMASV5PF" "REGMASV5PF", "TRHPFV5"."PREFIX2" "PREFIX" WHERE "REGMASV5PF"."RMSPRENAM" = "PREFIX"."ID"';
        if (!is_null($keys['hn'])) {
            $sql .= ' AND "REGMASV5PF"."RMSHNREF" = \'' . $keys['hn'] . '\'';
        } else if (!is_null($keys['fname']) AND ! is_null($keys['lname'])) {
            $sql .= ' AND "REGMASV5PF"."RMSNAME" LIKE \'' . $keys['fname'] . '%\' AND "REGMASV5PF"."RMSSURNAM" LIKE \'' . $keys['lname'] . '%\' ORDER BY "RMSNAME" , "RMSSURNAM"';
        } else if (!is_null($keys['fname']) AND is_null($keys['lname'])) {
            $sql .= ' AND "REGMASV5PF"."RMSNAME" LIKE \'' . $keys['fname'] . '% ORDER BY "RMSNAME" , "RMSSURNAM"';
        } else {
            $sql = "SELECT rmshnref AS hn, rmsname AS fname, rmssurnam AS lname FROM regmasv5pf WHERE rmshnref = 0";
        }
        $this->JDO = new \Orr\Jdo('orrconn', 'xoylfk', 'jdbc:as400://10.1.99.2/trhpfv5');
        //echo $sql;
        return $this->cacheFatch('his_patient', $this->JDO->query($sql));
    }

    /**
     * เก็บข้อมูล API ที่ใช้งานบ่อย
     * @param type $table
     * @param array $data
     * @return array
     */
    private function cacheFatch($table, array $data) {
        $this->load->database();
        foreach ($data as $value) {
            $this->db->replace($table, $value);
        }
        return $data;
    }

}
