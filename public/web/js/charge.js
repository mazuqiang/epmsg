function get_price (rmb, num){
//    console.log(rmb, num)
    return parseInt(rmb) * parseInt(num);
}

function get_paypfid(cid, _class){
    $.get('/pay/pf', {'cid': cid}, function (data){
	if(data == 0){
	    data = '<option value="" >无该卡充值平台</option>';
//	    $(_class).attr('disabled', true);
	}else{
//	    $(_class).attr('disabled', false);
	}
	$(_class).html(data);
    });
}

function set_rmb(sum, rmb){
    sum.text(get_price( rmb.attr('data-rmb'), $('.cardcount').val()));
}

function get_area(parent, game){
    var url = '/game/index/ajax_area/' + game ;
    $(parent).html('<option value="">--请选择--</option>');
    $.getJSON(url, function(data) {
        for ( var i = 0; i < data.length; i++) {
    		$('<option value=' + data[i].server_id + '>'+ data[i].server_name + '</option>').appendTo(parent);
        }
    });
}


function get_server(parent, game, area){
    var url = '/game/index/ajax_server/' + game + '/' + area;
    $(parent).html('<option value="">--请选择--</option>');
    $.getJSON(url, function(data) {
        for ( var i = 0; i < data.length; i++) {
    		$('<option value=' + data[i].server_id + '>'+ data[i].server_name + '</option>').appendTo(parent);
        }
    });
}


$(function() {
    $('.rmb').change(function (){
	if (this.value == '')
	    return;
	set_rmb($('.pay_sum'), $('.rmb option:selected'));
	get_paypfid(this.value, '.paypfid');
    });
    
    $('.cardcount').blur(function (){
	if (this.value <= 0)
	    this.value = 1;
	set_rmb($(".pay_sum"), $('.rmb option:selected'));
    });
    
    $('.change_area').change(function (){
	get_server('.change_server',  $('.change_game').val(), this.value);
    });
    
    
    

});
