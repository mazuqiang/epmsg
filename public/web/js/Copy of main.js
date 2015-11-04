$(
		function (){
			// 首页广告
			$('#col img').hover(
	            function(){
	                var $this = $(this);
	                $this.stop().animate({'height':'166px','top':'0px','left':'0px'});
	            },
	            function(){
	                var $this = $(this);
	                $this.stop().animate({'height':'250px','top':'-15px','left':'-70px'});
	            }
	        );
			
			
			// 常见问题
			$("#faq_subcaid").change(function (){
				form1.submit();
			});
			$("#faq_ifelite").click(function (){
				form1.submit();
			});
			
			$("#faq_gameid").change(function (){
				form1.submit();
			});
			$("#faq_ifelite").click(function (){
				form1.submit();
			});

			$('#passport_code').val(''); 
			
				
			// 注册页侧边栏
			var label= $('.label');
			var content= $('.content');
			
			$(content).hide();
			$('.content:first').show();
			$('.label a').addClass('default');
			$('.label:first a').addClass('clicked');
			
			$(label).on("click", function(){
											var tLabel = $(this);
											var tLabelColor = $(this).find('a');
											var tContent = $(this).next('.content');
											
											$(content).hide();
											$(tContent).show();
											
											$('.label a').removeClass('clicked');
											$(tLabelColor).addClass('clicked');
										});
			
// jQuery.validator.addMethod(
// "checkname",
// function(value, element, param) {
// var f = false;
// $.ajax({
// url : h + "index/unique",
// type: "GET",
// async: false,
// data : { passport_name : value },
// success : function (data){
// if (data == 'true'){
// $.get(h + "code/on", function (data){
// parseInt(data) && $('.trcode').show();
// pname = name;
// });
// }
// f = data == 'true';
// },
//			    		
// });
// return f;
// }
// );
			var checkname = true;
			$('.login_passport').blur(function (){
				var v = $(this).val() ;
				v && $.get(h + "index/unique",  { passport_name :  encodeURI(v) }, function (data){
					 $('#passport_name-error').remove();
					 if (data == 'true'){
						 $.get(h + "code/on", { passport_name :  encodeURI(v) }, function (data){
								parseInt(data) && $('.trcode').show();
								pname = name;
						});
						 checkname = true;
					 }else{
						 var errorhtml = '<label id="passport_name-error" class="error" for="passport_name"><img src="/public/web/images/1.png"></label>';
						 $(errorhtml).appendTo($('.login_passport').parent());
						 checkname = false;
					 }
				 });
			});
			
			
			 $('.feedback_type').change(function (){
			    	if(this.value == 2){
			    		var url = '/game/index/ajax_game';
			    		$.getJSON(url , function (data){
			    			for (var i=0; i < data.length; i++) {
							  $('<option value=' + data[i].game_id + '>' + data[i].game_name + '</option>').appendTo('.feedback_game');
							};
			    		});
			    		$('.feedback_rolename').parent().parent().show();
			    		$('.feedback_game_server').parent().parent().show();
			    		$('.feedback_game_area').parent().parent().show();
			    		$('.feedback_game').parent().parent().show();
			    	}else{
			    		$('.feedback_game').html("<option value='0'>请选择游戏</option>").parent().parent().hide();
			    		$('.feedback_game_server').html("<option value='0'>请选择服务器</option>").parent().parent().hide();
			    		$('.feedback_rolename').val('');
			    		$('.feedback_rolename').parent().parent().hide();
			    		$('.feedback_game_area').html("<option value='0'>请选择游戏分区</option>").parent().parent().hide();
			    	}
			    });
			
			 $('.feedback_game').change(function (){
			    	if(this.value !== ''){
			    		$('.feedback_game_area').html('<option value="0">请选择游戏分区</option>');
			    		var url = '/game/index/ajax_area/' + $('.feedback_game').val();
			    		$.getJSON(url , function (data){
			    			for (var i=0; i < data.length; i++) {
							  $('<option value=' + data[i].area_id + '>' + data[i].area_name + '</option>').appendTo('.feedback_game_area');
							};
			    		});
			    		
			    	}
			    });
			    
			    $('.feedback_game_area').change(function (){
			    	if(this.value !== ''){
			    		$('.feedback_game_server').html('<option value="0">请选择服务器</option>');
			    			var url = '/game/index/ajax_server/' + $('.feedback_game').val() + '/' + $('.feedback_game_area').val();
				    		$.getJSON(
					    				url , 
										function (data){
							    			for (var i=0; i < data.length; i++) {
											  $('<option value=' + data[i].server_id + '>' + data[i].server_name + '</option>').appendTo('.feedback_game_server');
											}
										}
				    				);
			    	}
			    }); 
			
			
			
			
			jQuery.validator.addMethod(
			    "checkname", 
			    function(value, element, param) {
			        return checkname;   
			    }
			);
			$('form[name="form1"]').validate({
				rules: {
					user_address : {
						maxlength:20
					},
					passport_name : {
						required : true,
						checkname : true
					},
					passport_pwd : {
						required : true,
						minlength : 6,
						maxlength : 20
					},
					passport_code : {
						required : true,
						minlength : 4,
						maxlength : 4,
						remote : {
							url : h + "code/check", // 后台处理程序
							type : "post", // 数据发送方式
							dataType : "json", // 接受数据格式
						}
					}
				},
				messages:{
					user_address : {
						maxlength:' <span>*</span>&nbsp;地址长度不能超过20位'
					},
					passport_name : {
						required : '<img src="/public/web/images/1.png"/>',
						checkname : '<img src="/public/web/images/1.png"/>'
					},
					passport_pwd : {
						required : '<img src="/public/web/images/1.png"/>',
						minlength : '<img src="/public/web/images/1.png"/>',
						maxlength : '<img src="/public/web/images/1.png"/>'
					},
					passport_code : {
						required : '<img src="/public/web/images/1.png"/>',
						minlength : '<img src="/public/web/images/1.png"/>',
						maxlength : '<img src="/public/web/images/1.png"/>',
						remote : '<img src="/public/web/images/1.png"/>'
					}
				},
				errorPlacement : function(error, element) {
					error.appendTo(element.parent());
				}
			});
			
			
			

			
			var searchtxt = document.getElementById('searchtxt');
			searchtxt.onfocus = function (){
				if(searchtxt.value == '常见问题') searchtxt.value = '';
			};
			searchtxt.onblur = function (){
				if(this.value ==  '') searchtxt.value = '常见问题';
			};	
			if(typeof $ == 'undefined'){
				var fileref = document.createElement('script');
			    fileref.setAttribute("type","text/javascript");
			    fileref.setAttribute("src",'<?php echo new_public_url()?>web/js/jquery-1.9.1.js');
			    if(typeof fileref != "undefined"){
			        document.getElementsByTagName("head")[0].appendChild(fileref);
			    }
			}
			var searchform = document.getElementById('searchform');
			searchform.onsubmit = function (e){
				var searchtxt = document.getElementById('searchtxt');
				if(searchtxt.value == '常见问题' || searchtxt.value == ''){
					alert('请填写您要搜索的常见问题');
					if(e && e.preventDefault) { 
					　　e.preventDefault(); 
					} else { 
					　　window.event.returnValue = false; 
					}
				}
			}
			

			

			
			
			
			$('#subpwd_sub').click(function (){
				if(!$('select[name="subpwd_server"]').val()){
					alert('请选择服务器');
					return ;
				}
				if(!$('select[name="subpwd_type"]').val()){
					alert('请选择找回方式');
					return ;
				}
				switch( $('select[name="subpwd_type"]').val() ){
				case 'email':
					send_ecode($('#subpwd_sub')[0]);
					break;
				case 'phone':
					send_pcode($('#subpwd_sub')[0]);
					break;
				default:
					break;
				}
			});
			
			
//			
// var _hmt = _hmt || [];
// (function() {
// var hm = document.createElement("script");
// hm.src = "//hm.baidu.com/hm.js?db0d97f10566494e524ca9e2744cfc8b";
// var s = document.getElementsByTagName("script")[0];
// s.parentNode.insertBefore(hm, s);
// })();
			
			/*
			 * var phonetime = 120; $('.sendphone').click(function() {
			 * var _this = this; if (phonetime = 120) { url = '<?php
			 * echo site_url($url['bindphone_send']); ?>';
			 * $.get(url, { 'passport_phone':
			 * $('passport_phone').val() }); } var to =
			 * setInterval(function() { $('.phoneone
			 * span').removeClass('stepone').addClass('steptwo'); if
			 * (phonetime > 0) { $(_this).attr('disabled', true); }
			 * else { $(_this).attr('disabled', false);
			 * $(_this).val('免费获取验证码'); phonetime = 120;
			 * clearTimeout(to); return; } phonetime--;
			 * $(_this).val(phonetime + '秒'); }, 1000); });
			 */
			
			
			
			$('.ullock li').click(function (){
				$('.ullock li').removeClass('btn85');
				$(this).addClass('btn85');
				$('.dviloack').hide().eq($(this).index()).show();
			});
			
			$('.datetimeymdhis')[0] && $('.datetimeymdhis').datetimepicker({
				currentText: '现在',
				closeText: '完成',
				timeFormat: 'HH:mm:ss',
				controlType: 'select',
				oneLine: true
			});

		});