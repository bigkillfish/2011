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
echo "\r\n<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<style>\r\n.menulines{}\r\n</style>\r\n<script type=\"text/javascript\" src=\"/inc/js/utility.js\"></script>\r\n<script Language=\"JavaScript\">\r\nvar parent_window = getOpenner();\r\nvar to_form = parent_window.";
echo $FORM_NAME;
echo ";\r\nvar to_id =   to_form.";
echo $TO_ID;
echo ";\r\n\r\nfunction click_dept(dept_id,td_id)\r\n{\r\n  TO_VAL=to_id.value;\r\n  targetelement=$(td_id);\r\n\r\n  if(TO_VAL.indexOf(\",\"+dept_id+\",\")>0 || TO_VAL.indexOf(dept_id+\",\")==0)\r\n  {\r\n    if(TO_VAL.indexOf(dept_id+\",\")==0)\r\n    {\r\n       to_id.value=to_id.value.replace(dept_id+\",\",\"\");\r\n       borderize_off(targetelement);\r\n    }\r\n    if(TO_VAL.indexOf(\",\"+dept_id+\",\")>0)\r\n    {\r\n       to_id.value=to_id.value.replace(\",\"+dept_id+\",\",\",\");\r\n       borderize_off(targetelement);\r\n    }\r\n  }\r\n  else\r\n  {\r\n    to_id.value+=dept_id+\",\";\r\n    borderize_on(targetelement);\r\n  }\r\n}\r\n\r\nfunction borderize_on(targetelement)\r\n{\r\n color=\"#003FBF\";\r\n targetelement.style.borderColor=\"black\";\r\n targetelement.style.backgroundColor=color;\r\n targetelement.style.color=\"white\";\r\n targetelement.style.fontWeight=\"bold\";\r\n}\r\n\r\nfunction borderize_off(targetelement)\r\n{\r\n  targetelement.style.backgroundColor=\"\";\r\n  targetelement.style.borderColor=\"\";\r\n  targetelement.style.color=\"\";\r\n  targetelement.style.fontWeight=\"\";\r\n}\r\n\r\nfunction begin_set()\r\n{\r\n  TO_VAL=to_id.value;\r\n  \r\n  for (step_i=0; step_i<allElements.length; step_i++)\r\n  {\r\n    if(allElements[step_i].className==\"menulines\")\r\n    {\r\n       dept_id=allElements[step_i].title;\r\n       if(TO_VAL.indexOf(\",\"+dept_id+\",\")>0 || TO_VAL.indexOf(dept_id+\",\")==0)\r\n          borderize_on(allElements[step_i]);\r\n    }\r\n  }\r\n}\r\n\r\nfunction add_all()\r\n{\r\n  TO_VAL=to_id.value;\r\n  for (step_i=0; step_i<allElements.length; step_i++)\r\n  {\r\n    if(allElements[step_i].className==\"menulines\")\r\n    {\r\n       dept_id=allElements[step_i].title;\r\n\r\n       if(TO_VAL.indexOf(\",\"+dept_id+\",\")<=0 && TO_VAL.indexOf(dept_id+\",\")!=0)\r\n       {\r\n         to_id.value+=dept_id+\",\";\r\n         borderize_on(allElements[step_i]);\r\n       }\r\n    }\r\n  }\r\n}\r\n\r\nfunction del_all()\r\n{\r\n  for (step_i=0; step_i<allElements.length; step_i++)\r\n  {\r\n    TO_VAL=to_id.value;\r\n    if(allElements[step_i].className==\"menulines\")\r\n    {\r\n       dept_id=allElements[step_i].title;\r\n       \r\n       if(TO_VAL.indexOf(dept_id+\",\")==0)\r\n       {\r\n          to_id.value=to_id.value.replace(dept_id+\",\",\"\");\r\n       }\r\n       if(TO_VAL.indexOf(\",\"+dept_id+\",\")>0)\r\n       {\r\n          to_id.value=to_id.value.replace(\",\"+dept_id+\",\",\",\");\r\n       }\r\n       borderize_off(allElements[step_i]);\r\n    }\r\n  }\r\n}\r\n\r\n</script>\r\n</head>\r\n\r\n<body topmargin=\"1\" leftmargin=\"0\" class=\"bodycolor\" onload=\"begin_set()\">\r\n";
$query = "SELECT * from USER_PRIV where USER_PRIV=".$LOGIN_USER_PRIV;
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$PRIV_NO = $ROW['PRIV_NO'];
}
if ( $USER_ID != "" )
{
				$WHERE_STR .= " and USER_ID like '%".$USER_ID."%'";
}
if ( $USER_NAME != "" )
{
				$WHERE_STR .= " and USER_NAME like '%".$USER_NAME."%'";
}
if ( $BYNAME != "" )
{
				$WHERE_STR .= " and BYNAME like '%".$BYNAME."%'";
}
if ( $DEPT_ID != "" )
{
				$WHERE_STR .= " and USER.DEPT_ID=".$DEPT_ID;
}
if ( $DEPT_ID != "0" )
{
				$WHERE_STR .= " and DEPARTMENT.DEPT_ID=USER.DEPT_ID";
}
if ( $USER_PRIV != "" )
{
				$WHERE_STR .= " and USER.USER_PRIV=".$USER_PRIV;
}
$WHERE_STR .= " and USER.EMAIL!=''";
$USER_COUNT = 0;
$query = "SELECT * from USER,USER_PRIV";
if ( $DEPT_ID != "0" )
{
				$query .= ",DEPARTMENT";
}
if ( $LOGIN_USER_PRIV != "1" )
{
				$query .= " where USER.USER_PRIV=USER_PRIV.USER_PRIV and USER_PRIV.PRIV_NO>".$PRIV_NO." and USER_PRIV.USER_PRIV!=1 ".$WHERE_STR." order by ";
}
else
{
				$query .= " where USER.USER_PRIV=USER_PRIV.USER_PRIV ".$WHERE_STR." order by ";
}
if ( $LAST_VISIT_TIME != "" )
{
				$query .= "LAST_VISIT_TIME ".$LAST_VISIT_TIME.",";
}
if ( $DEPT_ID != "0" )
{
				$query .= "DEPT_NO,";
}
$query .= "PRIV_NO,USER_NO,USER_NAME";
$query_count = str_replace( "SELECT *", "SELECT COUNT(*)", $query );
$cursor_count = exequery( $connection, $query_count );
if ( $ROW = mysql_fetch_array( $cursor_count ) )
{
				$USER_COUNT = $ROW[0];
}
if ( $USER_COUNT == 0 )
{
				message( "", _( "无符合条件的记录" ), "blank" );
				echo " \t \r\n<div align=\"center\">\r\n  <input type=\"button\" value=\"";
				echo _( "返回" );
				echo "\" class=\"SmallButton\" onclick=\"location='query_user_cond.php?FIELD=";
				echo $FIELD;
				echo "&TO_ID=";
				echo $TO_ID;
				echo "&FORM_NAME=";
				echo $FORM_NAME;
				echo "'\" title=\"";
				echo _( "查询用户" );
				echo "\" name=\"button\">\r\n</div>\r\n";
}
else
{
				echo "   <table class=\"TableBlock\" width=\"95%\" align=\"center\">\r\n     <tr class=\"TableControl\">\r\n       <td onclick=\"javascript:add_all();\" style=\"cursor:pointer\" align=\"center\" colspan=\"2\">";
				echo _( "全部添加" );
				echo "</td>\r\n     </tr>\r\n     <tr class=\"TableControl\">\r\n       <td onclick=\"javascript:del_all();\" style=\"cursor:pointer\" align=\"center\" colspan=\"2\">";
				echo _( "全部删除" );
				echo "</td>\r\n     </tr>\r\n";
				$cursor = exequery( $connection, $query );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$USER_ID = $ROW['USER_ID'];
								$USER_NAME = $ROW['USER_NAME'];
								$BYNAME = $ROW['BYNAME'];
								$PASSWORD = $ROW['PASSWORD'];
								$DEPT_ID = $ROW['DEPT_ID'];
								$USER_PRIV = $ROW['USER_PRIV'];
								$POST_PRIV = $ROW['POST_PRIV'];
								$LAST_VISIT_TIME = $ROW['LAST_VISIT_TIME'];
								$EMAIL = $ROW['EMAIL'];
								$MOBIL_NO = $ROW['MOBIL_NO'];
								$$FIELD = $ROW["{$FIELD}"];
								$IDLE_TIME_DESC = "";
								if ( $LAST_VISIT_TIME == "0000-00-00 00:00:00" )
								{
												$LAST_VISIT_TIME = "";
								}
								else
								{
												$IDLE_TIME = time( ) - strtotime( $LAST_VISIT_TIME ) - $ONLINE_REF_SEC;
												if ( 0 < floor( $IDLE_TIME / 86400 ) )
												{
																$IDLE_TIME_DESC .= floor( $IDLE_TIME / 86400 )._( "天" );
												}
												if ( 0 < floor( $IDLE_TIME % 86400 / 3600 ) )
												{
																$IDLE_TIME_DESC .= floor( $IDLE_TIME % 86400 / 3600 )._( "小时" );
												}
												if ( 0 < floor( $IDLE_TIME % 3600 / 60 ) )
												{
																$IDLE_TIME_DESC .= floor( $IDLE_TIME % 3600 / 60 )._( "分" );
												}
												if ( $IDLE_TIME_DESC == "" )
												{
																$IDLE_TIME_DESC = _( "0分" );
												}
								}
								if ( is_dept_priv( $DEPT_ID ) )
								{
								}
								else
								{
												$query1 = "SELECT * from DEPARTMENT where DEPT_ID=".$DEPT_ID;
												$cursor1 = exequery( $connection, $query1 );
												if ( $ROW = mysql_fetch_array( $cursor1 ) )
												{
																$DEPT_NAME = $ROW['DEPT_NAME'];
												}
												else
												{
																$DEPT_NAME = _( "离职人员/外部人员" );
												}
												if ( $POST_PRIV == "0" )
												{
																$POST_PRIV = _( "本部门" );
												}
												else if ( $POST_PRIV == "1" )
												{
																$POST_PRIV = _( "全体" );
												}
												else if ( $POST_PRIV == "2" )
												{
																$POST_PRIV = _( "指定部门" );
												}
												$query1 = "SELECT * from USER_PRIV where USER_PRIV='".$USER_PRIV."'";
												$cursor1 = exequery( $connection, $query1 );
												if ( $ROW = mysql_fetch_array( $cursor1 ) )
												{
																$USER_PRIV = $ROW['PRIV_NAME'];
												}
												$DEPT_LONG_NAME = dept_long_name( $DEPT_ID );
												echo "    <tr class=\"TableData\" style=\"cursor:pointer\" align=\"center\">\r\n      <td class=\"menulines\" id=\"";
												echo $USER_ID;
												echo "\" onclick=\"javascript:click_dept('";
												echo $$FIELD;
												echo "','";
												echo $USER_ID;
												echo "')\" title=\"";
												echo $$FIELD;
												echo "\">";
												echo $USER_NAME;
												echo "(";
												echo $DEPT_LONG_NAME;
												echo ")(";
												echo $$FIELD;
												echo ")</a></td>\r\n    </tr>\r\n  ";
								}
				}
				echo "   <tr>\r\n    <td nowrap  class=\"TableControl\" colspan=\"2\" align=\"center\">\r\n      <input type=\"button\" value=\"";
				echo _( "返回" );
				echo "\" class=\"SmallButton\" onclick=\"location='query_user_cond.php?FIELD=";
				echo $FIELD;
				echo "&TO_ID=";
				echo $TO_ID;
				echo "&FORM_NAME=";
				echo $FORM_NAME;
				echo "'\" title=\"";
				echo _( "查询用户" );
				echo "\" name=\"button\">\r\n    </td>\r\n   </tr>\r\n  </table>\r\n  ";
}
echo "</body>\r\n</html>\r\n";
?>
