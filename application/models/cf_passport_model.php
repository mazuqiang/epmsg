<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class cf_passport_model extends RS_Model
{
    protected $tablename = 'passport';
    
    function __construct() {
    	$this->db = $this->load->database('sms', TRUE);
        parent::__construct();
    }
    
    public function get_infoBAppId($appId)
    {
        return parent::get_list(array('appId' => intval(trim($appId))));
    }

}