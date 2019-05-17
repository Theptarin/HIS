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
        $sql = 'SELECT "PRDPRDNO" "id", "PRDPRDNAM" "trade_name", "PRDGNCNAM" "general_name", "PRDDOSFOM" "dosage_form" FROM "TRHPFV5"."PRDMASV5PF" "PRDMASV5PF" WHERE "PRDPRDTYP" = \'M\'';
        if (!isset($keys['is_sync'])) {
            $sql .= ' AND  "PRDPRDNO" = \'\'';
        }
        $this->JDO = new \Orr\Jdo('orrconn', 'xoylfk', 'jdbc:as400://10.1.99.2/trhpfv5');
        return $this->cacheFatch('his_drug', $this->JDO->query($sql));
    }

    /**
     * ประวัติยาผู้ป่วยเคยได้รับ
     * @param array $keys ['hn' => $hn];
     * @return array
     */
    public function fatchDispense(array $keys) {
        $sql = 'SELECT "BILTRDV5PF"."BTDHN" "hn", "BTDDOCDTE" - 5430000 "document_date", "DRMASV5PF"."DMSDRCOD" "doctor_id", CONCAT( TRIM ( "DMSPRENAM" ), CONCAT( TRIM ( "DMSNAME" ), CONCAT( \' \', TRIM ( "DMSNAME" ) ) ) ) "doctor_name", "BILTRMV5PF"."BTMIOPD" "visit_status", TRIM ( "PRDPRDNO" ) "drug_id", TRIM ( "PRDPRDNAM" ) "drug_trade_name", "BILTRDV5PF"."BTDISSQTY" "quantity", TRIM ( CONCAT( TRIM ( "BTDMTHNAM" ), CONCAT( \' \', CONCAT( TRIM ( "BTDQTYNAM" ), CONCAT( \' \', TRIM ( "BTDUNTNAM" ) ) ) ) ) ) "discription_1", TRIM ( CONCAT( TRIM ( "BTDTIMNAM1" ), CONCAT( \' \', TRIM ( "BTDTIMNAM2" ) ) ) ) "discription_2", TRIM ( CONCAT( TRIM ( "BTDWRNNAM1" ), CONCAT( \' \', CONCAT( TRIM ( "BTDWRNNAM2" ), CONCAT( \' \', TRIM ( "BTDWRNNAM3" ) ) ) ) ) ) "discription_3", "BTMVN1" * 100 + "BTMVN2" "vn", "BILTRMV5PF"."BTMAN" "an", "BILTRMV5PF"."BTMDOCNO" "document_id" FROM { oj "TRHPFV5"."DRMASV5PF" "DRMASV5PF" RIGHT OUTER JOIN "TRHPFV5"."BILTRMV5PF" "BILTRMV5PF" ON "DRMASV5PF"."DMSDRCOD" = "BILTRMV5PF"."BTMDRCOD" }, "TRHPFV5"."BILTRDV5PF" "BILTRDV5PF", "TRHPFV5"."PRDMASV5PF" "PRDMASV5PF" WHERE "BILTRMV5PF"."BTMDOCNO" = "BILTRDV5PF"."BTDDOCNO" AND "BILTRMV5PF"."BTMHN" = "BILTRDV5PF"."BTDHN" AND "PRDMASV5PF"."PRDPRDNO" = "BILTRDV5PF"."BTDPRDNO" AND "BILTRDV5PF"."BTDISSQTY" > 0';
        if (!is_null($keys['hn'])) {
            $sql .= ' AND "BILTRDV5PF"."BTDHN" = ' . $keys['hn'] . ' ORDER BY "document_date" DESC, "document_id" DESC ';
        } else {
            $sql .= ' AND "BILTRDV5PF"."BTDHN" = 0';
        }
        $this->JDO = new \Orr\Jdo('orrconn', 'xoylfk', 'jdbc:as400://10.1.99.2/trhpfv5');
        return $this->JDO->query($sql);
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
