<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use JsonRpc\Server as JsonServer;

/**
 * Description of Json_rpc_server
 * Use JsonRpc\Server As Json_rpc_server
 * @author Suchart Bunhachirat
 */
class Json_rpc_server extends JsonServer {

    /**
     * @param array $param_ ['methodHandler'] , ['transport']
     */
    public function __construct(array $param_) {
        parent::__construct($param_['methodHandler'], $param_['transport']);
    }

}
