<?php
use Orr\Jdo as Jdo;

/**
 * Description of Orr_jdo
 *
 * @author it
 */
class Orr_jdo extends Jdo {
    /**
     * @param array $param_ ['user'],['passwd', $url]
     */
    public function __construct(array $param_) {
        parent::__construct($param['user'], $param['passwd'], $$param['url']);
    }
}
