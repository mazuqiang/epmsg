<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RS_Error {
	private $errors = array();
	public function __construct (){}
	
	public function add ($key, $value){
		$this->clean($key);
		$this->errors[$key] = $value;
	}
	
	public function clean ($key = ''){
		if($key === ''){
			unset($this->errors[$key]);
			$this->errors[$key] = NULL;
		}else{
			unset($this->errors);
			$this->errors = NULL;
		}
	}
	
	public function get($key){
		return $this->errors[$key];
	}
	
	
}