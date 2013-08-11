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
$query = "select PARA_NAME, PARA_VALUE from SYS_PARA where PARA_NAME IN('FLOW_REMIND_BEFORE','FLOW_REMIND_AFTER')";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$PARA_NAME = $ROW['PARA_NAME'];
				$PARA_VALUE = $ROW['PARA_VALUE'];
				$$PARA_NAME = $PARA_VALUE;
}
$REMIND_ARRAY = array( );
$FLOW_ID_OLD = "";
$query = "select FLOW_ID,PRCS_ID,TIME_OUT,TIME_OUT_TYPE,TIME_OUT_MODIFY,TIME_OUT_ATTEND from FLOW_PROCESS where TIME_OUT<>'' ORDER BY FLOW_ID";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$FLOW_ID = $ROW['FLOW_ID'];
				$PRCS_ID = $ROW['PRCS_ID'];
				$TIME_OUT = $ROW['TIME_OUT'];
				$TIME_OUT_TYPE = $ROW['TIME_OUT_TYPE'];
				$TIME_OUT_MODIFY = $ROW['TIME_OUT_MODIFY'];
				$TIME_OUT_ATTEND = $ROW['TIME_OUT_ATTEND'];
				if ( $FLOW_ID_OLD != "" && $FLOW_ID != $FLOW_ID_OLD )
				{
								$PRCS_STR = substr( $PRCS_STR, 0, -1 );
								$TIME_OUT_STR = substr( $TIME_OUT_STR, 0, -1 );
								$TIME_OUT_TYPE_STR = substr( $TIME_OUT_TYPE_STR, 0, -1 );
								$TIME_OUT_MODIFY_STR = substr( $TIME_OUT_MODIFY_STR, 0, -1 );
								$TIME_OUT_ATTEND_STR = substr( $TIME_OUT_ATTEND_STR, 0, -1 );
								if ( $PRCS_STR != "" && $TIME_OUT_STR != "" )
								{
												$REMIND_ARRAY[$FLOW_ID_OLD] = $PRCS_STR."|".$TIME_OUT_STR."|".$TIME_OUT_TYPE_STR."|".$TIME_OUT_MODIFY_STR."|".$TIME_OUT_ATTEND_STR;
								}
								$PRCS_STR = $TIME_OUT_STR = $TIME_OUT_TYPE_STR = $TIME_OUT_MODIFY_STR = $TIME_OUT_ATTEND_STR = "";
				}
				$PRCS_STR .= $PRCS_ID.",";
				$TIME_OUT_STR .= $TIME_OUT.",";
				$TIME_OUT_TYPE_STR .= $TIME_OUT_TYPE.",";
				$TIME_OUT_MODIFY_STR .= $TIME_OUT_MODIFY.",";
				$TIME_OUT_ATTEND_STR .= $TIME_OUT_ATTEND.",";
				$FLOW_ID_OLD = $FLOW_ID;
}
if ( $PRCS_STR != "" && $TIME_OUT_STR != "" )
{
				$PRCS_STR = substr( $PRCS_STR, 0, -1 );
				$TIME_OUT_STR = substr( $TIME_OUT_STR, 0, -1 );
				$TIME_OUT_MODIFY_STR = substr( $TIME_OUT_MODIFY_STR, 0, -1 );
				$TIME_OUT_ATTEND_STR = substr( $TIME_OUT_ATTEND_STR, 0, -1 );
				$REMIND_ARRAY[$FLOW_ID] = $PRCS_STR."|".$TIME_OUT_STR."|".$TIME_OUT_TYPE_STR."|".$TIME_OUT_MODIFY_STR."|".$TIME_OUT_ATTEND_STR;
}
if ( $REMIND_ARRAY )
{
				echo "+OK";
				exit( );
}
foreach ( $REMIND_ARRAY as $FLOW_ID => $INFO )
{
				$INFO_ARRAY = explode( "|", $INFO );
				$PRCS_ARRAY = explode( ",", $INFO_ARRAY[0] );
				$TIME_OUT_ARRAY = explode( ",", $INFO_ARRAY[1] );
				$TIME_OUT_TYPE_ARRAY = explode( ",", $INFO_ARRAY[2] );
				$TIME_OUT_MODIFY_ARRAY = explode( ",", $INFO_ARRAY[3] );
				$TIME_OUT_ATTEND_ARRAY = explode( ",", $INFO_ARRAY[4] );
				$PRCS_TIME_OUT_ARRAY = array( );
				foreach ( $PRCS_ARRAY as $K => $PRCS_ID )
				{
								$PRCS_TIME_OUT_ARRAY[$PRCS_ID] = array( $TIME_OUT_ARRAY[$K], $TIME_OUT_TYPE_ARRAY[$K], $TIME_OUT_MODIFY_ARRAY[$K], $TIME_OUT_ATTEND_ARRAY[$K] );
				}
				$query = "SELECT \r\n                  a.RUN_ID,\r\n                  a.TIME_OUT as TIME_OUT_RUN,\r\n                  USER_ID,\r\n                  PRCS_FLAG,\r\n                  PRCS_ID,\r\n                  FLOW_PRCS,\r\n                  CREATE_TIME,\r\n                  PRCS_TIME,\r\n                  b.BEGIN_USER,\r\n                  RUN_NAME \r\n            from \r\n                  FLOW_RUN_PRCS AS a,\r\n                  FLOW_RUN AS b \r\n            WHERE a.RUN_ID=b.RUN_ID AND b.FLOW_ID='".$FLOW_ID."' AND a.FLOW_PRCS in ({$INFO_ARRAY['0']}) and b.DEL_FLAG=0 AND a.PRCS_FLAG in (1,2) AND a.OP_FLAG=1";
				$cursor = exequery( $connection, $query );
				$attend_cfg_arr = array( );
				do
				{
								if ( $ROW = mysql_fetch_array( $cursor ) )
								{
												$RUN_ID = $ROW['RUN_ID'];
												$TIME_OUT_RUN = $ROW['TIME_OUT_RUN'];
												$USER_ID = $ROW['USER_ID'];
												$PRCS_ID = $ROW['PRCS_ID'];
												$FLOW_PRCS = $ROW['FLOW_PRCS'];
												$PRCS_FLAG = $ROW['PRCS_FLAG'];
												$BEGIN_USER = $ROW['BEGIN_USER'];
												$RUN_NAME = $ROW['RUN_NAME'];
												$CREATE_TIME = $ROW['CREATE_TIME'];
												$PRCS_TIME = $ROW['PRCS_TIME'];
												if ( $TIME_OUT_RUN != "" )
												{
																$TIME_OUT = $TIME_OUT_RUN;
												}
												else
												{
																$TIME_OUT = $PRCS_TIME_OUT_ARRAY[$FLOW_PRCS][0];
												}
												$TIME_OUT_TYPE = $PRCS_TIME_OUT_ARRAY[$FLOW_PRCS][1];
												$TIME_OUT_MODIFY = $PRCS_TIME_OUT_ARRAY[$FLOW_PRCS][2];
												$TIME_OUT_ATTEND = $PRCS_TIME_OUT_ARRAY[$FLOW_PRCS][3];
												if ( $TIME_OUT_TYPE == 0 )
												{
																$BEGIN_TIME = $PRCS_TIME;
																if ( $PRCS_TIME == NULL )
																{
																				$BEGIN_TIME = $CREATE_TIME;
																}
												}
												else
												{
																$BEGIN_TIME = $CREATE_TIME;
												}
												if ( $BEGIN_TIME == NULL )
												{
																if ( $TIME_OUT_ATTEND != "0" )
																{
																				if ( array_key_exists( $USER_ID, $attend_cfg_arr ) )
																				{
																								$attend_cfg = $attend_cfg_arr[$USER_ID];
																				}
																				else
																				{
																								$attend_cfg = get_attend_cfg( $USER_ID );
																								$attend_cfg_arr[$USER_ID] = $attend_cfg;
																				}
																}
																$PRCS_BEGIN_TIME = strtotime( $BEGIN_TIME );
																if ( $TIME_OUT_ATTEND != "0" )
																{
																				$TIME_USED = get_time_out( $TIME_OUT, $PRCS_BEGIN_TIME, time( ), $attend_cfg );
																}
																else
																{
																				$TIME_USED = get_time_out( $TIME_OUT, $PRCS_BEGIN_TIME, time( ) );
																}
																$REMIND_URL = "workflow/list/input_form?RUN_ID=".$RUN_ID."&FLOW_ID={$FLOW_ID}&PRCS_ID={$PRCS_ID}&FLOW_PRCS={$FLOW_PRCS}";
																$BEFORE_UNIT = substr( $FLOW_REMIND_BEFORE, -1, 1 );
																$AFTER_UNIT = substr( $FLOW_REMIND_AFTER, -1, 1 );
																$BEFORE = substr( $FLOW_REMIND_BEFORE, 0, -1 );
																$AFTER = substr( $FLOW_REMIND_AFTER, 0, -1 );
																$BEFORE_UNIT = str_replace( array( "d", "h", "m", "s" ), array( "86400", "3600", "60", "1" ), $BEFORE_UNIT );
																$AFTER_UNIT = str_replace( array( "d", "h", "m", "s" ), array( "86400", "3600", "60", "1" ), $AFTER_UNIT );
																if ( $TIME_OUT * 3600 < $TIME_USED )
																{
																				if ( $TIME_USED - $TIME_OUT * 3600 < $AFTER * $AFTER_UNIT )
																				{
																								$SMS_CONTENT = sprintf( _( "您有待办工作已经超过办理时限，请火速办理!流水号:%s 工作名称:%s" ), $RUN_ID, $RUN_NAME );
																								send_sms( "", "admin", $USER_ID, 7, $SMS_CONTENT, $REMIND_URL );
																				}
																				$query1 = "update FLOW_RUN_PRCS SET TIME_OUT_FLAG = 1 WHERE RUN_ID='".$RUN_ID."' AND PRCS_ID='{$PRCS_ID}' AND FLOW_PRCS= '{$FLOW_PRCS}' and USER_ID='{$USER_ID}'";
																				exequery( $connection, $query1 );
																}
																else
																{
																				if ( $TIME_USED < $TIME_OUT * 3600 && $TIME_OUT * 3600 - $TIME_USED < $BEFORE * $BEFORE_UNIT )
																				{
																								$SMS_CONTENT = sprintf( _( "您有待办工作即将超过办理时限，请迅速办理!流水号:%s 工作名称:%s" ), $RUN_ID, $RUN_NAME );
																								send_sms( "", "admin", $USER_ID, 7, $SMS_CONTENT, $REMIND_URL );
																				}
																				$query1 = "update FLOW_RUN_PRCS SET TIME_OUT_FLAG = 0 WHERE RUN_ID='".$RUN_ID."' AND PRCS_ID='{$PRCS_ID}' AND FLOW_PRCS= '{$FLOW_PRCS}' and USER_ID='{$USER_ID}'";
																				exequery( $connection, $query1 );
																}
												}
								}
				} while ( 1 );
				break;
}
echo "+OK";
?>
