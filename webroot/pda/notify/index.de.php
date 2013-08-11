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
include_once( "inc/utility_org.php" );
$PAGE_SIZE = 7;
if ( !isset( $start ) || $start == "" )
{
				$start = 0;
}
if ( isset( $TOTAL_ITEMS ) )
{
				$CUR_DATE = date( "Y-m-d", time( ) );
				$query = "SELECT count(*) from NOTIFY where (TO_ID='ALL_DEPT' or find_in_set('".$LOGIN_DEPT_ID."',TO_ID)".dept_other_sql( "TO_ID" ).( " or find_in_set('".$LOGIN_USER_PRIV."',PRIV_ID)" ).priv_other_sql( "PRIV_ID" ).( " or find_in_set('".$LOGIN_USER_ID."',USER_ID)) and BEGIN_DATE<='{$CUR_DATE}' and (END_DATE>='{$CUR_DATE}' or END_DATE='0000-00-00') and PUBLISH='1'" );
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$TOTAL_ITEMS = $ROW[0];
				}
}
echo "\r\n<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"../main.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "公告通知" );
echo "</span>\r\n</div>\r\n<div class=\"list_main\">\r\n";
$CUR_DATE = date( "Y-m-d", time( ) );
$query = "SELECT NOTIFY_ID,FROM_ID,SUBJECT,TOP,TYPE_ID,BEGIN_DATE,ATTACHMENT_ID,ATTACHMENT_NAME from NOTIFY where (TO_ID='ALL_DEPT' or find_in_set('".$LOGIN_DEPT_ID."',TO_ID)".dept_other_sql( "TO_ID" ).( " or find_in_set('".$LOGIN_USER_PRIV."',PRIV_ID)" ).priv_other_sql( "PRIV_ID" ).( " or find_in_set('".$LOGIN_USER_ID."',USER_ID)) and begin_date<='{$CUR_DATE}' and (end_date>='{$CUR_DATE}' or end_date is null) and PUBLISH='1' order by TOP desc,BEGIN_DATE desc,SEND_TIME desc limit {$start},{$PAGE_SIZE}" );
$cursor = exequery( $connection, $query );
$NOTIFY_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$NOTIFY_COUNT;
				$NOTIFY_ID = $ROW['NOTIFY_ID'];
				$FROM_ID = $ROW['FROM_ID'];
				$SUBJECT = $ROW['SUBJECT'];
				$TOP = $ROW['TOP'];
				$TYPE_ID = $ROW['TYPE_ID'];
				$ATTACHMENT_ID = $ROW['ATTACHMENT_ID'];
				$ATTACHMENT_NAME = $ROW['ATTACHMENT_NAME'];
				$SUBJECT = str_replace( "<", "&lt", $SUBJECT );
				$SUBJECT = str_replace( ">", "&gt", $SUBJECT );
				$SUBJECT = stripslashes( $SUBJECT );
				$BEGIN_DATE = $ROW['BEGIN_DATE'];
				$BEGIN_DATE = strtok( $BEGIN_DATE, " " );
				$TYPE_NAME = get_code_name( $TYPE_ID, "NOTIFY" );
				if ( $TYPE_NAME != "" )
				{
								$SUBJECT = "【".$TYPE_NAME."】".$SUBJECT;
				}
				$query1 = "SELECT USER_NAME from USER where USER_ID='".$FROM_ID."'";
				$cursor1 = exequery( $connection, $query1 );
				if ( $ROW = mysql_fetch_array( $cursor1 ) )
				{
								$FROM_NAME = $ROW['USER_NAME'];
				}
				else
				{
								$FROM_NAME = $FROM_ID;
				}
				if ( $TOP == "1" )
				{
								$IMPORTANT_DESC = "<img src='../style/images/top.png' />";
				}
				else
				{
								$IMPORTANT_DESC = "";
				}
				echo "<a class=\"list_item\" href=\"read.php?P=";
				echo $P;
				echo "&NOTIFY_ID=";
				echo $NOTIFY_ID;
				echo "\" hidefocus=\"hidefocus\" >\r\n   <div class=\"list_item_subject\">";
				echo $start + $NOTIFY_COUNT;
				echo ".";
				echo $SUBJECT;
				echo " ";
				echo $IMPORTANT_DESC;
				echo "</div>\r\n   <div class=\"list_item_time\">";
				echo $FROM_NAME;
				echo " ";
				echo $BEGIN_DATE;
				echo "</div>\r\n   <div class=\"list_item_arrow\"></div>\r\n";
				if ( $ATTACHMENT_ID != "" && $ATTACHMENT_NAME != "" )
				{
								echo "      <div class=\"list_item_attachment\"></div>\r\n";
				}
				echo "</a>\r\n";
}
if ( $NOTIFY_COUNT == 0 )
{
				echo "<div class=\"message\">无新公告通知</div>";
}
echo "</div>\r\n<div id=\"list_bottom\">\r\n\t<div class=\"list_bottom_left\">";
echo pda_page_bar( $start, $TOTAL_ITEMS, $PAGE_SIZE );
echo "</div>\r\n</div>\r\n\r\n</body>\r\n</html>\r\n";
?>
