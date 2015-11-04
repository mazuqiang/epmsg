<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RS_Model extends CI_Model{

	function __construct(){
		parent::__construct();
	}
	

	public function get_action_status($status){}
	
	public function set_data($data){
		foreach ($this as $key => $value) {
			if($key == 'tablename') continue;
			isset($data[$key]) && ($this->$key = $data[$key]) ;	
		}
	}
	
	public function get_count($where = array(), $like  = array()){
		if(!empty($like) && is_array($like)) $this->db->like($like);
		$results = $this->db->select('COUNT(*) AS COUNT')
							->from($this->tablename)
							->where($where)
							->get()->row_array();
		//var_dump($this->db);
		return $results['COUNT'];
	}
	
	
	function page($where = array(), $like  = array(), $per_page = 0, $url){
		$data['count'] = $this->get_count($where, $like);
		if($data['count'] == 0) return array('count'=>0, 'list'=>array(), 'pages'=>'');
		
		//分页样式配置
		$this->load->library('pagination');
		$this->config->load("pagination_config" , true ) ;
		$config['pagination_config'] = $this->config->config['pagination_config']['config'];
		$config['pagination_config']['base_url'] = $url; 
		$config['pagination_config']['total_rows'] = $data['count'];
		$config['pagination_config']['per_page'] = PAGE_SIZE;
		$config['pagination_config']['page_query_string'] = TRUE ;
		$this->pagination->initialize($config['pagination_config']);
		//var_dump($this->pagination);
		$data['pages'] = $this->pagination->create_links();
		//取得当前页面的数据
		$limit = array (  $config['pagination_config']['per_page'] , $per_page ) ;
		$data['list'] = $this->get_list($where, $like, $limit);

		return $data;
	}	
	
	
	public function last_id(){
		return $this->db->insert_id();
	}
	
	protected function get_pdata(){
		foreach ($this as $key => $value) {
			if($key == 'tablename') continue;
			$data[$key] = $value;
		}
		return $data;
	}	

	/*
	 * 影响行数
	 */
	public function affected_rows(){
	    return $this->db->affected_rows();
	}

	public function list_fields(){
	    $filename = APPPATH.'cache/'.md5($this->tablename.'fields');
	    if(file_exists($filename) && time() - filemtime($filename) <=  3600 ){
	        $fields = json_decode(file_get_contents($filename));
	    }else{
	        $fields = $this->db->list_fields($this->tablename);
	        file_put_contents($filename, json_encode($fields));
	    }
		return $fields;
	}
	
	public function get_list($where = array(), $like = array(), $limit = array()){
		if(!empty($like) && is_array($like)) $this->db->like($like);
	    if(!empty($limit) && is_array($limit)){
		   count($limit) == 1 ? @$this->db->limit($limit[0]) :  @$this->db->limit($limit[0], $limit[1]);
		}
		$results = $this->db->select()
				->from($this->tablename)
				->where($where)
				->get()->result_object() ;
		return empty($results) ? array() : $results;
	}
	
	public function get_list_array($where = array(), $like = array(), $limit = array()){
		if(!empty($like) && is_array($like)) $this->db->like($like);
	    if(!empty($limit) && is_array($limit)){
		   count($limit) == 1 ? @$this->db->limit($limit[0]) :  @$this->db->limit($limit[0], $limit[1]);
		}
		$results = $this->db->select()
				->from($this->tablename)
				->where($where)
				->get()->result_array() ;
		return empty($results) ? array() : $results;
	}
	
	public function get_info($where = array(), $like = array()){
		if(!empty($like) && is_array($like)) $this->db->like($like);
		$results = $this->db->select()
				->from($this->tablename)
				->where($where)
				->get()->row_array() ;
		if(!empty($results))	$this->set_data($results);	
		return empty($results) ? array() : $results;
	}	

	///数据库增,改,查操作/////////////////////////////////////////////////////////////////////
	/*插入*/
	protected function insert($data){
		if( is_array($data) && count($data)) {
			$results = $this->list_fields();
			foreach ($data as $key => $value) {
				if(!in_array($key, $results)){
					unset($data[$key]);
				}
			}
			$result = !!$this->db->insert($this->tablename,$data);
			if($result) $this->set_data($data);
			return $result;
		}
		return FALSE;
	}
	
	public function insert_batch($data){
	    $result = !!$this->db->insert_batch($this->tablename, $data);
	    return $result;
	}
	
	
	public function del($where = array()){
		return $this->db->where($where)->delete($this->tablename);
	}
	
	public function update($data, $where = array(), $like = array(), $limit = array()){
		if(!is_array($data) && !count($data)) return FALSE;
		if(!empty($like) && is_array($like)) $this->db->like($like);
		if(!empty($limit) && is_array($limit)) @$this->db->limit($limit[0], $limit[1]);
		$results = $this->list_fields();
		foreach ($data as $key => $value) {
			if(!in_array($key, $results) || empty($value)){
				unset($data[$key]);
			}
		}
		
		$result = $this->db->where($where)->update($this->tablename, $data);
		
		if($result)	$this->set_data($data);
		return $result;
	}
	
/*	public function add ($data){
		$result = $this->insert($data);
		if($result){
			$this->set_data($data);
		}
		return $result;
	}	*/
	
	//状态定义//////////////////////////////////	
	public function get_status($status){
		$statuses = $this->get_statuses();
		return isset($statuses[$status]) ? $statuses[$status] : '未知';
	}	
	
	public function get_unstatuses(){
		$statuses = $this->get_statuses();
		$key = array_search('删除', $statuses);
		unset($statuses[$key]);
		return $statuses;
	}
	
	public function get_status_num($value){
		$statuses = $this->get_statuses();
		return array_search($value, $statuses);
	}	
	
	function __destruct(){
	    @$this->db->close();
	}
}