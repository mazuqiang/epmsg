<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log extends RS_Controller {
    
    public $data = array();
    
    function __construct() {
        parent::__construct();
        $this->data['current_first_level'] = '9';
        $this->data['current_second_level'] = '9-2';
        $this->data['current_third_level'] = '9-2-1';
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
        $apps = $passport = array();
        $tmp = $this->cfapplications->get_list();
        foreach($tmp as $k => $v) $apps[intval(trim($v->appId))] = $v;
        $tmp = $this->cfpassport->get_list();
        foreach($tmp as $k => $v) $passport[intval(trim($v->id))] = $v;
        $this->load->model('cf_log_model', 'cflog');
        $per_page = $this->input->get("per_page") ? $this->input->get("per_page") : 0;
        $data = $this->cflog->page($per_page, site_url('sms/log?'));
        $this->data['list'] = $data['list'];
        $this->data['pages'] = $data['pages'];
        $this->data['count'] = $data['count'];
        $this->data['apps'] = $apps;
        $this->data['passport'] = $passport;
        $this->data['pi'] = $this->pi;
        $this->data['interfaces'] = $this->interfaces;
        $this->load->model('cf_types_model', 'cftypes');
        $this->data['types'] = $this->cftypes->get_list();
        $this->load->view('sms/log', $this->data);
    }
}