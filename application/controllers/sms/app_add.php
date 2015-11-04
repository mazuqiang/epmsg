<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_add extends RS_Controller {
	function __construct(){
		parent::__construct();
        $this->data['current_first_level'] = '9';
        $this->data['current_second_level'] = '9-1';
        $this->data['current_third_level'] = '9-1-2';
		$this->load->model('smsapp_model', 'smsapp');
	}
	public function index (){
	   	$this->data['smsapp'] = &$this->smsapp;
	   	$this->data['do_url'] = site_url('sms/app_add/do_add') ;
	    $this->load->view('sms/app_add',$this->data);
	}
	
	public function do_add(){
        $result = $this->smsapp->app_validation();
        if(empty($result)){
            echo js_alert($this->rs_error->get('app_validation')).js_history();
            exit;
        }
        
        $data = $this->input->post(NULL, TRUE);

        $result = $this->smsapp->add($data);
        if(empty($result)){
            echo js_alert($this->rs_error->get('add')).js_history();
            exit;
        }
	    echo js_alert('增加成功').js_location('sms/app_index');
	}
	
	public function edit($id = 0){
	    if(!$id) echo js_history();
	    $result = $this->smsapp->get_infobyid($id);
	    if(empty($result)){
	        echo js_alert($this->rs_error->get('get_infobyid')).js_history();
	        return ;
	    }
	    $this->data['smsapp'] = &$this->smsapp;
	    $this->data['do_url'] = site_url('sms/app_add/do_edit/'.$id) ;
	    $this->load->view('sms/app_add',$this->data);
	}
	
	public function do_edit($id = 0){
	    if(!$id) echo js_history();
	     
	    $result = $this->smsapp->get_infobyid($id);
	    if(empty($result)){
	        echo js_alert($this->rs_error->get('get_infobyid')).js_history();
	        exit;
	    }
	    
	    /*foreach ($_POST as $key => $value){
	        $value = $this->input->post($key);
	        if(is_string($value)){
	            $value = trim($value);
	        }
	        $data[$key] = $value;
	    } */
	    $data = $this->input->post(NULL, TRUE);
	    $result = $this->smsapp->update_byid($id, $data);
	    if(empty($result)){
	        echo js_alert($this->rs_error->get('update_byid')).js_history();
	        exit;
	    }
	    echo js_alert('修改成功').js_nolocation($this->data['rurl']);
	}
}