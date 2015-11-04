<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class op_add extends RS_Controller {
	function __construct(){
		parent::__construct();
        $this->data['current_first_level'] = '9';
        $this->data['current_second_level'] = '9-3';
        $this->data['current_third_level'] = '9-3-2';
		$this->load->model('smsop_model', 'smsop');
	}
	
	public function index (){
	   	$this->data['smsop'] = &$this->smsop;
	   	$this->data['do_url'] = site_url('sms/op_add/do_add') ;
	    $this->load->view('sms/op_add',$this->data);
	}
	
	public function do_add(){
        $result = $this->smsop->op_validation();
        if(empty($result)){
            echo js_alert($this->rs_error->get('op_validation')).js_history();
            exit;
        }
        
        $data = $this->input->post(NULL, TRUE);

        $result = $this->smsop->add($data);
        if(empty($result)){
            echo js_alert($this->rs_error->get('add')).js_history();
            exit;
        }
	    echo js_alert('增加成功').js_location('sms/op_index');
	}
	
	public function edit($id = 0){
	    if(!$id) echo js_history();
	    $result = $this->smsop->get_infobyid($id);
	    if(empty($result)){
	        echo js_alert($this->rs_error->get('get_infobyid')).js_history();
	        return ;
	    }
	    $this->data['smsop'] = &$this->smsop;
	    $this->data['do_url'] = site_url('sms/op_add/do_edit/'.$id) ;
	    $this->load->view('sms/op_add',$this->data);
	}
	
	public function do_edit($id = 0){
	    if(!$id) echo js_history();
	     
	    $result = $this->smsop->get_infobyid($id);
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
	    $result = $this->smsop->update_byid($id, $data);
	    if(empty($result)){
	        echo js_alert($this->rs_error->get('update_byid')).js_history();
	        exit;
	    }
	    echo js_alert('修改成功').js_nolocation($this->data['rurl']);
	}	
}