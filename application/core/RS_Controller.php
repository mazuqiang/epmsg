<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//自定义Conotroller基类,继承CI_Controller
class RS_Controller extends CI_Controller{
	public $meta;
	public $data;
	public $ucenter;
	function __construct(){
	//    ini_set('session.cookie_domain', '.rshui.cn');
		parent::__construct();
		$this->int_meta();
		//保存上一页
		if($this->input->post('rurl')){
		    $this->data['rurl'] = $this->input->post('rurl');
		}else{
		    $this->data['rurl'] = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
		}
				
		$this->load->model('Admin_model', 'admin');
		
		!empty($this->session->userdata[ADMININFO]) && $this->admin->set_data($this->session->userdata[ADMININFO]);
		$this->data['admin'] = &$this->admin;
		//判断登录
		if( ! $this->admin->islogin() ) {
			echo js_location('login');
			exit;
		}
		
		$this->init_menu();

	}
	
	function int_meta(){
	//	 $this->load->config('meta');
		 $cur = $this->uri->segment(1);
		 $cur = (empty($cur) || $cur=='welcome') ? 'index' : $cur;
		 $this->meta = $this->config->item($cur);
	}
	
	function __destruct(){
		//页面执行完后,自动调用方法关闭数据库连接
		if( $this->db ) $this->db->close();
	}
	
	function init_menu(){
	    $current_url = '';
	    $this->data['admin_permissions'] = array();
	    //取出所有权限
	    $this->config->load("admin_permission_config" , true ) ;
	    //从数据库中取出管理员的权限
	    $my_menu1 = $this->admin->get_admin_per1() ;
		$my_menu2 = $this->admin->get_admin_per2() ;
		$my_menu3 = $this->admin->get_admin_per3() ;
//		var_dump($my_menu1, $my_menu2, $my_menu3);
	    /*
	     $my_menu1= array('1','2','3','4','5','6','7');
	     $my_menu2= array('1-1','2-1','3-1','4-1','4-2','5-1','6-1','7-1');
	     $my_menu3= array('1-1-1','1-1-2','2-1-1','2-1-2','3-1-1','3-1-2','4-1-1','4-1-2','4-1-3','4-1-4','4-1-5','4-2-1','4-2-2','4-2-3','4-2-4','5-1-1','6-1-1','6-1-2','6-1-3','6-1-4','6-1-5','6-1-6','6-1-7','7-1-1','7-1-2');
	    */
	    //取出一级权限，以及每个一级权限下第一个链接
	    $admin_permission_config_menus = $this->config->config['admin_permission_config']['menus'];
	    foreach($admin_permission_config_menus as $key1=>$submenu1)
	    {
	        if(in_array($key1,$my_menu1))
	        {
	            $current_menu1 =$key1;
	            foreach($this->config->config['admin_permission_config']['menus'][$current_menu1]['sub2'] as $key2=>$submenu2)
	            {
	                if(in_array($key2,$my_menu2))
	                {
	                    foreach($submenu2['sub3'] as $key3=>$submenu3)
	                    {
	                        if(in_array($key3,$my_menu3))
	                        {
	                            if($current_url=='') $current_url=$submenu3['url'];
	                        }
	                    }
	                }
	            }
	            $this->data['admin_permissions'][$key1] = array(
	                'name' 	=> $submenu1['caption'],
	                'url' 	=> $current_url,
	            );
	            $current_url = '';
	        }
	    }
	    
	    //取出左侧快捷菜单，也就是全部菜单，这一段代码设计的比较奇葩，估计智商低于一百五肯定看不懂，多看几遍conf ig/admin_permission_config.php这个文件的权限设计，是一个7维数组。一般人理解不了哥的超级牛逼的逻辑代码的。等待更加天才的你来给哥重构了！走你！！
	    foreach($admin_permission_config_menus as $key1=>$submenu1)
	    {
	        if(!in_array($key1,$my_menu1))
	        {
	            unset($admin_permission_config_menus[$key1]);
	        }
	        else
	        {
	            foreach($submenu1['sub2'] as $key2=>$submenu2)
	            {
	                if(!in_array($key2,$my_menu2))
	                {
	                    unset($admin_permission_config_menus[$key1]['sub2'][$key2]);
	                }
	                else
	                {
	                    foreach($submenu2['sub3'] as $key3=>$submenu3)
	                    {
	                        if(!in_array($key3,$my_menu3))
	                        {
	                            unset($admin_permission_config_menus[$key1]['sub2'][$key2]['sub3'][$key3]);
	                        }
	                    }
	                }
	            }
	        }
	    }
	    $this->data['admin_permissions_left'] = $admin_permission_config_menus;
	}
	
	
}
?>