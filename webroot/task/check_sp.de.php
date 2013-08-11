<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "./auth.php" );
include_once( "inc/utility_sms1.php" );
include_once( "inc/utility_all.php" );
include_once( "inc/td_core.php" );
ob_clean( );
$CUR_VERSION = "5.0";
$CHECK_SP_URL = "http://www.tongda2000.com/download/check_sp.php?VER=".$CUR_VERSION;
if ( $MYOA_IS_UN == 1 )
{
				$CHECK_SP_URL = "http://un.tongda2000.com/check_sp.php?VER=".$CUR_VERSION;
}
if ( substr( $TD_MYOA_VERSION, 0, strlen( $CUR_VERSION ) ) != $CUR_VERSION )
{
				echo _( "程序版本不一致" );
				exit( );
}
$query = "SELECT EXEC_TIME from OFFICE_TASK where TASK_CODE='check_sp'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$EXEC_TIME = $ROW['EXEC_TIME'];
				if ( $EXEC_TIME == "04:00:00" )
				{
								$EXEC_TIME = mt_rand( 68400, 118800 ) % 86400;
								$EXEC_TIME = sprintf( "%02d:%02d:%02d", floor( $EXEC_TIME / 3600 ), floor( $EXEC_TIME % 3600 / 60 ), floor( $EXEC_TIME % 60 ) );
								$query = "update OFFICE_TASK set EXEC_TIME='".$EXEC_TIME."' where TASK_CODE='check_sp'";
								exequery( $connection, $query );
								include_once( "inc/itask/itask.php" );
								$result = itask( array( "RELOAD_ALL_TASK" ) );
								echo "+OK";
								exit( );
				}
}
echo "+OK";
exit( );
$DATA = @file_get_contents( $CHECK_SP_URL );
if ( $DATA === FALSE )
{
				echo _( "获取版本信息失败" );
				exit( );
}
$VER_ARRAY = json_decode( $DATA, TRUE );
if ( !is_array( $VER_ARRAY ) || $VER_ARRAY['OA_VER'] == "" )
{
				echo _( "解析数据失败" );
				exit( );
}
$OA_VER = $VER_ARRAY['OA_VER'];
if ( $TD_MYOA_VERSION < $OA_VER )
{
				$DOWN_SP_URL = $VER_ARRAY['DOWN_SP_URL'];
				$DOWN_SP_URL = "<a href=\"".$DOWN_SP_URL."\" target=\"_blank\">".$DOWN_SP_URL."</a>";
				$CONTENT = sprintf( _( "OA最新版本号：%s，请访问 %s 下载最新修正合集" ), $OA_VER, $DOWN_SP_URL );
				send_sms( "", "admin", "admin", "0", $CONTENT );
}
$query = "update OFFICE_TASK set LAST_EXEC='".date( "Y-m-d" )."' where TASK_CODE='check_sp'";
exequery( $connection, $query );
echo "+OK";
?>
