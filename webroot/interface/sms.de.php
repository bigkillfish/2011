<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "./auth.php" );
include_once( "../inc/utility_sms1.php" );
if ( find_id( $AUTH_MODULE, "1" ) )
{
				echo "205#|#"._( "服务未授权" );
				exit( );
}
$SEND_TIME = trim( $SEND_TIME );
$FROM_ID = trim( $FROM_ID );
$TO_ID = trim( $TO_ID );
$SMS_TYPE = trim( $SMS_TYPE );
$CONTENT = trim( $CONTENT );
$REMIND_URL = trim( $REMIND_URL );
if ( $FROM_ID == "" )
{
				echo "301#|#"._( "FROM_ID为空" );
				exit( );
}
if ( $TO_ID == "" )
{
				echo "302#|#"._( "TO_ID为空" );
				exit( );
}
if ( $CONTENT == "" )
{
				echo "303#|#"._( "CONTENT为空" );
				exit( );
}
if ( $SEND_TIME != "" && !is_date_time( $SEND_TIME ) )
{
				echo "304#|#"._( "SEND_TIME无效" );
				exit( );
}
$query = "SELECT USER_ID from USER where USER_ID='".$FROM_ID."'";
$cursor = exequery( $connection, $query );
if ( mysql_num_rows( $cursor ) < 1 )
{
				echo "305#|#".$FROM_ID;
				exit( );
}
$TO_ID_STR = "";
$query = "SELECT USER_ID from USER where NOT_LOGIN!='1' and find_in_set(USER_ID,'".$TO_ID."')";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$TO_ID_STR .= $ROW['USER_ID'].",";
}
$USER_ID_STR = check_id( $TO_ID_STR, $TO_ID, FALSE );
if ( $USER_ID_STR != "" )
{
				echo "306#|#".$USER_ID_STR;
				exit( );
}
if ( $TO_ID_STR == "" )
{
				echo "302#|#"._( "TO_ID为空" );
				exit( );
}
if ( $SMS_TYPE != "" )
{
				$query = "SELECT * from SYS_CODE where PARENT_NO='SMS_REMIND' and CODE_NO='".$SMS_TYPE."'";
				$cursor = exequery( $connection, $query );
				if ( mysql_num_rows( $cursor ) < 1 )
				{
								echo "307#|#".$SMS_TYPE;
								exit( );
				}
}
$SMS_TYPE = $SMS_TYPE == "" ? "0" : $SMS_TYPE;
if ( $POSTFIX != "" )
{
				$CONTENT .= "\n---------------------------------------\n".$POSTFIX;
}
send_sms( $SEND_TIME, $FROM_ID, $TO_ID_STR, $SMS_TYPE, $CONTENT );
echo "100#|#";
?>
