<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function ext_login_check( $USERNAME )
{
				global $ROOT_PATH;
				global $connection;
				global $ATTACH_PATH;
				global $ONLINE_REF_SEC;
				global $ONE_USER_MUL_LOGIN;
				include_once( "inc/utility_all.php" );
				$USER_IP = get_client_ip( );
				$PARA_ARRAY = get_sys_para( "SEC_PASS_FLAG,SEC_PASS_TIME,SEC_RETRY_BAN,SEC_RETRY_TIMES,SEC_BAN_TIME,SEC_USER_MEM,SEC_KEY_USER,LOGIN_KEY,SEC_ON_STATUS,SEC_INIT_PASS" );
				$PARA_VALUE = each( &$PARA_ARRAY )[1];
				$PARA_NAME = each( &$PARA_ARRAY )[0];
				while ( each( &$PARA_ARRAY ) )
				{
								$$PARA_NAME = $PARA_VALUE;
				}
				$query = "SELECT * from USER where USER_ID='".$USERNAME."' or BYNAME='{$USERNAME}'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								add_log( 10, "USERNAME=".$USERNAME, $USERNAME );
								return _( "用户名或密码错误，注意大小写2!" );
				}
				$UID = $ROW['UID'];
				$USER_ID = $ROW['USER_ID'];
				$BYNAME = $ROW['BYNAME'];
				$USER_NAME = $ROW['USER_NAME'];
				$BIND_IP = $ROW['BIND_IP'];
				$USEING_KEY = $ROW['USEING_KEY'];
				$ON_STATUS = $ROW['ON_STATUS'];
				if ( !( $USERNAME != $USER_ID ) || $USERNAME != $BYNAME || $USERNAME == "" )
				{
								add_log( 10, "USERNAME=".$USERNAME, $USERNAME );
								return _( "用户名或密码错误，注意大小写3!" );
				}
				$NOT_LOGIN = $ROW['NOT_LOGIN'];
				if ( check_ip( $USER_IP, "0", $USER_ID ) )
				{
								add_log( 9, "USERNAME=".$USERNAME, $USERNAME );
								return sprintf( _( "您无权限从该IP(%s)登录!" ), $USER_IP );
				}
				if ( $BIND_IP != "" )
				{
								$NET_MATCH = FALSE;
								$IP_ARRAY = explode( ",", $BIND_IP );
								foreach ( $IP_ARRAY as $NETWORK )
								{
												if ( netmatch( $NETWORK, $USER_IP ) )
												{
																$NET_MATCH = TRUE;
																break;
												}
								}
								if ( $NET_MATCH )
								{
												return sprintf( _( "用户 %s 不允许从该IP(%s)登录！" ), $USERNAME, $USER_IP );
								}
				}
				global $LOGIN_UID;
				global $LOGIN_USER_ID;
				global $LOGIN_BYNAME;
				global $LOGIN_USER_NAME;
				global $LOGIN_USER_PRIV;
				global $LOGIN_USER_PRIV_OTHER;
				global $LOGIN_DEPT_ID;
				global $LOGIN_DEPT_ID_OTHER;
				global $LOGIN_AVATAR;
				global $LOGIN_THEME;
				global $LOGIN_FUNC_STR;
				global $LOGIN_NOT_VIEW_USER;
				global $LOGIN_ANOTHER;
				$LOGIN_USER_PRIV = $ROW['USER_PRIV'];
				$USER_PRIV_OTHER = $ROW['USER_PRIV_OTHER'];
				$LOGIN_AVATAR = $ROW['AVATAR'];
				$LOGIN_DEPT_ID = $ROW['DEPT_ID'];
				$LOGIN_DEPT_ID_OTHER = $ROW['DEPT_ID_OTHER'];
				$LAST_PASS_TIME = $ROW['LAST_PASS_TIME'];
				$LOGIN_THEME = $ROW['THEME'];
				$LOGIN_NOT_VIEW_USER = $ROW['NOT_VIEW_USER'];
				if ( $LOGIN_THEME == "" )
				{
								$LOGIN_THEME = "1";
				}
				if ( find_id( $USER_PRIV_OTHER, $LOGIN_USER_PRIV ) )
				{
								$USER_PRIV_OTHER .= $LOGIN_USER_PRIV.",";
				}
				$LOGIN_FUNC_STR = "";
				$USER_PRIV_OTHER = td_trim( $USER_PRIV_OTHER );
				if ( $USER_PRIV_OTHER != "" )
				{
								$query1 = "SELECT FUNC_ID_STR from USER_PRIV where USER_PRIV in (".$USER_PRIV_OTHER.")";
								$cursor1 = exequery( $connection, $query1 );
				}
				if ( $ROW = mysql_fetch_array( $cursor1 ) )
				{
								$FUNC_STR = $ROW['FUNC_ID_STR'];
								$MY_ARRAY = explode( ",", $FUNC_STR );
								$ARRAY_COUNT = sizeof( $MY_ARRAY );
								if ( $MY_ARRAY[$ARRAY_COUNT - 1] == "" )
								{
												--$ARRAY_COUNT;
								}
								$I = 0;
								do
								{
												for ( ;	$I < $ARRAY_COUNT;	do
	{
	++$I,	} while ( 1 )	)
												{
																if ( find_id( $LOGIN_FUNC_STR, $MY_ARRAY[$I] ) )
																{
																				$LOGIN_FUNC_STR .= $MY_ARRAY[$I].",";
																}
												} while ( 1 );
								}
				}
				$query = "SELECT * from INTERFACE";
				$cursor1 = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor1 ) )
				{
								$THEME_SELECT = $ROW['THEME_SELECT'];
								$THEME = $ROW['THEME'];
								if ( $THEME_SELECT == "0" )
								{
												$LOGIN_THEME = $THEME;
								}
				}
				$LOGIN_UID = $UID;
				$LOGIN_USER_ID = $USER_ID;
				$LOGIN_BYNAME = $BYNAME;
				$LOGIN_USER_NAME = $USER_NAME;
				$LOGIN_ANOTHER = "0";
				$LOGIN_USER_PRIV_OTHER = $USER_PRIV_OTHER;
				session_register( "LOGIN_UID" );
				session_register( "LOGIN_USER_ID" );
				session_register( "LOGIN_BYNAME" );
				session_register( "LOGIN_USER_NAME" );
				session_register( "LOGIN_USER_PRIV" );
				session_register( "LOGIN_USER_PRIV_OTHER" );
				session_register( "LOGIN_DEPT_ID" );
				session_register( "LOGIN_DEPT_ID_OTHER" );
				session_register( "LOGIN_AVATAR" );
				session_register( "LOGIN_THEME" );
				session_register( "LOGIN_FUNC_STR" );
				session_register( "LOGIN_NOT_VIEW_USER" );
				session_register( "LOGIN_ANOTHER" );
				update_my_online_status( 1, 0 );
				clear_online_status( );
				if ( file_exists( $ATTACH_PATH."new_sms/".$LOGIN_UID.".sms" ) )
				{
								new_sms_remind( $LOGIN_UID, 0 );
				}
				if ( $SEC_ON_STATUS != "1" && $ON_STATUS != "1" )
				{
								$update_str .= ",ON_STATUS='1'";
				}
				$query = "update USER set LAST_VISIT_TIME='".date( "Y-m-d H:i:s" )."'".$update_str.( " where USER_ID='".$LOGIN_USER_ID."'" );
				exequery( $connection, $query );
				if ( $SEC_USER_MEM == 1 )
				{
								setcookie( "USER_NAME_COOKIE", $USERNAME, time( ) + 86400000 );
				}
				else
				{
								setcookie( "USER_NAME_COOKIE", "", time( ) + 86400000 );
				}
				setcookie( "OA_USER_ID", $LOGIN_USER_ID );
				setcookie( "SID_".$UID, dechex( crc32( session_id( ) ) ), time( ) + 86400000, "/" );
				add_log( 1, "", $LOGIN_USER_ID );
				affair_sms( );
				return "1";
}

include_once( "inc/session.php" );
$OA_USER = urldecode( $OA_USER );
if ( $OA_USER == "admin" )
{
				echo _( "该帐号无权访问" );
				exit( );
}
session_start( );
ob_start( );
if ( !session_is_registered( "LOGIN_UID" ) || !session_is_registered( "LOGIN_USER_ID" ) || $LOGIN_USER_ID != $OA_USER )
{
				include_once( "./auth.php" );
				$result = ext_login_check( $OA_USER );
				if ( $result != "1" )
				{
								echo $result;
								exit( );
				}
}
header( "P3P: CP=\"CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR\"" );
header( "location: ".$_GET['TO_URL'] );
?>
