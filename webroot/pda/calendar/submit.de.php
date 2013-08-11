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
include_once( "inc/check_type.php" );
include_once( "inc/utility_all.php" );
echo "\r\n<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "今日日程" );
echo "</span>\r\n</div>\r\n<div class=\"list_main\">\r\n";
$CUR_DATE = date( "Y-m-d", time( ) );
if ( $CAL_TIME != "" )
{
				$CAL_TIME = $CUR_DATE." ".$CAL_TIME.":00";
}
if ( $END_TIME != "" )
{
				$END_TIME = $CUR_DATE." ".$END_TIME.":59";
}
if ( $CAL_TIME == "" || !is_date_time( $CAL_TIME ) )
{
				echo "<div class='message'>"._( "起始时间格式不对，应形如 09:35" )."</div>";
				exit( );
}
if ( $END_TIME == "" || !is_date_time( $END_TIME ) )
{
				echo "<div class='message'>"._( "结束时间格式不对，应形如 19:23" )."</div>";
				exit( );
}
if ( $END_TIME <= $CAL_TIME )
{
				echo "<div class='message'>"._( "起始时间晚于结束时间！" )."</div>";
				exit( );
}
$CAL_TIME = strtotime( $CAL_TIME );
$END_TIME = strtotime( $END_TIME );
if ( $CAL_ID == "" )
{
				$query = "insert into CALENDAR(USER_ID,CAL_TIME,END_TIME,CAL_TYPE,CAL_LEVEL,CONTENT,OVER_STATUS) values ('".$LOGIN_USER_ID."','{$CAL_TIME}','{$END_TIME}','{$CAL_TYPE}','{$CAL_LEVEL}','{$CONTENT}','0')";
}
else
{
				$query = "update CALENDAR set CAL_TYPE='".$CAL_TYPE."',CAL_TIME='{$CAL_TIME}',END_TIME='{$END_TIME}',CONTENT='{$CONTENT}' where CAL_ID='{$CAL_ID}'";
}
if ( exequery( $connection, $query ) )
{
				echo "<div class='message'>"._( "保存成功" )."</div>";
}
else
{
				echo "<div class='message'>"._( "保存失败" )."</div>";
}
echo "</div>\r\n</body>\r\n</html>";
?>
