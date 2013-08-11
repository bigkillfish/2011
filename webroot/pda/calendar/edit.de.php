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
$query = "SELECT * from CALENDAR where USER_ID='".$LOGIN_USER_ID."' and CAL_ID='{$CAL_ID}'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$CAL_ID = $ROW['CAL_ID'];
				$CAL_TIME = $ROW['CAL_TIME'];
				$CAL_TIME = date( "Y-m-d H:i:s", $CAL_TIME );
				$END_TIME = $ROW['END_TIME'];
				$END_TIME = date( "Y-m-d H:i:s", $END_TIME );
				$CAL_TIME = strtok( $CAL_TIME, " " );
				$CAL_TIME = strtok( " " );
				$CAL_TIME = substr( $CAL_TIME, 0, 5 );
				$CAL_TYPE = $ROW['CAL_TYPE'];
				$END_TIME = strtok( $END_TIME, " " );
				$END_TIME = strtok( " " );
				$END_TIME = substr( $END_TIME, 0, 5 );
				$CONTENT = $ROW['CONTENT'];
				$CONTENT = str_replace( "<", "&lt", $CONTENT );
				$CONTENT = str_replace( ">", "&gt", $CONTENT );
				$CONTENT = stripslashes( $CONTENT );
}
echo "<body onLoad=\"document.form1.CAL_TIME.focus();\">\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "修改今日日程" );
echo "</span>\r\n\t<div class=\"list_top_right\"><a class=\"ButtonA\" href=\"javascript:document.form1.submit();\">";
echo _( "提交" );
echo "</a></div>\r\n</div>\r\n<div class=\"list_main\">\r\n<form action=\"submit.php\"  method=\"post\" name=\"form1\">\r\n\t";
echo _( "日程类型" );
echo ":<br>\r\n <select name=\"CAL_TYPE\" class=\"BigSelect\" style=\"width:100%;\">\r\n   ";
echo code_list( "CAL_TYPE", $CAL_TYPE );
echo " </select><br><br>\r\n   ";
echo _( "起始时间：（样式如 09:35 ）" );
echo "<br>\r\n   <input type=\"text\" style=\"width:100%;\" name=\"CAL_TIME\" value=\"";
echo $CAL_TIME;
echo "\" /><br><br>  \r\n   ";
echo _( "结束时间：（样式如 19:23 ）" );
echo "<br>\r\n   <input type=\"text\" style=\"width:100%;\" name=\"END_TIME\" value=\"";
echo $END_TIME;
echo "\" /><br><br>    \r\n   ";
echo _( "日程内容" );
echo ":<br>\r\n   <textarea style=\"width:100%;\" name=\"CONTENT\" rows=\"5\" wrap=\"on\">";
echo $CONTENT;
echo "</textarea>\r\n   <input type=\"hidden\" name=\"P\" value=\"";
echo $P;
echo "\" />\r\n   <input type=\"hidden\" name=\"CAL_ID\" value=\"";
echo $CAL_ID;
echo "\" />\r\n</form>\r\n</div>\r\n</body>\r\n</html>";
?>
