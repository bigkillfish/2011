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
include_once( "inc/utility_file.php" );
echo "<body>\r\n";
$query = "SELECT SMS_ID,FROM_ID,FROM_UNIXTIME(SEND_TIME) as SEND_TIME,SMS_TYPE,CONTENT,USER_NAME from SMS,SMS_BODY,USER where SMS.BODY_ID=SMS_BODY.BODY_ID and USER.USER_ID=SMS_BODY.FROM_ID and TO_ID='".$LOGIN_USER_ID."' and SMS_ID='{$SMS_ID}'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$SMS_ID = $ROW['SMS_ID'];
				$FROM_ID = $ROW['FROM_ID'];
				$SEND_TIME = $ROW['SEND_TIME'];
				$REMIND_FLAG = $ROW['REMIND_FLAG'];
				$SMS_TYPE = $ROW['SMS_TYPE'];
				$CONTENT = $ROW['CONTENT'];
				$FROM_NAME = $ROW['USER_NAME'];
				$CONTENT = str_replace( "<", "&lt", $CONTENT );
				$CONTENT = str_replace( ">", "&gt", $CONTENT );
				$CONTENT = stripslashes( $CONTENT );
}
else
{
				exit( );
}
echo "<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "查看提醒" );
echo "</span>\r\n\t<div class=\"list_top_right\"><a class=\"ButtonA\" href=\"edit.php?P=";
echo $P;
echo "&FLAG=1&SMS_ID=";
echo $SMS_ID;
echo "&TO_NAME=";
echo $FROM_NAME;
echo "\">";
echo _( "回复" );
echo "</a></div>\r\n</div>\r\n<div class=\"list_main\">\r\n   <div class=\"read_time\">";
echo $FROM_NAME;
echo " ";
echo substr( $SEND_TIME, 0, 16 );
echo "</div>\r\n   <div class=\"read_content\">";
echo $CONTENT;
echo "</div>\r\n</div>\r\n</body>\r\n</html>\r\n";
?>
