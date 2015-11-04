<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class cf_log_model extends RS_Model
{
	protected $tablename = 'log';

	function __construct() {
		$this->db = $this->load->database('sms', TRUE);
		parent::__construct();
	}

    function gettodaysents($passport_id, $mobileNo, $type) {
        $where = array('passport_id' => $passport_id,
                       'mobileNo' => $mobileNo,
                       'type' => $type,
                       'status' => 1,
                       'is_validate <>' => '2',
                       'time >= ' => date('Y-m-d', time()));
        return intval(trim($this->get_count($where)));
    }
    
    function getsentpassed($passport_id, $mobileNo, $type) {
        $where = array('passport_id' => $passport_id, 'mobileNo' => $mobileNo, 'type' => $type, 'status' => 1, 'is_validate <>' => '2');
		$this->db->order_by('time', 'DESC');
        return parent::get_info($where, array(), 'time');
    }
    
    function insert($data) {
        parent::insert($data);
    }
    
    function getvcode(& $log, $expire = 600) {
    	$where = array('passport_id' => $log['passport_id'],
                       'mobileNo' => $log['mobileNo'],
                       'type' => $log['type'],
                       'status' => 1,
                       'is_validate' => '1',
                       'code_status' => '1',
                       'generate_time >= ' => date('Y-m-d H:i:s', (time()-$expire)));
    	$cnt = parent::get_info($where, array(), 'content, time, generate_time');
        if (empty($cnt)) {
            $log['content'] = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
            $log['generate_time'] = date('Y-m-d H:i:s', time());
        } else {
        	$log['content'] = $cnt['content'];
            $log['generate_time'] = $cnt['generate_time'];
        }
    }
    
    function checkvcode($args, $expire) {
    	$where = array('passport_id' => $args['appId'],
    			'mobileNo' => $args['mobileNo'],
    			'content' => $args['content'],
                'type' => $args['type'],
    			'status' => 1,
    			'is_validate' => '1',
                'code_status' => '1',
                'generate_time >= ' => date('Y-m-d H:i:s', (time()-$expire)));
        $ret = parent::get_list($where, array(), 'id');
        if(!empty($ret) ) {
            $ids = array();
            foreach($ret as $k => $v) array_push($ids, $v->id);
            $this->db->where_in('id', $ids);
            $this->db->set('code_status', '0');
            $this->update(array());
            return true;
        } else {
            return false;
        }
    }
    
    function page( $per_page = 0, $url){
        $like = array();
        $where = array();
    
        $data = $this->input->get(NULL, TRUE);
        !empty($data['mobileNo']) && $where['mobileNo'] = trim($data['mobileNo']);
        !empty($data['interface_id']) && $where['log.interface_id'] = trim($data['interface_id']);
        !empty($data['content']) && $where['content'] = trim($data['content']);
        if(!empty($data['status'])) intval(trim($data['status'])) === 2 && $where['status'] = 0;
        (!empty($data['status']) && intval(trim($data['status']))!==2) && $where['status'] = trim($data['status']);
        !empty($data['appId']) && $where['appId'] = trim($data['appId']);
        !empty($data['type']) && $where['type'] = trim($data['type']);
        !empty($data['start_time']) && $where['log.time >='] = trim($data['start_time']);
        !empty($data['end_time']) && $where['log.time <='] = trim($data['end_time']);
        if($data){
            unset($data['per_page']);
            $url .= http_build_query($data);
        }
    
        //  var_dump($url);exit;
        return parent::page($where, $like, $per_page, $url);
    }
    
    function get_list($where, $like, $limit) {
        $this->db->order_by('log.id', 'DESC');
        $this->db->join('passport_interface', 'log.passport_id = passport_interface.passport_id');
        return parent::get_list($where, $like, $limit);
    }
    
}