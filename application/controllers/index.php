<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends RS_Controller {
	function __construct(){
		parent::__construct();
		$this->data['current_first_level'] = '0';
		$this->data['current_second_level'] = '0';
		$this->data['current_third_level'] = '0';
	}
	
	function index(){
		$this->load->view(CURRENT_RS_STYLE.'index',$this->data);
	}
	
	public function logout(){
		$this->session->unset_userdata(ADMININFO);
		echo js_location('login');exit;
	}	
	
	public function change_pwd(){
	    $this->data['do_url'] = site_url('index/change_pwd/do_change') ;
	    $this->load->view(CURRENT_RS_STYLE.'change_pwd',$this->data);
	}
	
	public function do_change(){
	    if($this->admin->changepwd_validation()){
	        echo js_alert($this->rs_error->get('changepwd_validation')).js_history();
	        exit;
	    }
	    
	    foreach ($_POST as $key => $value){
	        $value = $this->input->post($key);
	        if(is_string($value)){
	            $value = trim($value);
	        }
	        $data[$key] = $value;
	    }	 
	       
	    $this->admin->changepwd($data['admin_oldpwd'], $data['admin_pwd']);
	    
	    $this->load->view(CURRENT_RS_STYLE.'change_pwd',$this->data);
	}
	
	
}