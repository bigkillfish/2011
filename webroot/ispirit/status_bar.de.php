<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
include_once( "inc/utility_all.php" );
include_once( "inc/td_core.php" );
$UPLOAD_MAX_FILESIZE = intval( ini_get( "upload_max_filesize" ) );
$UPLOAD_MAX_FILESIZE = 0 < $UPLOAD_MAX_FILESIZE ? $UPLOAD_MAX_FILESIZE : 200;
$USER_TOTAL_COUNT = 1;
$query = "SELECT count(*) from USER where NOT_LOGIN='0'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$USER_TOTAL_COUNT = $ROW[0];
}
$query = "SELECT * from USER where USER_ID='".$LOGIN_USER_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$SMS_ON = $ROW['SMS_ON'];
				$CALL_SOUND = $ROW['CALL_SOUND'];
				$MY_STATUS = $ROW['MY_STATUS'];
				$ON_STATUS = $ROW['ON_STATUS'];
				$PWD = $ROW['PASSWORD'];
				$PWD = substr( md5( keyed_str( $PWD, "BLVY" ) ), 0, 16 );
				if ( $ON_STATUS == "" )
				{
								$ON_STATUS = "1";
				}
}
$CHECK_SMS = 0;
if ( find_id( $USER_FUNC_ID_STR, "42" ) )
{
				$CHECK_SMS = 1;
}
else
{
				$query = "select * from SMS2_PRIV";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$SMS2_REMIND_PRIV = $ROW['SMS2_REMIND_PRIV'];
				}
				if ( find_id( $SMS2_REMIND_PRIV, $LOGIN_USER_ID ) )
				{
								$CHECK_SMS = 1;
				}
}
$NEW_SMS_HTML = sprintf( "<a href='#' onclick='javascript:show_sms(%s);' title='%s'><img src='/images/sms1.gif'border=0 height=10> %s</a>", $I_VER == "2" ? "2" : "", _( "点击查看新消息" ), _( "新消息" ) );
if ( $CALL_SOUND != "0" )
{
				$NEW_SMS_SOUND_HTML = "<object id='sms_sound' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='/inc/swflash.cab' width='0' height='0'><param name='movie' value='/wav/".$CALL_SOUND.".swf'><param name=quality value=high><embed id='sms_sound' src='/wav/{$CALL_SOUND}.swf' width='0' height='0' quality='autohigh' wmode='opaque' type='application/x-shockwave-flash' plugspace='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></embed></object>";
}
else
{
				$NEW_SMS_SOUND_HTML = "";
}
echo "\r\n<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"/theme/";
echo $LOGIN_THEME;
echo "/status_bar.css\">\r\n<title>";
echo _( "状态栏" );
echo "</title>\r\n<script type=\"text/javascript\" src=\"/inc/js/jquery/jquery.min.js\"></script>\r\n<script type=\"text/javascript\" src=\"/inc/js_lang.php\"></script>\r\n<SCRIPT LANGUAGE=\"JavaScript\">\r\njQuery.noConflict();\r\nvar $ = function(id) {return document.getElementById(id);};\r\n\r\nfunction killErrors()\r\n{\r\n   return true;\r\n}\r\nwindow.onerror = killErrors;\r\n\r\nvar ctroltime;\r\nvar checktime;\r\n\r\nfunction MyLoad()\r\n{\r\n   setTimeout(\"online_mon()\",1000);\r\n   clearTimeout(ctroltime);\r\n   ctroltime=setTimeout(\"sms_mon()\",3000);\r\n   setTimeout(\"email_mon()\",11000);\r\n\r\n";
if ( $I_VER == "2" )
{
				echo "     window.external.OA_SMS(\"";
				echo $LOGIN_USER_NAME;
				echo "\", \"";
				echo $PWD;
				echo "\", \"NAME\");\r\n     window.external.OA_SMS(\"UPLOAD_MAX_FILESIZE\", \"";
				echo $UPLOAD_MAX_FILESIZE;
				echo "\", \"INIT\");\r\n     window.external.OA_SMS(\"MY_STATUS\", \"";
				echo str_replace( array( "\"", "\r", "\n" ), array( "\\\"", "", "" ), trim( $MY_STATUS ) );
				echo "\", \"INIT\");\r\n     window.external.OA_SMS(\"ON_STATUS\", \"";
				echo $ON_STATUS;
				echo "\", \"INIT\");\r\n     window.external.OA_SMS(\"IS_UN\", \"";
				echo $MYOA_IS_UN;
				echo "\", \"INIT\");\r\n";
}
echo "}\r\n\r\nfunction online_mon()\r\n{\r\n   jQuery.get(\"../general/ipanel/user/user_count.php\", {CHECK_SMS: \"";
echo $CHECK_SMS;
echo "\", CLIENT: 2}, function(data){\r\n      var count = isNaN(parseInt(data)) ? 0 : parseInt(data);\r\n      \r\n      $(\"user_count1\").value=count;\r\n      $(\"user_count1\").size=($(\"user_count1\").value.length<3 ? 3 : $(\"user_count1\").value.length);\r\n      \r\n      var online_title = sprintf(td_lang.general.msg_34, \"";
echo $USER_TOTAL_COUNT;
echo "\", count);\r\n      $(\"user_count1\").title = online_title;\r\n      $(\"online_link\").title = online_title;\r\n";
if ( $I_VER == 2 )
{
				echo "      if(count == 0)\r\n      {\r\n         window.external.OA_SMS(\"\",\"\",\"RELOGIN\");\r\n      }\r\n";
}
echo "   });\r\n   setTimeout(\"online_mon()\",";
echo $ONLINE_REF_SEC * 1000;
echo ");\r\n}\r\n\r\nfunction email_mon()\r\n{\r\n   jQuery.get(\"../general/status_bar/email_mon.php\", {}, function(data){\r\n      if(data == \"1\")\r\n         $(\"new_letter\").innerHTML=\"<a href='#' onclick='javascript:show_email();' title='";
echo _( "点击查看新邮件" );
echo "'><img src='/images/email_close.gif' border='0' width='16' height='16' align='absMiddle'></a>&nbsp;\";\r\n      else\r\n         $(\"new_letter\").innerHTML=\"\";\r\n   });\r\n   setTimeout(\"email_mon()\",900000);\r\n}\r\n\r\nvar sms_mon_ref = ";
echo $SMS_REF_SEC * 1000;
echo ";\r\nvar sms_mon_flag = \"\";\r\nfunction sms_mon()\r\n{\r\n   clearTimeout(ctroltime);\r\n   jQuery.get(\"../attachment/new_sms/";
echo $LOGIN_UID;
echo ".sms\", {now: new Date().getTime()}, function(data){\r\n      sms_mon_flag = data;\r\n      if(sms_mon_flag.indexOf(\"1\") >= 0)\r\n      {\r\n         $(\"new_sms\").innerHTML=\"";
echo $NEW_SMS_HTML;
echo "\";\r\n         $(\"new_sms_sound\").innerHTML=\"";
echo $NEW_SMS_SOUND_HTML;
echo "\";\r\n";
if ( $I_VER == "2" )
{
				echo "         if(sms_mon_flag.substr(0, 1) == \"1\")\r\n            window.external.OA_SMS(\"\",\"1\",\"OPEN\");\r\n         if(sms_mon_flag.substr(1, 1) == \"1\")\r\n            window.external.OA_SMS(\"\",\"2\",\"OPEN\");\r\n";
}
else if ( $SMS_ON == 1 )
{
				echo "         show_sms();\r\n";
}
echo "      }\r\n      else\r\n      {\r\n      \t  set_no_sms()\r\n      }\r\n   });\r\n   ctroltime=setTimeout(\"sms_mon()\", sms_mon_ref);\r\n}\r\n\r\nfunction set_sms_ref()\r\n{\r\n   sms_mon_ref = ";
echo $SMS_REF_SEC * 10 * 1000;
echo ";\r\n}\r\nfunction set_no_sms()\r\n{\r\n   $(\"new_sms\").innerHTML=\"\";\r\n   $(\"new_sms_sound\").innerHTML=\"\";\r\n}\r\nfunction show_sms(flag)\r\n{\r\n   set_no_sms();\r\n   if(flag == \"1\")\r\n   {\r\n      jQuery.getJSON(\"../general/status_bar/get_msg.php\", {IM_FLAG: '1'}, function(json){\r\n         for(var i=0; i<json.length; i++)\r\n         {\r\n            window.external.OA_MSG(\"RECEIVE_MSG\", json[i].from_uid, json[i].time, json[i].type, json[i].content, json[i].from_name);\r\n         }\r\n      });\r\n   }\r\n   else if(flag == \"2\")\r\n   {\r\n      if(sms_mon_flag.substr(0, 1) == \"1\")\r\n         window.external.OA_SMS(\"\",\"\",\"OPEN_NOC\"); //打开事务提醒\r\n      if(sms_mon_flag.substr(1, 1) == \"1\")\r\n         window.external.OA_SMS(\"\",\"\",\"OPEN_MSG\"); //打开微讯\r\n   }\r\n   else\r\n   {\r\n      mytop=(screen.availHeight-410)/2;\r\n      myleft=(screen.availWidth-425)/2;\r\n      URL=\"../general/status_bar/sms_show.php@ISPIRIT=1*I_VER=";
echo $I_VER;
echo "*CALL_SOUND=";
echo $CALL_SOUND;
echo "\";\r\n      window.open(\"/ispirit/go.php?LOGIN_UID=";
echo $LOGIN_UID;
echo "&LOGIN_USER_PRIV=";
echo $LOGIN_USER_PRIV;
echo "&LOGIN_DEPT_ID=";
echo $LOGIN_DEPT_ID;
echo "&LOGIN_AVATAR=";
echo $LOGIN_AVATAR;
echo "&PWD=";
echo $PWD;
echo "&URL=\"+URL,\"sms_show_";
echo $LOGIN_UID;
echo "\",\"height=422,width=480,top=\"+mytop+\",left=\"+myleft+\",status=0,toolbar=no,menubar=no,location=no,scrollbars=no,resizable=yes\");\r\n   }\r\n}\r\n\r\nfunction show_email()\r\n{\r\n   $(\"new_letter\").innerHTML=\"\";\r\n   mytop=(screen.availHeight-500)/2-30;\r\n   myleft=(screen.availWidth-780)/2;\r\n\r\n   URL=\"/general/email/\";\r\n   window.open(\"/ispirit/go.php?LOGIN_UID=";
echo $LOGIN_UID;
echo "&LOGIN_USER_PRIV=";
echo $LOGIN_USER_PRIV;
echo "&LOGIN_DEPT_ID=";
echo $LOGIN_DEPT_ID;
echo "&LOGIN_AVATAR=";
echo $LOGIN_AVATAR;
echo "&PWD=";
echo $PWD;
echo "&URL=\"+URL,\"oa_sub_window\",\"height=500,width=780,status=0,toolbar=no,menubar=no,location=no,scrollbars=yes,top=\"+mytop+\",left=\"+myleft+\",resizable=yes\");\r\n}\r\n\r\nfunction show_online()\r\n{\r\n   parent.ipanel.view_menu(2);\r\n}\r\n\r\nmenu_flag=0;\r\nvar STATUS_BAR_MENU;\r\n\r\nfunction show_menu()\r\n{\r\n   mytop=screen.availHeight-480;\r\n   myleft=screen.availWidth-215;\r\n   if(menu_flag==0)\r\n       STATUS_BAR_MENU=window.open(\"menu.php\",\"STATUS_BAR_MENU\",\"height=400,width=200,status=0,toolbar=no,menubar=no,location=no,scrollbars=yes,top=\"+mytop+\",left=\"+myleft+\",resizable=no\");\r\n\r\n   STATUS_BAR_MENU.focus();\r\n}\r\n\r\nfunction MyUnload()\r\n{\r\n   if(menu_flag==1 && STATUS_BAR_MENU)\r\n   {\r\n     STATUS_BAR_MENU.focus();\r\n     STATUS_BAR_MENU.MAIN_CLOSE=1;\r\n     STATUS_BAR_MENU.close();\r\n   }\r\n}\r\n</script>\r\n</head>\r\n\r\n<body class=\"statusbar\" topmargin=\"0\" leftmargin=\"0\" marginwidth=\"0\" marginheight=\"0\" onload=\"MyLoad();\" onunload=\"MyUnload();\">\r\n\r\n<table border=\"0\" width=\"100%\" cellspacing=\"1\" cellpadding=\"0\" class=\"small\">\r\n  <tr>\r\n    <td>\r\n       <a id=\"online_link\" href=\"#\" onclick=\"javascript:show_online();\">\r\n       &nbsp;";
echo sprintf( _( "在线%s人" ), "<input type=\"text\" id=\"user_count1\" size=\"3\">" );
echo "       </a>\r\n    </td>\r\n    <td align=\"center\">&nbsp;\r\n       <span id=\"new_sms\"></span>\r\n       <span id=\"new_sms_sound\" style=\"width:1px;height:1px;\"></span>\r\n    </td>\r\n    <td align=\"right\">&nbsp;\r\n       <span id=\"new_letter\"></span>\r\n";
if ( tdoa_check_reg( ) )
{
				echo _( "未注册" );
}
echo "    </td>\r\n  </tr>\r\n</table>\r\n\r\n<script>\r\n//window.setTimeout('this.location.reload();',";
echo $STATUS_REF_SEC * 1000;
echo ");\r\nparent.ipanel.online_count();\r\n</script>\r\n\r\n</body>\r\n</html>\r\n";
?>
