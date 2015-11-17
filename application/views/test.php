<?php
use widget;

use widget\grid\gridview;
use widget\html\dropdownlist;
use widget\data\activedetail;
use widget\html\detailview;
?>
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
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css"></link>

<!-- 可选的Bootstrap主题文件（一般不用引入） -->
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"></link>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script type="text/javascript" src="<?php echo (CURRENT_PRS_STYLE.'js/scripts/main.js'); ?>"></script>
<script > var h = '<?php echo base_url(); ?>';</script>
</head>

<body>


<div class="container">
<?php 
// var_dump(dropdownlist::widget([
//             'name' => 'action',
//             'items' => ['请选择', '1', '2']
//         ]));

// echo detailview::widget([
//     'model' => $activedetail
// ]);


echo gridview::widget(array(
'dataprovider' => $pagination,
'columns' => [
    ['class' => 'widget\grid\checkboxcolumn'],
    [
    'attribute' => 'id',
    'label' => 'id',
    ],
    [
    'attribute' => 'method',
    'label' => dropdownlist::widget([
            'name' => 'action',
            'items' => ['请选择', '1', '2']
        ])
    ],
    'appId',
    'content',
    'appId',
    'content',
    'appId',
    'content',
     ['class' => 'widget\grid\actioncolumn'],		
]
));


?>
</div>

</body>
</html>