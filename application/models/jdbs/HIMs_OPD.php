<?php

if (defined('BASEPATH')) {
    require_once(APPPATH . 'libraries/orr/JDO.php');
} else {
    exit('No direct script access allowed');
}

/**
 * Description of HIMs_OPD
 *
 * @author it
 */
class HIMs_OPD extends CI_Model {

    private $JDO = NULL;

    public function __construct() {
        parent::__construct();
    }

    public function fatchDataVisit(array $keys) {
        if (!is_null($keys['hn'])) {
            $sql = "SELECT OAPREGDTE visit_thdate, OAPREGDTE - 5430000 visit_date, OAPHN hn, OAPVN * 100 + OAPSEQNO vn, OAPDIVCOD div_id, OAPDRCOD doctor_id, OAPCRDSTS card_status FROM TRHPFV5.OPDAPPV5PF OPDAPPV5PF WHERE OAPHN = '" . $keys['hn'] . "'";
            //$sql = "SELECT rmshnref AS hn, rmsname AS fname, rmssurnam AS lname FROM regmasv5pf WHERE rmshnref = '" . $keys['hn'] . "'";
        }
        $this->JDO = new \orr\JDO('orrconn', 'xoylfk', 'jdbc:as400://10.1.99.2/trhpfv5');
        //echo $sql;
        return $this->JDO->query($sql);
    }

}
