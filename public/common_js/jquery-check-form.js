/* jQuery.checkform.js
 *
 * check type:
 *  mustInput
 *  mustMoreThan
 *  mustLessThan
 *  mustEqualTo
 *  mustEmail
 *  mustInt
 *  mustFloat
 *  mustSelect
 *  mustCheck
 *  mustRadio:
 *  mustRegular
 *
 */ 
 
jQuery.extend({ 
    options: {
        ctrls: [ ],//controls to check         
        success: function() { return; },//When check success,you can do something,such as submit a ajax request
        failed:  function(msg, id){ jQuery.clewMsg(msg, id); } //when check faild                
    },
 
 clewMsg: function(msg, id){
     alert(msg);
 },
 
 checkForm: function(o){  
  o = jQuery.extend({},jQuery.options,o);
  
     var isok = true;
     
     
     var flashPrompt = function(ctr){
   var i = 0;   
   var intervalid = setInterval(function(){        
    jQuery("#"+ctr.id).toggleClass('warning');
    if(i++ > 2){
     clearInterval(intervalid);
     jQuery("#"+ctr.id).addClass('warning');
    }
   }, 100);   
  }; 
  
     //check failed, we alert a message, and change the control's style
     var fail = function(ctr){
             isok = false; 
                o.failed(ctr.msg, ctr.id);
                flashPrompt(ctr);
                jQuery("#"+ctr.id).focus();
                return false;
         }
     
     //check success, we change the control to its original style
     var succ = function(ctr){
             jQuery("#"+ctr.id).removeClass('warning');
             return true;
         }
     
     //regular express check
     var checkRegularExpression = function(val, expression){
             if(val != "")
                {
                    var matchArray = val.match(expression);
                    if (matchArray == null)return false;else return true;
                }
                else return true;
         }
           
  jQuery.each(o.ctrls, function(i, ctr){
      switch(ctr.type)
      {
          case "mustInput":   if(jQuery.trim(jQuery("#"+ctr.id).val()) == "")return fail(ctr); else return succ(ctr);
          case "mustMoreThan":if(jQuery.trim(jQuery("#"+ctr.id).val()).length < ctr.par)return fail(ctr); else return succ(ctr);
          case "mustLessThan":if(jQuery.trim(jQuery("#"+ctr.id).val()).length > ctr.par)return fail(ctr); else return succ(ctr);
          case "mustEqualTo": if(jQuery.trim(jQuery("#"+ctr.id).val()) != jQuery.trim(jQuery("#"+ctr.par).val()))return fail(ctr);else return succ(ctr);
          case "mustEmail":   if(!checkRegularExpression(jQuery.trim(jQuery("#"+ctr.id).val()), /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/))return fail(ctr);else return succ(ctr);
                case "mustInt":     if(!checkRegularExpression(jQuery.trim(jQuery("#"+ctr.id).val()), /^[0-9]*jQuery/))return fail(ctr);else return succ(ctr); 
                case "mustFloat":   if(!checkRegularExpression(jQuery.trim(jQuery("#"+ctr.id).val()), /^[0-9]+\.{0,1}[0-9]{0,2}jQuery/))return fail(ctr);else return succ(ctr); 
          case "mustSelect":  if(jQuery.trim(jQuery("#"+ctr.id).val()) == ctr.par)return fail(ctr); else return succ(ctr);
          case "mustCheck":   if(!jQuery("#"+ctr.id).attr("checked"))return fail(ctr); else return succ(ctr);
          case "mustRadio":   if(jQuery("input[type='radio'][name='"+ctr.id+"']:checked").length<1)return fail(ctr); else return succ(ctr);
          case "mustRegular": if(!checkRegularExpression(jQuery("#"+ctr.id).val(), ctr.par))return fail(ctr);else return succ(ctr); 
      }
      });
  
  
  if(isok) o.success();
 } 
});