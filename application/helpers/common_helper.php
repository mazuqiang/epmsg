<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getHttpResponsePOST'))
{
    function getHTTP_POST($url,  $para) {

        $curl = curl_init($url);
        //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL证书认证
        //     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
        //     curl_setopt($curl, CURLOPT_CAINFO,$cacert_url);//证书地址

        $para = http_build_query($para);
        curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        curl_setopt($curl, CURLOPT_POST, TRUE); // post传输数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $para);// post传输数据
        //     curl_setopt($curl, CURLOPT_, $para);// post传输数据
        $responseText = curl_exec($curl);
        //var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
        curl_close($curl);

        return $responseText;
    }
}

if ( ! function_exists('getHttpResponseGET'))
{
    function getHTTP_GET($url,  $para, $outtime = 0) {
        $url = $url.'?'.http_build_query($para);
//          log_message('error', 'url :'.$url);
        $curl = curl_init($url);
        //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);//SSL证书认证
        //     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
        //     curl_setopt($curl, CURLOPT_CAINFO,$cacert_url);//证书地址

        curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
         $outtime && curl_setopt($curl, CURLOPT_TIMEOUT , $outtime ); 
         $outtime && curl_setopt($curl, CURLOPT_CONNECTTIMEOUT , $outtime );
         
 //       curl_setopt($curl, CURLOPT_POST, TRUE); // post传输数据
 //       curl_setopt($curl, CURLOPT_POSTFIELDS, $para);// post传输数据
        //     curl_setopt($curl, CURLOPT_, $para);// post传输数据
        $responseText = curl_exec($curl);
        $curl_error=  curl_error ( $curl );
        !$responseText && log_message('error', curl_error($curl) );
        //var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
        curl_close($curl);

        return $responseText;
    }
}


/**
 * 载入视图
 *
 * 这个函数可以方便的在视图中载入视图
 *
 * @access	public
 * @param	string
 * @param	array
 * @param	bool
 * @return	void
 */ 
if ( ! function_exists('load_view'))  
{  
   function load_view($view, $vars = array(), $return = FALSE)  
   {
      $CI =& get_instance();
      return $CI->load->view($view, $vars, $return);  
   }  
}

/**
 * 获取日志目录存放路径
 *
 * 略
 *
 * @access	public
 * @return	string
 */ 
if ( ! function_exists('log_path'))  
{  
	function log_path(){
		$config = get_config();
		return $config['log_path']?$config['log_path']:APPPATH.'logs/';
	}
}


/**
 * css js img 目录
 *
 * 获得js css img 等 url路径
 *
 * @access	public
 * @return	string  url
 */ 
if ( ! function_exists('public_url'))  
{  
   function public_url()  
   {  
		return base_url().'public/';
   }  
}

if ( ! function_exists('new_public_url'))  
{  
   function new_public_url()  
   {  
		return base_url().'public/';
   }  
}


// 浏览器友好的变量输出
function dump($var, $exit=true, $label=null, $strict=true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $return = print_r($var, true);
            $return = "<pre>" . $label . htmlspecialchars($return, ENT_QUOTES) . "</pre>";
        } else {
            $return = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $return = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $return = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $return);
            $return = '<pre>' . $label . htmlspecialchars($return, ENT_QUOTES) . '</pre>';
        }
    }

    if($exit){ echo $return; exit(); }else{ return $return; }
}

/**
* 获取一个数组的某个key的值
*
* 为了书写连贯 
* 如 $user_a = get_user(); $user_a = $user_a['a']; echo $user_a->name;
* 使用此函数: echo array_value(get_user(),'a')->name;
* 
* @access	public
* @param	array   数组 
* @param	key     要取的key
* @param	default key不存在时的默认值
* @return	void
*/
if ( ! function_exists('array_value'))
{
	function array_value($key, $array, $default=null)
	{
		if(!is_array($array)) return $default;
		return array_key_exists($key,$array)?$array[$key]:$default;
	}
}

//功能：通过用户名和密码进行MD5加密
//输入：($str1->用户名,$str2->密码)	
//返回：md5后的字符串
if( !function_exists('md5ex') ){
    function md5ex($str1,$str2){
        return md5(md5(trim($str2)).strtolower(trim($str1)));
    }
}

/**
* base64用于url时使用 url_base64_encode url_base64_decode
*/
function url_base64_encode($str)
{
	return str_replace(array('+','/','='), array('!','*',''), base64_encode($str));//base64_encode编码字符串 并把 '+'替换成'!' '/'替换成'*' '='替为空
}
function url_base64_decode($code)
{
    return base64_decode(str_replace(array('!','*'), array('+','/'), $code));// "!"替换成"+" "*"替换成"/" 然后通过 base64_decode 解码
}

/**
 * 取得充值的类型，
 * -----------------------------
 * @param int $card  充值类型的序号
 * @return array() 
 */
function get_card_type ( $card = 0 )
{
	$card_type_id_array=array(
		'1'		=>array("percent" => '95' , 'card_name' => '神州行充值卡'),
		'4'		=>array("percent" => '95' , 'card_name' => '联通充值卡'),
		'12'	=>array("percent" => '95' , 'card_name' => '电信充值卡'),
		'15'	=>array("percent" => '98.5' , 'card_name' => '网银支付'),
		'26'	=>array("percent" => '97' , 'card_name' => '支付宝' ),
		'2'		=>array("percent" => '80' , 'card_name' => '盛大一卡通'),
		'3'		=>array("percent" => '80' , 'card_name' => '骏网一卡通'),
		'6'		=>array("percent" => '80' , 'card_name' => '征途游戏卡'),
		'7'		=>array("percent" => '80' , 'card_name' => '久游一卡通'),
		'8'		=>array("percent" => '80' , 'card_name' => '完美一卡通'),
		'9'		=>array("percent" => '80' , 'card_name' => '网易一卡通'),
		'11'	=>array("percent" => '80' , 'card_name' => '搜狐一卡通'),
		'10'	=>array("percent" => '' , 'card_name' => '魔兽世界点卡'),
		'5'		=>array("percent" => '' , 'card_name' => 'Q币卡'),
		'14'	=>array("percent" => '' , 'card_name' => '蓝港一卡通'),
		'16'	=>array("percent" => '' , 'card_name' => '盛付通充值卡'),
		'17'	=>array("percent" => '' , 'card_name' => '神州行地方卡'),
		'21'	=>array("percent" => '' , 'card_name' => '短信' ),
		'25'	=>array("percent" => '' , 'card_name' => 'U币' ) ,
		'27'	=>array("percent" => '' , 'card_name' => '91支付' ) ,
		'28'	=>array("percent" => '' , 'card_name' => '百度多酷' ) ,
		'30'	=>array("percent" => '' , 'card_name' => '凤凰支付' ) ,
		'31'	=>array("percent" => '' , 'card_name' => '飞流九天' ) ,
		'32'	=>array("percent" => '' , 'card_name' => '宝软' ) ,
		'33'	=>array("percent" => '' , 'card_name' => '小米' ) ,
		'34'	=>array("percent" => '' , 'card_name' => '机锋' ) ,
		'35'	=>array("percent" => '' , 'card_name' => 'UC支付' ) ,
		'36'	=>array("percent" => '95.6' , 'card_name' => '萌果' ) ,
		'37'	=>array("percent" => '' , 'card_name' => 'PP助手' ) ,
		'39'	=>array("percent" => '' , 'card_name' => 'AppStore' ) ,
	);
	if($card==0){
		return $card_type_id_array;
	}
	return empty( $card_type_id_array[intval($card)]) ? array () : $card_type_id_array[intval($card)];
}



function referer( $url = null ) 
{
	if( ! empty( $_SERVER["HTTP_REFERER"])){
		return $_SERVER["HTTP_REFERER"] ; 
	}
	if( $url ){
		return $url ;
	}
	return site_url() ;
}

//功能: 在后台文件为页面的head里添加script引用
//输入: $url->script文件的全路径,$add_br->是否在后面添加\r\n(默认添加)
//返回: javascript页面的引用字符串
if ( ! function_exists('add_script'))
{
	function add_script($url = '',$add_br = true){
		$url = trim($url);
		if( !trim($url) ) return '';
		return "<script type=\"text/javascript\" src=\"$url\"></script>".($add_br ? "\r\n" : '');
	}
}

//功能: 在后台文件为页面的head里添加css引用
//输入: $url->script文件的全路径,$add_br->是否在后面添加\r\n(默认添加)
//返回: javascript页面的引用字符串
if ( ! function_exists('add_css'))
{
	function add_css($url = '',$add_br = true){
		$url = trim($url);
		if( !trim($url) ) return '';
		return "<link rel=\"stylesheet\" type=\"text/css\" href=\"$url\" />".($add_br ? "\r\n" : '');
	}
}


//功能: 后台文件执行javascript的alert方法
//输入: $msg->弹出的消息
//返回: javascript的alert字符串
if ( ! function_exists('js_alert'))
{
	function js_alert($msg = ''){
		header('Content-Type:text/html;charset=utf-8');
		$msg = preg_replace("/\n/", '\\n', $msg);
		return "<script charset='utf-8' type=\"text/javascript\">alert('".$msg."');</script>";
		//return $msg;
	}
}

//功能: 后台文件执行javascript的location转向方法
//输入: $url->转向的页面
//返回: javascript的location字符串
if ( ! function_exists('js_location'))
{
	function js_location($url = ''){
		$url = site_url($url);
		return "<script type=\"text/javascript\">location.href='".$url."';</script>";
	}
}

//功能: 后台文件执行javascript的location转向方法
//输入: $url->转向的页面
//返回: javascript的location字符串
if ( ! function_exists('js_nolocation'))
{
    function js_nolocation($url = ''){
        return "<script type=\"text/javascript\">location.href='".$url."';</script>";
    }
}


//功能: 后台文件执行javascript的history转向方法
//输入: $back_step->返回第几步
//返回: javascript的history字符串
if ( ! function_exists('js_history'))
{
	function js_history($history = '-1'){
		//fix 屏蔽此行 允许向前跳 if( (int)$history > -1 ) return FALSE;
		return "<script type=\"text/javascript\">history.go(".$history.");</script>";
	}
}

if ( ! function_exists('alert_location'))
{
	function alert_location($msg = '操作成功',$url = null){
		header('Content-Type:text/html;charset=utf-8');
		$result = "<script charset='utf-8' type=\"text/javascript\">alert('".$msg."');";
		if(empty($url)){
			$result .= "history.go(-1)";
		}else{
			$result .= "location.href='".$url."';";
		}
		return $result .= "</script>";
	}
}
//功能: 根据配置文件名数组名,及键名返回值
//输入: $filename->文件名称,$array_name->数组名称,$key->键值
//返回: 对应的值
if ( ! function_exists('get_val_by_key'))
{
	function get_val_by_key($filename = '',$array_name = '',$key = ''){
		if( trim($filename) && trim($array_name) ){
			$CI =& get_instance();
			$CI->config->load(trim($filename),TRUE);
			$data_array  = $CI->config->item(trim($array_name),trim($filename));
			return $data_array[$key];
		}
		return '';
	}
}

/**
* 支付模块 业务级日志
*
* (客户比例分成未找到)放到人工检查  签名错误  金额异常 与第三方同步,事物出错  提交失败
* 
* @access	public
* @param	int  错误类型 1 客户比例分成未找到(下订单时) 2 签名错误 3 金额异常 4 与第三方同步,事物出错 5 与游戏方同步出错 6 与下游商户同步失败 7提交失败
* 				 3 4 默认已转入手动处理  2 7日志只用来查看,7直接在这里处理
* @param	int  订单id号 PAY_ID( 错误类型为2时 这里记录的是 PAY_MY_LINKID)
* @return	void
*/
if ( ! function_exists('log_pay'))
{
	function log_pay($type, $order_id, $info='', $manual=FALSE)
	{
		$_date_fmt = FALSE;
		
		if( $type==3 || $type==4 ){
			$manual = TRUE;
			$_date_fmt = 'Y-m-d H:i:s';
		}
		
		$config =& get_config();
		$_log_path = ($config['log_path'] != '') ? $config['log_path'] : APPPATH.'logs/';
		
		if( $type==2 || $type==7 ){
			$filepath  = $_log_path.'log_pay_view.php';
			$_date_fmt = 'Y-m-d H:i:s';
		}else{
			$filepath  = $_log_path.'log_pay'.($manual?'_manual':'').'.php';
		}
		
		if ( ! file_exists($filepath) )
		{
			$message .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";
		}

		if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
		{
			return FALSE;
		}
		$message .= json_encode(array('type'=>$type, 'order_id'=>$order_id, 'info'=>$info, 'time'=>$_date_fmt?date($_date_fmt):time()))."\n";
		
		flock($fp, LOCK_EX);
		fwrite($fp, $message);
		flock($fp, LOCK_UN);
		fclose($fp);

		@chmod($filepath, FILE_WRITE_MODE);
	}
}

/**
* 与下游商户进行订单同步
*
* 略
* 
* @access	public
* @param	array  传入订单信息
* @return	void
*/
if ( ! function_exists('pay_user_sync'))
{
	function pay_user_sync($order_info,$user_info)
	{
		$CI =& get_instance();

		$state = TRUE;
		
		// 提交人不是自己,订单状态同步给提交人
		if($order_info['CUSTOM_D']!=USER_ID){
			//订单状态sErrorCode  支付状态bType  商户编号ForUserId   商户的流水号LinkID   金额Moneys  商户的附加AssistStr   签名sign
			$get_data['sErrorCode']	= 1;
			$get_data['bType'] 		= $order_info['PAY_SUCCESS'];
			$get_data['ForUserId'] 	= $order_info['USER_ID'];
			$get_data['LinkID']  	= $order_info['PAY_CLIENT_LINKID'];
			$get_data['SorceLinkid']= $order_info['PAY_MY_LINKID'];
			$get_data['Moneys']		= $order_info['PAY_FEE'];
			$get_data['AssistStr']  = time();
			$get_data['sign'] 		= md5(sprintf('sErrorCode=%s&bType=%s&ForUserId=%s&LinkID=%s&Moneys=%s&AssistStr=%s&keyValue=%s',$get_data['sErrorCode'],$get_data['bType'],$get_data['ForUserId'],$get_data['LinkID'],$get_data['Moneys'],$get_data['AssistStr'],$user_info['PASS_KEY']));
			
			$CI->load->helper('http');
	
			$result = HttpClient::quickPost($order_info['PAY_REQUEST_URL'], $get_data);		
			if(trim($result)=='SUCC'){
				$state = TRUE;
			}else{
				$state = FALSE;
			}
		}
		
		// 受益人不是自己,并且受益人是独站,并且受益人不等于提交人 则 订单同步给受益人(B在C平台充值 订单同步给B) @本平台
		if($state && $order_info['USER_ID']!=USER_ID && $user_info['USER_OWN_TYPE']==2 && $order_info['USER_ID']!=$order_info['CUSTOM_D']){
			$post_order_info['PAY_FEE'] 	= $order_info['PAY_FEE'];
			$post_order_info['PAY_SUCCESS'] = $order_info['PAY_SUCCESS'];
			$post_order_info['CUSTOM_A'] 	= $order_info['CUSTOM_A'];
			$post_order_info['CUSTOM_B'] 	= $order_info['CUSTOM_B'];
			$post_order_info['PAY_CARD_INDEX'] = $order_info['PAY_CARD_INDEX'];
			$post_order_info['PAY_MY_LINKID']  = $order_info['PAY_MY_LINKID'];
			$post_order_info['CARD_TYPE_ID']   = $order_info['CARD_TYPE_ID'];
			$post_order_info['PAY_CARD_NUMBER']= $order_info['PAY_CARD_NUMBER'];
			$post_order_info['PAY_CARD_PASS']  = $order_info['PAY_CARD_PASS'];
			$post_order_info['CUSTOM_C'] = $order_info['CUSTOM_C'];
			$post_order_info['CUSTOM_D'] = $order_info['CUSTOM_D'];
			
			$CI->load->library('user_api',$user_info);
			if($CI->user_api->order_sync($post_order_info)){
				$state  = TRUE;
			}else{
				$state  = FALSE;
			}
		}
		
		if($state){
			// 与下游商户同步成功
			if($CI->db->set(array('PAY_USER_SYNC'=>0,'PAY_USER_SYNC_TIME'=>time()))->where('PAY_ID',$order_info['PAY_ID'])->update('PAY_GET_OTHER')){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			// 与下游商户同步失败次数加1
			$CI->db->set('PAY_USER_SYNC','PAY_USER_SYNC+1',FALSE)
				   ->where('PAY_ID',$order_info['PAY_ID'])
				   ->update('PAY_GET_OTHER',array('PAY_USER_SYNC_TIME'=>time()));			
			return FALSE;
		}
	}
}

if ( ! function_exists('log_check'))
{
	function log_check($text)
	{
		$config =& get_config();
		
		$_log_path = ($config['log_path'] != '') ? $config['log_path'] : APPPATH.'logs/check/';
		$_date_fmt = $config['log_date_format']?$config['log_date_format']:'Y-m-d H:i:s';
		$filepath  = $_log_path.'log_pay-'.date('Y-m-d').'.php';

		if ( ! file_exists($filepath))
		{
			$message .= "<"."?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?".">\n\n";
		}

		if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
		{
			return FALSE;
		}
		$message .= json_encode(array('type'=>$text,'time'=>date("Y-m-d H:i:s")))."\n";
		
		flock($fp, LOCK_EX);
		fwrite($fp, $message);
		flock($fp, LOCK_UN);
		fclose($fp);

		@chmod($filepath, FILE_WRITE_MODE);
	}
}


function excel_simple_down( $file_name , $data ) {
	
	
	Header( "Content-type:   application/octet-stream "); 
	Header( "Accept-Ranges:   bytes "); 
	Header( "Content-type:application/vnd.ms-excel");   
	Header( "Content-Disposition:attachment;filename=".$file_name);
	
	foreach( $data as $k => $value ){
		foreach( $value as $ns => $v ){
			echo  iconv ( "utf-8" , "gb2312" , $v )."\t" ;
		}
		echo "\n" ;
	}
	exit;
}

function cut_str($sourcestr,$cutlength)
{
   $returnstr='';
   $i=0;
   $n=0;
   $str_length=strlen($sourcestr);//字符串的字节数
   while (($n<$cutlength) and ($i<=$str_length))
   {
      $temp_str=substr($sourcestr,$i,1);
      $ascnum=Ord($temp_str);//得到字符串中第$i位字符的ascii码
      if ($ascnum>=224)    //如果ASCII位高与224，
      {
         $returnstr=$returnstr.substr($sourcestr,$i,3); //根据UTF-8编码规范，将3个连续的字符计为单个字符        
         $i=$i+3;            //实际Byte计为3
         $n++;            //字串长度计1
      }
      elseif ($ascnum>=192) //如果ASCII位高与192，
      {
         $returnstr=$returnstr.substr($sourcestr,$i,2); //根据UTF-8编码规范，将2个连续的字符计为单个字符
         $i=$i+2;            //实际Byte计为2
         $n++;            //字串长度计1
      }
      elseif ($ascnum>=65 && $ascnum<=90) //如果是大写字母，
      {
         $returnstr=$returnstr.substr($sourcestr,$i,1);
         $i=$i+1;            //实际的Byte数仍计1个
         $n++;            //但考虑整体美观，大写字母计成一个高位字符
      }
      else                //其他情况下，包括小写字母和半角标点符号，
      {
         $returnstr=$returnstr.substr($sourcestr,$i,1);
         $i=$i+1;            //实际的Byte数计1个
         $n=$n+0.5;        //小写字母和半角标点等与半个高位字符宽...
      }
   }
         if ($str_length>$cutlength){
          $returnstr = $returnstr . "...";//超过长度时在尾处加上省略号
      }
    return $returnstr;

}

function format_date($time){
    $t=time()-$time;
    $f=array(
        '31536000'=>'年',
        '2592000'=>'个月',
        '604800'=>'星期',
        '86400'=>'天',
        '3600'=>'小时',
        '60'=>'分钟',
        '1'=>'秒'
    );
    foreach ($f as $k=>$v)    {
        if (0 !=$c=floor($t/(int)$k)) {
            return $c.$v.'前';
        }
    }
}
function export_excel($item,$name){

	require_once FCPATH.'api/excel/PHPExcel.php';
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("XDTX")
		->setLastModifiedBy("XDTX")
		->setTitle("Office 2005 XLS Member Document")
		->setSubject("Office 2005 XLS Member Document")
		->setDescription("Member Document.")
		->setKeywords("XDTX")
		->setCategory("Export Member");
	$objPHPExcel->setActiveSheetIndex(0);


	$sheet = $objPHPExcel->getActiveSheet();
	$sheet->getColumnDimension('C')->setAutoSize(true);
	// 如果出现导出的Excel数据库中的数据，总是缺少第一行，请讲$row_offset 设置为 1， 否则如前面所述！
	$row_offset   = 1;
	foreach ($item AS $key => $value)
	{	$count1 = count($value)-1;
		foreach ( $value AS $offset => $row )
		{	if(!is_array($row)){
				$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($i++, $row_offset, $row);
			}else{
				foreach ( $row AS $off => $r ){
					$j=$i;
					$row_offset++;	
					foreach($r AS $off4 => $t){
						$objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($j++, $row_offset, $t);
					}			
				}	
			}
		}
		$i   = 0;
		$row_offset++;
	}
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.date("YmjHis").'.'.$name.'.xls"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
}

/* End of file common_helper.php */
/* Location: ./application/helpers/common_helper.php */