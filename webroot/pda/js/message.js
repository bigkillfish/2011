if(!+'\v1') {
    (function(f){
        window.setTimeout =f(window.setTimeout);
        window.setInterval =f(window.setInterval);
    })(function(f){
        return function(c,t){
            var a=[].slice.call(arguments,2);
            return f(function(){
                c.apply(this,a)},t)
            }
    });
}

$(document).bind("mobileinit", function(){
	$.mobile.ajaxLinksEnabled = false;
	//$.mobile.ajaxEnabled = false;
  	$.mobile.loadingMessage = td_lang.inc.msg_84;//"������"
  	$.mobile.pageLoadErrorMessage = td_lang.inc.msg_105;//"ҳ����ش���"

  	
  	$('#dialogue-list-page').live('pageshow',function(event, ui){
��		//var ypos = $('#mycust-dialogue-list').height();
		//$.mobile.silentScroll(ypos);	
	});

});
	

