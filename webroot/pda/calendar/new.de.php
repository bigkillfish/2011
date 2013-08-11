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
echo "<body onLoad=\"document.form1.CAL_TIME.focus();\">\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "新建今日日程" );
echo "</span>\r\n\t<div class=\"list_top_right\"><a class=\"ButtonA\" href=\"javascript:document.form1.submit();\">";
echo _( "提交" );
echo "</a></div>\r\n</div>\r\n<div class=\"list_main\">\r\n<form action=\"submit.php\"  method=\"post\" name=\"form1\">\r\n\t";
echo _( "日程类型" );
echo ":<br>\r\n <select name=\"CAL_TYPE\" class=\"BigSelect\" style=\"width:100%;\">\r\n   ";
echo code_list( "CAL_TYPE", "" );
echo " </select><br><br>\r\n   ";
echo _( "起始时间：（样式如 09:35 ）" );
echo "<br>\r\n   <input type=\"text\" style=\"width:100%;\" name=\"CAL_TIME\" value=\"\" /><br><br>  \r\n   ";
echo _( "结束时间：（样式如 19:23 ）" );
echo "<br>\r\n   <input type=\"text\" style=\"width:100%;\" name=\"END_TIME\" value=\"\" /><br><br>    \r\n   ";
echo _( "日程内容" );
echo ":<br>\r\n   <textarea style=\"width:100%;\" name=\"CONTENT\" rows=\"5\" wrap=\"on\"></textarea>\r\n   <input type=\"hidden\" name=\"P\" value=\"";
echo $P;
echo "\" />\r\n</form>\r\n</div>\r\n</body>\r\n</html>";
?>
