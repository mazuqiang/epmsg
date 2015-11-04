<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class admin_model extends RS_Model{
	//private $data = array();
    protected $admin_id 	= null;
	protected $admin_name	= null;
	protected $admin_pwd	= null; 
	protected $admin_status	= null;
	protected $admin_per1	= null; 
	protected $admin_per2	= null;
	protected $admin_per3	= null; 
	protected $admin_realname	= null;
	protected $admin_createtime	= null; 

	protected $tablename = 'pp_admin';
	
	public function __construct($data = array()){
		parent::__construct();
		$this->config->load("admin_permission_config" , true ) ;
		$this->config->load("admin_config" , true ) ;
	}
	
	public function get_admin_id(){	    return $this->admin_id;	}
	public function get_admin_status(){	    return $this->admin_status;	}
	public function get_admin_name(){		return $this->admin_name;	}
	public function get_admin_per1(){		return !empty($this->admin_per1) ?  $this->admin_per1 : array();	}	
	public function get_admin_per2(){		return !empty($this->admin_per2) ?  $this->admin_per2 : array();	}	
	public function get_admin_per3(){		return !empty($this->admin_per3) ?  $this->admin_per3 : array();	}
	public function get_admin_realname(){	    return $this->admin_realname;	}
	public function islogin(){		return !empty($this->admin_name);	}
	
	public function get_status($status){
	    $statuses = $this->config->config['admin_config']['status'];
	    return empty($statuses[$status]) ? '未知' : $statuses[$status];
	}
	
	public function get_menu(){
	    return $this->config->config['admin_permission_config']['menus'];
	}
	
	public function get_action_status($status){
	    $statuses = $this->config->config['admin_config']['status'];
	    unset($statuses[$status]);
	    unset($statuses[9]);
	    return $statuses;
	}

	function page( $per_page = 0, $url){
	    return parent::page(array(), array(), $per_page, $url);
	}	
	
	public function get_count($where = array(), $like = array()){
	    $where['admin_status <>'] = 9;
	    return parent::get_count($where, $like);
	}
	
	public function get_info($where = array(), $like = array()){
	    $where['admin_status <>'] = 9;
	    $result = parent::get_info($where, $like);
	    if(!empty($result)){
	        $this->admin_per1 = $result['admin_per1'] != '' ? explode(',', $result['admin_per1']) : array();
	        $this->admin_per2 = $result['admin_per2'] != '' ? explode(',', $result['admin_per2']) : array();
	        $this->admin_per3 = $result['admin_per3'] != '' ? explode(',', $result['admin_per3']) : array();
	        $result['admin_per1'] = $this->admin_per1;
	        $result['admin_per2'] = $this->admin_per2;
	        $result['admin_per3'] = $this->admin_per3;
	    }
	    return $result;
	}
	
	public function get_infobyid($id){
	    $where['admin_id'] = $id; 
	    $result = $this->get_info($where);
	    if(empty($result))
	          $this->rs_error->add('get_infobyid', '管理原不存在');
	    return $result;
	}
	
	public function get_list($where = array(), $like = array(), $limit = array()){
	    $where['admin_status <>'] = 9;
	    $this->db->order_by('admin_id', 'DESC');
	    return parent::get_list($where, $like, $limit);
	}
	
    public function shield($id, $status){
       $data['admin_status'] = $status;
       $result = $this->update_byid($id, $data);
       if(!$result){
           $this->rs_error->add('shield', '操作失败');
           return FALSE;
       }
       return  TRUE;  
    }
    
    public function changepwd($oldname, $admin_pwd){
        $where['admin_id'] = $this->admin_id;
        $where['admin_pwd'] = md5ex($this->admin_name, $oldname);
        $result = $this->get_info($where);
        if(empty($result)){
            $this->rs_error->add('changepwd', '账号不存在');
            return FALSE;
        }
        $result = $this->update_byid($this->admin_id, array('admin_pwd' =>$admin_pwd ));
        if(empty($result)){
            $this->rs_error->add('changepwd', '密码修改失败');
            return FALSE;
        }
        return  TRUE;
    }
    
    
    public function update_byid($id, $data){
       $where['admin_id'] = $id;
       $where['admin_status <>'] = 9;
       $result = $this->update($data, $where); 
       if(!$result){
           $this->rs_error->add('update_byid', '更新管理员失败');
           return FALSE;
       }
       return  TRUE;
    }
    
    public function update($data, $where = array(), $like = array(), $limit = array()){
        if(!empty($data["admin_permission"])){
            $array = $data["admin_permission"];
            $size = count($array);
            for($i=0; $i< $size; $i++){
                $admin_per1_array[$i] =  substr($array[$i],0,1);
                $admin_per2_array[$i] =  substr($array[$i],0,3);
                $admin_per3_array[$i] =  $array[$i];
            }
            unset($data["admin_permission"]);
            $data['admin_per1'] = implode(',',array_unique($admin_per1_array));
            $data['admin_per2'] = implode(',',array_unique($admin_per2_array));
            $data['admin_per3'] = implode(',',array_unique($admin_per3_array));
        }    
        if(!empty($data['admin_pwd'])) $data['admin_pwd'] = md5ex($data['admin_name'], $data['admin_pwd']);
        return parent::update($data, $where, $like, $limit);
    }
    
    
    public function add($data){
        if(!empty($data["admin_permission"])){
            $array = $data["admin_permission"];
            $size = count($array);
            for($i=0; $i< $size; $i++){
                $admin_per1_array[$i] =  substr($array[$i],0,1);
                $admin_per2_array[$i] =  substr($array[$i],0,3);
                $admin_per3_array[$i] =  $array[$i];
            }
            unset($data["admin_permission"]);
            $data['admin_per1'] = implode(',',array_unique($admin_per1_array));
            $data['admin_per2'] = implode(',',array_unique($admin_per2_array));
            $data['admin_per3'] = implode(',',array_unique($admin_per3_array));
        }
        $data['admin_pwd'] = md5ex($data['admin_name'], $data['admin_pwd']);
        if(!$this->insert($data)){
            $this->rs_error->add('add', '添加管理员失败');
            return FALSE;
        }
        return TRUE;
    }
    
    public function insert($data){
        $data['admin_createtime'] = time();
        $data['admin_status'] = 1;
        return parent::insert($data);
    }
    
    
    
    
	/*
	 * 登录操作
	 * 正确返回真,错误返回假
	 * */
	public function do_login($admin, $pwd){
		$where['admin_name'] = $admin;
		$where['admin_pwd'] = md5ex($admin, $pwd);
		$result = $this->get_info($where);
		
		if( empty($result) ){
			$this->rs_error->add('do_login', '帐号密码错误');
			return FALSE;
		}
		
		$this->session->set_userdata(ADMININFO,  $result);
		return TRUE;
	}
	
	public function loginout(){
		$this->session->unset_userdata(ADMININFO);
	}
	
	/*
	 * 检查新密码和确认密码和旧密码
	 * admin_oldpwd
	 * */
	public function changepwd_validation(){
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('admin_oldpwd',
		    '原密码',
		    'trim|required|min_length[6]|max_length[20]|xss_clean');
		$this->form_validation->set_rules('admin_pwd', 
											'新密码', 
											'trim|required|min_length[6]|max_length[20]|xss_clean');
		$this->form_validation->set_rules('admin_pwd2', 
											'确认密码', 
											'trim|required|matches[admin_pwd]|min_length[6]|max_length[20]|xss_clean');
		$result = $this->form_validation->run();
		if(!$result){
			$this->rs_error->add('changepwd_validation', $this->form_validation->error_string());
		}
		return $result;
	}
	
	/*
	 * 检查登录
	 * */
	public function login_validation(){
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('admin_name', 
											'用户名', 
											'trim|required|min_length[1]|max_length[20]');
		$this->form_validation->set_rules('admin_pwd', 
											'密码', 
											'trim|required|min_length[1]|max_length[20]');
		$result = $this->form_validation->run();
		if(!$result){
			$this->rs_error->add('login_validation', $this->form_validation->error_string());
		}
		return $result;
	}
	
	/*
	 * 检查表单
	 * */
	public function from_validation(){
	    $this->load->library('form_validation');
	    $this->form_validation->set_error_delimiters('', '');
	    $this->form_validation->set_rules('admin_name',
	        '账号',
	        'trim|required|min_length[1]|max_length[20]|xss_clean');
	    $this->form_validation->set_rules('admin_pwd',
	        '密码',
	        'trim|required|min_length[1]|max_length[20]|xss_clean');
	    $this->form_validation->set_rules('admin_realname',
	        '真实姓名',
	        'trim|required|min_length[1]|max_length[20]|xss_clean');
	    $result = $this->form_validation->run();
	    if(!$result){
	        $this->rs_error->add('from_validation', $this->form_validation->error_string());
	    }
	    return $result;
	}
	
	/*
	 * 检查表单
	* */
	public function from_editvalidation(){
	    $this->load->library('form_validation');
	    $this->form_validation->set_error_delimiters('', '');
	    $this->form_validation->set_rules('admin_pwd',
	        '密码',
	        'trim|min_length[1]|max_length[20]|xss_clean');
	    $this->form_validation->set_rules('admin_realname',
	        '真实姓名',
	        'trim|required|min_length[1]|max_length[20]|xss_clean');
	    $result = $this->form_validation->run();
	    if(!$result){
	        $this->rs_error->add('from_validation', $this->form_validation->error_string());
	    }
	    return $result;
	}	
	
}