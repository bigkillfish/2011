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
include_once( "inc/utility_msg.php" );
echo "<body>\r\n<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "发微讯" );
echo "</span>\r\n</div>\r\n<div class=\"list_main\">\r\n   <div class=\"message\">\r\n";
$query = "SELECT UID from USER where USER_NAME='".$TO_NAME."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$TO_UID = $ROW['UID'];
				send_msg( $LOGIN_UID, $TO_UID, 3, $CONTENT );
				echo _( "微讯发送成功" );
}
else
{
				echo _( "指定的收信人姓名不存在" );
}
echo "   </div>\r\n</div>\r\n</body>\r\n</html>";
?>
