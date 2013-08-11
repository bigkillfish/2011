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
if ( $TO_ID == "" || $TO_ID == "undefined" )
{
				$TO_ID = "TO_ID";
}
if ( $FORM_NAME == "" || $FORM_NAME == "undefined" )
{
				$FORM_NAME = "form1";
}
echo "\r\n<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<style>\r\n.menulines{}\r\n</style>\r\n<script type=\"text/javascript\" src=\"/inc/js/utility.js\"></script>\r\n<script Language=\"JavaScript\">\r\nvar parent_window = getOpenner();\r\nvar to_form = parent_window.";
echo $FORM_NAME;
echo ";\r\nvar to_id =   to_form.";
echo $TO_ID;
echo ";\r\n\r\nfunction click_dept(dept_id,td_id)\r\n{\r\n  TO_VAL=to_id.value;\r\n  targetelement=$(td_id);\r\n\r\n  if(TO_VAL.indexOf(\",\"+dept_id+\",\")>0 || TO_VAL.indexOf(dept_id+\",\")==0)\r\n  {\r\n    if(TO_VAL.indexOf(dept_id+\",\")==0)\r\n    {\r\n       to_id.value=to_id.value.replace(dept_id+\",\",\"\");\r\n       borderize_off(targetelement);\r\n    }\r\n    if(TO_VAL.indexOf(\",\"+dept_id+\",\")>0)\r\n    {\r\n       to_id.value=to_id.value.replace(\",\"+dept_id+\",\",\",\");\r\n       borderize_off(targetelement);\r\n    }\r\n  }\r\n  else\r\n  {\r\n    to_id.value+=dept_id+\",\";\r\n    borderize_on(targetelement);\r\n  }\r\n}\r\n\r\nfunction borderize_on(targetelement)\r\n{\r\n color=\"#003FBF\";\r\n targetelement.style.borderColor=\"black\";\r\n targetelement.style.backgroundColor=color;\r\n targetelement.style.color=\"white\";\r\n targetelement.style.fontWeight=\"bold\";\r\n}\r\n\r\nfunction borderize_off(targetelement)\r\n{\r\n  targetelement.style.backgroundColor=\"\";\r\n  targetelement.style.borderColor=\"\";\r\n  targetelement.style.color=\"\";\r\n  targetelement.style.fontWeight=\"\";\r\n}\r\n\r\nfunction begin_set()\r\n{\r\n  TO_VAL=to_id.value;\r\n  \r\n  for (step_i=0; step_i<allElements.length; step_i++)\r\n  {\r\n    if(allElements[step_i].className==\"menulines\")\r\n    {\r\n       dept_id=allElements[step_i].title;\r\n       if(TO_VAL.indexOf(\",\"+dept_id+\",\")>0 || TO_VAL.indexOf(dept_id+\",\")==0)\r\n          borderize_on(allElements[step_i]);\r\n    }\r\n  }\r\n}\r\n\r\nfunction add_all()\r\n{\r\n  TO_VAL=to_id.value;\r\n  for (step_i=0; step_i<allElements.length; step_i++)\r\n  {\r\n    if(allElements[step_i].className==\"menulines\")\r\n    {\r\n       dept_id=allElements[step_i].title;\r\n\r\n       if(TO_VAL.indexOf(\",\"+dept_id+\",\")<=0 && TO_VAL.indexOf(dept_id+\",\")!=0)\r\n       {\r\n         to_id.value+=dept_id+\",\";\r\n         borderize_on(allElements[step_i]);\r\n       }\r\n    }\r\n  }\r\n}\r\n\r\nfunction del_all()\r\n{\r\n  for (step_i=0; step_i<allElements.length; step_i++)\r\n  {\r\n    TO_VAL=to_id.value;\r\n    if(allElements[step_i].className==\"menulines\")\r\n    {\r\n       dept_id=allElements[step_i].title;\r\n       \r\n       if(TO_VAL.indexOf(dept_id+\",\")==0)\r\n       {\r\n          to_id.value=to_id.value.replace(dept_id+\",\",\"\");\r\n       }\r\n       if(TO_VAL.indexOf(\",\"+dept_id+\",\")>0)\r\n       {\r\n          to_id.value=to_id.value.replace(\",\"+dept_id+\",\",\",\");\r\n       }\r\n       borderize_off(allElements[step_i]);\r\n    }\r\n  }\r\n}\r\n\r\n</script>\r\n</head>\r\n\r\n<body topmargin=\"1\" leftmargin=\"0\" class=\"bodycolor\" onload=\"begin_set()\">\r\n";
$GROUP_ID_STR .= "0";
$query = "SELECT * from ADDRESS where (USER_ID='".$LOGIN_USER_ID."' or USER_ID='') and GROUP_ID in ({$GROUP_ID_STR}) and {$FIELD}!=''\r\n           and (PSN_NAME like '%{$KWORD}%' or EMAIL like '%{$KWORD}%' or TEL_NO_DEPT like '%{$KWORD}%' or TEL_NO_HOME like '%{$KWORD}%'\r\n            or DEPT_NAME like '%{$KWORD}%' or OICQ_NO like '%{$KWORD}%' or ICQ_NO like '%{$KWORD}%') order by PSN_NAME";
$cursor = exequery( $connection, $query );
if ( mysql_num_rows( $cursor ) == 0 )
{
				message( "", _( "无符合条件的记录" ), "blank" );
				exit( );
}
echo " <table class=\"TableBlock\" width=\"95%\" align=\"center\">\r\n   <tr class=\"TableControl\">\r\n     <td onclick=\"javascript:add_all();\" style=\"cursor:pointer\" align=\"center\" colspan=\"2\">";
echo _( "全部添加" );
echo "</td>\r\n   </tr>\r\n   <tr class=\"TableControl\">\r\n     <td onclick=\"javascript:del_all();\" style=\"cursor:pointer\" align=\"center\" colspan=\"2\">";
echo _( "全部删除" );
echo "</td>\r\n   </tr>\r\n";
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$ADD_ID = $ROW['ADD_ID'];
				$PSN_NAME = $ROW['PSN_NAME'];
				$FIELD_VALUE = $ROW[$FIELD];
				echo "  <tr class=\"TableData\" style=\"cursor:pointer\" align=\"center\">\r\n    <td class=\"menulines\" id=\"";
				echo $ADD_ID;
				echo "\" onclick=\"javascript:click_dept('";
				echo $FIELD_VALUE;
				echo "','";
				echo $ADD_ID;
				echo "')\" title=\"";
				echo $FIELD_VALUE;
				echo "\">";
				echo $PSN_NAME;
				echo "(";
				echo $FIELD_VALUE;
				echo ")</a></td>\r\n  </tr>\r\n";
}
echo "</body>\r\n</html>\r\n";
?>
