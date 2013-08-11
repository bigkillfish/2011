<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$CSS_ARRAY = array( "/pda/style/main.css" );
$JS_ARRAY = array( );
include_once( "./auth.php" );
$ONLINE_DESC = sprintf( _( "共%s人在线" ), "<input type=\"text\" id=\"user_count\" size=\"3\">" );
echo "<body>\r\n<div id=\"main_bottom\">\r\n   <div class=\"online\">";
echo $ONLINE_DESC;
echo "</div>\r\n   <a class=\"ButtonD relogin\" target=\"_top\" href=\"index.php\">";
echo _( "重新登录" );
echo "</a>\r\n   <a class=\"ButtonC message\" href=\"javascript:;\" onclick=\"parent.ResizeFrame(2);\">";
echo _( "微讯" );
echo "</a>\r\n   <a class=\"ButtonC message\" href=\"javascript:;\" onclick=\"parent.ResizeFrame(1);\">OA</a>\r\n</div>\r\n</body>\r\n</html>\r\n";
?>
