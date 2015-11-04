<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Module extends RS_Controller {
    
    public $data = array();
    
    function __construct() {
        parent::__construct();
        header("Content-type:text/html;charset=utf-8");
        $this->data['current_first_level'] = '9';
        $this->data['current_second_level'] = '9-3';
        $this->data['current_third_level'] = '9-3-3';
    }
    
    function index() {
    	$per_page = $this->input->get("per_page") ? $this->input->get("per_page") : 0;
        $this->load->model('cf_template_model', 'cftemplate');
        $this->data = array_merge($this->data, $this->cftemplate->page($per_page, site_url('sms/module?')));
        $this->load->view('sms/module', $this->data);
    }
    
    function dodel() {
        $id = intval(trim($this->uri->rsegment(3)));
        $id === 0 && show_error('id 不能为 0!', 500, '出现错误!');
        $this->load->model('cf_template_model', 'cftemplate');
        $this->cftemplate->del(array('id' => $id));
        header('location: '.site_url('sms/module'));
    }
    
    function add() {
        $this->load->view('sms/addmodule', $this->data);
    }
    
    function doadd() {
        $this->load->model('cf_template_model', 'cftemplate');
        $this->cftemplate->insert($this->input->post('data'));
        header('location: '.site_url('sms/module'));
    }
}