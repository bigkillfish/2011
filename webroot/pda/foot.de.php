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
$ONLINE_DESC = sprintf( _( "��%s������" ), "<input type=\"text\" id=\"user_count\" size=\"3\">" );
echo "<body>\r\n<div id=\"main_bottom\">\r\n   <div class=\"online\">";
echo $ONLINE_DESC;
echo "</div>\r\n   <a class=\"ButtonD relogin\" target=\"_top\" href=\"index.php\">";
echo _( "���µ�¼" );
echo "</a>\r\n   <a class=\"ButtonC message\" href=\"javascript:;\" onclick=\"parent.ResizeFrame(2);\">";
echo _( "΢Ѷ" );
echo "</a>\r\n   <a class=\"ButtonC message\" href=\"javascript:;\" onclick=\"parent.ResizeFrame(1);\">OA</a>\r\n</div>\r\n</body>\r\n</html>\r\n";
?>
