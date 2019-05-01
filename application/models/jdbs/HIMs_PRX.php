<?php

if (defined('BASEPATH')) {
    require_once(APPPATH . 'libraries/orr/Jdo.php');
} else {
    exit('No direct script access allowed');
}

/**
 * ทะเบียนผู้ป่วยที่แพ้ยา
 * @author Suchart Bunhachirat <suchartbu@gmail.com>
 */
class HIMs_PRX extends CI_Model {

    private $JDO = NULL;

    public function __construct() {
        parent::__construct();
    }

    public function fatchDrugAllergy(array $keys) {
        $sql = 'SELECT "REGALGV5PF"."RAGHN" "hn", "PRDMASV5PF"."PRDPRDNAM" "drug_name", "PHATABV5PF"."PTBTABNAM" "phamaco_name", "GNCTABV5PF"."GTBGNCNAM" "generic_name", "REGALGV5PF"."RAGREMARK" "description", ( 25000000 + "RAGSECDTE" ) - 5430000 "update_date" FROM { oj "TRHPFV5"."REGALGV5PF" "REGALGV5PF" LEFT OUTER JOIN "TRHPFV5"."PRDMASV5PF" "PRDMASV5PF" ON "REGALGV5PF"."RAGPRDNO" = "PRDMASV5PF"."PRDPRDNO" LEFT OUTER JOIN "TRHPFV5"."GNCTABV5PF" "GNCTABV5PF" ON "REGALGV5PF"."RAGGENCOD" = "GNCTABV5PF"."GTBGNCCOD" LEFT OUTER JOIN "TRHPFV5"."PHATABV5PF" "PHATABV5PF" ON "REGALGV5PF"."RAGPHARMA1" = "PHATABV5PF"."PTBTABCOD1" AND "REGALGV5PF"."RAGPHARMA2" = "PHATABV5PF"."PTBTABCOD2" AND "REGALGV5PF"."RAGPHARMA3" = "PHATABV5PF"."PTBTABCOD3" } WHERE ';
        if (!is_null($keys['hn'])) {
            $sql .= '"REGALGV5PF"."RAGHN" = ' . $keys['hn'];
        } else {
            $sql .= '"REGALGV5PF"."RAGHN" = 0';
        }

        $this->JDO = new \Orr\Jdo('orrconn', 'xoylfk', 'jdbc:as400://10.1.99.2/trhpfv5');
        return $this->JDO->query($sql);
    }

    /**
     * ข้อมูลยา
     * @param array $keys ['is_sync' => TRUE]
     * @return array
     */
    public function fatchDrug(array $keys) {
        $sql = 'SELECT "PRDPRDNO" "id", "PRDPRDNAM" "trade_name", "PRDGNCNAM" "general_name" FROM "TRHPFV5"."PRDMASV5PF" "PRDMASV5PF" WHERE "PRDPRDTYP" = \'M\' ';
        if (!$keys['is_sync']) {
            $sql .= 'AND  "PRDPRDNO" = \'\'';
        }
        $this->JDO = new \Orr\Jdo('orrconn', 'xoylfk', 'jdbc:as400://10.1.99.2/trhpfv5');
        return $this->cacheFatch('his_drug', $this->JDO->query($sql));
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
