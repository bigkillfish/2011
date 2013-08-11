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
$PAGE_SIZE = 7;
if ( !isset( $start ) || $start == "" )
{
				$start = 0;
}
if ( isset( $TOTAL_ITEMS ) )
{
				$query = "SELECT count(*) from EMAIL,EMAIL_BODY where EMAIL_BODY.BODY_ID=EMAIL.BODY_ID and BOX_ID=0 and TO_ID='".$LOGIN_USER_ID."' and SEND_FLAG='1' and (DELETE_FLAG='' or DELETE_FLAG='0' or DELETE_FLAG='2')";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$TOTAL_ITEMS = $ROW[0];
				}
}
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n<div class=\"list_top_center\"><a href=\"showall.php?P=";
echo $P;
echo "\" >";
echo _( "全部" );
echo "</a>|<a  href=\"index.php?P=";
echo $P;
echo "\" >";
echo _( "未确认" );
echo "</a></div><div class=\"list_top_right\"><a class=\"ButtonB\" href=\"edit.php?P=";
echo $P;
echo "\">";
echo _( "发微讯" );
echo "</a></div>\r\n</div>\r\n<div class=\"list_main\">\r\n";
$CUR_TIME = time( );
$query = "SELECT SMS_ID,FROM_ID,FROM_UNIXTIME(SEND_TIME) as SEND_TIME,SMS_TYPE,CONTENT,USER_NAME from SMS,SMS_BODY,USER where SMS.BODY_ID=SMS_BODY.BODY_ID and USER.USER_ID=SMS_BODY.FROM_ID and TO_ID='".$LOGIN_USER_ID."' and SEND_TIME<='{$CUR_TIME}'  and DELETE_FLAG!='1' order by SEND_TIME desc limit {$start},{$PAGE_SIZE}";
$cursor = exequery( $connection, $query );
$SMS_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$SMS_COUNT;
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
				echo "   <div class=\"list_item\" onclick=\"window.location='read.php?P=";
				echo $P;
				echo "&SMS_ID=";
				echo $SMS_ID;
				echo "';\">\r\n      <div class=\"list_item_subject\">";
				echo $start + $SMS_COUNT;
				echo ".";
				echo $CONTENT;
				echo "</div>\r\n      <div class=\"list_item_time\">";
				echo $FROM_NAME;
				echo " ";
				echo substr( $SEND_TIME, 0, 16 );
				echo "</div>\r\n      <div class=\"list_item_arrow\"></div>\r\n      <div class=\"list_item_op\">\r\n         <a href=\"edit.php?P=";
				echo $P;
				echo "&TO_NAME=";
				echo $FROM_NAME;
				echo "\">";
				echo _( "回复" );
				echo "</a>&nbsp;\r\n      ";
				if ( $REMIND_FLAG != 0 )
				{
								echo "         <a href=\"unread.php?P=";
								echo $P;
								echo "&SMS_ID=";
								echo $SMS_ID;
								echo "\">";
								echo _( "已读" );
								echo "</a>\r\n      ";
				}
				echo "      </div>\r\n   </div>\r\n";
}
if ( $SMS_COUNT == 0 )
{
				echo "<div class=\"message\">无提醒</div>";
}
echo "</div>\r\n<div id=\"list_bottom\">\r\n\t<div class=\"list_bottom_left\">";
echo pda_page_bar( $start, $TOTAL_ITEMS, $PAGE_SIZE );
echo "</div>\r\n</div>\r\n</body>\r\n</html>\r\n";
?>
