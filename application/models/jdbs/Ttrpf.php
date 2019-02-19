<?php

if (defined('BASEPATH')) {
    require_once(APPPATH . 'libraries/orr/JDO.php');
} else {
    exit('No direct script access allowed');
}

/**
 * Description of Jdb_ttrpf
 * ตัวอย่างการใช้งานฐานข้อมูล ttrpf จาก AS400
 * @author suchart bunhachirat
 */
class Ttrpf extends \CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function Select() {
        $jdo = new \orr\JDO('orrconn', 'xoylfk', 'jdbc:as400://10.1.99.2/ttrpf');
        $sql = "SELECT * FROM jdbc_test";
        return $jdo->query($sql);
    }

}
