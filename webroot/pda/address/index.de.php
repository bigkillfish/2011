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
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"../main.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "通讯簿查询" );
echo "</span>\r\n\t<div class=\"list_top_right\"><a class=\"ButtonB\" href=\"javascript:document.form1.submit();\">";
echo _( "查询" );
echo "</a></div>\r\n</div>\r\n<div class=\"list_main\">\r\n   <form action=\"search.php\"  method=\"get\" name=\"form1\">\r\n      ";
echo _( "姓名：" );
echo "<br>\r\n      <input type=\"text\" name=\"PSN_NAME\" size=\"20\" /><br><br>\r\n      ";
echo _( "单位：" );
echo "<br>\r\n      <input type=\"text\" name=\"DEPT_NAME\" size=\"20\" /><br><br>\r\n      <input type=\"hidden\" name=\"P\" value=\"";
echo $P;
echo "\" />\r\n   </form>\r\n</div>\r\n</body>\r\n</html>\r\n";
?>
