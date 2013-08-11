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
echo "\r\n<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"../main.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "最新邮件" );
echo "</span>\r\n\t<div class=\"list_top_right\"><a class=\"ButtonB\" href=\"new.php?P=";
echo $P;
echo "\">";
echo _( "写邮件" );
echo "</a></div>\r\n</div>\r\n<div class=\"list_main\">\r\n";
$CUR_DATE = date( "Y-m-d", time( ) );
$COUNT = 0;
$query = "SELECT EMAIL_ID,FROM_ID,SUBJECT,from_unixtime(SEND_TIME) as SEND_TIME,IMPORTANT,ATTACHMENT_ID,ATTACHMENT_NAME,USER.USER_NAME from EMAIL,EMAIL_BODY left join USER on EMAIL_BODY.FROM_ID=USER.USER_ID where EMAIL_BODY.BODY_ID=EMAIL.BODY_ID and BOX_ID=0 and TO_ID='".$LOGIN_USER_ID."' and SEND_FLAG='1' and (DELETE_FLAG='' or DELETE_FLAG='0' or DELETE_FLAG='2') order by SEND_TIME desc limit {$start},{$PAGE_SIZE}";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$COUNT;
				$EMAIL_ID = $ROW['EMAIL_ID'];
				$FROM_ID = $ROW['FROM_ID'];
				$SUBJECT = $ROW['SUBJECT'];
				$SEND_TIME = $ROW['SEND_TIME'];
				$IMPORTANT = $ROW['IMPORTANT'];
				$ATTACHMENT_ID = $ROW['ATTACHMENT_ID'];
				$ATTACHMENT_NAME = $ROW['ATTACHMENT_NAME'];
				$FROM_NAME = $ROW['USER_NAME'];
				$SUBJECT = htmlspecialchars( $SUBJECT );
				if ( $FROM_NAME == "" )
				{
								$FROM_NAME = $FROM_ID;
				}
				if ( $IMPORTANT == "0" || $IMPORTANT == "" )
				{
								$IMPORTANT_DESC = "";
				}
				else if ( $IMPORTANT == "1" )
				{
								$IMPORTANT_DESC = "<font color=red>"._( "重要" )."</font>";
				}
				else if ( $IMPORTANT == "2" )
				{
								$IMPORTANT_DESC = "<font color=red>"._( "非常重要" )."</font>";
				}
				echo "   <a class=\"list_item\" href=\"read.php?P=";
				echo $P;
				echo "&EMAIL_ID=";
				echo $EMAIL_ID;
				echo "\" hidefocus=\"hidefocus\">\r\n      <div class=\"list_item_subject\">";
				echo $start + $COUNT;
				echo ".";
				echo $SUBJECT;
				echo " ";
				echo $IMPORTANT_DESC;
				echo "</div>\r\n      <div class=\"list_item_time\">";
				echo $FROM_NAME;
				echo " ";
				echo substr( $SEND_TIME, 0, 16 );
				echo "</div>\r\n      <div class=\"list_item_arrow\"></div>\r\n";
				if ( $ATTACHMENT_ID != "" && $ATTACHMENT_NAME != "" )
				{
								echo "      <div class=\"list_item_attachment\"></div>\r\n";
				}
				echo "   </a>\r\n";
}
if ( $COUNT == 0 )
{
				echo "<div class=\"message\">"._( "无新邮件" )."</div>";
}
echo "</div>\r\n<div id=\"list_bottom\">\r\n\t<div class=\"list_bottom_left\">";
echo pda_page_bar( $start, $TOTAL_ITEMS, $PAGE_SIZE );
echo "</div>\r\n</div>\r\n</body>\r\n</html>\r\n";
?>
