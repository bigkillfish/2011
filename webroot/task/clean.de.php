<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "./auth.php" );
include_once( "inc/utility_all.php" );
$SYS_PARA = get_sys_para( "TASK_CLEAN" );
$TASK_CLEAN = unserialize( $SYS_PARA['TASK_CLEAN'] );
if ( is_array( $TASK_CLEAN ) )
{
				while ( list( $KEY, $VALUE ) = each( &$TASK_CLEAN ) )
				{
								$$KEY = $VALUE;
				}
}
if ( $DAY_SMS <= 0 )
{
				$DAY_SMS = 30;
}
if ( $DAY_LOGS <= 0 )
{
				$DAY_LOGS = 30;
}
include( "./clean/attachment.php" );
if ( $CLEAN_SYS_LOG )
{
				include( "./clean/sys_log.php" );
}
if ( $CLEAN_SMS )
{
				include( "./clean/sms.php" );
}
if ( $CLEAN_LOGS )
{
				include( "./clean/logs.php" );
}
$query = "update OFFICE_TASK set LAST_EXEC='".date( "Y-m-d" )."' where TASK_CODE='clean'";
exequery( $connection, $query );
echo "+OK";
?>
