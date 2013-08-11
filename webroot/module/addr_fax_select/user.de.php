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
echo "<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<style>\r\n.menulines{}\r\n</style>\r\n<script type=\"text/javascript\" src=\"/inc/js/utility.js\"></script>\r\n<script Language=\"JavaScript\">\r\nvar parent_window = getOpenner();\r\nvar to_form = parent_window.";
echo $FORM_NAME;
echo ";\r\nvar to_id   = to_form.";
echo $TO_ID;
echo ";\r\nvar to_name = to_form.";
echo $TO_NAME;
echo ";\r\nvar to_company = to_form.";
echo $TO_COMPANY;
echo ";\r\n\r\nfunction click_dept(dept_id,td_id,real_name,dept_name)\r\n{\r\n  TO_VAL=to_id.value;\r\n  targetelement=$(td_id);\r\n  \r\n  TO_VAL1=to_name.value;\r\n  targetelement1=$(real_name);\r\n  \r\n  TO_VAL2=to_company.value;\r\n  targetelement2=$(dept_name);\r\n\r\n  if(TO_VAL.indexOf(\",\"+dept_id+\",\")>0 || TO_VAL.indexOf(dept_id+\",\")==0)\r\n  {\r\n    if(TO_VAL.indexOf(dept_id+\",\")==0)\r\n    {\r\n       to_id.value=to_id.value.replace(dept_id+\",\",\"\");\r\n       borderize_off(targetelement);\r\n    }\r\n    if(TO_VAL.indexOf(\",\"+dept_id+\",\")>0)\r\n    {\r\n       to_id.value=to_id.value.replace(\",\"+dept_id+\",\",\",\");\r\n       borderize_off(targetelement);\r\n    }\r\n  }\r\n  else\r\n  {\r\n    to_id.value+=dept_id+\",\";\r\n    borderize_on(targetelement);\r\n  }\r\n  \r\n  if(TO_VAL1.indexOf(\",\"+real_name+\",\")>0 || TO_VAL1.indexOf(real_name+\",\")==0)\r\n  {\r\n    if(TO_VAL1.indexOf(real_name+\",\")==0)\r\n    {\r\n       to_name.value=to_name.value.replace(real_name+\",\",\"\");\r\n       //borderize_off(targetelement1);\r\n    }\r\n    if(TO_VAL1.indexOf(\",\"+real_name+\",\")>0)\r\n    {\r\n       to_name.value=to_name.value.replace(\",\"+real_name+\",\",\",\");\r\n       //borderize_off(targetelement1);\r\n    }\r\n  }\r\n  else\r\n  {\r\n    to_name.value+=real_name+\",\";\r\n   // borderize_on(targetelement1);\r\n  }\r\n  \r\n  if(TO_VAL2.indexOf(\",\"+dept_name+\",\")>0 || TO_VAL2.indexOf(dept_name+\",\")==0)\r\n  {\r\n    if(TO_VAL2.indexOf(dept_name+\",\")==0)\r\n    {\r\n       to_company.value=to_company.value.replace(dept_name+\",\",\"\");\r\n       //borderize_off(targetelement2);\r\n    }\r\n    if(TO_VAL2.indexOf(\",\"+dept_name+\",\")>0)\r\n    {\r\n       to_company.value=to_company.value.replace(\",\"+dept_name+\",\",\",\");\r\n       //borderize_off(targetelement2);\r\n    }\r\n  }\r\n  else\r\n  {\r\n    to_company.value+=dept_name+\",\";\r\n    //borderize_on(targetelement2);\r\n  }\r\n}\r\n\r\nfunction borderize_on(targetelement)\r\n{\r\n color=\"#003FBF\";\r\n targetelement.style.borderColor=\"black\";\r\n targetelement.style.backgroundColor=color;\r\n targetelement.style.color=\"white\";\r\n targetelement.style.fontWeight=\"bold\";\r\n}\r\n\r\nfunction borderize_off(targetelement)\r\n{\r\n  targetelement.style.backgroundColor=\"\";\r\n  targetelement.style.borderColor=\"\";\r\n  targetelement.style.color=\"\";\r\n  targetelement.style.fontWeight=\"\";\r\n}\r\n\r\nfunction begin_set()\r\n{\r\n  TO_VAL=to_id.value;\r\n  TO_VAL1=to_name.value;\r\n  TO_VAL2=to_company.value;\r\n  \r\n  for (step_i=0; step_i<document.all.length; step_i++)\r\n  {\r\n    if(document.all(step_i).className==\"menulines\")\r\n    {\r\n       sTemp=document.all(step_i).title.split(\"|\");\r\n\t   dept_id=sTemp[0];\r\n       name=sTemp[1];\r\n\t   dept_name=sTemp[2];\r\n       if(TO_VAL.indexOf(\",\"+dept_id+\",\")>0 || TO_VAL.indexOf(dept_id+\",\")==0)\r\n          borderize_on(document.all(step_i));\r\n    }\r\n  }\r\n}\r\n\r\nfunction add_all()\r\n{\r\n  TO_VAL=to_id.value;\r\n  TO_VAL1=to_name.value;\r\n  TO_VAL2=to_company.value;\r\n  for (step_i=0; step_i<document.all.length; step_i++)\r\n  {\r\n    if(document.all(step_i).className==\"menulines\")\r\n    {\r\n       sTemp=document.all(step_i).title.split(\"|\");\r\n\t   dept_id=sTemp[0];\r\n       name=sTemp[1];\r\n\t   dept_name=sTemp[2];\r\n\r\n       if(TO_VAL.indexOf(\",\"+dept_id+\",\")<=0 && TO_VAL.indexOf(dept_id+\",\")!=0)\r\n       {\r\n         to_id.value+=dept_id+\",\";\r\n         borderize_on(document.all(step_i));\r\n       }\r\n\t   \r\n\t   if(TO_VAL1.indexOf(\",\"+name+\",\")<=0 && TO_VAL1.indexOf(name+\",\")!=0)\r\n       {\r\n         to_name.value+=name+\",\";\r\n       }\r\n\t   \r\n\t   if(TO_VAL2.indexOf(\",\"+dept_name+\",\")<=0 && TO_VAL2.indexOf(dept_name+\",\")!=0)\r\n       {\r\n         to_company.value+=dept_name+\",\";\r\n       }\r\n    }\r\n  }\r\n}\r\n\r\nfunction del_all()\r\n{\r\n  for (step_i=0; step_i<document.all.length; step_i++)\r\n  {\r\n    TO_VAL=to_id.value;\r\n\tTO_VAL1=to_name.value;\r\n\tTO_VAL2=to_company.value;\r\n\t\r\n    if(document.all(step_i).className==\"menulines\")\r\n    {\r\n       sTemp=document.all(step_i).title.split(\"|\");\r\n\t   dept_id=sTemp[0];\r\n       name=sTemp[1];\r\n\t   dept_name=sTemp[2];\r\n       \r\n       if(TO_VAL.indexOf(dept_id+\",\")==0)\r\n       {\r\n          to_id.value=to_id.value.replace(dept_id+\",\",\"\");\r\n       }\r\n\t   if(TO_VAL1.indexOf(name+\",\")==0)\r\n       {\r\n          to_name.value=to_name.value.replace(name+\",\",\"\");\r\n       }\r\n\t   if(TO_VAL2.indexOf(dept_name+\",\")==0)\r\n       {\r\n          to_company.value=to_company.value.replace(dept_name+\",\",\"\");\r\n       }\r\n\t   \r\n       if(TO_VAL.indexOf(\",\"+dept_id+\",\")>0)\r\n       {\r\n          to_id.value=to_id.value.replace(\",\"+dept_id+\",\",\",\");\r\n       }\r\n\t   if(TO_VAL1.indexOf(\",\"+name+\",\")>0)\r\n       {\r\n          to_name.value=to_name.value.replace(\",\"+name+\",\",\",\");\r\n       }\r\n\t   if(TO_VAL2.indexOf(\",\"+dept_name+\",\")>0)\r\n       {\r\n          to_company.value=to_company.value.replace(\",\"+dept_name+\",\",\",\");\r\n       }\r\n       borderize_off(document.all(step_i));\r\n    }\r\n  }\r\n}\r\n</script>\r\n</head>\r\n\r\n<body topmargin=\"1\" leftmargin=\"0\" class=\"bodycolor\" onLoad=\"begin_set()\">\r\n";
$query = "SELECT * from ADDRESS where USER_ID='".$USER_ID."' and GROUP_ID='{$GROUP_ID}' and {$FIELD}!='' order by PSN_NAME";
$cursor = exequery( $connection, $query );
if ( mysql_num_rows( $cursor ) == 0 )
{
				message( "", _( "该分组尚无记录" ), "blank" );
				exit( );
}
echo " <table class=\"TableBlock\" width=\"95%\" align=\"center\">\r\n   <tr class=\"TableControl\">\r\n     <td onClick=\"javascript:add_all();\" style=\"cursor:pointer\" align=\"center\" colspan=\"2\">";
echo _( "全部添加" );
echo "</td>\r\n   </tr>\r\n   <tr class=\"TableControl\">\r\n     <td onClick=\"javascript:del_all();\" style=\"cursor:pointer\" align=\"center\" colspan=\"2\">";
echo _( "全部删除" );
echo "</td>\r\n   </tr>\r\n";
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$ADD_ID = $ROW['ADD_ID'];
				$PSN_NAME = $ROW['PSN_NAME'];
				$DEPT_NAME = $ROW['DEPT_NAME'];
				$FIELD_VALUE = $ROW[$FIELD];
				echo "  <tr class=\"TableData\" style=\"cursor:pointer\" align=\"center\">\r\n    <td class=\"menulines\" id=\"";
				echo $ADD_ID;
				echo "\" onclick=\"javascript:click_dept('";
				echo $FIELD_VALUE;
				echo "','";
				echo $ADD_ID;
				echo "','";
				echo $PSN_NAME;
				echo "','";
				echo $DEPT_NAME;
				echo "')\" title=\"";
				echo $FIELD_VALUE."|".$PSN_NAME."|".$DEPT_NAME;
				echo "\">";
				echo $PSN_NAME;
				echo "(";
				echo $FIELD_VALUE;
				echo ")</td>\r\n  </tr>\r\n";
}
echo "</body>\r\n</html>\r\n";
?>
