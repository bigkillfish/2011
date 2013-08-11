<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$CSS_ARRAY = array( "/pda/style/list.css" );
$JS_ARRAY = array( );
include_once( "../auth.php" );
include_once( "inc/utility_all.php" );
if ( $DIA_ID != "" )
{
				$query = "SELECT * from DIARY where DIA_ID='".$DIA_ID."'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$USER_ID = $ROW['USER_ID'];
								if ( $USER_ID == $LOGIN_USER_ID )
								{
												$DIA_TYPE = $ROW['DIA_TYPE'];
												$CONTENT = $ROW['CONTENT'];
								}
				}
}
echo "\r\n<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "今日日志" );
echo "</span>\r\n\t<div class=\"list_top_right\"><a class=\"ButtonA\" href=\"javascript:document.form1.submit();\">";
echo _( "保存" );
echo "</a></div>\r\n</div>\r\n<div class=\"list_main\">\r\n<form action=\"send.php\"  method=\"post\" name=\"form1\">\r\n   ";
echo _( "日志类型" );
echo ":<br>\r\n <select name=\"DIA_TYPE\" class=\"BigSelect\" style=\"width:100%;\">\r\n   ";
echo code_list( "DIARY_TYPE", $DIA_TYPE );
echo " </select><br><br>\r\n   ";
echo _( "日志内容" );
echo ":<br>\r\n<textarea cols=\"18\" name=\"CONTENT\" rows=\"6\" wrap=\"on\" style=\"width:100%;\">";
echo $CONTENT;
echo "</textarea>\r\n<br>\r\n<input type=\"hidden\" name=\"P\" value=\"";
echo $P;
echo "\">\r\n<input type=\"hidden\" name=\"DIA_ID\" value=\"";
echo $DIA_ID;
echo "\">\r\n</form>\r\n</div>\r\n</body>\r\n</html>";
?>
