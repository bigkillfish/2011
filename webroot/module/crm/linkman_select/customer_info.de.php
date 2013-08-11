<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
echo "\r\n<html>\r\n<head>\r\n<title>";
echo _( "选择客户" );
echo "</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n";
include_once( "inc/menu_button.js" );
echo "\r\n<script Language=\"JavaScript\">\r\nvar parent_window = parent.dialogArguments;\r\n\r\nfunction add_customer(customer_id,customer_name)\r\n{\r\n  parent_window.form1.LINKMAN_ID.value=\"\";\r\n\tparent_window.form1.LINKMAN_NAME.value=\"\";\r\n\r\n  CUSTOMER_VAL=parent_window.form1.LINKMAN_ID.value;\r\n  if(CUSTOMER_VAL.indexOf(\",\"+customer_id+\",\")<0 && CUSTOMER_VAL.indexOf(customer_id+\",\")!=0 && (parent_window.form1.CUSTOMER_ID.value!=\"ALL_CUSTOMER\"))\r\n  {\r\n    parent_window.form1.LINKMAN_ID.value+=customer_id;\r\n    parent_window.form1.LINKMAN_NAME.value+=customer_name;\r\n  }\r\n  parent.close();\r\n}\r\n\r\n</script>\r\n</head>\r\n\r\n<body class=\"bodycolor\" onMouseover=\"borderize_on(event)\" onMouseout=\"borderize_off(event)\" onclick=\"borderize_on1(event)\" topmargin=\"5\">\r\n\r\n";
$query = "SELECT * from LINKMAN  where  CUSTOMER_ID='".$CUSTOMER_ID."' and LINKMAN_NAME like '%{$CUSTOMER_NAME}%' order by LINKMAN_NAME";
$cursor = exequery( $connection, $query );
$CUSTOMER_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$CUSTOMER_COUNT;
				$CUSTOMER_ID = $ROW['LINKMAN_ID'];
				$CUSTOMER_NAME = $ROW['LINKMAN_NAME'];
				if ( $CUSTOMER_COUNT == 1 )
				{
								echo "\r\n<table width=\"95%\" class=\"TableList\"  align=\"center\">\r\n";
				}
				echo "<tr class=\"TableControl\">\r\n  <td class=\"menulines\" align=\"center\" onclick=\"javascript:add_customer('";
				echo $CUSTOMER_ID;
				echo "','";
				echo $CUSTOMER_NAME;
				echo "')\" style=\"cursor:hand\">";
				echo $CUSTOMER_NAME;
				echo "</a></td>\r\n</tr>\r\n";
				++$CUSTOMER_COUNT;
				if ( 50 <= $CUSTOMER_COUNT )
				{
				}
}
if ( $CUSTOMER_COUNT == 0 )
{
				message( _( "提示" ), _( "没有定义联系人" ), "blank" );
}
else
{
				echo "<thead class=\"TableControl\">\r\n  <th bgcolor=\"#d6e7ef\" align=\"center\"><b>";
				echo _( "选择客户（最多显示50条）" );
				echo "</b></th>\r\n</thead>\r\n</table>\r\n\r\n";
}
echo "\r\n</body>\r\n</html>\r\n";
?>
