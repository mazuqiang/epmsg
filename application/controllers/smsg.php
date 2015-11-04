<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

global $args;
$args = array();

class smsg extends RS_Controller {
    
    function __construct() {
        parent::__construct();
        global $args;
        $args['method'] = strtolower(trim($_SERVER['REQUEST_METHOD']));
        $t = empty($_GET) ? $_POST : $_GET;
        $args['url'] = $_SERVER['SERVER_NAME'].substr($_SERVER['REQUEST_URI'], 0, 0-strlen($_SERVER['QUERY_STRING']));
        $args = array_merge($args, $t);
        $args['ip'] = sprintf("%u\n", ip2long($_SERVER['REMOTE_ADDR']));
        $this->load->model('cf_requests_model', 'cf_request');
        $this->cf_request->insert($args);
        $args = array('requests_id' => $this->cf_request->last_id());
    }
    
    function send() {
        empty($_GET) && $_GET = $_POST;
        $this->load->driver('sms', array('args' => $_GET));
        echo $this->sms->send();
    }
    
    function sendvcode() {
    	empty($_GET) && $_GET = $_POST;
    	$this->load->driver('sms', array('args' => $_GET));
    	echo $this->sms->vcode();
    }
    
    function checkvcode() {
    	empty($_GET) && $_GET = $_POST;
    	$this->load->driver('sms', array('args' => $_GET));
    	echo $this->sms->checkvcode();
    }
    
}