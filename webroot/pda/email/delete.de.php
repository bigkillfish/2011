<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$CSS_ARRAY = array( "/pda/style/list.css" );
$JS_ARRAY = array( );
include_once( "../auth.php" );
include_once( "inc/utility_all.php" );
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "删除邮件" );
echo "</span>\r\n</div>\r\n<div class=\"list_main\">\r\n   <div class=\"message\">\r\n";
$query = "update EMAIL set DELETE_FLAG='3' where TO_ID='".$LOGIN_USER_ID."' and (DELETE_FLAG='' or (DELETE_FLAG='' or DELETE_FLAG='0')) and EMAIL_ID='{$EMAIL_ID}'";
exequery( $connection, $query );
$query = "update EMAIL set DELETE_FLAG='4' where TO_ID='".$LOGIN_USER_ID."' and DELETE_FLAG='2' and EMAIL_ID='{$EMAIL_ID}'";
exequery( $connection, $query );
echo _( "邮件删除成功" );
echo "   </div>\r\n</div>\r\n</body>\r\n</html>";
?>
