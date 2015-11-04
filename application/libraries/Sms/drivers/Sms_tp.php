<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_tp extends CI_Driver {
	
	protected $rets = array('-1' => "提交接口错误", 
                            '-3' => "用户名或密码错误",
                            '-4' => "短信内容和备案的模板不一样",
                            '-5' => "签名不正确（格式为：短信内容......【签名内容】）签名一定要放在短信最后",
                            '-7' => "余额不足",
                            '-8' => "通道错误",
                            '-9' => "无效号码",
                            '-10' => "签名内容不符合长度",
                            '-11' => "用户有效期过期",
                            '-12' => "黑名单",
                            '-13' => "语音验证码的 Amount 参数必须是整形字符串",
                            '-14' => "语音验证码的内容只能为数字",
                            '-15' => "语音验证码的内容最长为6位",
                            '-16' => "余额请求过于频繁，5秒才能取余额一次",
                            '-17' => "非法ip");
	
    protected $sign = '【若水游戏】';
	
    function send(& $log) {
    	$client = new SoapClient("http://h.1069106.com:1210/Services/MsgSend.asmx?WSDL");
        $param = array("userCode" => "RSWL", "userPass" => "RSWL8866", "DesNo" => $log['mobileNo'], "Msg" => $log["content"].$this->sign, "Channel" => "0");
        $p = $client->__soapCall('SendMsg', array('parmaeters' => $param));
        $log['status'] = !isset($this->rets[$p->SendMsgResult]) ? 1 : 0;
        $log['retmessage'] = isset($this->rets[$p->SendMsgResult]) ? $this->rets[$p->SendMsgResult] : $p->SendMsgResult;
        return $p;
    }
    
    /*function send(& $log) { // 调试方法
    	$log['status'] = 1;
    	$log['retmessage'] = '23144040670'.rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
    }*/
}