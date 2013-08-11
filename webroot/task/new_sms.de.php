<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "./auth.php" );
$INTERVAL = 3;
$query = "SELECT * from OFFICE_TASK where TASK_CODE='new_sms'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$INTERVAL = $ROW['INTERVAL'];
}
$INTERVAL += 1;
$TO_ID_STR = "";
$query = "SELECT TO_ID from SMS,SMS_BODY where SMS.BODY_ID=SMS_BODY.BODY_ID and FROM_ID!='' and REMIND_FLAG='1' and DELETE_FLAG!='1' and REMIND_TIME>='".( time( ) - $INTERVAL * 60 )."' and REMIND_TIME<='".time( )."' group by TO_ID";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$TO_ID_STR .= $ROW['TO_ID'].",";
}
if ( $TO_ID_STR != "" )
{
				$query = "SELECT UID from USER where find_in_set(USER_ID, '".$TO_ID_STR."')";
				$cursor = exequery( $connection, $query );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								new_sms_remind( $ROW['UID'], 1 );
				}
}
echo "+OK";
?>
