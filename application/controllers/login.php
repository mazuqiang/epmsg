<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->data['current_first_level'] = '0';
		$this->load->model('Admin_model', 'admin');
	}
	
	function index(){
// 	    var_dump( $this->admin);
		$this->load->view('login');
	}
	
	public function do_login(){
		$result = $this->admin->login_validation();
		if(!$result){
			echo js_alert($this->rs_error->get('login_validation')).js_history();
			return ;
		}
		foreach ($_POST as $key => $value) {
			$data[$key] = strtolower(trim($this->input->post($key)));
		}
		if(!$this->admin->do_login($data['admin_name'], $data['admin_pwd'])){
			echo js_alert($this->rs_error->get('do_login')).js_history();
			return ;
		}
		echo js_location('index');
	}
	
	
	
}