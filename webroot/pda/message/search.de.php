<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

require_once( "inc/auth.php" );
ob_clean( );
require_once( "header.php" );
require_once( "func.php" );
echo "<div data-role=\"page\" data-theme=\"b\" id=\"select-user\">\r\n\t<div data-role=\"header\" class=\"ui-btn-up-b\" data-theme=\"b\">\r\n\t\t<h1>";
echo _( "添加收信人" );
echo "</h1>\r\n\t\t<a data-icon=\"right\" href=\"muti_send.php?#write-sms-page\" data-theme=\"b\" data-ajax=\"true\" data-rel=\"back\" data-transition=\"";
echo $deffect[deviceagent( )]['flip'];
echo "\">";
echo _( "确定" );
echo "</a>\r\n\t</div><!-- /header -->\r\n\t<div data-role=\"content\" id=\"contact-list-content\">\r\n\t\t\t<div data-role=\"fieldcontain\" class=\"mycust-contactsearch\">\r\n\t\t\t\t<span class=\"mycust-contactsearch-block clear\">\r\n\t\t\t\t\t<input type=\"search\" name=\"password\" id=\"search\" value=\"";
echo _( "点击搜索" );
echo "\" data-theme=\"c\"/>\r\n\t\t\t\t</span>\r\n\t\t\t</div>\t\t\r\n\t\t\t<div data-role=\"fieldcontain\" id=\"contacts-list\">\r\n\t\t\t \t<fieldset data-role=\"controlgroup\" id=\"contacts-list-fieldset\"></fieldset>\r\n\t\t\t</div>\r\n\t\t\t<div class=\"mycust-loading\" style=\"display:none;\"></div>\r\n\t\t\t<div style=\"text-align:center;\">\r\n\t\t\t\t<a href=\"muti_send.php?#write-sms-page\" data-inline=\"true\" data-role=\"button\" data-rel=\"back\" data-ajax=\"true\" data-theme=\"b\"  data-icon=\"check\">";
echo _( "确定" );
echo "</a>       \r\n\t\t\t\t<a href=\"muti_send.php?#write-sms-page\" data-inline=\"true\" data-role=\"button\" data-rel=\"back\" data-ajax=\"true\" data-theme=\"c\" data-icon=\"back\">";
echo _( "返回" );
echo "</a>  \t\r\n\t\t\t</div>\r\n\t</div>\r\n</div>\r\n";
?>
