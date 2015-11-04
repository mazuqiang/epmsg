$(function() {
    var error = '<img src="/public/web/images/1.png">';
    jQuery.validator.addMethod("checkname", function(value, element, param) {
	return checkname;
    });
    
    jQuery.validator.addMethod("chrcode", function(value, element) {
	var chrnum = /^([a-zA-Z0-9]+)$/;
	return chrnum.test(value);
    }, '验证码错误');
    // 字母和数字的验证
    jQuery.validator.addMethod("chrnum", function(value, element) {
	var chrnum = /^[a-zA-Z]([a-zA-Z0-9_]+)$/;
	return this.optional(element) || (chrnum.test(value));
    }, '以字母开头');
    // 手机号
    jQuery.validator.addMethod("chrphone", function(value, element) {
	var chrnum = /^(13[0-9]|14[0-9]|15[0-9]|18[0-9])\d{8}$/;
	return chrnum.test(value);
    }, '手机号码错误');
    jQuery.validator.addMethod("no_header_num", function(value, a) {
	return this.optional(a) || isNaN(value.substr(0, 1))
    }, error);
    jQuery.validator.addMethod("check_realname", function(value, a) {
	return check_surname(value);
    }, '请输入真实姓名');
    jQuery.validator.addMethod("check_idcardnum", function(value, a) {
	return checktheform(value);
    }, '请输入真实身份证号码');
    jQuery.validator.addMethod("checkpppp", function(value, a) {
	return $('input[name="paypfid"]').val();
    }, '必选');
    jQuery.validator.addMethod("checktype", function(value, a) {
	return $('input[name="feedback_type"]').val();
    }, '必选');
    jQuery.validator.addMethod("checkgame", function(value, a) {
	// console.log(parseInt($('input[name="game"]').val()));
	return parseInt($('input[name="game"]').val());
    }, '必选');
    jQuery.validator.addMethod("checkarea", function(value, a) {
	return parseInt($('input[name="area"]').val());
    }, '必选');
    jQuery.validator.addMethod("checkserver", function(value, a) {
	return parseInt($('input[name="server"]').val());
    }, '必选');
    jQuery.validator.addMethod("req_check", function(value, a) {
	return $('input[name="reg_pool"]')[0].checked;
    }, '必选');    
    
    
     jQuery.extend(jQuery.validator.messages, {
     required: "必填",
// remote: "请修正该字段",
     email: "请输入正确格式的电子邮件",
     url: "请输入合法的网址",
     date: "请输入合法的日期",
     dateISO: "请输入合法的日期 (ISO).",
     number: "请输入合法的数字",
     digits: "只能输入整数",
     creditcard: "请输入合法的信用卡号",
     equalTo: "两次输入不一致",
     accept: "请输入拥有合法后缀名的字符串",
     maxlength: jQuery.validator.format("长度最多是{0}位"),
     minlength: jQuery.validator.format("长度最少是{0}位"),
     rangelength: jQuery.validator.format("请输入一个长度介于 {0} 和 {1} 之间的字符串"),
     range: jQuery.validator.format("介于 {0} 和 {1} 之间"),
     max: jQuery.validator.format("最大为 {0} "),
     min: jQuery.validator.format("最小为 {0} ")
     });
// jQuery.extend(jQuery.validator.messages, {
// required : error,
// remote : error,
// email : error,
// url : error,
// date : error,
// dateISO : error,
// number : error,
// digits : error,
// creditcard : error,
// equalTo : error,
// accept : error,
// maxlength : error,
// minlength : error,
// rangelength : error,
// range : error,
// max : error,
// min : error
// });

    $('form[name="forvalidate"]')[0]
	    && $('form[name="forvalidate"]')[0].reset();

    $('form[name="forvalidate"]').validate({
	rules : {
	    passport_name : {
		required : true,
		remote : {
		    url : "/index/unique", // 后台处理程序
		    type : "get" // 数据发送方式
		}
	    },
	    passport_phone:{
		required : true,
		chrphone: true
	    },
	    userreg_phone : {
		required : true,
		chrphone: true,
		remote : {
		    type : "POST",
		    url : "/index/user_is_unique",
		    data : {
			userreg_name : function() {
			    return $("input[name='userreg_phone']").val()
			}
		    }
		}
	    },
	    passport_email:{
		required : true,
		email : true
	    },
	    new_phone:{
		required : true,
		chrphone: true,
		remote : {
		    type : "POST",
		    url : "/index/user_is_unique",
		    data : {
			userreg_name : function() {
			    return $("input[name='new_phone']").val()
			}
		    }
		}
	    },
	    new_email:{
		required : true,
		email : true,
		remote : {
		    type : "POST",
		    url : "/index/user_is_unique",
		    data : {
			userreg_name : function() {
			    return $("input[name='new_email']").val()
			}
		    }
		}
	    },
	    passport_pwd : {
		required : true,
		minlength : 6,
		maxlength : 20
	    },
	    passport_name2 : {
		required : true,
		equalTo : 'input[name="passport_name"]'
	    },
	    userreg_email : {
		required : true,
		email : true,
		remote : {
		    type : "POST",
		    url : "/index/user_is_unique",
		    data : {
			userreg_name : function() {
			    return $("input[name='userreg_email']").val()
			}
		    }
		}
	    },
	    userreg_pwd : {
		required : true,
		minlength : 6,
		maxlength : 20
	    },
	    userreg_pwd2 : {
		equalTo : "input[name='userreg_pwd']"
	    },
	    userreg_name : {
		required : true,
		chrnum : true,
		minlength : 6,
		maxlength : 25,
		no_header_num : true,
		remote : {
		    type : "POST",
		    url : "/index/user_is_unique"
		}
	    },
	    reg_pool:{
		req_check : true
	    },
	    user_realname : {
		required : true,
		check_realname : true
	    },
	    userreg_realname:{
		required : true,
		check_realname : true
	    },
	    user_idcardnum : {
		required : true,
		check_idcardnum : true
	    },
	    userreg_idcardnum:{
		required : true,
		check_idcardnum : true
	    },
	    pwd_old : {
		required : true,
		minlength : 6,
		maxlength : 25,
		remote : {
		    type : "POST",
		    url : "/passport/passold"
		}
	    },
	    pwd_new : {
		required : true,
		minlength : 6,
		maxlength : 25
	    },
	    pwd_new2 : {
		equalTo : "input[name='pwd_new']"
	    },
	    /* 问题描述 */
	    feedback_title : {
		required : true,
		maxlength : 50
	    },
	    feedback_content : {
		required : true,
		maxlength : 200
	    },
	    feedback_time : {
		required : true,
		date : true
	    },
	    feedback_uname : {
		required : true
	    },
	    feedback_phone : {
		required : true,
		chrphone : true
	    },
	    feedback_uemail : {
		required : true
// email : true
	    },
	    feedback_rolename:{
		required : true
	    },
	    /* 被盗找回 */
	    
	    /* 密保问题 */
	    security_mb1:{
		required : true
	    },
	    security_mb2:{
		required : true
	    },
	    security_mb3:{
		required : true
	    },
	    security_ans1:{
		required : true
	    },
	    security_ans2:{
		required : true
	    },
	    security_ans3:{
		required : true
	    },
	    mail_code:{
		required : true,
		chrcode: true,
		minlength: 6
	    },
	    /* 矩阵卡 */
	    validate_code:{
		required : true,
		chrcode: true
	    },
	    mbcard_num:{
		required : true
	    },
	    identify:{
		required : true
	    },
	    phone_code:{
		required : true,
		chrcode: true,
		minlength: 6
	    },
	    newpwd:{
		required : true,
		minlength: 6,
		maxlength: 20
	    },
	    repwd:{
		required : true,
		equalTo : 'input[name="newpwd"]'
	    },
	    code:{
		required : true,
		chrcode: true
	    },
	    game : {
		required : true,
		digits : true
	    },
	    area : {
		required : true,
		digits : true
	    },
	    server : {
		required : true,
		digits : true
	    },
	    cardtype : {
		required : true,
		digits : true
	    },
	    paypfid : {
		required : true,
		digits : true
	    },
	    cardcount : {
		required : true,
		digits : true
	    },
	    passport_code : {
		required : true,
		chrcode: true,
		minlength : 4,
		maxlength : 6,
		remote : {
		    url : "/code/check", // 后台处理程序
		    type : "post", // 数据发送方式
		    dataType : "json" // 接受数据格式
		}
	    },
	    jyapply_passport_name : {
		required : true
	    },
	    jyapply_gameid : {
		required : true
	    },
	    jyapply_areaid : {
		required : true
	    },
	    jyapply_serverid : {
		required : true
	    },
	    jyapply_losetime : {
		required : true
	    },
	    pppp : {
		checkpppp : true
	    },
	    vtype : {
		checktype : true
	    },
	    vgame : {
		checkgame : true
	    },
	    varea : {
		checkarea : true
	    },
	    vserver : {
		checkserver : true
	    },
	    cardno_pass : {
		required : true,
		minlength: 16,
		maxlength: 16
	    }
	},
	messages : {
	    userreg_name:{
		chrnum: '以字母开头, 数字，字母，或下划线',
		no_header_num: '不能以数字开头',
		remote : '用户名已存在'
	    },
	    passport_name:{
		remote : '用户名不存在'
	    },
	    new_phone:{
		remote: '手机号码已存在'
	    },
	    new_email:{
		remote: '邮箱地址已存在'
	    },
	    userreg_email:{
		remote: '邮箱地址已存在'
	    },
	    userreg_phone:{
		remote: '手机号码已存在'
	    },
	    reg_pool:{
		req_check: '必选'
	    },
	    pwd_old:{
		remote:'原密码不正确'
	    },
	    passport_code:{
		remote:'验证码错误'
	    }
	},
	errorPlacement : function(error, element) {
	    error.appendTo(element.parent());
	}
//	submitHandler : function(form) {
// $('input[type="submit"]').attr('disabled', true);
// if ($('.paypfid')[0] && $('.paypfid').val() == 12) {
// wx_getimgid(form);
// $('input[type="submit"]').attr('disabled', false);
// return false;
// }
//	    form.submit();
//	}

    });
    
    var ff = $('form[name="form1"]').validate({
	rules : {
	    passport_name : {
		required : true,
		remote : {
		    url : "/index/unique", // 后台处理程序
		    type : "get" // 数据发送方式
		}
	    },
	    passport_pwd : {
		required : true,
		minlength : 6,
		maxlength : 20
	    },
	    passport_code : {
		required : true,
		chrcode: true,
		minlength : 4,
		maxlength : 6,
		remote : {
		    url : "/code/check", // 后台处理程序
		    type : "post", // 数据发送方式
		    dataType : "json" // 接受数据格式
		}
	    }
	},
	messages : {
	    passport_name: {
		required: '用户名不能为空',
		remote: '用户名不存在'
	    },
	    passport_pwd : {
		required : '密码不能为空',
		minlength : '密码不能少于6位',
		maxlength : '密码不能多于20位'
	    },
	    passport_code : {
		required : '验证码不能为空',
		chrcode: '验证码错误',
		minlength : '验证码必须4位',
		maxlength : '验证码必须4位',
		remote : '验证码错误'
	    }
	},
// errorLabelContainer: $(".dialog_error"),
	errorPlacement : function(error, element) {
	    if($('.dialog_error').text()){
		return ;
	    };
	    error.appendTo('.dialog_error');
	},
	submitHandler : function(form) {
	    $('input[type="submit"]').attr('disabled', true).val('登陆中...');
	    if($('.ptype')[0] && $('.ptype').val() == 1){
		iscode($('input[name="passport_name"]').val(), function (chcname){
		    chcname && $.post($(form).attr('action'), $(form).serialize(), function (data){
			$('input[type="submit"]').attr('disabled', false);
			if(data.code == 1){
			    document.location.href  = document.location.href;
			}else{
			    $('input[type="submit"]').val('登陆');
			    $(".dialog_error").html('<label id="passport_name-error" class="error" for="passport_name">' + data.msg + '</label>');
			}
		    }, 'json');
		});

		return false;
	    }
	    form.submit();
	}

    });

    $('form[name="forvalidate_ajax"]').validate({
	rules : {
	    vgame : {
		checkgame : true
	    },
	    varea : {
		checkarea : true
	    },
	    vserver : {
		checkserver : true
	    }
	},
	messages : {},
	errorPlacement : function(error, element) {
	    error.appendTo(element.parent());
	},
	submitHandler : function(form) {
	    $.post($(form).attr('action'), $(form).Stringserialize(), function (data){
		if(data){
		    
		}
	    });
	}
    });



});
