<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class cf_log_last_vcode_model extends RS_Model
{
	protected $tablename = '`log_last_vcode`';

	function __construct() {
		$this->db = $this->load->database('sms', TRUE);
		parent::__construct();
	}
	
    function gettodaysents($passport_id, $mobileNo) {
        $where = array('passport_id' => $passport_id,
                       'mobileNo' => $mobileNo,
                       'time >= ' => date('Y-m-d', time()));
        return intval(trim($this->get_count($where)));
    }
    
}