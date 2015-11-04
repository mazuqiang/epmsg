<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Types extends RS_Controller {
    
    public $data = array();
    
    function __construct() {
        parent::__construct();
        header("Content-type:text/html;charset=utf-8");
        $this->data['current_first_level'] = '9';
        $this->data['current_second_level'] = '9-1';
        $this->data['current_third_level'] = '9-1-2';
    }
    
    function index() {
        $per_page = $this->input->get("per_page") ? $this->input->get("per_page") : 0;
        $this->load->model('cf_types_model', 'cftypes');
	    $this->data = array_merge($this->data, $this->cftypes->page($per_page, site_url('sms/types?')));
        $this->load->view('sms/types', $this->data);
    }
    
    function addtype() {
    	$this->load->view('sms/addtype', $this->data);
    }
    
    function doaddtype() {
        $DB = $this->load->database('sms', TRUE);
        $data = $this->bb($this->input->post('data'));
        $DB->insert('`types`', $data);
        header('location: '.site_url('sms/types'));
    }
    
    function dodeltype() {
        $id = intval(trim($this->uri->rsegment(3)));
        $id === 0 && show_error('id 不能为 0!', 500, '出现错误!');
        $this->load->model('cf_types_model', 'cftypes');
        $this->cftypes->del(array('id' => $id));
        header('location: '.site_url('sms/types'));
    }
    
    private function bb($a) {
    	$t = array();
    	foreach($a as $k => $v) $t['`'.$k.'`'] = $v;
    	return $t;
    }
    
}