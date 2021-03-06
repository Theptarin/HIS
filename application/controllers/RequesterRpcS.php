<?php

if (defined('BASEPATH')) {
    chdir(__DIR__);
    ini_set('default_charset', 'UTF-8');

    # we don't want any PHP errors being output
    ini_set('display_errors', '0');
    # so we will log them. Exceptions will be logged as well
    ini_set('log_errors', '1');
    ini_set('error_log', 'server-errors.log');
} else {
    exit('No direct script access allowed');
}
/**
 * Register Server API
 */
class ServerMethods {

    public $error = null;
    
    public function getById($id) {
        $ci = & get_instance();
        $ci->load->model('jdbs/HIMs_AUT');
        $HIMs_AUT = new HIMs_AUT();
        return $HIMs_AUT->fatchRequester(['id' => $id]);
    }
}

/**
 * Description of RequesterRpcS
 * HIS Patient RPC Server
 * @author suchart bunhachirat
 */
class RequesterRpcS extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        # set up our method handler class
        $methods = new ServerMethods();

        # create our server object, passing it the method handler class
        $this->load->library('vendor/json_rpc_server', ['methodHandler' => $methods]);

        # and tell the server to do its stuff
        $this->json_rpc_server->receive();
    }

}
