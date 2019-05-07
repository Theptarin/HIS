<?php

if (defined('BASEPATH')) {
    //require_once(APPPATH . 'libraries/orr/Jdo.php');
} else {
    exit('No direct script access allowed');
}

/**
 * ฐานข้อมูลการวินิจฉัยโรค ICD10
 * @author suchart bunhachirat
 */
class IMC_ICD10 extends CI_Model {

    public function facthICD10Principal(array $keys) {
        $db = $this->load->database('theptarin', TRUE);
        $sql = "SELECT `id`,`code`,`name_en`,`chronic`,`external_cause` FROM `imc_icd10_code`";
        if (!is_null($keys['search'])) {
            $sql .= " WHERE `external_cause` = 0 AND CONCAT(`code`,`name_en`) LIKE '" . $keys['search'] . "%'";
        } else if (!is_null($keys['code'])) {
            $sql .= " WHERE `external_cause` = 0 AND `code` = '" . $keys['code'] . "'";
        } else {
            $sql .= " WHERE `id` = 0";
        }
        $query = $db->query($sql);
        return $query->result_array();
    }

}
