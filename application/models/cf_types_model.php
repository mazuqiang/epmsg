<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class cf_types_model extends RS_Model
{
	protected $tablename = '`types`';

	function __construct() {
		$this->db = $this->load->database('sms', TRUE);
		parent::__construct();
	}

	function insert($data) {
	    return parent::insert($data);
	}

	function page( $per_page = 0, $url){
		$like = array();
		$where = array();	
		//  var_dump($url);exit;
		return parent::page($where, $like, $per_page, $url);
	}
	
	function get_list($where = array(), $like = array(), $limit = array()) {
		$this->db->order_by('`id`', 'DESC');
		return parent::get_list($where, $like, $limit);
	}
}