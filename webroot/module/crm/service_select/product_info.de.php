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
echo _( "添加供应商" );
echo "</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n";
include_once( "inc/menu_button.js" );
echo "\r\n<script Language=\"JavaScript\">\r\nvar parent_window = parent.dialogArguments;\r\n\r\nfunction add_product(product_id,product_name_type)\r\n{\r\n    parent_window.form1.SER_ID.value=\"\";\r\n    parent_window.form1.SER_NAME.value=\"\";\r\n    parent_window.form1.SER_ID.value=product_id;\r\n    parent_window.form1.SER_NAME.value=product_name_type;\r\n    parent.close();\r\n}\r\n\r\n</script>\r\n</head>\r\n\r\n<body class=\"bodycolor\" onMouseover=\"borderize_on(event)\" onMouseout=\"borderize_off(event)\" onclick=\"borderize_on1(event)\" topmargin=\"5\">\r\n\r\n";
$query = "SELECT SERVICE_ID,SERVICE_NAME from SERVICE where SERVICE_NAME like '%".$PRODUCT_NAME."%' order by SERVICE_NAME";
$cursor = exequery( $connection, $query );
$PRODUCT_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$PRODUCT_COUNT;
				$PRODUCT_ID = $ROW['SERVICE_ID'];
				$PRODUCT_NAME = $ROW['SERVICE_NAME'];
				if ( $PRODUCT_COUNT == 1 )
				{
								echo "\r\n<table width=\"95%\" class=\"TableList\" align=\"center\">\r\n";
				}
				echo "<tr class=\"TableControl\">\r\n  <td class=\"menulines\" align=\"center\" onclick=\"javascript:add_product('";
				echo $PRODUCT_ID;
				echo "','";
				echo $PRODUCT_NAME;
				echo "')\" style=\"cursor:hand\">";
				echo $PRODUCT_NAME;
				echo "</a></td>\r\n</tr>\r\n";
				if ( 50 <= $PRODUCT_COUNT )
				{
				}
}
if ( $PRODUCT_COUNT == 0 )
{
				message( _( "提示" ), _( "没有定义服务型产品" ), "blank" );
}
else
{
				echo "<thead class=\"TableControl\">\r\n  <th bgcolor=\"#d6e7ef\" align=\"center\"><b>";
				echo _( "选择产品（最多显示50条）" );
				echo "</b></th>\r\n</thead>\r\n</table>\r\n\r\n";
}
echo "\r\n</body>\r\n</html>\r\n";
?>
