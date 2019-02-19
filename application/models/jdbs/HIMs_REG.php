<?php

if (defined('BASEPATH')) {
    require_once(APPPATH . 'libraries/orr/JDO.php');
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

    public function fatchDataPatient(array $keys) {
        if (!is_null($keys['hn'])) {
            $sql = "SELECT rmshnref AS hn, rmsname AS fname, rmssurnam AS lname FROM regmasv5pf WHERE rmshnref = '" . $keys['hn'] . "'";
        } else if (!is_null($keys['fname']) AND !is_null($keys['lname'])) {
            $sql = "SELECT rmshnref AS hn, rmsname AS fname, rmssurnam AS lname FROM regmasv5pf WHERE RMSNAME LIKE '" . $keys['fname'] . "%' AND RMSSURNAM LIKE '" . $keys['lname'] . "%' ORDER BY rmsname , rmssurnam";
        } else if (!is_null($keys['fname']) AND is_null($keys['lname'])) {
            $sql = "SELECT rmshnref AS hn, rmsname AS fname, rmssurnam AS lname FROM regmasv5pf WHERE RMSNAME LIKE '" . $keys['fname'] . "%' ORDER BY rmsname";
        }else{
            $sql = "SELECT rmshnref AS hn, rmsname AS fname, rmssurnam AS lname FROM regmasv5pf WHERE rmshnref = 0";
        }
        $this->JDO = new \orr\JDO('orrconn', 'xoylfk', 'jdbc:as400://10.1.99.2/trhpfv5');
        //echo $sql;
        return $this->JDO->query($sql);
    }

}
