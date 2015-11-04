<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>上善若水--通行证管理后台</title>
		<!--                       CSS                       -->
		<!-- Reset Stylesheet -->
		<link rel="stylesheet" href="<?php echo (CURRENT_PRS_STYLE.'css/reset.css')?>" type="text/css" media="screen" />
		<!-- Main Stylesheet -->
		<link rel="stylesheet" href="<?php echo (CURRENT_PRS_STYLE.'css/style.css')?>" type="text/css" media="screen" />
		<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you want the CSS completely valid -->
		<link rel="stylesheet" href="<?php echo (CURRENT_PRS_STYLE.'css/invalid.css')?>" type="text/css" media="screen" />	
		<!-- Internet Explorer .png-fix -->
</head>

	<script	src="<?php echo (CURRENT_BASE_JS.'jquery-1.9.1.js')?>" ></script>
	<script	src="<?php echo (CURRENT_BASE_JS.'jquery.validate.js')?>" ></script>

	<body id="login">
		<div id="login-wrapper" class="png_bg">
			<div id="login-top">
            	<!--<div style="width:278px; height:178px; margin:-40px auto 40px;"></div>-->
				<div style="width:278px; height:108px; background: url(<?php echo base_url(CURRENT_PRS_STYLE.'images/login.png')?>) no-repeat; margin:-60px auto 40px;"></div>
				<span style="font-size:40px; font-family:黑体; text-shadow:2px 2px #000000; color:#CA502C;">上善若水--通行证管理后台</span>
			</div>
			<div id="login-content">
			<form name='form1' method='post' action="<?php echo site_url('login/do_login') ;?>">
				<p>
					<label style="font-family:微软雅黑;">用户名：</label>
					<input class="text-input" type="text" name="admin_name" id="admin_name"  style="font-family:微软雅黑;" />
				</p>
				<div class="clear"></div>
				<p>
					<label style="font-family:微软雅黑;">密　码：</label>
					<input class="text-input" name="admin_pwd" id="admin_pwd"  type="password" />
				</p>
				<div class="clear"></div>
				<p>
					<input style="display:none;" class="button"  id="btn_login"type="button" value="重置" />
					<input class="button" id="btn_login" type="submit" value="登 录" />
				</p>
			</form>
			</div> <!-- End #login-content -->
		</div> <!-- End #login-wrapper -->
  </body>
</html>
