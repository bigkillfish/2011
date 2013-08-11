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
$FROM_UID = intval( $FROM_UID );
$query = "UPDATE message SET REMIND_FLAG = 2 WHERE (TO_UID='".$LOGIN_UID."' and FROM_UID='{$FROM_UID}') and DELETE_FLAG!='1' and REMIND_FLAG = 1";
exequery( $connection, $query );
if ( ( !in_array( $FROM_UID, $_COOKIE['CookieArray'] ) || !isset( $_COOKIE['CookieArray'] ) ) && $FROM_UID != $LOGIN_UID )
{
				setcookie( "CookieArray[".$FROM_UID."]", $FROM_UID, time( ) + 2592000 );
}
echo "<script type=\"text/javascript\">\r\nwindow.setTimeout(function(){var ypos = $('#mycust-dialogue-list').height();$.mobile.silentScroll(ypos);},1000);\r\n\t\r\nfunction send_msg(){\r\n\tvar msg = $.trim($(\"#inp_msg\").val());\r\n\tif(msg==\"\"){ $(\"#inp_msg\").focus();return;}\r\n\tallnum = $(\"#mycust-dialogue-list > .mycust-list\").size();\r\n\tnextline = allnum%2 == 0 ? \"line1\" : \"line2\";\r\n\t$.ajax({\r\n\t\ttype: \"POST\",\r\n\t\turl: \"action.php\",\r\n\t\tdata: {\"action\":\"add\",\"to_uid\":";
echo $FROM_UID;
echo ",\"msg\":msg,\"nextline\":nextline},\r\n\t\tcache: false,\r\n\t\tsuccess: function(m){\r\n\t\t\t$('#mycust-dialogue-list').append(m);\r\n\t\t\t$('#mycust-dialogue-list').find('div.mycust-list:hidden').fadeIn(1000);\r\n\t\t\t$.mobile.silentScroll($('#mycust-dialogue-list').height() + 50);\r\n\t\t\t$('#inp_msg').val(\"\");\r\n\t\t}\r\n\t});\r\n}\r\n</script>\r\n<div data-role=\"page\" data-theme=\"b\" id=\"dialogue-list-page\">\r\n\r\n\t<div data-role=\"header\" class=\"ui-btn-up-b\" data-theme=\"b\">\r\n\t\t<a href=\"index.php\" data-role=\"button\"  rel=\"external\" data-icon=\"arrow-l\" ajax-data=\"false\">";
echo _( "短信列表" );
echo "</a>\r\n\t\t<h1>";
echo $LOGIN_USER_NAME;
echo "</h1>\r\n\t\t<a href=\"index.php#contact-list-page\" data-icon=\"grid\" data-theme=\"b\" data-ajax=\"false\" data-transition=\"";
echo $deffect[deviceagent( )]['flip'];
echo "\">";
echo _( "联系人" );
echo "</a>\r\n\t</div><!-- /header -->\r\n\r\n\t<div data-role=\"content\">\r\n\t\t<div id=\"mycust-dialogue-list\">\r\n\t\t";
$count = 0;
$_str = $sfinal_str = $msg_type_name = $line_style = "";
$query_num = ag( "iPad" ) ? $C['optimizeiPad']['sms-diog-show-num'] : 15;
$query = "SELECT MSG_ID,TO_UID,FROM_UID,SEND_TIME,CONTENT,MSG_TYPE from message where (TO_UID='".$LOGIN_UID."' and FROM_UID='{$FROM_UID}') or (TO_UID='{$FROM_UID}' and FROM_UID='{$LOGIN_UID}') and DELETE_FLAG!='1' AND REMIND_FLAG!=0 order by MSG_ID DESC limit ".$query_num;
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$FROM_UID = $ROW['FROM_UID'];
				$MSG_ID = $ROW['MSG_ID'];
				$TO_UID = $ROW['TO_UID'];
				$SEND_TIME = $ROW['SEND_TIME'];
				$CONTENT = $ROW['CONTENT'];
				$MSG_TYPE = $ROW['MSG_TYPE'];
				$SEND_TIME = timeintval( $SEND_TIME );
				++$count;
				$line_style = $FROM_UID == $LOGIN_UID ? "line1" : "line2";
				$online_type = $MSG_TYPE == 3 ? "<div class=\"mycust-online\"></div>" : "";
				$msg_type_name = $MSG_TYPE == 3 && $FROM_UID != $LOGIN_UID ? " - 来自微讯" : "";
				$_str = "<div class=\"mycust-list ".$line_style." clear\">\r\n\t\t\t\t<div class=\"mycust-dioavatar\"><a href=\"#\" class=\"avatar\">".$online_type."<img src=\"".showavatar( $USER_ARRAY[$FROM_UID]['AVATAR'], $USER_ARRAY[$FROM_UID]['SEX'] )."\" /></a></div>\r\n\t\t\t\t<div class=\"mycust-diobox\">\r\n\t\t\t\t\t<span class=\"mycust-list-user\"><span class=\"mycust-list-time\">".$SEND_TIME."</span>".$USER_ARRAY[$FROM_UID]['NAME']."<span class=\"mycust-list-from\">".$msg_type_name."</span></span>\r\n\t\t\t\t\t<div class=\"mycust-list-msg\">".$CONTENT."</div>\r\n\t\t\t\t\t\t</div>\r\n\t\t\t\t </div>";
				$sfinal_str = $_str.$sfinal_str;
				$_str = "";
}
echo $sfinal_str;
echo "\t</div>\r\n\t<div id=\"inp_area\" data-role=\"fieldcontain\">\r\n\t\t<textarea cols=\"40\" rows=\"8\" name=\"inp_msg\" id=\"inp_msg\" data-theme=\"c\"></textarea>\r\n\t\t<div class=\"ui-grid-a\">\r\n\t\t";
echo _( "　" );
echo " <div class=\"ui-block-a\"><a href=\"javascript:void(0);\" data-role=\"button\" data-theme=\"b\" data-icon=\"arrow-r\" data-iconpos=\"right\" id=\"myapp-send\" onclick=\"send_msg()\">";
echo _( "发送" );
echo "</a></div>\r\n\t\t";
echo _( "　" );
echo " <div class=\"ui-block-b\"><a href=\"index.php\" rel=\"external\" data-role=\"button\" data-icon=\"home\" data-theme=\"c\" data-transition=\"slideup\" data-ajax=\"false\">";
echo _( "主页" );
echo "</a></div>\r\n\t\t</div>\r\n\t</div>\r\n\t\r\n</div>\r\n</div>\r\n<!--//对话聊天-->\r\n<script type=\"text/javascript\">\r\nvar timer_msg_mon = null;\r\ntimer_msg_mon = window.setInterval(msg_mon,monInterval.MSG_DIOG_REF_SEC*1000);\r\n\r\nfunction msg_mon(){\r\n\t$.ajax({\r\n      type: 'POST',\r\n      url: '/attachment/new_sms/' + loginUser.uid + '.sms',\r\n      data: {'now': new Date().getTime()},\r\n      success: function(data){\r\n   \t\tif(data==\"01\" || data==\"11\"){\r\n   \t\t\t$.ajax({\r\n\t\t\t\t\ttype: \"POST\",\r\n\t\t\t\t\turl: \"action.php\",\r\n\t\t\t\t\tdata: {\"action\":\"siglequery\",\"to_uid\":";
echo $FROM_UID;
echo "},\r\n\t\t\t\t\tcache: false,\r\n\t\t\t\t\tsuccess: function(m){\r\n\t\t\t\t\t\tif(m == \"NO\") return;\r\n\t\t\t\t\t\tif(m!=\"\"){\r\n\t\t\t\t\t\t\t$('#mycust-dialogue-list').append(m);\r\n\t\t\t\t\t\t\t$('#mycust-dialogue-list').find('div.mycust-list:hidden').fadeIn(1000);\r\n\t\t\t\t\t\t\t$.mobile.silentScroll($('#mycust-dialogue-list').height());\r\n\t\t\t\t\t\t}\r\n\t\t\t\t\t}\r\n\t\t\t\t});\r\n   \t\t}\r\n   \t}\r\n   });\r\n}\r\n</script>";
?>
