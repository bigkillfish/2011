<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
include_once( "inc/utility_sms1.php" );
include_once( "inc/utility_sms2.php" );
ob_end_clean( );
if ( $lActionType == "" )
{
				echo _( "错误：未知操作！" );
				exit( );
}
switch ( $lActionType )
{
				case 6 :
								$query = "select 1 from USER WHERE KEY_SN = '".$strName."' and USER_ID='{$LOGIN_USER_ID}'";
								$cursor = exequery( $connection, $query );
								if ( mysql_fetch_array( $cursor ) )
								{
												echo "ok";
								}
								else
								{
												echo _( "用户身份不符，您无权使用此印章智能卡（UKey）!" );
												return 1;
								}
				case 5 :
								$query = "select USER_ID from USER WHERE KEY_SN = '".$strValue."' and USER_ID='{$LOGIN_USER_ID}'";
								$cursor = exequery( $connection, $query );
								if ( mysql_fetch_array( $cursor ) )
								{
												$query1 = "select 1 from REGISTER_CONTROL WHERE REG_ID='".$REG_ID."' AND (DRAFTER='{$LOGIN_USER_ID}' OR find_in_set('{$strName}',C))";
												$cursor1 = exequery( $connection, $query1 );
												if ( $ROW = mysql_fetch_array( $cursor1 ) )
												{
																$query = "select 1 from SEAL WHERE SEAL_ID = '".$strName."' AND FIND_IN_SET('{$LOGIN_USER_ID}',USER_STR)";
																$cursor = exequery( $connection, $query );
																if ( mysql_fetch_array( $cursor ) )
																{
																				$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
																				echo "ok:".$CUR_TIME;
																				$USER_IP = get_client_ip( );
																				$query = _( "insert into SEAL_LOG (S_ID,LOG_TYPE,LOG_TIME,RESULT,IP_ADD,USER_ID,CLIENT_TYPE) VALUES ('".$strName."','addseal','{$CUR_TIME}','盖章成功','{$USER_IP}','{$LOGIN_USER_ID}','2')" );
																				exequery( $connection, $query );
																				$query = "select USER_STR,SEAL_NAME from SEAL WHERE SEAL_ID = '".$strName."'";
																				$cursor = exequery( $connection, $query );
																				if ( $ROW = mysql_fetch_array( $cursor ) )
																				{
																								$USER_ID_STR .= $ROW[0];
																								$SEAL_NAME = $ROW[1];
																				}
																				$query = "select DOC_TITLE from REGISTER_NOTE WHERE REG_ID = '".$REG_ID."'";
																				$cursor = exequery( $connection, $query );
																				if ( $ROW = mysql_fetch_array( $cursor ) )
																				{
																								$DOC_TITLE = $ROW['DOC_TITLE'];
																				}
																				if ( find_id( $USER_ID_STR, $LOGIN_USER_ID ) )
																				{
																								$USER_ID_STR = str_replace( $LOGIN_USER_ID.",", "", $USER_ID_STR );
																				}
																				if ( $USER_ID_STR != "" )
																				{
																								$SMS_CONTENT = $LOGIN_USER_NAME.sprintf( _( "加盖印章'%s'于《%s》" ), $SEAL_NAME, $DOC_TITLE );
																								$REMIND_URL = "";
																								send_sms( $CUR_TIME, $LOGIN_USER_ID, $USER_ID_STR, 48, $SMS_CONTENT, $REMIND_URL );
																								send_mobile_sms_user( $CUR_TIME, $LOGIN_USER_ID, $USER_ID_STR, $SMS_CONTENT, 48 );
																				}
																}
																else
																{
																				echo _( "您无此印章权限，无法盖章!" );
																}
												}
												else
												{
																echo _( "您无此公文盖章权限，无法盖章!" );
												}
								}
								else
								{
												echo _( "用户身份不符，您无权使用此印章智能卡（UKey）!" );
												return 1;
								}
				case 4 :
								$query = "select USER_ID from USER WHERE KEY_SN = '".$strValue."' and USER_ID='{$LOGIN_USER_ID}'";
								$cursor = exequery( $connection, $query );
								if ( mysql_fetch_array( $cursor ) )
								{
												$query = "select 1 from REGISTER_CONTROL WHERE REG_ID='".$REG_ID."' AND  (DRAFTER='{$LOGIN_USER_ID}' OR find_in_set('{$strName}',C))";
												$cursor = exequery( $connection, $query );
												if ( mysql_fetch_array( $cursor ) )
												{
																echo "ok";
												}
												else
												{
																echo _( "您无此公文印章修改或者删除权限!" );
												}
								}
								else
								{
												echo _( "用户身份不符，您无权使用此印章智能卡（UKey）!" );
												return 1;
								}
				case 1 :
								$query = "select DRAFTER from REGISTER_CONTROL where REG_ID='".$REG_ID."'";
								$cursor = exequery( $connection, $query );
								if ( $ROW = mysql_fetch_array( $cursor ) )
								{
												$DRAFTER = $ROW['DRAFTER'];
								}
								if ( $DRAFTER == $LOGIN_USER_ID )
								{
												echo "ok:NL";
								}
								else
								{
												$query = "SELECT ALLOW_PRINT_NUM,HAVE_PRINT_NUM FROM REGISTER_PRINT WHERE REG_ID = '".$REG_ID."' and SIGN_DEPT_ID = '{$LOGIN_DEPT_ID}'";
												$cursor = exequery( $connection, $query );
												if ( $ROW = mysql_fetch_array( $cursor ) )
												{
																$ALLOW_PRINT_NUM = $ROW[0];
																$HAVE_PRINT_NUM = $ROW[1];
												}
												$ALLOW_NUM = $ALLOW_PRINT_NUM - $HAVE_PRINT_NUM;
												echo "ok:".$ALLOW_NUM;
												return 1;
								}
				default :
								echo "ok";
}
?>
