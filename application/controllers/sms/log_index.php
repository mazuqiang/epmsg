<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class log_index extends RS_Controller {
    function __construct(){
        parent::__construct();
        $this->data['current_first_level'] = '9';
        $this->data['current_second_level'] = '9-2';
        $this->data['current_third_level'] = '9-2-1';			
		$this->load->model('smslog_model', 'smslog');
		$this->load->model('smsapp_model', 'smsapp');
		$this->load->model('smsop_model', 'smsop');
    }

    public function index (){

	    //取得分页的信息
	    $per_page = $this->input->get("per_page") ? $this->input->get("per_page") : 0  ;
	    $data = $this->smslog->page($per_page, site_url("sms/log_index?") );
	    if(!empty($data)) $this->data = array_merge($this->data, $data) ;
	    $this->data['smslog'] = &$this->smslog;
	    $this->data['app_list'] = $this->smsapp->get_list();
	    $this->data['op_list'] = $this->smsop->get_list();
		
		//var_dump($this->db->queries);exit;
		$this->load->view('sms/log_index', $this->data);
	}
}