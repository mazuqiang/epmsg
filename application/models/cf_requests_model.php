<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class cf_requests_model extends RS_Model
{
    protected $tablename = 'requests';
    
    function __construct() {
    	$this->db = $this->load->database('sms', TRUE);
        parent::__construct();
        foreach ($this->list_fields() as $v){
            $this->$v = NULL;
        }
    }
    
    function insert($data) {
        return parent::insert($data);
    }

    function getAtterbutes(){
        return $this->list_fields();
    }
}