<?php

namespace model;

if (defined('BASEPATH')) {
    require_once(APPPATH . 'libraries/orr/Jdb_jt400.php');
} else {
    exit('No direct script access allowed');
}

/**
 * Description of TRHPFV5
 * การใช้งานฐานข้อมูล TRHPFV5 จาก HIMsV5
 * @author suchart bunhachirat
 */
class TRHPFV5 extends \orr\Jdb_jt400 {
    public function __construct($user,$passwd) {
        parent::__construct($user,$passwd,'10.1.99.2/trhpfv5');
    }

    public function InsertJdbc_test($id,$name) {
        $sql = "INSERT INTO jdbc_test (id,name) VALUES('$id','$name')";
        return $this->execUpdate($sql);
    }
    
    public function UpdateJdbc_test() {
        $sql = "UPDATE jdbc_test SET name='ปรับปรุงจาก UpdataJdbc' WHERE id=19";
        return $this->execUpdate($sql);
    }
    
    public function DeleteJdbc_test($id) {
        $sql = "DELETE FROM jdbc_test WHERE id = $id";
        return $this->execUpdate($sql);
    }
    
    public function SelectPatient() {
        //$sql = "SELECT RMSHNREF, RMSNAME, RMSSURNAM FROM regmasv5pf WHERE \"RMSNAME\" = 'สุชาติ'";
        $sql = "SELECT \"RMSHNREF\", \"RMSNAME\", \"RMSSURNAM\" FROM \"regmasv5pf\" WHERE \"RMSNAME\" LIKE 'สุชา%' AND \"RMSSURNAM\" LIKE 'บุญ%'";
        //$sql = "SELECT \"HN___00001\", \"FNAME00001\" FROM \"patient\" WHERE \"FNAME00001\" = 'สุชาติ'";
        return $this->execQuery($sql);
    }

}