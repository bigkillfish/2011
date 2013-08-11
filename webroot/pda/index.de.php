<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/conn.php" );
$query = "SELECT * from INTERFACE";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$IE_TITLE = $ROW['IE_TITLE'];
}
$USER_NAME_COOKIE = $_COOKIE['USER_NAME_COOKIE'];
if ( $USER_NAME_COOKIE == "" )
{
				$FOCUS = "USERNAME";
}
else
{
				$FOCUS = "PASSWORD";
}
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<title>";
echo $IE_TITLE;
echo "</title>\r\n<meta name=\"viewport\" content=\"width=device-width\" />\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" />\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"/pda/style/index.css\" />\r\n</head>\r\n<body>\r\n<div id=\"logo\">\r\n   <div id=\"product\"></div>\r\n   <div id=\"form\">\r\n      <form name=\"form1\" method=\"post\" action=\"login.php?P_VER=";
echo $P_VER;
echo "\">\r\n      <div id=\"form_input\">\r\n         <div class=\"user\"><input type=\"text\" class=\"text\" name=\"USERNAME\" maxlength=\"20\" value=\"";
echo $USER_NAME_COOKIE;
echo "\" /></div>\r\n         <div class=\"pwd\"><input type=\"password\" class=\"text\" name=\"PASSWORD\" value=\"\" /></div>\r\n      </div>\r\n      <div id=\"form_submit\">\r\n         <input type=\"image\" src=\"style/images/submit.png\" class=\"submit\" title=\"";
echo _( "登录" );
echo "\" value=\" \" />\r\n      </div>\r\n      </form>\r\n   </div>\r\n   <div id=\"msg\">\r\n";
if ( $ERROR_NO == 1 )
{
				echo "<div>".sprintf( _( "用户名或密码错误%s或禁止该用户登录%s请重新登录" ), "<br />", "<br />" )."</div>";
}
echo "   </div>\r\n</div>\r\n</body>\r\n</html>\r\n";
?>
