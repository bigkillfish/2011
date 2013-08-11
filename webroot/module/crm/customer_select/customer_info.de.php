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
echo "<html>\r\n<head>\r\n<title>";
echo _( "选择客户" );
echo "</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n";
include_once( "inc/menu_button.js" );
echo "\r\n<script Language=\"JavaScript\">\r\nvar parent_window = parent.dialogArguments;\r\n\r\nfunction add_customer(customer_id,customer_name)\r\n{\r\n  parent_window.form1.CUSTOMER_ID.value=\"\";\r\n  parent_window.form1.CUSTOMER_NAME.value=\"\";\r\n\r\n  CUSTOMER_VAL=parent_window.form1.CUSTOMER_ID.value;\r\n  if(CUSTOMER_VAL.indexOf(\",\"+customer_id+\",\")<0 && CUSTOMER_VAL.indexOf(customer_id+\",\")!=0 && (parent_window.form1.CUSTOMER_ID.value!=\"ALL_CUSTOMER\"))\r\n  {\r\n    parent_window.form1.CUSTOMER_ID.value+=customer_id;\r\n    parent_window.form1.CUSTOMER_NAME.value+=customer_name;\r\n  }\r\n  parent.close();\r\n}\r\n\r\n</script>\r\n</head>\r\n\r\n<body class=\"bodycolor\" onMouseover=\"borderize_on(event)\" onMouseout=\"borderize_off(event)\" onclick=\"borderize_on1(event)\" topmargin=\"5\">\r\n\r\n";
$query = "select * from SALE_MANAGER where MANAGER_ID=1";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$MANAGER_ID = $ROW['MANAGER_ID'];
				$MANAGERS = $ROW['MANAGERS'];
}
if ( find_id( $MANAGERS, $LOGIN_USER_ID ) )
{
				$query1 = "select DEPT_ID from DEPARTMENT";
				$cursor1 = exequery( $connection, $query1 );
				while ( $ROW = mysql_fetch_array( $cursor1 ) )
				{
								$DEPT_ID = $ROW['DEPT_ID'];
								if ( is_dept_priv( $DEPT_ID ) == 1 )
								{
												$TO_ID = $TO_ID.$DEPT_ID.",";
								}
				}
				$TO_ID = "'".str_replace( ",", "','", substr( $TO_ID, 0, -1 ) )."'";
				$FLAG = 1;
				$query = "SELECT * from CUSTOMER a  LEFT OUTER JOIN USER b ON a.SELLER = b.USER_ID  where ((SELLER='".$LOGIN_USER_ID."' or a.CREATOR='{$LOGIN_USER_ID}') or (find_in_set( '{$LOGIN_USER_ID}',SHAREUSER) and SHARE='1') or (SHAREUSER='' and SHARE='1') or (b.DEPT_ID in ({$TO_ID}) and SHARE='0')) and CUSTOMER_NAME like '%{$CUSTOMER_NAME}%' order by CUSTOMER_NAME";
}
else
{
				$query = "SELECT * from CUSTOMER where ((SELLER='".$LOGIN_USER_ID."' or CREATOR='{$LOGIN_USER_ID}') or (find_in_set( '{$LOGIN_USER_ID}',SHAREUSER) and SHARE='1') or (SHAREUSER='' and SHARE='1')) and CUSTOMER_NAME like '%{$CUSTOMER_NAME}%' order by CUSTOMER_NAME";
}
$cursor = exequery( $connection, $query );
$CUSTOMER_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$CUSTOMER_ID = $ROW['CUSTOMER_ID'];
				$CUSTOMER_NAME = $ROW['CUSTOMER_NAME'];
				$CUSTOMER_NAME = htmlspecialchars( $CUSTOMER_NAME );
				$CUSTOMER_NAME1 = str_replace( "'", "\\'", $CUSTOMER_NAME );
				$SELLER1 = $ROW['SELLER'];
				$SHARE1 = $ROW['SHARE'];
				++$CUSTOMER_COUNT;
				if ( $CUSTOMER_COUNT == 1 )
				{
								echo "\r\n<table width=\"95%\" class=\"TableList\" align=\"center\">\r\n";
				}
				echo "<tr class=\"TableControl\">\r\n  <td class=\"menulines\" align=\"center\" onClick=\"javascript:add_customer('";
				echo $CUSTOMER_ID;
				echo "','";
				echo $CUSTOMER_NAME1;
				echo "')\" style=\"cursor:hand\">";
				echo $CUSTOMER_NAME;
				echo "</a></td>\r\n</tr>\r\n";
				if ( 50 <= $CUSTOMER_COUNT )
				{
				}
}
if ( $CUSTOMER_COUNT == 0 )
{
				message( _( "提示" ), _( "没有定义客户" ), "blank" );
}
else
{
				echo "<thead class=\"TableControl\">\r\n  <th bgcolor=\"#d6e7ef\" align=\"center\"><b>";
				echo _( "选择客户（最多显示50条）" );
				echo "</b></th>\r\n</thead>\r\n</table>\r\n\r\n";
}
echo "\r\n</body>\r\n</html>\r\n";
?>
