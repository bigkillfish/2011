<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function return_register_type( $REGISTER_TIME, $USER_ID )
{
				global $connection;
				$query = "SELECT * from SYS_PARA where PARA_NAME='DUTY_INTERVAL_BEFORE1'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$DUTY_INTERVAL_BEFORE1 = $ROW['PARA_VALUE'];
				}
				$query = "SELECT * from SYS_PARA where PARA_NAME='DUTY_INTERVAL_AFTER1'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$DUTY_INTERVAL_AFTER1 = $ROW['PARA_VALUE'];
				}
				$query = "SELECT * from SYS_PARA where PARA_NAME='DUTY_INTERVAL_BEFORE2'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$DUTY_INTERVAL_BEFORE2 = $ROW['PARA_VALUE'];
				}
				$query = "SELECT * from SYS_PARA where PARA_NAME='DUTY_INTERVAL_AFTER2'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$DUTY_INTERVAL_AFTER2 = $ROW['PARA_VALUE'];
				}
				$query = "SELECT a.DUTY_TYPE,b.DUTY_NAME,b.GENERAL,b.DUTY_TIME1,b.DUTY_TIME2,b.DUTY_TIME3,b.DUTY_TIME4,b.DUTY_TIME5,b.DUTY_TIME6 from USER a left join ATTEND_CONFIG b on a.DUTY_TYPE=b.DUTY_TYPE where a.USER_ID='".$USER_ID."'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$DUTY_TYPE = $ROW['DUTY_TYPE'];
								$DUTY_NAME = $ROW['DUTY_NAME '];
								$GENERAL = $ROW['GENERAL'];
								$DUTY_TIME1 = $ROW['DUTY_TIME1'];
								$DUTY_TIME2 = $ROW['DUTY_TIME2'];
								$DUTY_TIME3 = $ROW['DUTY_TIME3'];
								$DUTY_TIME4 = $ROW['DUTY_TIME4'];
								$DUTY_TIME5 = $ROW['DUTY_TIME5'];
								$DUTY_TIME6 = $ROW['DUTY_TIME6'];
				}
				if ( $REGISTER_TIME != "" )
				{
								$timearray = explode( " ", $REGISTER_TIME );
								$time = $timearray[0];
								$DUTY_TIME1 = $time." ".$DUTY_TIME1;
								$DUTY_TIME2 = $time." ".$DUTY_TIME2;
								$DUTY_TIME3 = $time." ".$DUTY_TIME3;
								$DUTY_TIME4 = $time." ".$DUTY_TIME4;
								$DUTY_TIME5 = $time." ".$DUTY_TIME5;
								$DUTY_TIME6 = $time." ".$DUTY_TIME6;
								if ( strtotime( $DUTY_TIME1 ) - $DUTY_INTERVAL_BEFORE1 * 60 <= strtotime( $REGISTER_TIME ) && strtotime( $REGISTER_TIME ) <= strtotime( $DUTY_TIME1 ) + $DUTY_INTERVAL_AFTER1 * 60 )
								{
												$REGISTER_TYPE = 1;
								}
								if ( strtotime( $DUTY_TIME2 ) - $DUTY_INTERVAL_BEFORE2 * 60 <= strtotime( $REGISTER_TIME ) && strtotime( $REGISTER_TIME ) <= strtotime( $DUTY_TIME2 ) + $DUTY_INTERVAL_AFTER2 * 60 )
								{
												$REGISTER_TYPE = 2;
								}
								if ( strtotime( $DUTY_TIME3 ) - $DUTY_INTERVAL_BEFORE1 * 60 <= strtotime( $REGISTER_TIME ) && strtotime( $REGISTER_TIME ) <= strtotime( $DUTY_TIME3 ) + $DUTY_INTERVAL_AFTER2 * 60 )
								{
												$REGISTER_TYPE = 3;
								}
								if ( strtotime( $DUTY_TIME4 ) - $DUTY_INTERVAL_BEFORE2 * 60 <= strtotime( $REGISTER_TIME ) && strtotime( $REGISTER_TIME ) <= strtotime( $DUTY_TIME4 ) + $DUTY_INTERVAL_AFTER2 * 60 )
								{
												$REGISTER_TYPE = 4;
								}
								if ( strtotime( $DUTY_TIME5 ) - $DUTY_INTERVAL_BEFORE1 * 60 <= strtotime( $REGISTER_TIME ) && strtotime( $REGISTER_TIME ) <= strtotime( $DUTY_TIME5 ) + $DUTY_INTERVAL_AFTER2 * 60 )
								{
												$REGISTER_TYPE = 5;
								}
								if ( strtotime( $DUTY_TIME6 ) - $DUTY_INTERVAL_BEFORE2 * 60 <= strtotime( $REGISTER_TIME ) && strtotime( $REGISTER_TIME ) <= strtotime( $DUTY_TIME6 ) + $DUTY_INTERVAL_AFTER2 * 60 )
								{
												$REGISTER_TYPE = 6;
								}
				}
				return $REGISTER_TYPE;
}

include_once( "./auth.php" );
include_once( "inc/utility_all.php" );
ob_end_clean( );
if ( $DUTY_MACHINE != 1 )
{
				echo "+OK";
				exit( );
}
$query = "SELECT MACHINEID,MACHINE_BRAND,DATABASE_TYPE,ACCESS_PATH from ATTEND_MACHINE where MACHINEID=1";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$MACHINEID = $ROW['MACHINEID'];
				$MACHINE_BRAND = $ROW['MACHINE_BRAND'];
				$DATABASE_TYPE = $ROW['DATABASE_TYPE'];
				$ACCESS_PATH = $ROW['ACCESS_PATH'];
}
$query = "select LAST_EXEC from OFFICE_TASK where USE_FLAG='1' and TASK_CODE='sync_duty_machine' limit 0,1";
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
if ( file_exists( $ACCESS_PATH ) )
{
				echo "+OK";
				exit( );
}
if ( !( $MACHINE_BRAND == "ZK_iclock660" ) || !( $DATABASE_TYPE == "access" ) )
{
				$conn = new COM( "ADODB.Connection" );
				$connstr = "DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=".realpath( "{$ACCESS_PATH}" );
				$conn->Open( $connstr );
				$rs = new COM( "ADODB.RecordSet" );
				$query = "select SENSORID,USERID,CHECKTIME from CHECKINOUT where format(CHECKTIME,'yyyy-MM-dd') >'".$LAST_EXEC."' order by CHECKTIME desc";
				$rs->Open( $query, $conn, 1, 1 );
				while ( !$rs->eof )
				{
								$SENSORID = $rs->Fields( "SENSORID" )->value;
								$USERID = $rs->Fields( 1 )->value;
								$CHECKTIME = $rs->Fields['CHECKTIME']->value;
								$conn1 = new COM( "ADODB.Connection" );
								$conn1->Open( $connstr );
								$rs1 = new COM( "ADODB.RecordSet" );
								$query1 = "select Name from USERINFO where USERID=".$USERID;
								$rs1->Open( $query1, $conn1, 1, 1 );
								while ( !$rs1->eof )
								{
												$USER_NAME = $rs1->Fields( "NAME" )->value;
												$rs1->MoveNext( );
								}
								$query1 = "SELECT USER_ID from USER where USER_NAME='".$USER_NAME."'";
								$cursor1 = exequery( $connection, $query1 );
								if ( $ROW1 = mysql_fetch_array( $cursor1 ) )
								{
												$USER_ID = $ROW1['USER_ID'];
												$REGISTER_TYPE = return_register_type( $CHECKTIME, $USER_ID );
												if ( $REGISTER_TYPE != "" )
												{
																$query2 = "insert into ATTEND_DUTY(USER_ID,REGISTER_TYPE,REGISTER_TIME,REGISTER_IP,REMARK) values('".$USER_ID."','{$REGISTER_TYPE}','{$CHECKTIME}','{$SENSORID}','"._( "¿¼ÇÚ»ú" )."')";
																exequery( $connection, $query2 );
												}
								}
								$rs->MoveNext( );
				}
}
$query = "update OFFICE_TASK set LAST_EXEC='".date( "Y-m-d" )."' where TASK_CODE='sync_duty_machine'";
exequery( $connection, $query );
echo "+OK";
?>
