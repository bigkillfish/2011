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
include_once( "inc/utility_org.php" );
if ( $TO_ID == "" || $TO_ID == "undefined" )
{
				$TO_ID = "TO_ID";
}
if ( $FORM_NAME == "" || $FORM_NAME == "undefined" )
{
				$FORM_NAME = "form1";
}
echo "\r\n<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<style>\r\n.menulines{}\r\n</style>\r\n<script type=\"text/javascript\" src=\"/inc/js/utility.js\"></script>\r\n<script Language=\"JavaScript\">\r\n\r\nfunction init() {\r\n  parent.resizeTo(700, 400);\r\n}\r\n\r\nfunction CheckForm(form_action)\r\n{\r\n   document.form1.action = form_action;\r\n   document.form1.submit();\r\n}\r\n</script>\r\n</head>\r\n\r\n<body topmargin=\"1\" leftmargin=\"0\" class=\"bodycolor\" onload=\"init();\">\r\n<br>\r\n<table class=\"TableBlock\" width=\"90%\" align=\"center\">\r\n  <form action=\"query_user.php\" method=\"post\" name=\"form1\">\r\n   <tr>\r\n    <td nowrap class=\"TableData\" width=\"80\">";
echo _( "用户名：" );
echo "</td>\r\n    <td nowrap class=\"TableData\">\r\n        <input type=\"text\" name=\"USER_ID\" class=\"SmallInput\" size=\"20\" maxlength=\"20\">&nbsp;\r\n    </td>\r\n   </tr>\r\n   <tr>\r\n    <td nowrap class=\"TableData\">";
echo _( "真实姓名：" );
echo "</td>\r\n    <td nowrap class=\"TableData\">\r\n        <input type=\"text\" name=\"USER_NAME\" class=\"SmallInput\" size=\"10\" maxlength=\"10\">&nbsp;\r\n    </td>\r\n   </tr>\r\n   <tr>\r\n    <td nowrap class=\"TableData\">";
echo _( "别名：" );
echo "</td>\r\n    <td nowrap class=\"TableData\">\r\n        <input type=\"text\" name=\"BYNAME\" class=\"SmallInput\" size=\"10\" maxlength=\"10\">&nbsp;\r\n    </td>\r\n   </tr>\r\n   <tr>\r\n    <td nowrap class=\"TableData\">";
echo _( "部门：" );
echo "</td>\r\n    <td nowrap class=\"TableData\">\r\n        <select name=\"DEPT_ID\" class=\"SmallSelect\">\r\n        <option value=\"\"></option>\r\n";
echo my_dept_tree( 0, $DEPT_ID, 1 );
if ( $DEPT_ID == 0 )
{
				echo "          <option value=\"0\">";
				echo _( "离职人员/外部人员" );
				echo "</option>\r\n";
}
echo "        </select>\r\n    </td>\r\n   </tr>\r\n   <tr>\r\n    <td nowrap class=\"TableData\">";
echo _( "角色：" );
echo "</td>\r\n    <td nowrap class=\"TableData\">\r\n        <select name=\"USER_PRIV\" class=\"SmallSelect\">\r\n        <option value=\"\"></option>\r\n\r\n";
$query = "SELECT * from USER_PRIV order by PRIV_NO desc";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$USER_PRIV1 = $ROW['USER_PRIV'];
				$PRIV_NAME = $ROW['PRIV_NAME'];
				echo "          <option value=\"";
				echo $USER_PRIV1;
				echo "\">";
				echo $PRIV_NAME;
				echo "</option>\r\n";
}
echo "        </select>\r\n    </td>\r\n   </tr>\r\n   <tr>\r\n    <td nowrap  class=\"TableControl\" colspan=\"2\" align=\"center\">\r\n      <input type=\"button\" value=\"";
echo _( "查询" );
echo "\" class=\"SmallButton\" onclick=\"CheckForm('query_user.php');\" title=\"";
echo _( "查询用户" );
echo "\" name=\"button\">\r\n    </td>\r\n   </tr>\r\n   \r\n     <input type=\"hidden\" name=\"FIELD\" value=\"";
echo $FIELD;
echo "\">\r\n     <input type=\"hidden\" name=\"TO_ID\" value=\"";
echo $TO_ID;
echo "\">\r\n     <input type=\"hidden\" name=\"FORM_NAME\" value=\"";
echo $FORM_NAME;
echo "\">\r\n  </form>\r\n</table>\r\n\r\n</body>\r\n</html>\r\n";
?>
