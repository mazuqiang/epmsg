<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Applications extends RS_Controller {
    
    public $data = array();
    
    function __construct() {
        parent::__construct();
        header("Content-type:text/html;charset=utf-8");
        $this->data['current_first_level'] = '9';
        $this->data['current_second_level'] = '9-1';
        $this->data['current_third_level'] = '9-1-1';
        $this->load->model('cf_log_model', 'cflog');
        $this->load->model('cf_passport_model', 'cfpassport');
        $this->load->model('cf_applications_model', 'cfapplications');
        $DB = $this->load->database('sms', true);
        $tp1 = $DB->query('SELECT `passport_id`, `interface_id` FROM `passport_interface`');
        $this->pi = array();
        foreach($tp1->result_array() as $k => $v) $this->pi[intval(trim($v['passport_id']))] = intval(trim($v['interface_id']));
        $tp2 = $DB->query('SELECT `id`, `desc` FROM `interfaces`');
        $this->interfaces = array();
        foreach($tp2->result_array() as $k=>$v) $this->interfaces[intval(trim($v['id']))] = trim($v['desc']);       
    }
    
    function index() {
        $this->data['apps'] = $this->cfapplications->get_list();
        $this->load->view('sms/applications', $this->data);
    }
    
    function keys() {
        $appId = intval(trim($this->uri->rsegment(3)));
        $this->data['keys'] = $this->cfpassport->get_list(array('appId' => $appId));
        foreach($this->data['keys'] as $k => $v) {
            if(isset($this->pi[intval(trim($v->id))])) {
                $tid = $this->pi[intval(trim($v->id))];
                $this->data['keys'][$k]->interface_desc = $this->interfaces[$tid];
            } else {
                $this->data['keys'][$k]->interface_desc = '<font color="#ff0000">未绑定短信接口！</font>';
            }
            trim($v->allow_ips) !== '' && $this->data['keys'][$k]->allow_ips = str_replace(',', '<br />', trim($v->allow_ips));
        }
        $this->data['appId'] = $appId;
        $this->load->view('sms/applications_keys', $this->data);
    }
    
    function addapp() {
        $this->load->view('sms/addapp', $this->data);
    }
    
    function doaddapp() {
        $DB = $this->load->database('sms', TRUE);
        $data = $this->bb($this->input->post('data'));
        $DB->insert('`applications`', $data);
        header('location: '.site_url('sms/applications'));
    }
    
    function dodelapp() {
        $id = intval(trim($this->uri->rsegment(3)));
        $id === 0 && show_error('id 不能为 0!', 500, '出现错误!');
        $app = $this->cfapplications->get_info(array('id' => $id));
        $keys = $this->cfpassport->get_list(array('appId' => intval(trim($app['appId']))));
        foreach($keys as $k=>$v) $this->dodelkey(intval(trim($v->id)));
        $this->load->model('cf_applications_model', 'cfapplications');
        $this->cfapplications->del(array('id' => $id));
        header('location: '.site_url('sms/applications'));
    }
    
    function addkey() {
        $appId = intval(trim($this->uri->rsegment(3)));
        $appId === 0 && show_error('appId 不能为 0!', 500, '出现错误!');
        $this->data['appId'] = $appId;
        $this->data['interfaces'] = $this->interfaces;
    	$this->load->view('sms/addkey', $this->data);
    }
    
    function doaddkey() {
        $DB = $this->load->database('sms', TRUE);
        $data = $this->bb($this->input->post('data'));
        $DB->insert('`passport`', $data);
        $interface_id = intval(trim($this->input->post('interface_id')));
        if($interface_id >= 1) {
            $passport_id = $DB->insert_id();
            $DB->insert('passport_interface', array('passport_id' => $passport_id, 'interface_id' => $interface_id));
        }
        header('location: '.site_url('sms/applications/keys').'/'.intval(trim($data['`appId`'])));
    }
    
    function editkey() {
        $passport_id = intval(trim($this->uri->rsegment(3)));
        $this->data['key'] = $this->cfpassport->get_info(array('id' => $passport_id));
        $this->data['key']['interface_id'] = 0;
        if(isset($this->pi[$this->data['key']['id']])) $this->data['key']['interface_id'] = $this->pi[$this->data['key']['id']];
        $this->data['interfaces'] = $this->interfaces;
        empty($this->data['key']) && show_error('没有该数据!', 500, '出现错误!');
        $this->load->view('sms/editkey', $this->data);
    }

    function doeditkey() {
        $passport_id = intval(trim($this->input->post('passport_id')));
    	$DB = $this->load->database('sms', TRUE);
    	$data = $this->bb($this->input->post('data'));
    	$DB->update('`passport`', $data, array('id' => $passport_id));
    	$interface_id = intval(trim($this->input->post('interface_id')));
    	if($interface_id >= 1) {
    		if(!isset($this->pi[$passport_id]))
    		    $DB->insert('passport_interface', array('passport_id' => $passport_id, 'interface_id' => $interface_id));
    		else
                $DB->update('passport_interface', array('interface_id' => $interface_id), array('passport_id' => $passport_id));
        } else {
            $DB->where('passport_id', $passport_id);
            $DB->delete('passport_interface');
        }
    	header('location: '.site_url('sms/applications/keys').'/'.intval(trim($this->input->post('appId'))));
    }

    function dodelkey($id = 0) {
    	$id = intval(trim($id));
    	$id === 0 && show_error('id 不能为 0!', 500, '出现错误!');
        $DB = $this->load->database('sms', TRUE);
    	 
        if(isset($this->pi[$id])) {
            $DB->where('passport_id', $id);
            $DB->delete('passport_interface');
        }
        
        $this->cfpassport->del(array('id' => $id));
        
        header('location: '.site_url('sms/applications'));
    }
    
    private function bb($a) {
        $t = array();
        foreach($a as $k => $v) $t['`'.$k.'`'] = $v;
        return $t;
    }
    
}