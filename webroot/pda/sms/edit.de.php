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
if ( $FLAG == 1 )
{
				$GO_BACK = "read.php?P=".$P."&SMS_ID=".$SMS_ID;
}
else
{
				$GO_BACK = "index.php?P=".$P;
}
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"";
echo $GO_BACK;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "发微讯" );
echo "</span>\r\n\t<div class=\"list_top_right\"><a class=\"ButtonA\" href=\"javascript:document.form1.submit();\">";
echo _( "发送" );
echo "</a></div>\r\n</div>\r\n<div class=\"list_main\">\r\n   <form action=\"send.php\"  method=\"post\" name=\"form1\">\r\n      ";
echo _( "收信人姓名：" );
echo "<input type=\"text\" style=\"width:100%;\" name=\"TO_NAME\" value=\"";
echo $TO_NAME;
echo "\"><br><br>\r\n      ";
echo _( "内容：" );
echo "<br>\r\n      <textarea style=\"width:100%;\" name=\"CONTENT\" rows=\"3\" wrap=\"on\"></textarea>\r\n      <input type=\"hidden\" name=\"P\" value=\"";
echo $P;
echo "\">\r\n</form>\r\n</div>\r\n</body>\r\n</html>";
?>
