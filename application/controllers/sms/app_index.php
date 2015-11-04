<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_index extends RS_Controller {
    function __construct(){
        parent::__construct();
        $this->data['current_first_level'] = '9';
        $this->data['current_second_level'] = '9-1';
        $this->data['current_third_level'] = '9-1-1';			
		$this->load->model('smsapp_model', 'smsapp');
    }

    public function index (){

	    //取得分页的信息
	    $per_page = $this->input->get("per_page") ? $this->input->get("per_page") : 0  ;
	    $data = $this->smsapp->page($per_page, site_url("sms/app_index?") );
	    if(!empty($data)) $this->data = array_merge($this->data, $data) ;
	    
	    $this->data['smsapp'] = &$this->smsapp;
		$this->load->view('sms/app_index', $this->data);
	}
	
	public function set($id = 0, $status = 0){
	   if(!$id || !is_numeric($id) || !$status || !is_numeric($status)){
            echo js_history();
            return ;
        }
   
	    $cation = strip_tags($this->smsapp->get_status($status));
	    if(!$this->smsapp->shield($id, $status)){
	        echo js_alert($cation.'失败').js_history();
	    }
	    echo js_alert($cation.'成功').js_nolocation($this->data['rurl']);
	}
	
	public function delete($id = 0){
	    if(!$id) {
	        echo js_history();
	        return ;
	    }
	    if(!$this->smsapp->shield($id, 9)){
	        echo js_alert('删除失败').js_history();
            exit;
        }
        echo js_alert('删除成功').js_nolocation($this->data['rurl']);
	}
}