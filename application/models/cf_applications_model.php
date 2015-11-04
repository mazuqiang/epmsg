<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class cf_applications_model extends RS_Model
{
    protected $tablename = 'applications';
    
    function __construct() {
    	$this->db = $this->load->database('sms', TRUE);
        parent::__construct();
    }

    function insert($data) {
        return parent::insert($data);
    }
    
}