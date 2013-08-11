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
				$CUR_DATE = date( "Y-m-d", time( ) );
				$query = "SELECT count(*) from DIARY where USER_ID='".$LOGIN_USER_ID."'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$TOTAL_ITEMS = $ROW[0];
				}
}
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"../main.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "工作日志" );
echo "</span>\r\n\t<div class=\"list_top_right\"><a class=\"ButtonB\" href=\"edit.php?P=";
echo $P;
echo "\">";
echo _( "写日志" );
echo "</a></div>\r\n</div>\r\n<div class=\"list_main\">\r\n\r\n";
$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
$query = "SELECT * from DIARY where USER_ID='".$LOGIN_USER_ID."' order by DIA_ID desc limit {$start},{$PAGE_SIZE}";
$cursor = exequery( $connection, $query );
$DIA_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$DIA_COUNT;
				$DIA_ID = $ROW['DIA_ID'];
				$DIA_DATE = $ROW['DIA_DATE'];
				$DIA_DATE = strtok( $DIA_DATE, " " );
				$DIA_TYPE = $ROW['DIA_TYPE'];
				$CONTENT = $ROW['CONTENT'];
				$DIA_TYPE_DESC = get_code_name( $DIA_TYPE, "DIARY_TYPE" );
				$CONTENT = str_replace( "<", "&lt", $CONTENT );
				$CONTENT = str_replace( ">", "&gt", $CONTENT );
				$CONTENT = stripslashes( $CONTENT );
				echo "<a class=\"list_item\" href=\"edit.php?P=";
				echo $P;
				echo "&DIA_ID=";
				echo $DIA_ID;
				echo "\" hidefocus=\"hidefocus\" >\r\n\t <div class=\"list_item_subject\">";
				echo $start + $DIA_COUNT;
				echo ".";
				echo $DIA_TYPE_DESC;
				echo " ";
				echo csubstr( strip_tags( $CONTENT ), 0, 20 );
				echo "</div>\r\n   <div class=\"list_item_time\">";
				echo $DIA_DATE;
				echo "</div>\r\n   <div class=\"list_item_arrow\"></div>\r\n</a>    \r\n\r\n";
}
if ( $DIA_COUNT == 0 )
{
				echo "<div class='message'>"._( "无今日日志" )."</div>";
}
echo "</div>\r\n<div id=\"list_bottom\">\r\n\t<div class=\"list_bottom_left\">";
echo pda_page_bar( $start, $TOTAL_ITEMS, $PAGE_SIZE );
echo "</div>\r\n</div>\r\n\r\n</body>\r\n</html>\r\n";
?>
