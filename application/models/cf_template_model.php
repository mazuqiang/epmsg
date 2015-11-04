<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class cf_template_model extends RS_Model
{
    protected $tablename = '`templates`';

    function __construct() {
        $this->db = $this->load->database('sms', TRUE);
        parent::__construct();
    }

    function insert($data) {
        return parent::insert($data);
    }

    function cnt($c, $id = 0) {
        $id === 0 && $id = 7;// 这个 7 是要动态改变的 , 对应着数据库中的 7 模板
        $cnt = $this->get_info(array('id' => $id));
        if(empty($cnt)) return sms_error(array('code' => '-207', 'message' => '短信模板不存在!'));
        if(strpos($cnt['cnt'], '{$dynamiccode}') === FALSE) return sms_error(array('code' => '-207', 'message' => '短信模板不存在!'));
        return str_replace('{$dynamiccode}', $c, $cnt['cnt']);
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
