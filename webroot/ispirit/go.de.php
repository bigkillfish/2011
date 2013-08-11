<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/utility.php" );
include_once( "inc/utility_all.php" );
include_once( "inc/td_core.php" );
$query = "SELECT UID,PASSWORD from USER where UID='".$LOGIN_UID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				echo "<link rel='stylesheet' type='text/css' href='/theme/1/style.css'>";
				message( _( "警告" ), _( "非法登录！" ) );
				exit( );
}
$PASSWORD = $ROW['PASSWORD'];
$PASSWORD = substr( md5( keyed_str( $PASSWORD, "BLVY" ) ), 0, 16 );
if ( $PASSWORD != $PWD )
{
				echo "<link rel='stylesheet' type='text/css' href='/theme/1/style.css'>";
				message( _( "警告" ), _( "非法登录！" ) );
				exit( );
}
$query = "select * from USER_ONLINE where UID='".$LOGIN_UID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$SID = $ROW['SID'];
}
else
{
				echo "<link rel='stylesheet' type='text/css' href='/theme/1/style.css'>";
				message( _( "警告" ), _( "请重新登录！" ) );
				exit( );
}
$LOGIN_UID_NOW = $LOGIN_UID;
session_id( $SID );
session_start( );
if ( $LOGIN_UID_NOW != $LOGIN_UID )
{
				echo "<link rel='stylesheet' type='text/css' href='/theme/1/style.css'>";
				message( _( "警告" ), _( "出于安全保护，请重新登录！" ) );
				exit( );
}
$URL = str_replace( array( "*", "@" ), array( "&", "?" ), $_GET['URL'] );
if ( $URL == "/general" )
{
				$URL .= "?ISPIRIT=1";
}
if ( !stristr( $URL, "/general/email/?MAIN_URL=" ) && !stristr( $URL, "/general/webmail/?MAIN_URL=" ) )
{
				$URL = unescape( $URL );
}
header( "location: ".$URL );
?>
