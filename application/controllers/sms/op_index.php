<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class op_index extends RS_Controller {
    function __construct(){
        parent::__construct();
        $this->data['current_first_level'] = '9';
        $this->data['current_second_level'] = '9-3';
        $this->data['current_third_level'] = '9-3-1';
    }

    public function index(){
	    //取得分页的信息
	    $DB = $this->load->database('sms',true);
	    $q = $DB->query("SELECT * FROM `interfaces` ORDER BY `id` DESC");
	    
	    
	    $this->data['list'] = $q->result_array();
		$this->load->view('sms/op_index', $this->data);
    }
	
	/*public function set($id = 0, $status = 0){
	   if(!$id || !is_numeric($id) || !$status || !is_numeric($status)){
            echo js_history();
            return ;
        }
   
	    $cation = strip_tags($this->smsop->get_status($status));
	    if(!$this->smsop->shield($id, $status)){
	        echo js_alert($cation.'失败').js_history();
	    }
	    echo js_alert($cation.'成功').js_nolocation($this->data['rurl']);
	}
	
	public function delete($id = 0){
	    if(!$id) {
	        echo js_history();
	        return ;
	    }
	    if(!$this->smsop->shield($id, 9)){
	        echo js_alert('删除失败').js_history();
            exit;
        }
        echo js_alert('删除成功').js_nolocation($this->data['rurl']);
	}*/
}