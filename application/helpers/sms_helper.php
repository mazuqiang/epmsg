<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_passport_by_appId($args) {
    $CI = & get_instance();

    if(!isset($args['appId'])) return sms_error(array('code' => '-101', 'message' => '应用ID必须为一个正整数!'));
    if(intval(trim($args['appId'])) === 0) return sms_error(array('code' => '-101', 'message' => '应用ID必须为一个正整数!'));
    if(!isset($args['mobileNo'])) return sms_error(array('code' => '-102', 'message' => '手机号码不能为空!'));
    if(trim($args['mobileNo']) === '') return sms_error(array('code' => '-102', 'message' => '手机号码不能为空!'));
    if(!isset($args['type'])) return sms_error(array('code' => '-103', 'message' => '应用类型不能为空!'));
    if(trim($args['type']) === '') return sms_error(array('code' => '-103', 'message' => '应用类型不能为空!'));
    if($args['is_valid'] === 0) {
        if(!isset($args['content'])) return sms_error(array('code' => '-104', 'message' => '短信内容模板ID不能为空!'));
        if(trim($args['content']) === '') return sms_error(array('code' => '-104', 'message' => '短信内容模板ID不能为空!'));
    }
    if(!isset($args['sign'])) return sms_error(array('code' => '-105', 'message' => '签名格式不正确!'));
    if(!preg_match('/[0-9A-Z]{32}/is', trim($args['sign']))) return sms_error(array('code' => '-105', 'message' => '签名格式不正确!'));   
    
    $appId = intval(trim($args['appId']));
    $istype = intval(trim($CI->cftypes->get_count(array('`name`' => trim($args['type'])))));
    if(!$istype) return sms_error(array('code' => '-201', 'message' => '应用类型不存在!'));
    $r = $CI->cfpassport->get_infoBAppId($appId);
    if(empty($r) || $r === FALSE) sms_error(array('code' => '-202', 'message' => '相关应用不存在!'));
    
    $tmp_passport = analyse_passport($r, $args);
    
    if(empty($tmp_passport)) return sms_error(array('code' => '-203', 'message' => '签名验证失败,请联系技保中心相关人员核实!'));
    return $tmp_passport;
}

function analyse_passport($r, $args) {
	$CI = & get_instance();
	
    //appId999231827content测试web短信接口mobileNo13913250273typeREGqwertyuiop
	//appId100029content测试短信接口mobileNo18550099060typeRPGrewqfdsadfsafdsa
    $t = $interface = array();
    $content = $args['is_valid'] === 0 ? 'content'.trim($args['content']) : '';
    foreach($r as $k => $v) {
        if(strtoupper(md5('appId'.trim($v->appId).
                          $content.
                          'mobileNo'.trim($args['mobileNo']).
                          'type'.trim($args['type']).trim($v->key))) === strtoupper(trim($args['sign']))) {
                              $t = array('passport_id' => intval(trim($v->id)),
                                         'appId' => intval(trim($v->appId)),
                                         'sentsperday' => intval(trim($v->sentsperday)),
                                         'ablesendperseconds' => intval(trim($v->ablesendperseconds)),
                                         'expire' => intval(trim($v->expire)),
                                         'allow_ips' => trim($v->allow_ips));
                          break;
        }
    }
    
    if(!empty($t)) {
    	$db = $CI->load->database('sms', TRUE);
        $qry = $db->query('SELECT `interface_id` FROM `passport_interface` WHERE `passport_id`='.intval(trim($t['passport_id'])));
        $row = $qry->row_array();
        if(empty($row)) return sms_error(array('code' => '-204', 'message' => '短信通道缺失!'));
        $t['interface_id'] = intval(trim($row['interface_id']));
        
        $qry = $db->query('SELECT `name` FROM `interfaces` WHERE `id`='.intval(trim($t['interface_id'])));
        $row = $qry->row_array();
        if(empty($row)) return sms_error(array('code' => '-204', 'message' => '短信通道缺失!'));
        $t['interface_name'] = trim($row['name']);
        
        unset($db);
        
        // 检测一下提交短信请求来的 ip 是否在白名单中 .
        if($t['allow_ips'] !== "") {
        	$tmp = explode(',', $t['allow_ips']);
        	if(!in_array(trim($_SERVER["REMOTE_ADDR"]), $tmp)) return sms_error(array('code' => '-301', 'message' => 'IP非法!'));
        }
    }

    check_mobile_illegal($args['mobileNo']);
    
    return $t;
}

/**
 * 检测该手机号码格式是否合法 , 并检测系统是否允许该手机号码发送短信 (是否不在黑名单中)
 * @param String $mobileNo
 */
function check_mobile_illegal($mobileNo) {
    $CI = & get_instance();
    if(!preg_match('/[0-9]+/', $mobileNo)) return sms_error(array('code' => '-106', 'message' => '手机号码格式错误!'));
    $db = $CI->load->database('sms', TRUE);
	$qry = $db->query('SELECT count(*) FROM `hosts_deny` WHERE `mobileNo`='.trim($mobileNo));
	$row = current($qry->row_array());
    if($row >= 1) return sms_error(array('code' => '-302', 'message' => '该手机号码已被加入黑名单!'));
}

/**
 * 如果是直接发送内容 , 那么必须查出短信模板后根据模板内容发送 .
 */
function get_content_by_tpid($args) {
	/*if(!isset($args['extends'])) return sms_error(array('code' => '-108', 'message' => '必须带入短信内容!'));
    if(trim($args['extends']) === '') return sms_error(array('code' => '-108', 'message' => '必须带入短信内容!'));*/
    $CI = & get_instance();
    $db = $CI->load->database('sms', TRUE);
    $tpid = intval(trim($args['content']));
    if($tpid === 0) return sms_error(array('code' => '-107', 'message' => '内容必须带入为短信模板ID!'));
    $query = $db->query('select `id`, `cnt` FROM `templates` WHERE `id`='.$tpid);
    $template = $query->row_array();
    if(empty($template)) return sms_error(array('code' => '-205', 'message' => '短信模板不存在!'));
    $template['cnt'] = trim($template['cnt']);
    if(isset($args['extends']) && trim($args['extends']) !== '') parse_str(urldecode($args['extends']));
    preg_match_all('/{(.+?)}/is', $template['cnt'], $tmp);
    foreach ($tmp[1] as $k => $v) if(!isset(${substr($v, 1)})) return sms_error(array('code' => '-206', 'message' => '短信模板与带入变量不匹配!'));
    $template['cnt'] = preg_replace('/{(.+?)}/ies', "\\1", $template['cnt']);
    return $template;
}

/**
 * 检测该手机号码是否符合每天每应用不超过 N 条短信的要求
 * 检测该手机号是否符每条短信必须符合每 N 秒的需求
 */
function check_sms_sendable($data) {
    $CI = & get_instance();
    if(intval(trim($data['sentsperday'])) !== 0) {
        $times = $CI->cflog->gettodaysents($data['passport_id'], $data['mobileNo'], $data['type']);
        if($times >= $data['sentsperday']) return sms_error(array('code' => '-303', 'message' => '该短信已经超过每天'.$data['sentsperday'].'条短信的限制!'));
    }

    if(intval(trim($data['ablesendperseconds'])) !== 0) {
        $lastsendtime = $CI->cflog->getsentpassed($data['passport_id'], $data['mobileNo'], $data['type']);
        if (!empty($lastsendtime)) {
            if(time() - intval(trim(strtotime($lastsendtime['time']))) <= intval($data['ablesendperseconds'])) {
        	    return sms_error(array('code' => '-304', 'message' => '对同一号码发送短信至少间隔 '.$data['ablesendperseconds'].'秒'));
            }
        }
    }
}

function sms_error($data, $t = 'json') {
	$CI = & get_instance();
	if ($t === 'json') {
	    if($data['code'] !== '0') {
	    	global $args;
			$CI->load->model('cf_requestserror_model', 'cf_requestsmodel');
			$args = array_merge($args, $data);
			$CI->cf_requestsmodel->insert($args);
		}
		exit(json_encode($data));
	} else {
		return $data;
	}
}