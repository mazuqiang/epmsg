<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
	上善若水--通行证管理后台
</title>
<!-- CSS -->
<!-- Reset Stylesheet -->
<link rel="stylesheet" href="<?php echo (CURRENT_PRS_STYLE.'css/reset.css')?>" type="text/css" media="screen" />
<!-- Main Stylesheet -->
<link rel="stylesheet" href="<?php echo (CURRENT_PRS_STYLE.'css/style.css')?>" type="text/css" media="screen" />
<!-- Invalid Stylesheet. This makes stuff look pretty. Remove it if you
want the CSS completely valid -->
<link rel="stylesheet" href="<?php echo (CURRENT_PRS_STYLE.'css/invalid.css')?>" type="text/css" media="screen" />	

<!-- jQuery -->
<script	src="<?php echo (CURRENT_BASE_JS.'jquery-1.9.1.js')?>" ></script>

<!-- jQuery-ui -->
<link rel="stylesheet" href="<?php echo (CURRENT_PRS_STYLE.'js/jquery-ui/jquery-ui.css'); ?>">
<script src="<?php echo (CURRENT_PRS_STYLE.'js/jquery-ui/jquery-ui.js'); ?>"></script>
<script src="<?php echo (CURRENT_PRS_STYLE.'js/jquery-ui/jquery-zh.js'); ?>"></script>
<script charset="utf-8" src="<?php echo (CURRENT_PRS_STYLE.'js/editor/kindeditor.js'); ?>"></script>
<script charset="utf-8" src="<?php echo (CURRENT_PRS_STYLE.'js/editor/lang/zh_CN.js'); ?>"></script>


<script type="text/javascript" src="<?php echo (CURRENT_PRS_STYLE.'js/scripts/simpla.jquery.configuration.js'); ?>"></script>

<!-- 新 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- 可选的Bootstrap主题文件（一般不用引入） -->
<link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo (CURRENT_PRS_STYLE.'js/scripts/main.js'); ?>"></script>
<script > var h = '<?php echo base_url(); ?>';</script>
</head>

<body>
<div id="header">
	<!-- Top -->
	<div id="top">
		<!-- Logo -->
		<div style="float:left; width:450px; color:#fff; margin:10px 0 0 10px;">
			<span style="font-size:40px; font-family:黑体; text-shadow:2px 2px #000000;color: #CA502C;">
				若水通行证管理后台
			</span>
		</div>
		<!-- End of Logo -->
		<!-- Meta information -->
		<div class="meta">
			<ul>
				<li>
					<a href="<?php echo site_url(CURRENT_RS_STYLE."index/logout");?>" >
						<span class="ui-icon k-power">
						</span>
						退出
					</a>
				</li>
				<li>
					<a href="<?php echo site_url(CURRENT_RS_STYLE."index/change_pwd");?>" >
						<span class="ui-icon k-wrench">
						</span>
						修改密码
					</a>
				</li>
				<li>
					<a target="_back" href="<?php echo base_url('');?>" >
						<span class="ui-icon k-wrench">
						</span>
						访问首页
					</a>
				</li>
			</ul>
			<div class="k-name">
				欢迎您 ，
				<span>
					<?php echo $admin->get_admin_name() ;?>
				</span>
			</div>
		</div>
		<!-- End of Meta information -->
	</div>
	<!-- End of Top-->
	<!-- The navigation bar -->
	<div id="navbar">
		<ul class="nav">
			<li>
				<a <?php if($current_first_level=="0" ){ ?> class="current" <?}?> href="<?php echo site_url("index");?>">
					全部菜单
				</a>
			</li>
			<?php foreach( $admin_permissions as $key=>$menu){ ?>
			<li>
				<a <?php if($key==$current_first_level){ echo $key.'+'.$current_first_level; ?> class="current" <?}?> href="<?php echo site_url($menu['url']);?>">
					<?php echo $menu['name']; ?>
				</a>
			</li>
			<?php } ?>
		</ul>
	</div>
	<!-- End of navigation bar" -->
</div>
