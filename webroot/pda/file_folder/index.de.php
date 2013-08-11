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
				$query = "SELECT count(*) from FILE_CONTENT where SORT_ID=0 and  USER_ID='".$LOGIN_USER_ID."'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$TOTAL_ITEMS = $ROW[0];
				}
}
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"../main.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "我的文件" );
echo "</span>\r\n</div>\r\n<div class=\"list_main\">\r\n";
$query = "SELECT CONTENT_ID,SUBJECT,SEND_TIME from FILE_CONTENT where SORT_ID=0 and USER_ID='".$LOGIN_USER_ID."' order by CONTENT_NO,SEND_TIME desc limit {$start},{$PAGE_SIZE}";
$cursor = exequery( $connection, $query );
$FILE_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$FILE_COUNT;
				$CONTENT_ID = $ROW['CONTENT_ID'];
				$SUBJECT = $ROW['SUBJECT'];
				$SEND_TIME = $ROW['SEND_TIME'];
				$SUBJECT = htmlspecialchars( $SUBJECT );
				echo "\r\n<a class=\"list_item\" href=\"read.php?P=";
				echo $P;
				echo "&CONTENT_ID=";
				echo $CONTENT_ID;
				echo "\" hidefocus=\"hidefocus\" >\r\n   <div class=\"list_item_subject\">";
				echo $start + $FILE_COUNT;
				echo ".";
				echo $SUBJECT;
				echo "</div>\r\n   <div class=\"list_item_time\">";
				echo $SEND_TIME;
				echo "</div>\r\n   <div class=\"list_item_arrow\"></div>\r\n</a>\r\n";
}
if ( $FILE_COUNT == 0 )
{
				echo _( "个人文件柜根目录无文件" );
}
echo "</div>\r\n<div id=\"list_bottom\">\r\n\t<div class=\"list_bottom_left\">";
echo pda_page_bar( $start, $TOTAL_ITEMS, $PAGE_SIZE );
echo "</div>\r\n</div>\r\n\r\n</body>\r\n</html>\r\n";
?>
