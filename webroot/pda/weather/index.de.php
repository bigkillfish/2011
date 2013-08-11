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
include_once( "inc/td_core.php" );
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"../main.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "天气预报" );
echo "</span>\r\n\t<div class=\"list_top_right\"><a class=\"ButtonB\" href=\"javascript:document.form1.submit();\">";
echo _( "查询" );
echo "</a></div>\r\n</div>\r\n<div class=\"list_main\">\r\n   <form method=\"get\" action=\"index.php\" name=\"form1\">\r\n      ";
echo _( "请输入查询城市名称：" );
echo "<br>\r\n      <input name=\"WEATHER_CITY\" size=\"20\" value=\"";
echo $WEATHER_CITY;
echo "\">\r\n      <input type=\"hidden\" name=\"P\" value=\"";
echo $P;
echo "\">\r\n   </form>\r\n";
if ( $WEATHER_CITY != "" )
{
				$WEATHER_INFO = tdoa_weather( $WEATHER_CITY, "c" );
				if ( substr( $WEATHER_INFO, 0, 6 ) == "error:" )
				{
								$WEATHER_INFO = substr( $WEATHER_INFO, 6 );
				}
				echo "<br>".$WEATHER_INFO;
}
echo "</div>\r\n</body>\r\n</html>";
?>
