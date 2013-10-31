<?php
include_once( "inc/conn.php" );
include_once( "inc/td_core.php" );
include_once( "inc/utility.php" );
if ( $_POST['LANGUAGE'] != "" )
{
				setcookie( "LANG_COOKIE", $_POST['LANGUAGE'], time( ) + 86400000, "/" );
}
session_start( );
ob_start( );
$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
echo "\r\n<html>\r\n<head>\r\n<title>";
echo _( "系统登录" );
echo "</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"/theme/";
echo stristr( $HTTP_USER_AGENT, "MSIE 6.0" ) ? "1" : "10";
echo "/style.css\">\r\n</head>\r\n\r\n<body class=\"bodycolor\" topmargin=\"5\">\r\n";
if ( $UNAME != "" )
{
				$USERNAME = $UNAME;
}
$USERNAME = trim( $USERNAME );
$LOGIN_MSG = login_check( $USERNAME, $PASSWORD, $KEY_DIGEST, $KEY_SN, $KEY_USER );
if ( $LOGIN_MSG != "1" )
{
				message( _( "错误" ), $LOGIN_MSG, "error", array( array( "value" => _( "重新登录" ), "href" => "/" ) ) );
				if ( $USERNAME == "admin" )
				{
								echo "<br><div class=small1 align=center>"._( "忘记了admin密码？请参考官方网站/OA知识库/Office Anywhere 疑难解答/清空admin密码" )."</div>";
				}
				exit( );
}
$query = "SELECT MENU_TYPE from USER where USER_ID='".$LOGIN_USER_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$MENU_TYPE = $ROW['MENU_TYPE'];
}
if ( $UI == "" )
{
				$UI = 0;
}
if ( $UI == "0" )
{
				$OA_UI = "general";
}
else
{
				$OA_UI = "ui/".$UI;
}
setcookie( "UI_COOKIE", $UI, time( ) + 86400000 );
echo $uc_synclogin_script;
echo "<script>\r\nfunction goto_oa()\r\n{\r\n    location=\"";
echo $OA_UI;
echo "\";\r\n}\r\n";
if ( $MENU_TYPE == 1 || stristr( $HTTP_USER_AGENT, "Opera" ) || stristr( $HTTP_USER_AGENT, "Firefox" ) || stristr( $HTTP_USER_AGENT, "MSIE 5.0" ) || stristr( $HTTP_USER_AGENT, "TencentTraveler" ) )
{
				echo "goto_oa();\r\n";
}
else
{
				echo "window.setTimeout('goto_oa();',3000);\r\nvar open_flag=window.open(\"";
				echo $OA_UI;
				echo "\",'";
				echo md5( $USERNAME ).time( );
				echo "',\"menubar=0,toolbar=";
				if ( $MENU_TYPE == 2 )
				{
								echo "1";
				}
				else
				{
								echo "0";
				}
				echo ",status=1,resizable=1\");\r\nif(open_flag== null) {\r\n   goto_oa();\r\n}\r\nelse\r\n{\r\n   focus();\r\n   window.opener =window.self;\r\n   window.close();\r\n}\r\n";
}
echo "</script>\r\n\r\n<div class=big1>";
echo _( "正在进入OA系统，请稍候..." );
echo "</div>\r\n\r\n</body>\r\n</html>\r\n";
?>
