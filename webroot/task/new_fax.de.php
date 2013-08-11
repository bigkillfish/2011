<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "./auth.php" );
include_once( "inc/utility_fax.php" );
include_once( "inc/utility_sms1.php" );
include_once( "inc/utility_sms2.php" );
$query = "SELECT * from EFAX_ACCOUNT order by ACCOUNT_ID";
$cursor = exequery( $connection, $query );
$cur_date = date( "Y-m-d", time( ) );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$NAME_DESC = $ROW['NAME_DESC'];
				$ACCOUNT_ID = $ROW['ACCOUNT_ID'];
				$NAME = $ROW['NAME'];
				$fax_no = $ROW['FAX'];
				$RECEIVE_PRIV = $ROW['RECEIVE_PRIV'];
				$PASSWORD = $ROW['PASSWORD'];
				$NEW_RECEIVE_TIME = $ROW['NEW_RECEIVE_TIME'];
				$VALID_DATE = $ROW['VALID_DATE'];
				$_POST_TO_SERVER['fax_user'] = $NAME;
				$_POST_TO_SERVER['fax_pass'] = decrypt_str( $PASSWORD, "webfax" );
				$TIME_OK = is_date( $VALID_DATE );
				if ( $VALID_DATE == "" || $VALID_DATE == "0000-00-00" || !$TIME_OK )
				{
								$_POST_TO_SERVER['action'] = "getValiddate";
								$str_result = php_post( $FAX_SUBMIT_URL."action.php", $_POST_TO_SERVER );
								if ( is_date( $str_result ) )
								{
												$VALID_DATE = $str_result;
												$query = "update EFAX_ACCOUNT set VALID_DATE='".$VALID_DATE."' where ACCOUNT_ID='{$ACCOUNT_ID}'";
												exequery( $connection, $query );
								}
				}
				if ( $VALID_DATE < $cur_date && $VALID_DATE != "0000-00-00" )
				{
								break;
				}
				else
				{
								$_POST_TO_SERVER['endTime'] = "";
								$_POST_TO_SERVER['receiverNumber'] = "";
								$_POST_TO_SERVER['senderNumber'] = "";
								$_POST_TO_SERVER['action'] = "receiveFax";
								$_POST_TO_SERVER['startTime'] = $NEW_RECEIVE_TIME;
								$str_back = php_post( $FAX_SUBMIT_URL."action.php", $_POST_TO_SERVER );
				}
				if ( $str_back == "" )
				{
								break;
				}
				else
				{
								$rec_flag = explode( "#|#", $str_back );
				}
				if ( $rec_flag[0] != "224" )
				{
								if ( $rec_flag[0] != "100" )
								{
												break;
								}
								else
								{
												$single_fax = explode( "*|*", $str_back );
												$I = 0;
												for ( ;	$I < sizeof( $single_fax );	++$I	)
												{
																$detail = explode( "#|#", $single_fax[$I] );
												}
												if ( $detail[0] == "100" )
												{
																$fax_status = $detail[0];
																$SEND_NO = $detail[2];
																$RECEIVE_TIME = $detail[6];
																$PAGES = $detail[5];
																$FAX_URL = $detail[4];
																$FAX_FORMAT = $detail[3];
																$IS_INTER = $detail[7];
												}
												else
												{
																$SEND_NO = $detail[1];
																$RECEIVE_TIME = $detail[5];
																$PAGES = $detail[4];
																$FAX_URL = $detail[3];
																$FAX_FORMAT = $detail[2];
																$IS_INTER = $detail[6];
												}
												if ( $IS_INTER == "False" || $IS_INTER == "" )
												{
																$IS_INTER = "0";
												}
												if ( $IS_INTER == "True" )
												{
																$IS_INTER = "1";
												}
												$query = "insert into EFAX_RECEIVE_BOX(FAX_NAME,FAX_NO,SEND_NO,RECEIVE_TIME,PAGES,FAX_URL,STATE,ISDONWLOAD,FAX_FORMAT,IS_INTER) values('".$NAME."','{$fax_no}','{$SEND_NO}','{$RECEIVE_TIME}','{$PAGES}','{$FAX_URL}','1','0','{$FAX_FORMAT}','{$IS_INTER}')";
												exequery( $connection, $query );
												$SEND_NO_ARR .= $SEND_NO.",";
								}
								$SEND_TIME = date( "Y-m-d H:i:s", time( ) );
								$USER_ID_STR = $RECEIVE_PRIV;
								if ( substr( $SEND_NO_ARR, -1 ) == "," )
								{
												$SEND_NO_ARR = substr( $SEND_NO_ARR, 0, -1 );
								}
								$SMS_CONTENT = $NAME_DESC.":".$FAX.sprintf( _( "有来自%s的新传真，请查收。" ), $SEND_NO_ARR );
								$REMIND_URL = "1:fax/receive/receivebox.php";
								if ( $USER_ID_STR != "" )
								{
												send_sms( $SEND_TIME, "admin", $USER_ID_STR, 44, $SMS_CONTENT, $REMIND_URL );
								}
								$query = "SELECT max(RECEIVE_TIME) FROM EFAX_RECEIVE_BOX where FAX_NAME='".$NAME."'";
								$cursor = exequery( $connection, $query );
								if ( $ROW = mysql_fetch_array( $cursor ) )
								{
												$NEW_TIME = $ROW[0];
								}
								$query = "update EFAX_ACCOUNT set NEW_RECEIVE_TIME='".$NEW_TIME."' where NAME='{$NAME}'";
								exequery( $connection, $query );
				}
}
echo "+OK";
?>
