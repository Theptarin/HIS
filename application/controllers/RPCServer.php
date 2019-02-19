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
 * Our methods class
 */
class ServerMethods {

    public $error = null;

    public function divide($dividend, $divisor, $int = false) {

        if (!$divisor) {
            $this->error = 'Cannot divide by zero';
        } else {
            $quotient = $dividend / $divisor;
            return $int ? (int) $quotient : $quotient;
        }
    }

}

class RPCServer extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        # set up our method handler class
        $methods = new ServerMethods();

        # create our server object, passing it the method handler class
        //$Server = new JsonRpc\Server($methods);
        $this->load->library('vendor/json_rpc_server', ['methodHandler' => $methods]);

        # and tell the server to do its stuff
        //$Server->receive();
        $this->json_rpc_server->receive();
    }

}
