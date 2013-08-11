<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
include_once( "inc/utility_all.php" );
ob_end_clean( );
echo "<html>\r\n<head>\r\n<title>";
echo _( "事务提醒" );
echo "</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"./style/smsbox.css\" />\r\n<script type=\"text/javascript\" src=\"/inc/js_lang.php\"></script>\r\n<script type=\"text/javascript\" src=\"/inc/js/jquery/jquery.min.js\"></script>\r\n<script type=\"text/javascript\" src=\"./js/smsbox.js\"></script>\r\n<script type=\"text/javascript\">\r\nvar bSmsPriv = ";
echo find_id( $USER_FUNC_ID_STR, "3" ) ? "true" : "false";
echo ";\r\nvar loginUser = {uid:";
echo $LOGIN_UID;
echo ", user_id:\"";
echo str_replace( "\"", "\\\"", $LOGIN_USER_ID );
echo "\", user_name:\"";
echo str_replace( "\"", "\\\"", $LOGIN_USER_NAME );
echo "\"};\r\n\r\nif(typeof(window.external.OA_SMS) != 'undefined')\r\n{\r\n   window.external.OA_SMS(445, 412, \"SET_SIZE\");\r\n   window.external.OA_SMS(document.title, \"\", \"NAV_TITLE\");\r\n}\r\n</script>\r\n<body scroll=\"no\">\r\n<div class=\"center\">\r\n   <div id=\"new_noc_panel\">\r\n   \t<div id=\"new_noc_title\">\r\n   \t\t\t<span class=\"noc_iterm_num\">";
echo sprintf( _( "共%s条提醒" ), "&nbsp;<span></span>&nbsp;" );
echo "</span>\r\n            <span class=\"noc_iterm_history\"><a id=\"check_remind_histroy\" href=\"javascript:;\" hidefocus=\"hidefocus\">";
echo _( "查看历史记录" );
echo "</a></span>\r\n   \t</div> \r\n   \t<div id=\"nocbox_tips\"></div>\r\n   \t<div id=\"new_noc_list\"></div>\r\n   \t<div class=\"button\">\r\n         <a id=\"ViewAllNoc\" class=\"btn-white-big\" href=\"javascript:;\" hidefocus=\"hidefocus\">";
echo _( "全部已阅" );
echo "</a>\r\n         <a id=\"ViewDetail\" class=\"btn-white-big\" href=\"javascript:;\" hidefocus=\"hidefocus\">";
echo _( "全部详情" );
echo "</a>\r\n         <a id=\"CloseBtn\" class=\"btn-white-big\" href=\"javascript:;\" hidefocus=\"hidefocus\">";
echo _( "关闭" );
echo "</a>\r\n      </div>\t\t\t\t\t\r\n   </div>\r\n</div>\r\n</body>\r\n</html>";
?>
