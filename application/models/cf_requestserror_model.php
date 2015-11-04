<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class cf_requestserror_model extends RS_Model
{
    protected $tablename = 'requests_error';
    
    function __construct() {
    	$this->db = $this->load->database('sms', TRUE);
        parent::__construct();
    }
    
    function insert($data) {
        return parent::insert($data);
    }

}