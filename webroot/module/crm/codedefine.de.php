<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
$query = "SELECT CODE_NAME from SYS_CODE where CODE_NO='".$codeid."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$ShowName = $ROW[0];
}
if ( $OP == "edit" && $flag != "1" )
{
				$query = "SELECT * from SYS_CODE where CODE_ID='".$CODE_ID."'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$CODE_NO = $ROW['CODE_NO'];
								$CODE_NAME = $ROW['CODE_NAME'];
								$CODE_ORDER = $ROW['CODE_ORDER'];
								$PARENT_NO = $ROW['PARENT_NO'];
								$CODE_FLAG = $ROW['CODE_FLAG'];
				}
}
echo "<html>\r\n<head>\r\n<title>";
echo $ShowName;
echo _( "定义" );
echo "</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<script type=\"text/javascript\" src=\"/inc/js_lang.php\"></script>\r\n<script Language=\"JavaScript\">\r\nvar parent_window =window.opener;\r\nfunction CheckForm(optext,opvalue)\r\n{\r\n   if(document.form1.CODE_NO.value==\"\")\r\n   { alert(\"";
echo _( "编号不能为空！" );
echo "\");\r\n     return (false);\r\n   }\r\n    if(document.form1.CODE_NAME.value==\"\")\r\n   { alert(\"";
echo _( "名称不能为空！" );
echo "\");\r\n     return (false);\r\n   }\r\n}\r\nfunction delete_code(CODE_ID,FUNC_NAME)\r\n{\r\n var msg=sprintf(\"";
echo _( "确认要删除代码项'%s'吗？" );
echo "\", FUNC_NAME);\r\n if(window.confirm(msg))\r\n {\r\n  URL=\"codedefine.php?flag=1&OP=delete&kname=";
echo $kname;
echo "&codeid=";
echo $codeid;
echo "&CODE_ID=\" + CODE_ID;\r\n  location=URL;\r\n }\r\n}\r\n</script>\r\n</head>\r\n<body class=\"bodycolor\" topmargin=\"5\" onload=\"document.form1.CODE_NO.focus();\">\r\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" class=\"small\">\r\n  <tr>\r\n    <td class=\"Big\"><img src=\"/images/edit.gif\" WIDTH=\"22\" HEIGHT=\"20\" align=\"absmiddle\"><span class=\"big3\">&nbsp;&nbsp;";
echo $ShowName;
echo _( "定义" );
echo "</span>\r\n    </td>\r\n  </tr>\r\n</table>\r\n<br>\r\n<table class=\"TableBlock\" width=\"450\" align=\"center\">\r\n  <form action=\"codedefine.php?flag=1&codeid=";
echo $codeid;
echo "&kname=";
echo $kname;
echo "\"  method=\"post\" name=\"form1\" onsubmit=\"return CheckForm();\">\r\n   <tr>\r\n    <td nowrap class=\"TableData\" width=\"120\">";
echo _( "编号：" );
echo "</td>\r\n    <td nowrap class=\"TableData\">\r\n        <input type=\"text\" name=\"CODE_NO\" class=\"";
if ( $CODE_FLAG == "0" )
{
				echo "BigStatic";
}
else
{
				echo "BigInput";
}
echo "\" size=\"20\" maxlength=\"100\" value=\"";
echo $CODE_NO;
echo "\"";
if ( $CODE_FLAG == "0" )
{
				echo " readonly";
}
echo ">&nbsp;\r\n    </td>\r\n   </tr>\r\n   <tr>\r\n    <td nowrap class=\"TableData\">";
echo _( "排序号：" );
echo "</td>\r\n    <td nowrap class=\"TableData\">\r\n        <input type=\"text\" name=\"CODE_ORDER\" class=\"BigInput\" size=\"20\" maxlength=\"100\" value=\"";
echo $CODE_ORDER;
echo "\">&nbsp;\r\n    </td>\r\n   </tr>\r\n   <tr>\r\n    <td nowrap class=\"TableData\">";
echo _( "名称：" );
echo "</td>\r\n    <td nowrap class=\"TableData\">\r\n        <input type=\"text\" name=\"CODE_NAME\" class=\"BigInput\" size=\"20\" maxlength=\"100\" value=\"";
echo $CODE_NAME;
echo "\">&nbsp;\r\n    </td>\r\n   </tr>\r\n   <tr>\r\n    <td nowrap  class=\"TableControl\" colspan=\"2\" align=\"center\">\r\n        <input type=\"hidden\" name=\"CODE_ID\" value=\"";
echo $codeid;
echo "\">\r\n        <input type=\"hidden\" name=\"CODE_ID1\" value=\"";
echo $CODE_ID;
echo "\">\r\n        <input type=\"hidden\" name=\"K_Name\" value=\"";
echo $kname;
echo "\">\r\n        <input type=\"hidden\" name=\"OP\" value=\"";
echo $OP;
echo "\">\r\n        <input type=\"submit\" value=\"";
echo _( "确定" );
echo "\" class=\"BigButton\">&nbsp;&nbsp;\r\n        <input type=\"button\" value=\"";
echo _( "关闭" );
echo "\" class=\"BigButton\"  onclick=\"window.opener=null;window.open('','_self'); window.close();\">\r\n";
if ( $OP == "edit" && $flag != "1" )
{
				echo " \r\n       &nbsp;&nbsp;<input type=\"button\" value=\"";
				echo _( "取消" );
				echo "\" class=\"BigButton\"  onclick=\"location='codedefine.php?kname=";
				echo $kname;
				echo "&codeid=";
				echo $codeid;
				echo "';\"> \r\n";
}
echo "      \r\n    </td>\r\n  </form>\r\n</table>\r\n";
if ( $flag == "1" )
{
				if ( $OP == "edit" )
				{
								$query = "update SYS_CODE set CODE_NAME='".$CODE_NAME."',CODE_ORDER='{$CODE_ORDER}' where CODE_ID='{$CODE_ID1}'";
								exequery( $connection, $query );
								message( "", _( "修改成功！" ), "blank" );
				}
				else if ( $OP == "delete" )
				{
								$query = "delete from SYS_CODE where CODE_ID='".$CODE_ID."'";
								exequery( $connection, $query );
				}
				else
				{
								$query = "SELECT * from SYS_CODE where CODE_NO='".$CODE_NO."' and PARENT_NO='{$CODE_ID}'";
								$cursor = exequery( $connection, $query );
								if ( $ROW = mysql_fetch_array( $cursor ) )
								{
												message( _( "提示" ), sprintf( _( "代码编号%s已存在！" ), $CODE_NO ), "blank" );
												exit( );
								}
								$query = "insert into SYS_CODE (CODE_NO,CODE_NAME,CODE_ORDER,PARENT_NO) values ('".$CODE_NO."','{$CODE_NAME}','{$CODE_ORDER}','{$CODE_ID}')";
								exequery( $connection, $query );
								message( "", _( "增加成功！" ), "blank" );
				}
				echo "<script language=javascript>\r\nvar parent_window =window.opener;\r\nvar OPTION_LIST=[\r\n";
				$query = "SELECT CODE_NO,CODE_NAME from SYS_CODE where PARENT_NO='".$codeid."' order by CODE_ORDER";
				$cursor = exequery( $connection, $query );
				$VOTE_COUNT = 0;
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$CODE_NO = $ROW['CODE_NO'];
								$CODE_NAME = $ROW['CODE_NAME'];
								$STR_PRONAME1 = $STR_PRONAME1."\"".$CODE_NAME."\",";
								$STR_PROID1 = $STR_PROID1."\"".$CODE_NO."\",";
				}
				$CODE_NO = "";
				$CODE_NAME = "";
				$STR_PRONAME1 = substr( $STR_PRONAME1, 0, strlen( $STR_PRONAME1 ) - 1 );
				$STR_PROID1 = substr( $STR_PROID1, 0, strlen( $STR_PROID1 ) - 1 );
				$STR_TEMP = $STR_TEMP."[".$STR_PRONAME1."],[".$STR_PROID1."],";
				$STR_TEMP = substr( $STR_TEMP, 0, strlen( $STR_TEMP ) - 1 );
				echo $STR_TEMP;
				echo "];\r\nfunction setvalue(kname)\r\n{\r\n var PRO_ID= parent_window.document.all(kname);\r\n var PRODUCT_NAME=OPTION_LIST[0];\r\n var PRODUCT_VALUE=OPTION_LIST[1];\r\n\r\n PRO_ID.length=0;\r\n for(var i=0;i<PRODUCT_NAME.length;i++)\r\n {\r\n  //alert(PRODUCT_NAME[i]);alert(PRODUCT_VALUE[i]);\r\n  var my_option =parent_window.document.createElement(\"OPTION\");\r\n  my_option.text=PRODUCT_NAME[i];\r\n  my_option.value=PRODUCT_VALUE[i];\r\n  parent_window.document.all(kname).add(my_option,i);\r\n  parent_window.document.all(kname).selectedIndex=0;\r\n  parent_window.document.all(kname).selected;\r\n }\r\n}\r\n   setvalue('";
				echo $kname;
				echo "');\r\n   document.form1.CODE_NO.value=\"\";\r\n   document.form1.CODE_NAME.value=\"\";\r\n   document.form1.CODE_ID1.value=\"\";\r\n   document.form1.OP.value=\"\";\r\n </script>\r\n";
}
echo "<br>\r\n<table width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" height=\"3\">\r\n <tr>\r\n   <td background=\"/images/dian1.gif\" width=\"100%\"></td>\r\n </tr>\r\n</table>\r\n<br>\r\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"3\" class=\"small\">\r\n  <tr>\r\n    <td class=\"Big\"><img src=\"/images/edit.gif\" WIDTH=\"22\" HEIGHT=\"20\" align=\"absmiddle\"><span class=\"big3\">&nbsp;&nbsp;";
echo $ShowName;
echo _( "代码管理" );
echo "</span>\r\n    </td>\r\n  </tr>\r\n</table>\r\n<table class=\"TableBlock\" align=\"center\">\r\n <tr class=\"TableHeader\" align=\"center\">\r\n   <td nowrap>\r\n       <b>";
echo _( "名称" );
echo "</b>\r\n    </td>\r\n    <td nowrap>\r\n      <b>";
echo _( "操作" );
echo "</b>\r\n    </td>\r\n </tr>\r\n";
$query1 = "SELECT * from SYS_CODE where PARENT_NO='".$codeid."' order by CODE_ORDER";
$cursor1 = exequery( $connection, $query1 );
while ( $ROW = mysql_fetch_array( $cursor1 ) )
{
				$CODE_ID = $ROW['CODE_ID'];
				$CODE_NO = $ROW['CODE_NO'];
				$CODE_NAME = $ROW['CODE_NAME'];
				$CODE_FLAG = $ROW['CODE_FLAG'];
				echo "        <tr class=\"TableData\">\r\n          <td nowrap title=\"";
				echo $CODE_NAME;
				echo "\" >\r\n            &nbsp;<b>";
				echo $CODE_NO;
				echo "&nbsp;&nbsp;";
				echo $CODE_NAME;
				echo "</b>&nbsp;\r\n          </td>\r\n          <td nowrap>&nbsp;\r\n           <a href=\"codedefine.php?OP=edit&CODE_ID=";
				echo $CODE_ID;
				echo "&kname=";
				echo $kname;
				echo "&codeid=";
				echo $codeid;
				echo "\"> ";
				echo _( "编辑" );
				echo "</a>&nbsp;&nbsp;\r\n";
				if ( $CODE_FLAG != "0" )
				{
								echo "           <a href=\"javascript:delete_code(";
								echo $CODE_ID;
								echo ",'";
								echo $CODE_NAME;
								echo "');\"> ";
								echo _( "删除" );
								echo "</a>\r\n";
				}
				echo "          </td>\r\n        </tr>\r\n";
}
echo "    </table>\r\n</body>\r\n</html>\r\n";
?>
