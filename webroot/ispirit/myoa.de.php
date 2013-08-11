<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

ob_start( );
include_once( "inc/utility.php" );
include_once( "inc/conn.php" );
include_once( "inc/td_core.php" );
if ( $UNAME != "" )
{
				$USERNAME = $UNAME;
}
else
{
				$USERNAME = $_GET['USERNAME'];
}
$USERNAME = trim( $USERNAME );
if ( $I_VER == "2" && $USERNAME == "" )
{
				message( _( "错误" ), _( "用户名不能为空" ) );
				exit( );
}
$SECURE_KEY_SN = "";
$query = "SELECT * from SYS_PARA where PARA_NAME='LOGIN_SECURE_KEY'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$LOGIN_SECURE_KEY = $ROW['PARA_VALUE'];
				if ( $LOGIN_SECURE_KEY == "1" && $USERNAME != "" )
				{
								$query = "SELECT SECURE_KEY_SN from USER where USER_ID='".$USERNAME."'";
								$cursor = exequery( $connection, $query );
								if ( $ROW = mysql_fetch_array( $cursor ) )
								{
												$SECURE_KEY_SN = $ROW['SECURE_KEY_SN'];
								}
				}
}
$CHECK_SECURE_KEY = $LOGIN_SECURE_KEY == "1" && $USERNAME == "" && $SECURE_KEY_SN == "" ? 1 : 0;
echo "<html>\r\n<head>\r\n<title>";
echo _( "OA精灵" );
echo "</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<meta http-equiv=\"pragma\" content=\"no-cache\">\r\n<meta http-equiv=\"Cache-Control\" content=\"no-store, must-revalidate\">\r\n<meta http-equiv=\"expires\" content=\"Wed, 26 Feb 1997 08:21:57 GMT\">\r\n<meta http-equiv=\"expires\" content=\"0\">\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"/theme/1/style.css\">\r\n<link rel=\"shortcut icon\" href=\"/images/tongda.ico\">\r\n</head>\r\n<script type=\"text/javascript\" src=\"/inc/js/utility.js\"></script>\r\n<script type=\"text/javascript\">\r\nfunction CheckForm()\r\n{\r\n   return true;\r\n}\r\n\r\nfunction check_status(req)\r\n{\r\n   if(req.status == 200)\r\n   {\r\n      if(req.responseText == \"0\")\r\n         document.form1.submit();\r\n      else if(req.responseText == \"1\")\r\n         $(\"tb_tips\").style.display=\"block\";\r\n      else\r\n         alert(req.responseText);\r\n   }\r\n   else\r\n   {\r\n      alert(\"";
echo _( "错误：" );
echo "\"+req.status);\r\n   }\r\n}\r\n\r\nfunction check_login()\r\n{\r\n   var check_secure_key = \"";
echo $CHECK_SECURE_KEY;
echo "\";\r\n   var secure_key_sn = \"";
echo substr( $SECURE_KEY_SN, 0, 2 );
echo "\";\r\n   if(check_secure_key == \"1\")\r\n   {\r\n      _get(\"check_secure_key.php\", \"USERNAME=\"+document.form1.UNAME.value, check_status);\r\n   }\r\n   else\r\n   {\r\n      if(secure_key_sn == \"\")\r\n         document.form1.submit();\r\n      else\r\n         $(\"tb_tips\").style.display=\"block\";\r\n   }\r\n}\r\n\r\nfunction AutoLogin(user, pass)\r\n{\r\n   if(document && document.form1 && document.form1.UNAME && document.form1.PASSWORD)\r\n   {\r\n      document.form1.UNAME.value = user;\r\n      document.form1.PASSWORD.value = pass;\r\n      document.form1.submit();\r\n   }\r\n}\r\n</script>\r\n\r\n<body class=\"bodycolor\" onload=\"javascript:form1.PASSWORD.focus();";
if ( isset( $_GET['PASSWORD'] ) )
{
				echo "check_login();";
}
echo "\" scroll=\"no\" topmargin=\"5\">\r\n\r\n<div align=\"center\">\r\n<form name=\"form1\" method=\"post\" action=\"logincheck.php\" onsubmit=\"return CheckForm();\">\r\n\r\n<table class=\"TableBlock\" width=\"90%\" align=\"center\">\r\n    <tr class=\"TableHeader\">\r\n      <td align=\"center\">";
echo _( "登录OA精灵" );
echo "</td>\r\n    </tr>\r\n    <tr class=\"TableControl\">\r\n      <td class=\"small\">\r\n        <img src=\"/images/login_user.gif\" align=\"absmiddle\"><b>";
echo _( "用户名：" );
echo "</b>\r\n        <input type=\"text\" class=\"SmallInput\" name=\"UNAME\" size=\"10\" value=\"";
echo $USERNAME;
echo "\"><br>\r\n        <img src=\"/images/login_pass.gif\" align=\"absmiddle\"><b>";
echo _( "密　码：" );
echo "</b>\r\n        <input type=\"password\" class=\"SmallInput\" name=\"PASSWORD\" size=\"10\" value=\"";
echo $PASSWORD;
echo "\">\r\n      </td>\r\n    </tr>\r\n     <tr class=\"TableControl\">\r\n      <td align=\"center\">\r\n      \t<input type=\"hidden\" name=\"I_VER\" value=\"";
echo $I_VER;
echo "\">\r\n        <input type=\"submit\" name=\"Submit\" class=\"BigButton\" value=\"";
echo _( "登录" );
echo "\">\r\n      </td>\r\n    </tr>\r\n</form>\r\n</table>\r\n</div>\r\n<table id=\"tb_tips\" class=\"MessageBox\" align=\"center\" width=\"180\" style=\"display:none;\">\r\n  <tr>\r\n    <td class=\"msg\" style=\"padding-left:20px;text-align:center;\">\r\n      <div class=\"content\" style=\"font-size:12pt\">";
echo _( "请输入动态密码" );
echo "</div>\r\n    </td>\r\n  </tr>\r\n</table>\r\n";
if ( $ERROR_NO == 1 )
{
				message( _( "用户名或密码错误" ), _( "请重新登录!" ) );
}
else if ( $ERROR_NO == 2 )
{
				message( _( "图形验证码错误" ), _( "请重新登录!" ) );
}
else if ( $ERROR_NO == 3 )
{
				message( _( "警告" ), _( "用户被设定为禁止登录！" ) );
}
echo "<script type=\"text/javascript\">\r\n";
if ( $I_VER == "2" && $SECURE_KEY_SN != "" )
{
				echo "window.external.OA_SMS(\"\",\"\",\"SECURE_PASS\");";
}
echo "</script>\r\n</body>\r\n</html>\r\n";
?>
