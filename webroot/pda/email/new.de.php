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
				$SUBJECT = "Re:".$SUBJECT;
				$TO_NAME1 = $FROM_NAME;
				$GO_BACK = "read.php?P=".$P."&EMAIL_ID=".$EMAIL_ID;
}
else
{
				$GO_BACK = "index.php?P=".$P;
}
echo "<body onLoad=\"document.form1.TO_NAME1.focus();\">\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"";
echo $GO_BACK;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "写新邮件" );
echo "</span>\r\n\t<div class=\"list_top_right\"><a class=\"ButtonA\" href=\"javascript:document.form1.submit();\">";
echo _( "发送" );
echo "</a></div>\r\n</div>\r\n<div class=\"list_main\">\r\n<form action=\"submit.php\"  method=\"post\" name=\"form1\">\r\n   ";
echo _( "内部收信人姓名" );
echo ":<br>\r\n   <input type=\"text\" style=\"width:100%;\" name=\"TO_NAME1\" value=\"";
echo $TO_NAME1;
echo "\" /><br><br>\r\n   ";
echo _( "外部收信人地址" );
echo ":<br>\r\n   <input type=\"text\" style=\"width:100%;\" name=\"TO_NAME2\" value=\"";
echo $TO_NAME2;
echo "\" /><br><br>\r\n   ";
echo _( "邮件主题" );
echo ":<br>\r\n   <input type=\"text\" style=\"width:100%;\" name=\"SUBJECT\" value=\"";
echo $SUBJECT;
echo "\" /><br><br>\r\n   ";
echo _( "邮件内容" );
echo ":<br>\r\n   <textarea style=\"width:100%;\" name=\"CONTENT\" rows=\"5\" wrap=\"on\"></textarea>\r\n   <input type=\"hidden\" name=\"P\" value=\"";
echo $P;
echo "\" />\r\n</form>\r\n</div>\r\n</body>\r\n</html>";
?>
