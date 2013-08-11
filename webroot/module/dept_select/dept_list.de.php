<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
include_once( "inc/utility_org.php" );
if ( $TO_ID == "" || $TO_ID == "undefined" )
{
				$TO_ID = "TO_ID";
				$TO_NAME = "TO_NAME";
}
if ( $PRIV_OP == "undefined" )
{
				$PRIV_OP = "";
}
if ( $FORM_NAME == "" || $FORM_NAME == "undefined" )
{
				$FORM_NAME = "form1";
}
echo "\r\n<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<style>\r\n.menulines{}\r\n</style>\r\n<script type=\"text/javascript\" src=\"/inc/js/utility.js\"></script>\r\n<script Language=\"JavaScript\">\r\nvar parent_window = getOpenner();\r\nvar to_form = parent_window.";
echo $FORM_NAME;
echo ";\r\nvar to_id =   to_form.";
echo $TO_ID;
echo ";\r\nvar to_name = to_form.";
echo $TO_NAME;
echo ";\r\n\r\nfunction click_dept(dept_id)\r\n{\r\n  TO_VAL=to_id.value;\r\n  targetelement=$(dept_id);\r\n  dept_name=targetelement.title;\r\n\r\n  if(TO_VAL.indexOf(\",\"+dept_id+\",\")>0 || TO_VAL.indexOf(dept_id+\",\")==0)\r\n  {\r\n    if(TO_VAL.indexOf(dept_id+\",\")==0)\r\n    {\r\n       to_id.value=to_id.value.replace(dept_id+\",\",\"\");\r\n       to_name.value=to_name.value.replace(dept_name+\",\",\"\");\r\n       borderize_off(targetelement);\r\n    }\r\n    if(TO_VAL.indexOf(\",\"+dept_id+\",\")>0)\r\n    {\r\n       to_id.value=to_id.value.replace(\",\"+dept_id+\",\",\",\");\r\n       to_name.value=to_name.value.replace(\",\"+dept_name+\",\",\",\");\r\n       borderize_off(targetelement);\r\n    }\r\n  }\r\n  else\r\n  {\r\n  \t//处理最大字符数\r\n  \tvar to_name_length = to_name.value.length + dept_name.length;\r\n  \tif(to_name.maxLength < to_name_length && to_name.maxLength != -1)\r\n  \t\treturn;\r\n    to_id.value+=dept_id+\",\";\r\n    to_name.value+=dept_name+\",\";\r\n    borderize_on(targetelement);\r\n  }\r\n}\r\n\r\nfunction borderize_on(targetelement)\r\n{\r\n   if(targetelement.className.indexOf(\"TableRowActive\") < 0)\r\n      targetelement.className = \"TableRowActive \" + targetelement.className;\r\n}\r\n\r\nfunction borderize_off(targetelement)\r\n{\r\n   if(targetelement.className.indexOf(\"TableRowActive\") >= 0)\r\n      targetelement.className = targetelement.className.substr(15);\r\n}\r\n\r\nfunction begin_set()\r\n{\r\n  TO_VAL=to_id.value;\r\n  \r\n  if(TO_VAL==\"ALL_DEPT\")\r\n  {\r\n     to_id.value=\"\";\r\n     to_name.value=\"\";\r\n  }\r\n\r\n  for (step_i=0; step_i<allElements.length; step_i++)\r\n  {\r\n    if(allElements[step_i].className==\"menulines\")\r\n    {\r\n       dept_id=allElements[step_i].id;\r\n       if(TO_VAL.indexOf(\",\"+dept_id+\",\")>0 || TO_VAL.indexOf(dept_id+\",\")==0)\r\n          borderize_on(allElements[step_i]);\r\n    }\r\n  }\r\n}\r\n\r\nfunction add_all()\r\n{\r\n  TO_VAL=to_id.value;\r\n  for (step_i=0; step_i<allElements.length; step_i++)\r\n  {\r\n    if(allElements[step_i].className==\"menulines\")\r\n    {\r\n       dept_id=allElements[step_i].id;\r\n       dept_name=allElements[step_i].title;\r\n\r\n       if(TO_VAL.indexOf(\",\"+dept_id+\",\")<=0 && TO_VAL.indexOf(dept_id+\",\")!=0)\r\n       {\r\n         to_id.value+=dept_id+\",\";\r\n         to_name.value+=dept_name+\",\";\r\n         borderize_on(allElements[step_i]);\r\n       }\r\n    }\r\n  }\r\n}\r\n\r\nfunction add_all_dept()\r\n{\r\n    to_id.value=\"ALL_DEPT\";\r\n    to_name.value=\"";
echo _( "全体部门" );
echo "\";\r\n    parent.close();\r\n}\r\n\r\nfunction del_all()\r\n{\r\n  for (step_i=0; step_i<allElements.length; step_i++)\r\n  {\r\n    TO_VAL=to_id.value;\r\n    if(allElements[step_i].className==\"TableRowActive menulines\")\r\n    {\r\n       dept_id=allElements[step_i].id;\r\n       dept_name=allElements[step_i].title;\r\n       \r\n       if(TO_VAL.indexOf(dept_id+\",\")==0)\r\n       {\r\n          to_id.value=to_id.value.replace(dept_id+\",\",\"\");\r\n          to_name.value=to_name.value.replace(dept_name+\",\",\"\");\r\n       }\r\n       if(TO_VAL.indexOf(\",\"+dept_id+\",\")>0)\r\n       {\r\n          to_id.value=to_id.value.replace(\",\"+dept_id+\",\",\",\");\r\n          to_name.value=to_name.value.replace(\",\"+dept_name+\",\",\",\");\r\n       }\r\n       borderize_off(allElements[step_i]);\r\n    }\r\n  }\r\n}\r\n\r\n</script>\r\n</head>\r\n<body topmargin=\"1\" leftmargin=\"0\" class=\"bodycolor\" onLoad=\"begin_set();";
if ( $CHECKED == "true" && 0 < $DEPT_ID )
{
				echo "add_all();";
}
else if ( $CHECKED == "false" && 0 < $DEPT_ID )
{
				echo "del_all();";
}
else if ( $CHECKED && $DEPT_ID == 0 )
{
				echo "add_all_dept()";
}
echo "\">\r\n\r\n";
$PRIV_NO_FLAG = $PRIV_OP;
include_once( "inc/my_priv.php" );
if ( $DEPT_ID == "" )
{
				$DEPT_ID = 0;
				$LEVEL = 0;
}
while ( list( $ID, $DEPT ) = each( &$SYS_DEPARTMENT ) )
{
				if ( $ID == $DEPT_ID )
				{
								$LEVEL = $DEPT['DEPT_LEVEL'];
				}
				if ( !isset( $LEVEL ) && $ID != $DEPT_ID )
				{
								if ( $DEPT['DEPT_LEVEL'] <= $LEVEL && $ID != $DEPT_ID )
								{
												break;
								}
								else
								{
												$DEPT_NAME = $DEPT['DEPT_NAME'];
												$DEPT_NAME = htmlspecialchars( $DEPT_NAME );
								}
								if ( is_dept_priv( $ID, $DEPT_PRIV, $DEPT_ID_STR ) )
								{
												$OPTION_TEXT .= "\r\n  <tr class=TableData>\r\n    <td class='menulines' id='".$ID."' title='".$DEPT_NAME."' onclick=javascript:click_dept('".$ID."') style='cursor:pointer'>".str_repeat( _( "　" ), $DEPT['DEPT_LEVEL'] - 1 )."├".$DEPT_NAME."</a></td>\r\n  </tr>";
								}
				}
}
if ( $OPTION_TEXT == "" )
{
				message( _( "提示" ), _( "未定义或无可管理部门" ), "blank" );
}
else
{
				echo " <table class=\"TableBlock\" width=\"95%\">\r\n\r\n";
				if ( $DEPT_PRIV == "1" )
				{
								echo "   <tr class=\"TableData\">\r\n     <td onClick=\"javascript:add_all_dept();\" style=\"cursor:pointer\" align=\"center\">";
								echo _( "全体部门" );
								echo "</td>\r\n   </tr>\r\n";
				}
				echo "   <tr class=\"TableControl\">\r\n     <td onClick=\"javascript:add_all();\" style=\"cursor:pointer\" align=\"center\">";
				echo _( "全部添加" );
				echo "</td>\r\n   </tr>\r\n   <tr class=\"TableControl\">\r\n     <td onClick=\"javascript:del_all();\" style=\"cursor:pointer\" align=\"center\">";
				echo _( "全部删除" );
				echo "</td>\r\n   </tr>\r\n";
				echo $OPTION_TEXT;
				if ( $DEPT_ID != 0 )
				{
								echo "   <tr class=\"TableData\">\r\n     <td onClick=\"javascript:location='dept_list.php?MODULE_ID=";
								echo $MODULE_ID;
								echo "&TO_ID=";
								echo $TO_ID;
								echo "&TO_NAME=";
								echo $TO_NAME;
								echo "';\" style=\"cursor:pointer\" align=\"center\">";
								echo _( "返回" );
								echo "</td>\r\n   </tr>\r\n</table>\r\n";
				}
}
echo "\r\n</body>\r\n</html>\r\n";
?>
