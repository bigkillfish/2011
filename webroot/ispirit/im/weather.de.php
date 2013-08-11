<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
include_once( "inc/td_core.php" );
include_once( "inc/weather.inc.php" );
$query = "SELECT WEATHER_CITY from INTERFACE";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$WEATHER_CITY = $ROW['WEATHER_CITY'];
}
$query = "SELECT WEATHER_CITY from USER where UID='".$LOGIN_UID."'";
$cursor = exequery( $connection, $query );
$WEATHER_CITY = $ROW['WEATHER_CITY'];
ob_end_clean( );
if ( strlen( $WEATHER_CITY ) != 5 )
{
				echo "info:0";
				exit( );
}
$KEY = array_search( $WEATHER_CITY, $CITY_ID_ARRAY );
if ( $KEY === NULL )
{
				echo "error:"._( "无该城市的天气数据" );
				exit( );
}
$WEATHER_CITY = $CITY_NAME_ARRAY[$KEY];
echo tdoa_weather( $WEATHER_CITY, "d" );
?>
