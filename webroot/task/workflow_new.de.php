<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "./auth.php" );
include_once( "inc/utility_flow.php" );
include_once( "inc/utility_sms1.php" );
$CUR_YEAR = date( "Y" );
$CUR_MONTH = date( "m" );
$CUR_WEEK = date( "w" );
$CUR_DAY = date( "j" );
$CUR_DATE = date( "Y-m-d H:i:s" );
$CUR_TIME = date( "H:i:s" );
$query = "select * from OFFICE_TASK where USE_FLAG='1' and TASK_CODE='workflow_new' limit 0,1";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$INTERVAL = $ROW['INTERVAL'];
				$EXEC_TIME = $ROW['EXEC_TIME'];
				$LAST_EXEC = $ROW['LAST_EXEC'];
}
else
{
				echo "+OK";
				exit( );
}
$sql = "select * from FLOW_TIMER where (time_to_sec(REMIND_TIME)-time_to_sec('".$CUR_TIME."') between 0 and {$INTERVAL}*60) and (LAST_TIME<'{$CUR_DATE}' or LAST_TIME='0000-00-00 00:00:00')";
$cursor = exequery( $connection, $sql );
}
do
{
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$TID = $ROW['TID'];
								$USER_STR = $ROW['USER_STR'];
								$FLOW_ID = $ROW['FLOW_ID'];
								$TYPE = $ROW['TYPE'];
								$REMIND_DATE = $ROW['REMIND_DATE'];
								$REMIND_TIME = $ROW['REMIND_TIME'];
								$LAST_TIME = $ROW['LAST_TIME'];
								$FLAG = 0;
								if ( $TYPE == "1" && $REMIND_DATE == date( "Y-m-d" ) )
								{
												if ( $LAST_TIME == "0000-00-00 00:00:00" )
												{
																$FLAG = 1;
												}
												echo $FLAG;
								}
								else if ( $TYPE == "2" )
								{
												$FLAG = 1;
								}
								else if ( $TYPE == "3" && $CUR_WEEK == $REMIND_DATE )
								{
												$FLAG = 1;
								}
								else if ( $TYPE == "4" && $CUR_DAY == $REMIND_DATE )
								{
												$FLAG = 1;
								}
								else if ( $TYPE == "5" )
								{
												$REMIND_ARR = explode( "-", $REMIND_DATE );
												$REMIND_DATE_MON = $REMIND_ARR[0];
												$REMIND_DATE_DAY = $REMIND_ARR[1];
												if ( date( "n" ) == $REMIND_DATE_MON && date( "j" ) == $REMIND_DATE_DAY )
												{
																$FLAG = 1;
												}
								}
				}
} while ( !( $FLAG == 1 ) );
$USER_ARR = explode( ",", $USER_STR );
$i = 0;
do
{
				do
				{
								for ( ;	$i < count( $USER_ARR ) - 1;	} while ( 0 ),	do
	{
	++$i,	} while ( 1 )	)
				{
								new_flow( $FLOW_ID, $USER_ARR[$i], $USER_ARR[$i], 0, 0, 0, 1 );
								$query = "update flow_timer set LAST_TIME='".$CUR_DATE."' where TID={$TID}";
								exequery( $connection, $query );
								break;
				} while ( 1 );
				echo "+OK";
?>
