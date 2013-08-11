<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/utility_all.php" );
include_once( "inc/utility_file.php" );
backup_tables( "sms,sms_body" );
$BODY_ID_STR = "";
$query = "select BODY_ID from SMS_BODY where SMS_TYPE!='0' and SMS_TYPE!='10' and SMS_TYPE!='23' and SEND_TIME<='".( time( ) - $DAY_SMS * 86400 )."'";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$BODY_ID_STR .= $ROW['BODY_ID'].",";
}
$BODY_ID_STR = td_trim( $BODY_ID_STR );
if ( $BODY_ID_STR != "" )
{
				$query = "delete from SMS where BODY_ID in (".$BODY_ID_STR.")";
				exequery( $connection, $query );
				$query = "delete from SMS_BODY where BODY_ID in (".$BODY_ID_STR.")";
				exequery( $connection, $query );
				$query = "repair table SMS,SMS_BODY";
				exequery( $connection, $query );
}
?>
