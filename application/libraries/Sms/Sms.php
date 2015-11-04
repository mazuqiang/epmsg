<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 发送短信接口
 */
class Sms extends CI_Driver_Library{

    protected $valid_drivers = array('sms_mw', 'sms_tp');
    protected $interface = NULL;
    protected $args;
    protected $CI;
    protected $passport;
    
    function __construct($args = array()) {
    	header("Content-type:text/html;charset=utf-8");
        
        $this->CI = & get_instance();
        $this->CI->load->helper('sms');
        $this->CI->load->model('cf_passport_model', 'cfpassport');
        $this->CI->load->model('cf_types_model', 'cftypes');
        $this->CI->load->model('cf_log_model', 'cflog');
        $this->CI->load->model('cf_log_last_vcode_model', 'cflog2');
        $this->args = $args['args'];
    }
    
    
    
    function send() {
    	$this->args['is_valid'] = 0;// 不是验证码接口
        $this->passport = get_passport_by_appId($this->args);
        check_sms_sendable(array('passport_id' => $this->passport['passport_id'], 'appId' => $this->passport['appId'], 'mobileNo' => $this->args['mobileNo'], 'sentsperday' => $this->passport['sentsperday'], 'ablesendperseconds' => $this->passport['ablesendperseconds'], 'type' => $this->args['type']));
        
        $template = get_content_by_tpid($this->args);
        $log = array('passport_id' => $this->passport['passport_id'], 
                     'interface_id' => $this->passport['interface_id'], 
                     'appId' => $this->passport['appId'], 
                     'mobileNo' => $this->args['mobileNo'], 
                     'content' => $template['cnt'], 
                     'tpid' => $template['id'],
                     'type' => $this->args['type'], 
                     'sign' => $this->args['sign'],
                     'code_status' => '0',
                     'time' => date('Y-m-d H:i:s', time()));
        
        $me = $this->passport['interface_name'];
        $this->interface = $this->$me;
        $this->interface->send($log);
        
        $log['tpid'] = intval(trim($template['id']));
        $this->CI->cflog->insert($log);
        if($log['status'] === 0) return sms_error(array('code' => '-401', 'message' => $log['retmessage']));
        if($log['status'] === 1) return sms_error(array('code' => '0', 'message' => '短信发送成功!'));
    }
    
    function vcode() {
    	$this->args['is_valid'] = 1;// 是验证码接口
    	$this->passport = get_passport_by_appId($this->args);
    	check_sms_sendable(array('passport_id' => $this->passport['passport_id'], 'appId' => $this->passport['appId'], 'mobileNo' => $this->args['mobileNo'], 'sentsperday' => $this->passport['sentsperday'], 'ablesendperseconds' => $this->passport['ablesendperseconds'], 'type' => $this->args['type']));
    
    	$log_send = $log = array('passport_id' => $this->passport['passport_id'],
                                 'interface_id' => $this->passport['interface_id'],
                                 'appId' => $this->passport['appId'],
                                 'mobileNo' => $this->args['mobileNo'],
                                 'type' => $this->args['type'],
                                 'sign' => $this->args['sign'],
                                 'is_validate' => '1',
                                 'time' => date('Y-m-d H:i:s', time()));
        
    	$this->CI->cflog->getvcode($log, $this->passport['expire']);
        $log_send['generate_time'] = $log['generate_time'];
        $this->CI->load->model('cf_template_model', 'cftemplate');
        $content_id = isset($this->args['content']) ? intval(trim($this->args['content'])) : 0;
        $log_send['content'] = $this->CI->cftemplate->cnt($log['content'], $content_id);
        
    	$me = $this->passport['interface_name'];
    	$this->interface = $this->$me;
    	$this->interface->send($log_send);
        
        $log['status'] = $log_send['status'];
        $log['retmessage'] = $log_send['retmessage'];
    	$this->CI->cflog->insert($log);
    	if($log['status'] === 0) return sms_error(array('code' => '-401', 'message' => $log['retmessage']));
    	if($log['status'] === 1) return sms_error(array('code' => '0', 'message' => '验证码发送成功!'));
    }
    
    function checkvcode() {
        $this->args['is_valid'] = 0;// 其实这个是验证码接口 , 只不过它需要检测 content 字段
        $this->passport = get_passport_by_appId($this->args);
        
        $this->args['appId'] = $this->passport['passport_id'];
        $ret = $this->CI->cflog->checkvcode($this->args, $this->passport['expire']);
        if(!$ret) {
            return sms_error(array("code" => '-10', "message" => "验证失败 , 该验证码已过期 !"));
        } else {
            return sms_error(array("code" => '0', "message" => "验证通过!"));
        }
    }

}