<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "./auth.php" );
include_once( "inc/utility_sms2.php" );
include_once( "inc/utility_all.php" );
$query = "select LAST_EXEC from OFFICE_TASK where USE_FLAG='1' and TASK_CODE='affair_remind' limit 0,1";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$LAST_EXEC = $ROW['LAST_EXEC'];
}
else
{
				echo "+OK";
				exit( );
}
$CUR_DATE = date( "Y-m-d", time( ) );
if ( $LAST_EXEC == $CUR_DATE )
{
				echo "+OK";
				exit( );
}
$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
$query = "SELECT * from AFFAIR where SMS2_REMIND='1' order by AFF_ID";
$cursor = exequery( $connection, $query );
$cur_date = date( "Y-m-d", time( ) );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$AFF_ID = $ROW['AFF_ID'];
				$USER_ID = $ROW['USER_ID'];
				$BEGIN_TIME = $ROW['BEGIN_TIME'];
				$END_TIME = $ROW['END_TIME'];
				$TYPE = $ROW['TYPE'];
				$REMIND_DATE = $ROW['REMIND_DATE'];
				$REMIND_TIME = $ROW['REMIND_TIME'];
				$CONTENT = $ROW['CONTENT'];
				$LAST_REMIND = $ROW['LAST_REMIND'];
				$LAST_SMS2_REMIND = $ROW['LAST_SMS2_REMIND'];
				$BEGIN_DATE = substr( $BEGIN_TIME, 0, 10 );
				$END_DATE = substr( $END_TIME, 0, 10 );
				if ( compare_date( $CUR_DATE, $BEGIN_DATE ) < 0 || $LAST_SMS2_REMIND == $CUR_DATE || $END_DATE != "0000-00-00" && 0 < compare_date( $CUR_DATE, $END_DATE ) )
				{
								$FLAG = 0;
								if ( $TYPE == "2" )
								{
												$FLAG = 1;
								}
								else if ( $TYPE == "3" && date( "w", time( ) ) == $REMIND_DATE )
								{
												$FLAG = 1;
								}
								else if ( $TYPE == "4" && date( "j", time( ) ) == $REMIND_DATE )
								{
												$FLAG = 1;
								}
								else if ( $TYPE == "5" )
								{
												$REMIND_ARR = explode( "-", $REMIND_DATE );
												$REMIND_DATE_MON = $REMIND_ARR[0];
												$REMIND_DATE_DAY = $REMIND_ARR[1];
												if ( date( "n", time( ) ) == $REMIND_DATE_MON && date( "j", time( ) ) == $REMIND_DATE_DAY )
												{
																$FLAG = 1;
												}
								}
								if ( $FLAG == 1 )
								{
												$SEND_TIME = $CUR_DATE." ".$REMIND_TIME;
												$SMS_CONTENT = _( "日程安排-周期性事务：" ).$CONTENT;
												send_mobile_sms_user( $SEND_TIME, $USER_ID, $USER_ID, $SMS_CONTENT, 45 );
												$Tquery = "update AFFAIR set LAST_SMS2_REMIND='".$CUR_DATE."' where AFF_ID='{$AFF_ID}'";
												exequery( $connection, $Tquery );
								}
				}
}
$query = "update OFFICE_TASK set LAST_EXEC='".date( "Y-m-d" )."' where TASK_CODE='affair_remind'";
exequery( $connection, $query );
echo "+OK";
?>
