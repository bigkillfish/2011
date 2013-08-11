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
echo "\r\n<script Language=\"JavaScript\">\r\nvar parent_window = parent.dialogArguments;\r\n\r\nfunction add_provider(provider_id,provider_name)\r\n{\r\n  parent_window.form1.PROVIDER_ID.value=\"\";\r\n    parent_window.form1.PROVIDER_NAME.value=\"\";\r\n    \r\n  PROVIDER_VAL=parent_window.form1.PROVIDER_ID.value;\r\n  if(PROVIDER_VAL.indexOf(\",\"+provider_id+\",\")<0 && PROVIDER_VAL.indexOf(provider_id+\",\")!=0 && (parent_window.form1.PROVIDER_ID.value!=\"ALL_PROVIDER\"))\r\n  {\r\n    parent_window.form1.PROVIDER_ID.value+=provider_id;\r\n    parent_window.form1.PROVIDER_NAME.value+=provider_name;\r\n  }\r\n  parent.close();\r\n}\r\n\r\n</script>\r\n</head>\r\n\r\n<body class=\"bodycolor\" onMouseover=\"borderize_on(event)\" onMouseout=\"borderize_off(event)\" onclick=\"borderize_on1(event)\" topmargin=\"5\">\r\n\r\n";
$query = "SELECT * from PROVIDER where PROVIDER_NAME like '%".$PROVIDER_NAME."%' order by PROVIDER_NAME";
$cursor = exequery( $connection, $query );
$PROVIDER_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$PROVIDER_COUNT;
				$PROVIDER_ID = $ROW['PROVIDER_ID'];
				$PROVIDER_NAME = $ROW['PROVIDER_NAME'];
				if ( $PROVIDER_COUNT == 1 )
				{
								echo "\r\n<table border=\"1\" cellspacing=\"0\" width=\"95%\" class=\"small\" cellpadding=\"3\"  bordercolorlight=\"#000000\" bordercolordark=\"#FFFFFF\"  align=\"center\">\r\n";
				}
				echo "<tr class=\"TableControl\">\r\n  <td class=\"menulines\" align=\"center\" onclick=\"javascript:add_provider('";
				echo $PROVIDER_ID;
				echo "','";
				echo $PROVIDER_NAME;
				echo "')\" style=\"cursor:hand\">";
				echo $PROVIDER_NAME;
				echo "</a></td>\r\n</tr>\r\n";
				++$PROVIDER_COUNT;
				if ( 50 <= $PROVIDER_COUNT )
				{
				}
}
if ( $PROVIDER_COUNT == 0 )
{
				message( _( "提示" ), _( "没有定义供应商" ), "blank" );
}
else
{
				echo "<thead class=\"TableControl\">\r\n  <th bgcolor=\"#d6e7ef\" align=\"center\"><b>";
				echo _( "选择供应商（最多显示50条）" );
				echo "</b></th>\r\n</thead>\r\n</table>\r\n\r\n";
}
echo "\r\n</body>\r\n</html>\r\n";
?>
