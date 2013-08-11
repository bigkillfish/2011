<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
$TYPE = strtolower( $_GET['TYPE'] );
$CUR_TIME = time( );
$EMAIL_COUNT = 0;
if ( find_id( $TYPE, "email" ) )
{
				$query = "SELECT count(*) from EMAIL,EMAIL_BODY LEFT JOIN USER ON USER.USER_ID = EMAIL_BODY.FROM_ID where EMAIL.BODY_ID=EMAIL_BODY.BODY_ID and TO_ID='".$LOGIN_USER_ID."' and READ_FLAG!='1' and (DELETE_FLAG='' or DELETE_FLAG='0' or DELETE_FLAG='2')";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$EMAIL_COUNT = $ROW[0];
				}
}
$SMS_COUNT = 0;
if ( find_id( $TYPE, "sms" ) )
{
				$query = "SELECT count(*) from SMS,SMS_BODY where SMS.BODY_ID=SMS_BODY.BODY_ID and TO_ID='".$LOGIN_USER_ID."' and SEND_TIME<='{$CUR_TIME}' and DELETE_FLAG!='1' and REMIND_FLAG!='0'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$SMS_COUNT += $ROW[0];
				}
}
ob_clean( );
echo $EMAIL_COUNT."|".$SMS_COUNT;
?>
