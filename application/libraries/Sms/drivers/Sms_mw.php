<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_mw extends CI_Driver {
    
    function send(& $log) {
        $p = false;
        $log['status'] = 0;
        $log['retmessage'] = '该接口尚未接入!遂无法发送短信!';
        return $p;
    }
    
}