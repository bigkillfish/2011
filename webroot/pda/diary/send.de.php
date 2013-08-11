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
echo "\r\n<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "日志提交" );
echo "</span>\r\n</div>\r\n<div class=\"list_main\">\r\n";
$DIA_DATE = date( "Y-m-d", time( ) );
$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
if ( $DIA_ID == "" )
{
				$query = "insert into DIARY(USER_ID,DIA_DATE,DIA_TIME,DIA_TYPE,CONTENT) values ('".$LOGIN_USER_ID."','{$DIA_DATE}','{$CUR_TIME}','{$DIA_TYPE}','{$CONTENT}')";
				if ( exequery( $connection, $query ) )
				{
								echo "<div class='message'>"._( "日志保存成功" )."</div>";
				}
}
else
{
				$query = "select USER_ID from DIARY where DIA_ID='".$DIA_ID."'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$USER_ID = $ROW['USER_ID'];
				}
				if ( $USER_ID == $LOGIN_USER_ID )
				{
								$query = "update DIARY set DIA_TYPE='".$DIA_TYPE."',CONTENT='{$CONTENT}',DIA_TIME='{$CUR_TIME}' where DIA_ID='{$DIA_ID}'";
								if ( exequery( $connection, $query ) )
								{
												echo "<div class='message'>"._( "日志保存成功" )."</div>";
								}
				}
				else
				{
								echo "<div class='message'>"._( "非法操作" )."</div>";
				}
}
echo "</div>\r\n</body>\r\n</html>";
?>
