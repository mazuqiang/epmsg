/**
 * @mazuqiang
 */
$(function() {
    $('<div class="dialog_panel" />').appendTo('body');
});

function time120(obj) {
    var pmailtime = 120;
    var to = setInterval(function() {
	if (pmailtime > 0) {
	    $(obj).attr('disabled', true);
	} else {
	    $(obj).attr('disabled', false);
	    $(obj).val('获取验证码');
	    pmailtime = 120;
	    clearInterval(to);
	    return;
	}
	pmailtime--;
	$(obj).val(pmailtime + '秒');
    }, 1000);
}

function must_ecode(obj) {
    // console.log($('.emailval').val());
    if (!$('.emailval').val()) {
	alert('请填写邮箱地址!');
    } else {
	send_ecode(obj);
    }
}

/**
 * 发送邮箱验证码
 * 
 * @param obj
 */
function send_ecode(obj) {
    data = $('.emailval').val() ? {
	email : encodeURI($('.emailval').val())
    } : {};
    $(obj).attr('disabled', true);
    $.ajax({
	url : '/send/email',
	type : "GET",
	dataType : "html",
	data : data,
	cache : false,
	success : function(message) {
	    if (parseInt(message)) {
		alert('发送成功');
		time120(obj);
	    } else {
		alert('发送失败');
		$(obj).val('重新获取');
		$(obj).attr('disabled', false);
	    }

	}
    });
}

function must_pcode(obj) {
    if (!$('.phoneval').val()) {
	alert('请填写手机号！');
    } else {
	send_pcode(obj);
    }
}

/**
 * 发送手机
 * 
 * @param obj
 */
function send_pcode(obj) {
    data = $('.phoneval').val() ? {
	phone : encodeURI($('.phoneval').val())
    } : {};
    $(obj).attr('disabled', true);
    $.ajax({
	url : '/send/phone',
	type : "GET",
	dataType : "json",
	data : data,
	cache : false,
	success : function(e) {
	    if (e.code >= 0) {
		alert('发送成功');
		time120(obj);
	    } else {
		alert(e.message);
		$(obj).val('重新获取');
		$(obj).attr('disabled', false);
	    }
	}
    });
}

/**
 * 二级密码检查
 */
function is_subpwd() {
    $('select[name="subpwd_type"]').attr('disabled', true);
    $.ajax({
	url : '/send/subpwd',
	type : "GET",
	dataType : "html",
	data : {
	    game : $('.feedback_game').val(),
	    area : $('.feedback_game_area').val(),
	    server : $('.subpwd_game_server').val()
	},
	cache : false,
	success : function(message) {
	    if (!parseInt(message)) {
		alert('该服务器下尚未设置二级密码');
		$('.subpwd_game_server option').eq(0).attr('selected', true);
	    } else {
		$('select[name="subpwd_type"]').attr('disabled', false);
	    }
	}
    });
}

/**
 * 获取微信验证码
 */
function wx_getimg() {

}

function wx_getimgid(form) {
    $.post($(form).attr('action'), $(form).serialize(), function(data) {
	console.log(data);
    }, "json");
}

/**
 * 是否显示验证码
 */
var checkname = true;
var checkname_name = '';
function iscode(name, callback) {
    if (!name){
	return;
    }
    var unique = h + "index/unique";
    var data = {
	passport_name : encodeURI(name)
    };
    $.get(unique, data, function(data2) {
	if (data2 == 'true') {
	    var codeon = h + "code/on";
	    $.get(codeon, data, function(data) {
		parseInt(data) && $('.trcode').show();
	    });
	    checkname = true;
	} else {
	    checkname = false;
	}
	callback && callback(checkname);
    });
}

/**
 * 充值用到
 * 
 * @param _class
 * @param obj
 * @param _idv
 * @param _callback
 */
function change_rmb(_class, obj, _idv, _callback) {
    $(_class).removeClass('active');
    var id = parseInt($(obj).addClass('active').attr('data-value'));
    $(_idv).val(id);
    _callback(id);
}

/**
 * 选择平台
 * 
 * @param cid
 */
function change_pf(cid) {
    $.get('/pay/pf', {
	'cid' : cid
    }, function(data) {
	if (data == 0) {
	    data = '<li><a href="javascript:; " >暂不支持充值</a></li>';
	    $('#paypfid').val('');
	}
	$('.Payment ul').html(data);
    });
}

/**
 * 获取游戏
 * 
 * @param _class
 */
function get_game(_class) {
    var url = '/game/index/ajax_game';
    var options = $(_class).combobox('options');
    options.valueField = 'game_id';
    options.textField = 'game_name';
    $(_class).combobox('reload', url);
}

/**
 * 获取区
 * 
 * @param _class
 */
function get_area(game, _class) {
//    console.log(game);
    if (!game) {
	return;
    }
    var url = '/game/index/ajax_area/' + game;
    var options = $(_class).combobox('options');
    options.valueField = 'area_id';
    options.textField = 'area_name';
    $(_class).combobox('reload', url);
}

function get_order_rmba(game, obj){
    if (!game) {
	return;
    }
    var url = '/pay/game/index/ajax_cardtype/' + game;
    $.get(url, function (data){
	obj.html(data);
	var a = parseInt($('.active').text());
	console.log($('.active')[0]);
	$('.pay_sum').text(get_price(isNaN(a) ? 0 : a, $('input[name="cardcount"]').val()));
	a = parseInt($('.active').attr('data-dian'));
	$('.pay_sum2').text(get_price(isNaN(a) ? 0 : a, $('input[name="cardcount"]').val()));
    })
}

/**
 * 选择区域获取服务器
 * 
 * @param game
 * @param area
 * @param _class
 */
function get_server(game, area, _class) {
    console.log(game, area);
    if (!game || !area) {
	return;
    }
    var url = '/game/index/ajax_server/' + game + '/' + area;
    var options = $(_class).combobox('options');
    options.valueField = 'server_id';
    options.textField = 'server_name';
    $(_class).combobox('reload', url);
}

/**
 * 获取人名币
 * 
 * @param rmb
 * @param num
 * @returns {Number}
 */
function get_price(rmb, num) {
    return parseInt(rmb) * parseInt(num);
}

/**
 * 显示面板
 */
function show_window(_class) {
    var ccc = $(_class);
    $('.dialog_panel').window({
	width : ccc.attr('data-width') ? ccc.attr('data-width') : 800,
	height : ccc.attr('data-height') ? ccc.attr('data-height') : 600,
	title : ccc.text(),
	modal : true
    });
    $('.dialog_panel').window('open').window('refresh', ccc.attr('data-url'));
}

/**
 * 新窗口打开
 * 
 * @param url
 */
function todo(url) {
    window.open(url);
}

function charge_ep(obj) {
    $('.mget_code').attr('disabled', false);
    if (obj.value == 'email') {
	$('.mget_code').val('获取邮箱验证码').attr('onclick', 'send_ecode(this)');
    } else if (obj.value == 'phone') {
	$('.mget_code').val('获取手机验证码').attr('onclick', 'send_pcode(this)');
    }
}

function enable_ep(obj) {
    // console.log(obj);
    if (!obj.server_id)
	return;

    $.ajax({
	url : '/send/subpwd',
	type : "GET",
	dataType : "html",
	data : {
	    game : $('.get_area').combobox('getValue'),
	    area : $('.get_server').combobox('getValue'),
	    server : $('.get_server_end').combobox('getValue')
	},
	cache : false,
	success : function(message) {
	    if (!parseInt(message)) {
		alert('该服务器下尚未设置二级密码');
		$('.get_server_end').combobox('select', 0);
		$('.change_codetype').combobox('disable');
		$('.mget_code').attr('onclick', '');
	    } else {
		$('.change_codetype').combobox('enable');
	    }
	}
    });

}

/**
 * 弹出框消息，然后页面跳转
 * 
 * @param title
 * @param msg
 * @param url
 */
function msg_location(title, msg, url) {
    $.messager.alert(title, msg);
    setTimeout(function() {
	location.href = url;
    }, 3000);
}

function data_callback(fname, obj) {
    switch (fname) {
    case 'enable_ep':
	enable_ep(obj);
	break;
    case 'charge_ep':
	charge_ep(obj);
	break;
    }
}

/*
 * ie 支持 placeholder
 */
var JPlaceHolder = {
    // 检测
    _check : function() {
	return 'placeholder' in document.createElement('input');
    },
    // 初始化
    init : function() {
	if (!this._check()) {
	    this.fix();
	}
    },
    // 修复
    fix : function() {
	jQuery(':input[placeholder]').each(
			function(index, element) {
			    var self = $(this), txt = self.attr('placeholder'), pwidth=self.css('width');
			    self.wrap($('<div></div>').css({
				position : 'relative',
				zoom : '1',
				'display':'inline',
				border : 'none',
				background : 'none',
				padding : 'none',
				width: pwidth + 30,
				margin : 'none'
			    }));
			    var pos = self.position(), h = self.outerHeight(true), paddingleft = self.css('padding-left');
			    if(pos.left < 0) pos.left = 0;
			    var holder = $('<span></span>').text(txt).css({
				position : 'absolute',
				left : pos.left,
				top : pos.top,
				height : h,
				'line-height' : h + 'px',
				lienHeight : h,
				'font-size' : '12px',
				paddingLeft : paddingleft,
				'margin-left' : '10px',
				color : '#aaa'
			    }).appendTo(self.parent());
			    self.focusin(function(e) {
				holder.hide();
			    }).focusout(function(e) {
				if (!self.val()) {
				    holder.show();
				}
			    });
			    holder.click(function(e) {
				holder.hide();
				self.focus();
			    });
			});
    }
};
jQuery(function() {
    JPlaceHolder.init();
});

jQuery
	.extend({
	    cookie : function(name, value, options) {
		if (typeof value != 'undefined') {
		    options = options || {};
		    if (value === null) {
			value = '';
			options.expires = -1;
		    }
		    var expires = '';
		    if (options.expires
			    && (typeof options.expires == 'number' || options.expires.toUTCString)) {
			var date;
			if (typeof options.expires == 'number') {
			    date = new Date();
			    date.setTime(date.getTime()
				    + (options.expires * 24 * 60 * 60 * 1000));
			} else {
			    date = options.expires;
			}
			expires = '; expires=' + date.toUTCString();
		    }
		    var path = options.path ? '; path=' + options.path : '';
		    var domain = options.domain ? '; domain=' + options.domain
			    : '';
		    var secure = options.secure ? '; secure' : '';
		    document.cookie = [ name, '=', encodeURIComponent(value),
			    expires, path, domain, secure ].join('');
		} else {
		    var cookieValue = null;
		    if (document.cookie && document.cookie != '') {
			var cookies = document.cookie.split(';');
			for ( var i = 0; i < cookies.length; i++) {
			    var cookie = jQuery.trim(cookies[i]);
			    if (cookie.substring(0, name.length + 1) == (name + '=')) {
				cookieValue = decodeURIComponent(cookie
					.substring(name.length + 1));
				break;
			    }
			}
		    }
		    return cookieValue;
		}
	    }
	});

/**
 * select 去重插件
 * 
 * @param _class
 */
function security_mb(_class) {
    var _this = this;
    _this._class = _class;
    var options = [];
    var x = [];

    var init = function() {
	$(_this._class).children().each(function(k, v) {
	    options[v.value] = v.innerHTML;
	});
    }

    $(_this._class).change(function(e) {
	var index = $(_this._class).index(this);
	var preval = x[index];
	x[index] = this.value;
	$(_this._class).each(function(k, v) {
	    if (k == index)
		return;
	    var value = v.value;
	    $(v).html('');
	    for (i in options) {
		if ($.inArray(i, x) != -1 && value != i)
		    continue;
		var option = $('<option/>');
		x[k] == i && option.attr('selected', true);
		option.val(i).text(options[i]).appendTo(v);
	    }
	});
    });

    init();
}
