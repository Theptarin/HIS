<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use JsonRpc\Client as JsonClient;

/**
 * Description of Json_rpc_client
 * Use JsonRpc\Client As Json_rpc_client
 * @author Suchart Bunhachirat
 */
class Json_rpc_client extends JsonClient {

    /**
     * @param array $param_ ['url'],['transport']
     */
    public function __construct(array $param_) {
        //print_r($params);
        parent::__construct($param_['url'], $param_['transport']);
    }

}
