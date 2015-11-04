$(function() {
    $('.trone').hide();
    $('.reglist li a').click(function (){
	var i = $('.reglist li a').index(this);
	$('.reglist li a').removeClass('active').eq(i).addClass('active');
	$('.trone').hide().eq(i).show();
	$('.mpcode').hide().eq(i).show();
	$('input[name="regtype"]').val(i);
    });
    
    $('.charge_name').blur(function(){
	if($('.order_rmba')[0]){
	    var order_rmba = $('.order_rmba').parent().children('.active');
	    var data_count = order_rmba.attr('data-count');
	    if(data_count > 0 && this.value){
		var data_value = order_rmba.attr('data-value');
		var data = { 'passport_name': this.value, 'cardtype': data_value};
		$.post('/pay/charge/', data, function (data){
		    if(data.code < 0){
			$.messager.alert('警告',  data.msg);
			data.code == -3 && $('.order_rmba').eq(0).click();
		    }
		}, 'JSON');
	    }
	}
    })
    
    $('.login_passport').blur(function() {
	var v = $(this).val();
	if(v.lenght < 6)
	    return ;
	iscode($(this).val());
    });
    
    $('.login_passport').focus(function() {
	checkname_name = $(this).val();
    });


    $('table').on('click', '.order_rmba', function (){
	var _this = this;
	var data_count = $(_this).attr('data-count');
	$('.cardcount').numberspinner(data_count <= 0 ? 'enable' : 'disable');
	if(data_count > 0 ){
	    $('.cardcount').numberspinner('setValue', data_count);
	}
	if(data_count <= 0 || $('.charge_name').val() == ''){
	    change_rmbtext(_this); 
	    return ;
	}
	var data_value = $(_this).attr('data-value');
	var data = { 'passport_name': $('.charge_name').val(), 'cardtype': data_value};
	$.post('/pay/charge/', data, function (data){
	    if(data.code < 0){
		$.messager.alert('警告', data.msg);
		data.code == -3 && $('.order_rmba').eq(0).click();
		return ;
	    }
	    change_rmbtext(_this);
	}, 'JSON');
    });
    
    $('.Payment').on('click', '.platform_a', function (){
	if($(this).hasClass('disabled')){
	    return ;
	}
	if($(this).attr('data-value') == 13){
	    $('.point_online').hide();
	    $('.point').show();
	}else{
	    $('.point_online').show();
	    $('.point').hide();
	}
	change_rmb('.platform_a', this, '#paypfid', (function(){}));
    });
    
    
    function change_rmbtext(_this){
	    change_rmb('.order_rmba', _this, '#order_rmb', change_pf);
	    $('.pay_sum').text(get_price(parseInt($(_this).text()), $('input[name="cardcount"]').val()));
	    $('.pay_sum2').text(get_price(parseInt($(_this).attr('data-dian')), $('input[name="cardcount"]').val()));
    }

    $('.cardcount').numberspinner({
	width : 142,
	height : 34,
	min : 1,
	onChange : function() {
	    $('.pay_sum').text(get_price(parseInt($('.active').text()), $('input[name="cardcount"]').val()));
	    $('.pay_sum2').text(get_price(parseInt($('.active').attr('data-dian')), $('input[name="cardcount"]').val()));
	}
    });

    $('.get_name').combobox({
	'onSelect' : function(pam) {
	    if (pam.value == 1) {
		$('#vtype-error').remove();
		get_game('.get_area');
		$('.game_tr').show();
	    } else {
		$('.game_tr').hide();
	    }
	}
    });
    

    $('.get_area').combobox({
	'valueField' : 'game_id',
	'textField' : 'game_name',
	'onSelect' : function(pam) {
	    $('#vgame-error').remove();
	    get_area(pam.game_id, '.get_server');
	    $('.number ul')[0] && get_order_rmba(pam.game_id, $('.number ul'));
	    $('.step').addClass('stepone');
//	    $('.pay_sum').text(parseInt($('.number  .active').text()));
//	    $('.pay_sum2').text(parseInt($('.number  .active').attr('data-dian')));
	}
    });

    $('.get_server').combobox(
	    {
		'onSelect' : function(pam) {
		    $('#varea-error').remove();
		    $('input[name="varea"]').val(pam.area_id);
		    get_server($('.get_area').combobox('getValue'),
			    pam.area_id ? pam.area_id : pam.value, '.get_server_end');
		}
	    });

    $('.get_server_end').combobox({
	'onSelect' : function(pam) {
	    $('#vserver-error').remove();
	    $('input[name="vserver"]').val(pam.server_id);
	    $('.change_codetype').combobox({});
	    $('.get_server_end').attr('data-callback') && data_callback($('.get_server_end').attr('data-callback'), pam);
	}
    });
    
    $('.change_codetype').combobox({
	'onSelect' : function(pam) {
	    $('.change_codetype').attr('data-callback') && data_callback($('.change_codetype').attr('data-callback'), pam);
	}
    });
    
    
    $('.combobox').combobox({
	required : true,
	width : 242,
	height : 34,
	editable: false
    });

    $('.combobox2').combobox({
	width : 142,
	height : 34,
	editable: false
    });

    $('.combobox292').combobox({
	width : 292,
	height : 34,
	editable: false
    });

    $('.dialog_show').linkbutton({
	width : 120,
	height : 30,
	'onClick' : function() {
	    show_window(this);
	}
    });

    $('.datebox').datebox({
	height : 34,
	editable: false
    });
    
    $('.datetimebox').datetimebox({
	height : 34,
	editable: false
    });

    if($.cookie('user')){
	var user = $.cookie('user');
	user = user.length <= 8 ? user : user.replace(/^(\w{4}).*(\w{4})$/, "$1**$2")
	$('.username p')[0] && $('.username p').text(user);
	$('.userinfo b')[0] && $('.userinfo b').text('欢迎登录 : ' + user);
    }
     
    $('.ullock li').click(function (){
	$('.ullock li').removeClass('btn85');
	$(this).addClass('btn85');
	$('.dviloack').hide().eq($(this).index()).show();
    });

    $('.gameproblem li a').click(function (e){
	e.preventDefault();
	$('.gameproblem li a').removeClass('active');
	$('.gameproblem i a').attr('href', '/service/faq_list/index?faq_type='+$('.gameproblem li a').index(this));
	$(this).addClass('active');
	$.get($(this).attr('href'), function (data){
	    $('.new').html(data);
	});
    });
    
    /*css样式兼容*/
    $('input[type="text"]').css('line-height', $('input[type="text"]').css('height'));
    $('input[type="password"]').css('line-height', $('input[type="password"]').css('height'));
    //
    $("#submittype")[0] && $("#submittype").val('email');

    $('.recharge td div div span').css('left', parseInt($('td div div span').css('left')) + 10 +'px');
});