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
echo _( "�����ʱ��ѯ" );
echo "</span>\r\n\t<div class=\"list_top_right\"><a class=\"ButtonB\" href=\"javascript:document.form1.submit();\">";
echo _( "��ѯ" );
echo "</a></div>\r\n</div>\r\n<div class=\"list_main\">\r\n<form action=\"search.php\"  method=\"get\" name=\"form1\">\r\n   ";
echo _( "��/��/��/�ֵ������ư�����" );
echo "<br>\r\n   <input type=\"text\" name=\"AREA\" size=\"22\"><br><br>\r\n   ";
echo _( "���ţ�" );
echo "<br>\r\n   <input type=\"text\" name=\"TEL_NO\" size=\"22\"><br><br>\r\n   ";
echo _( "�ʱࣺ" );
echo "<br>\r\n   <input type=\"text\" name=\"POST_NO\" size=\"22\"><br><br>\r\n   <input type=\"hidden\" name=\"P\" value=\"";
echo $P;
echo "\">\r\n</form>\r\n</div>\r\n</body>\r\n</html>\r\n";
?>
