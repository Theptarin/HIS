<?php

if (defined('BASEPATH')) {
    require_once(APPPATH . 'libraries/orr/JDO.php');
} else {
    exit('No direct script access allowed');
}

/**
 * ข้อมูลงานควบคุมการเข้าใช้ข้อมูล
 * @author Suchart Bunhachirat <suchartbu@gmail.com>
 */
class HIMs_AUT extends CI_Model {

    private $JDO = NULL;

    public function __construct() {
        parent::__construct();
    }

    /**
     * ข้อมูลเกี่ยวกับผู้มีสิทธิ์แก้ไขข้อมูล
     * ['id'] = รหัสผู้บันทึกข้อมูล
     * @param array $keys
     * @return array
     */
    public function fatchRequester(array $keys) {
        $sql = 'SELECT "TUSUSRNAM" "name", "TUSSTFNO" "staff_id", "TUSDRCOD" "doctor_id" FROM "TRHPFV5"."TABUSRV5PF" "TABUSRV5PF" WHERE "TUSACTFLG" = \' \' ';
        if (!is_null($keys['id'])) {
            $sql .= 'AND "TUSUSRCOD" = \'' . strtoupper($keys['id']) . '\'';
        } else {
            $sql .= 'AND "TUSUSRCOD" = \'\'';
        }
        $this->JDO = new \orr\JDO('orrconn', 'xoylfk', 'jdbc:as400://10.1.99.2/trhpfv5');
        //echo $sql;
        return $this->JDO->query($sql);
    }

}
