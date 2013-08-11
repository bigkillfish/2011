<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

require_once( "header.php" );
require_once( "inc/utility_all.php" );
require_once( "user.php" );
require_once( "inc/department.php" );
echo "<script type=\"text/javascript\">\r\n\t\r\nvar orgstr = new Array();\r\nvar timer_search_mon = null;\r\n\r\n$(\"#search\").live('tap click',function(){\r\n\t$(this).val(\"\");\r\n\ttimer_search_mon = window.setInterval(search_mon, monInterval.SEARCH_REF_SEC*1000);\r\n});\r\n\r\n$(\"#search\").live('blur',function(){\r\n\ttimer_search_mon = window.clearInterval(search_mon);\r\n\ttimer_search_mon = null;\r\n});\r\n\r\nvar gsearch = '";
echo _( "点击搜索" );
echo "';\r\nfunction search_mon(){\r\n\t\tvar sname = $.trim($(\"#search\").val());\r\n\t\tif(gsearch == sname) return;\r\n\t\tif(sname == \"\") {\r\n\t\t\tgsearch = sname; \r\n\t\t\tshowOrgData(orgstr,'');\r\n\t\t\treturn;\t\r\n\t\t}else{\r\n\t\t\tgsearch = sname;\r\n\t\t}\r\n\t\t$.ajax({\r\n\t\t\ttype: \"POST\",\r\n\t\t\turl: \"contact.php\",\r\n\t\t\tdata: \"sname=\"+sname,\r\n\t\t\tcache: false,\r\n\t\t\tbeforeSend: function(){\r\n\t\t\t\t$('.mycust-loading').show();\r\n\t\t\t},\r\n\t\t\tsuccess: function(m){\r\n\t\t\t\t$('.mycust-loading').hide();\r\n\t\t\t\tif(m!=\"\"){\r\n\t\t\t\t\t$(\"#contacts-list-fieldset\").empty().html(m);\r\n\t\t\t\t\tselecteduser();\r\n\t\t\t\t}\r\n\t\t\t}\r\n\t\t});\r\n}\r\n\r\n//绑定选中事件\r\n$(\"#contacts-list > #contacts-list-fieldset > .ui-checkbox > input\").live('click',function(){\r\n\tobj = $(this).parents(\".ui-checkbox\");\r\n\tuid = obj.attr(\"uid\");\r\n\tusername = obj.attr(\"username\");\r\n\tdeptname = obj.attr(\"deptname\");\r\n\tcheckthis(obj,uid,username,deptname);\r\n});\r\n\r\n//选中和反选人物，传入input的ID\r\nfunction checkthis(obj,uid,username,deptname){\r\n\tif(obj.find(\"input\").attr(\"checked\") == \"checked\"){\r\n\r\n\t\tif($(\"#mycust-user-list > #mycust-select-user\"+uid).size() == 0){\r\n\t\t\tobj.find(\"label.ui-btn\").addClass(\"ui-btn-active\");\r\n\t\t\tobj.find(\"span.ui-icon\").addClass(\"ui-icon-checkbox-on\");\r\n\t\t\tuserOper(uid,username,deptname,\"add\");\r\n\t\t}else{\r\n\t\t\tobj.find(\"label\").removeClass(\"ui-btn-active\");\r\n\t\t\tobj.find(\"span.ui-icon\").removeClass(\"ui-icon-checkbox-on\");\r\n\t\t\tuserOper(uid,username,deptname,\"remove\");\t\r\n\t\t}\r\n\t\t\r\n\t}else{\r\n\t\tobj.find(\"label\").removeClass(\"ui-btn-active\");\r\n\t\tobj.find(\"span.ui-icon\").removeClass(\"ui-icon-checkbox-on\");\r\n\t\tuserOper(uid,username,\"remove\");\r\n\t}\r\n}\r\n\r\nfunction userOper(uid,username,deptname,op){\r\n\tvar str = '';\r\n\tif(op == \"add\"){\r\n\t\tstr = '<span class=\"mycust-select-user\" uid=\"'+uid+'\" id=\"mycust-select-user'+uid+'\" deptname=\"'+deptname+'\">'+username+'</span>';\r\n\t\t$(\"#mycust-user-list\").append(str);\r\n\t\treturn;\r\n\t}else{\r\n\t\t$('#mycust-select-user'+uid).remove();\r\n\t\treturn;\r\n\t}\r\n}\r\n\r\nfunction selecteduser(){\r\n\t$('#mycust-user-list > .mycust-select-user').each(function(){\r\n  \t\tvar uid = $(this).attr(\"uid\");\r\n  \t\tvar obj = $('#checkbox-'+uid+'a');\r\n  \t\tif(obj){\r\n  \t\t\tobj.parents('.ui-checkbox').find(\"label\").addClass(\"ui-btn-up-c ui-btn-active\");\r\n\t\t\tobj.parents('.ui-checkbox').find(\"span.ui-icon\").addClass(\"ui-icon-checkbox-on\");\r\n  \t\t}\r\n\t});\r\n}\r\n\r\nfunction muti_send_msg(){\r\n\tvar msg = $.trim($(\"#inp_msg_muti\").val());\r\n\tvar idstr = getMutiUserUID();\r\n\t\r\n\tif(!idstr || idstr == \"\"){alert(\"";
echo _( "请选择收信人！" );
echo "\");$(\"#search\").focus();return;}\r\n\tif(msg==\"\"){$(\"#inp_msg_muti\").focus();return;}\r\n\t\r\n\t$.ajax({\r\n\t\ttype: \"POST\",\r\n\t\turl: \"action.php\",\r\n\t\tdata: {\"action\":\"mutisend\",\"to_uid\":idstr,\"msg\":msg},\r\n\t\tcache: false,\r\n\t\tbeforeSend: function(){\r\n\t\t   $.mobile.loadingMessage = \"发送中\";\r\n\t\t\t$.mobile.pageLoading();\t\r\n\t\t},\r\n\t\tsuccess: function(m){\r\n\t\t\tif(m==\"+OK\"){\r\n\t\t\t   $.mobile.loadingMessage = \"发送成功\";\r\n\t\t\t   $.mobile.pageLoading();\r\n\t\t\t   setTimeout(function(){$.mobile.pageLoading(true);},2000);\r\n\t\t\t   setTimeout(function(){location.reload();},2000);\r\n\t\t\t}\r\n\t\t}\r\n\t});\r\n}\r\n\r\nfunction getMutiUserUID(){\r\n\tvar idstr = dot = \"\";\r\n\tvar obj = $(\"#mycust-user-list > .mycust-select-user\");\r\n\tif(obj.size() <= 0 ) return;\r\n\t$(obj).each(function(){\r\n  \t\tvar uid = $(this).attr(\"uid\");\r\n  \t\tidstr += dot + uid;\r\n  \t\tdot = \",\";\r\n  \t});\r\n  \treturn idstr;\r\n}\r\n\r\n//搜索页面加载时，把选中用户带过来\r\n$('#select-user').live('pageshow',function(event, ui){\r\n\tvar obj = $(\"#mycust-user-list > .mycust-select-user\");\r\n\tvar selected_num = obj.size();\r\n\tif(selected_num == 0) {\r\n\t\tshowOrgData(orgstr,'');\r\n\t\treturn;\r\n\t}\r\n\t$(\"#search\").val(\"";
echo _( "点击搜索" );
echo "\");\r\n\tgsearch = \"";
echo _( "点击搜索" );
echo "\";\r\n\t$(\"#contacts-list > #contacts-list-fieldset > .ui-checkbox\").remove();\r\n\tvar sstyle = selected_str = '';\r\n\tvar _tmp = 0;\r\n\t$(obj).each(function(){\r\n\t\t_tmp++;\r\n  \t\tvar uid = $(this).attr(\"uid\");\r\n  \t\tvar username = $(this).text();\r\n  \t\tvar deptname = $(this).attr(\"deptname\");\r\n  \t\t\t\r\n\t\tif(selected_num > 1){ \r\n\t\t\tif(_tmp == 1) { sstyle = 'ui-corner-top'; }else{ sstyle = '';}\r\n\t\t\tif(_tmp == selected_num){sstyle = 'ui-corner-bottom';}\r\n\t\t}else{\r\n\t\t\tsstyle =  'ui-corner-top ui-corner-bottom';\t\t\r\n\t\t}\r\n  \t\tselected_str += '<div class=\"ui-checkbox\" uid=\"'+uid+'\" username=\"'+username+'\" deptname=\"'+deptname+'\">';\r\n\t\tselected_str += \t'<input type=\"checkbox\" data-theme=\"c\" class=\"custom\" id=\"checkbox-'+uid+'a\" name=\"checkbox-'+uid+'a\">';\r\n\t\tselected_str += \t\t'<label for=\"checkbox-'+uid+'a\" data-theme=\"c\" class=\"ui-btn ui-btn-icon-left '+sstyle+' ui-btn-up-c ui-btn-active\">';\r\n\t\tselected_str += \t\t'<span class=\"ui-btn-inner ui-corner-top\">';\r\n\t\tselected_str += \t\t\t'<span class=\"ui-btn-text\">'+username+' - <span class=\"dept_name\"> ('+ deptname +')</span></span>';\r\n\t\tselected_str += \t\t\t'<span class=\"ui-icon ui-icon-ui-icon-checkbox-off ui-icon-checkbox-off ui-icon-checkbox-on\"></span>';\r\n\t\tselected_str += \t\t'</span>';\r\n\t\tselected_str +=\t '</label>';\r\n\t\tselected_str += '</div>';\r\n  \t});\r\n  \t$(\"#contacts-list > #contacts-list-fieldset\").append(selected_str);\r\n\r\n});\r\n\r\n//显示原始数据并高亮,如果ids设置了\r\nfunction showOrgData(arr,ids){\r\n\tvar sstyle = str = ''\r\n\tarr_length = arr.length;\r\n\tfor(var i = 0;i< arr_length;i++){\r\n\t\tif(arr_length > 1){ \r\n\t\t\tif(i == 0) { sstyle = 'ui-corner-top';}else{sstyle = '';}\r\n\t\t\tif(i == arr_length-1){sstyle = 'ui-corner-bottom';}\r\n\t\t}else{\r\n\t\t\tsstyle =  'ui-corner-top ui-corner-bottom';\t\t\r\n\t\t}\r\n\t\tstr += '<div class=\"ui-checkbox\" uid=\"'+arr[i][1]+'\" username=\"'+arr[i][2]+'\" deptname=\"'+arr[i][3]+'\">';\r\n\t\tstr += \t'<input type=\"checkbox\" data-theme=\"c\" class=\"custom\" id=\"checkbox-'+arr[i][1]+'a\" name=\"checkbox-'+arr[i][1]+'a\">';\r\n\t\tstr += \t\t'<label for=\"checkbox-'+arr[i][1]+'a\" data-theme=\"c\" class=\"ui-btn ui-btn-icon-left '+sstyle+' ui-btn-up-c\">';\r\n\t\tstr += \t\t'<span class=\"ui-btn-inner ui-corner-top\">';\r\n\t\tstr += \t\t\t'<span class=\"ui-btn-text\">'+arr[i][2]+' - <span class=\"dept_name\">('+ arr[i][3] +')</span></span>';\r\n\t\tstr += \t\t\t'<span class=\"ui-icon ui-icon-ui-icon-checkbox-off ui-icon-checkbox-off\"></span>';\r\n\t\tstr += \t\t'</span>';\r\n\t\tstr +=\t '</label>';\r\n\t\tstr += '</div>';\r\n\t}\r\n\t$(\"#contacts-list > #contacts-list-fieldset\").empty().append(str).show();\r\n}\r\n\r\n\r\n\r\n";
$_count = 0;
foreach ( $USER_ARRAY_ORDER_BYDEPT as $k => $v )
{
				$id_arr = explode( ",", $v['UID'] );
				$id_arr = array_filter( $id_arr );
				foreach ( $id_arr as $g => $i )
				{
								echo "orgstr[";
								echo $_count;
								echo "] = ['";
								echo $k;
								echo "','";
								echo $i;
								echo "',\"";
								echo $USER_ARRAY[$i]['NAME'];
								echo "\",\"";
								echo $SYS_DEPARTMENT[$k]['DEPT_NAME'];
								echo "\"];\r\n\t\t";
								++$_count;
				}
}
echo "\r\n</script>\r\n<body> \r\n<div data-role=\"page\" data-theme=\"b\" id=\"write-sms-page\">\r\n\t<div data-role=\"header\" class=\"ui-btn-up-b\" data-theme=\"b\">\r\n\t\t<a href=\"index.php#sms-list-page\" data-role=\"button\" data-icon=\"arrow-l\" data-transition=\"slideup\" data-ajax=\"false\">";
echo _( "主页" );
echo "</a>\r\n\t\t<h1 id=\"mycust-title\">";
echo _( "通讯录" );
echo "</h1>\r\n\t</div><!-- /header -->\r\n\r\n\t<div data-role=\"content\" id=\"contact-list-content\">\r\n\t\t\t<div data-role=\"fieldcontain\" class=\"mycust-contactsearch\">\r\n\t\t\t\t<span class=\"mycust-contactsearch-block clear\">\r\n\t\t\t\t\t<span class=\"mycust-cb-item\">";
echo _( "收信人：" );
echo "</span>\r\n\t\t\t\t\t<span id=\"mycust-btn-add\" data-rel=\"dialog\" data-theme=\"b\" class=\"ui-btn-active\"><span class=\"ui-icon ui-icon-plus ui-icon-shadow\"></span><a href=\"search.php\" data-rel=\"dialog\" data-transition=\"";
echo $deffect[deviceagent( )]['flip'];
echo "\">";
echo _( "添加收信人" );
echo "</a></span>\r\n\t\t\t\t\t<br />\r\n\t\t\t\t\t<div class=\"mycust-user-list\" id=\"mycust-user-list\"></div>\r\n\t\t\t\t</span>\r\n\t\t\t</div>\r\n\t\t\t<div id=\"inp_area_muti\" data-role=\"fieldcontain\">\r\n\t\t\t\t<span id=\"inp_area_text\">";
echo _( "短信内容：" );
echo "</span>\r\n\t\t\t\t<textarea cols=\"40\" rows=\"8\" name=\"inp_msg_muti\" id=\"inp_msg_muti\" data-theme=\"c\"></textarea>\r\n\t\t\t\t<div class=\"ui-grid-a\">\r\n               <div class=\"ui-block-a\"><a href=\"javascript:void(0);\" data-role=\"button\" data-theme=\"b\" data-icon=\"arrow-r\" data-iconpos=\"right\" id=\"myapp_muti_send\" onclick=\"muti_send_msg()\">";
echo _( "发送" );
echo "</a></div>\r\n               <div class=\"ui-block-b\"><a href=\"index.php#sms-list-page\" rel=\"external\" data-role=\"button\" data-icon=\"home\" data-theme=\"c\" data-transition=\"slideup\" data-ajax=\"false\">";
echo _( "主页" );
echo "</a></div>\r\n\t\t\t\t</div>\r\n\t\t\t</div>\r\n\t</div>\r\n</div>\r\n\r\n</body>\r\n</html>\r\n";
?>
