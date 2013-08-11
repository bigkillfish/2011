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
				$query = "SELECT count(*) from NEWS where PUBLISH='1' and (TO_ID='ALL_DEPT' or find_in_set('".$LOGIN_DEPT_ID."',TO_ID) or find_in_set('{$LOGIN_USER_PRIV}',PRIV_ID) or find_in_set('{$LOGIN_USER_ID}',USER_ID))";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$TOTAL_ITEMS = $ROW[0];
				}
}
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"../main.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "最新新闻" );
echo "</span>\r\n</div>\r\n<div class=\"list_main\">\r\n";
$CUR_DATE = date( "Y-m-d", time( ) );
$query = "SELECT NEWS_ID,PROVIDER,SUBJECT,NEWS_TIME,FORMAT,TYPE_ID,ATTACHMENT_ID,ATTACHMENT_NAME from NEWS where PUBLISH='1' and (TO_ID='ALL_DEPT' or find_in_set('".$LOGIN_DEPT_ID."',TO_ID) or find_in_set('{$LOGIN_USER_PRIV}',PRIV_ID) or find_in_set('{$LOGIN_USER_ID}',USER_ID)) order by NEWS_TIME desc limit {$start},{$PAGE_SIZE}";
$cursor = exequery( $connection, $query );
$COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$COUNT;
				$NEWS_ID = $ROW['NEWS_ID'];
				$PROVIDER = $ROW['PROVIDER'];
				$SUBJECT = $ROW['SUBJECT'];
				$NEWS_TIME = $ROW['NEWS_TIME'];
				$FORMAT = $ROW['FORMAT'];
				$TYPE_ID = $ROW['TYPE_ID'];
				$ATTACHMENT_ID = $ROW['ATTACHMENT_ID'];
				$ATTACHMENT_NAME = $ROW['ATTACHMENT_NAME'];
				$NEWS_TIME = strtok( $NEWS_TIME, " " );
				$SUBJECT = htmlspecialchars( $SUBJECT );
				$TYPE_NAME = get_code_name( $TYPE_ID, "NEWS" );
				if ( $TYPE_NAME != "" )
				{
								$SUBJECT = "【".$TYPE_NAME."】".$SUBJECT;
				}
				$query1 = "SELECT USER_NAME from USER where USER_ID='".$PROVIDER."'";
				$cursor1 = exequery( $connection, $query1 );
				if ( $ROW = mysql_fetch_array( $cursor1 ) )
				{
								$FROM_NAME = $ROW['USER_NAME'];
				}
				else
				{
								$FROM_NAME = $FROM_ID;
				}
				echo "   <a class=\"list_item\" href=\"read.php?P=";
				echo $P;
				echo "&NEWS_ID=";
				echo $NEWS_ID;
				echo "\" hidefocus=\"hidefocus\">\r\n      <div class=\"list_item_subject\">";
				echo $start + $COUNT;
				echo ".";
				echo $SUBJECT;
				echo "</div>\r\n      <div class=\"list_item_time\">";
				echo $FROM_NAME;
				echo " ";
				echo $NEWS_TIME;
				echo "</div>\r\n      <div class=\"list_item_arrow\"></div>\r\n";
				if ( $ATTACHMENT_ID != "" && $ATTACHMENT_NAME != "" )
				{
								echo "      <div class=\"list_item_attachment\"></div>\r\n";
				}
				echo "   </a>\r\n";
}
if ( $COUNT == 0 )
{
				echo "<div class=\"message\">无最新新闻</div>";
}
echo "</div>\r\n<div id=\"list_bottom\">\r\n\t<div class=\"list_bottom_left\">";
echo pda_page_bar( $start, $TOTAL_ITEMS, $PAGE_SIZE );
echo "</div>\r\n</div>\r\n</body>\r\n</html>\r\n";
?>
