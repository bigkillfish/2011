<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/conn.php" );
include_once( "inc/utility_all.php" );
include_once( "inc/ldap/adLDAP.php" );
$SYNC_CONFIG = get_sys_para( "DOMAIN_SYNC_CONFIG" );
$SYNC_CONFIG = unserialize( $SYNC_CONFIG['DOMAIN_SYNC_CONFIG'] );
if ( $SYNC_CONFIG['AD_USER'] == "" || $SYNC_CONFIG['AD_PWD'] == "" )
{
				echo "-ERR "._( "请设置域管理员帐号和密码" );
				exit( );
}
$dept_array = array( );
$dn_array = array( );
$query = "SELECT * from DEPT_MAP";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$dept_array[] = $ROW['DEPT_ID'];
				$guid_array[] = $ROW['DEPT_GUID'];
				$dn_array[] = $ROW['DN'];
}
if ( count( $dept_array ) <= 0 )
{
				echo "-ERR "._( "请到“部门管理”模块添加OA部门和域组织单位的映射" );
				exit( );
}
$query = "select PRIV_NAME from USER_PRIV where USER_PRIV='".$SYNC_CONFIG['USER_PRIV']."'";
$cursor = exequery( $connection, $query );
if ( mysql_num_rows( $cursor ) <= 0 )
{
				echo "-ERR "._( "请设置同步用户的默认角色" );
				exit( );
}
$USER_ID_ARRAY = array( );
$query = "select USER_ID from USER";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$USER_ID_ARRAY[] = $ROW['USER_ID'];
}
$MAP_USER_ID_ARRAY = array( );
$query = "select USER_ID from USER_MAP";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$MAP_USER_ID_ARRAY[] = $ROW['USER_ID'];
}
try
{
				$option = get_ldap_option( $SYNC_CONFIG );
				$option['ad_username'] = iconv( ini_get( "default_charset" ), "utf-8", $SYNC_CONFIG['AD_USER'] );
				$option['ad_password'] = iconv( ini_get( "default_charset" ), "utf-8", $SYNC_CONFIG['AD_PWD'] );
				$adldap = new adLDAP( $option );
				$folder_list = $adldap->folder_list( NULL, ADLDAP_FOLDER, NULL, "folder" );
				if ( $folder_list )
				{
								echo "-ERR "._( "获取组织单位列表失败：" ).$adldap->get_last_error( );
								exit( );
				}
				$value_str = "";
				$map_value_str = "";
				$org_array = get_org_array( $folder_list, $option['base_dn'] );
				$i = 0;
				do
				{
								for ( ;	$i < count( $org_array );	++$i	)
								{
												$index = array_search( $org_array[$i]['guid'], $guid_array );
												if ( $index === FALSE )
												{
																if ( $org_array[$i]['dn'] != $dn_array[$index] )
																{
																				$dn_array[$index] = $org_array[$i]['dn'];
																				$query = "update DEPT_MAP set DN='".mysql_escape_string( $dn_array[$index] )."' where DEPT_GUID='".$guid_array[$index]."'";
																				$cursor = exequery( $connection, $query );
																}
																$ou = substr( $dn_array[$index], 0, 0 - strlen( $option['base_dn'] ) );
																$ou = trim( $ou, " ," );
																$ou = iconv( ini_get( "default_charset" ), "utf-8", $ou );
																$ou_array = get_ou_array( $ou );
																$user_list = $adldap->folder_list( $ou_array, ADLDAP_FOLDER, FALSE, "user" );
																if ( is_array( $user_list ) )
																{
																				break;
																}
												}
								}
								continue;
				} while ( 0 );
				$fields = array( "objectguid", "samaccountname", "displayname", "userAccountControl", "memberof", "userprincipalname", "iscriticalsystemobject", "mail", "telephonenumber", "facsimiletelephonenumber", "mobile", "homephone", "department", "alias" );
				$j = 0;
				for ( ;	$j < $user_list['count'];	++$j	)
				{
								$user_info = $user_list[$j]['samaccountname'][0]( $user_list[$j]['samaccountname'][0], $fields );
								if ( is_array( $user_info ) )
								{
								}
								else
								{
												$user_info = $user_info[0];
												if ( $SYNC_CONFIG['DISABLED'] == "0" && ( $user_info['useraccountcontrol'][0] & 2 ) == 2 )
												{
												}
												else
												{
																continue;
												}
												$guid = bin2guid( $user_info['objectguid'][0] );
												$samaccountname = iconv( "utf-8", ini_get( "default_charset" ), strtolower( $user_info['samaccountname'][0] ) );
												$ou_array = get_ou_array( $user_info['dn'] );
												$displayname = iconv( "utf-8", ini_get( "default_charset" ), $ou_array[0] );
												$dept_id = $dept_array[$index];
												$mobile = iconv( "utf-8", ini_get( "default_charset" ), $user_info['mobile'][0] );
												$telephonenumber = iconv( "utf-8", ini_get( "default_charset" ), $user_info['telephonenumber'][0] );
												$facsimiletelephonenumber = iconv( "utf-8", ini_get( "default_charset" ), $user_info['facsimiletelephonenumber'][0] );
												$homephone = iconv( "utf-8", ini_get( "default_charset" ), $user_info['homephone'][0] );
												$mail = iconv( "utf-8", ini_get( "default_charset" ), $user_info['mail'][0] );
												$USER_NAME = $displayname == "" ? $samaccountname : $displayname;
												$USER_NAME_INDEX = getchnprefix( $USER_NAME );
												if ( in_array( $samaccountname, $USER_ID_ARRAY ) )
												{
																$query = "update USER set USER_NAME = '".$USER_NAME."',USER_NAME_INDEX='".$USER_NAME_INDEX."',DEPT_ID='".$dept_id."',NOT_LOGIN='".$SYNC_CONFIG['NOT_LOGIN']."',MOBIL_NO='".$mobile."',TEL_NO_DEPT='".$telephonenumber."',FAX_NO_DEPT='".$facsimiletelephonenumber."',TEL_NO_HOME='".$homephone."',EMAIL='".$mail.( "' where USER_ID='".$samaccountname."'" );
																exequery( $connection, $query );
												}
												else
												{
																$value_str .= "('".$samaccountname."','".$USER_NAME."','".$USER_NAME_INDEX."','".$SYNC_CONFIG['USER_PRIV']."','".$dept_id."','".$SYNC_CONFIG['NOT_LOGIN']."','".$mobile."','".$telephonenumber."','".$facsimiletelephonenumber."','".$homephone."','".$mail."','0','0','1','9','1','1','1','10'),";
												}
												if ( in_array( $samaccountname, $MAP_USER_ID_ARRAY ) )
												{
																$query = "update USER_MAP set USER_GUID='".$guid."' where USER_ID='{$samaccountname}'";
																exequery( $connection, $query );
												}
												else
												{
																$map_value_str .= "('".$samaccountname."','".$guid."'),";
												}
								}
				}
				$value_str = td_trim( $value_str );
				if ( $value_str != "" )
				{
								$query = "insert into USER (USER_ID,USER_NAME,USER_NAME_INDEX,USER_PRIV,DEPT_ID,NOT_LOGIN,MOBIL_NO,TEL_NO_DEPT,FAX_NO_DEPT,TEL_NO_HOME,EMAIL,SEX,POST_PRIV,AVATAR,THEME,CALL_SOUND,DUTY_TYPE,SMS_ON,USER_NO) values ".$value_str;
								$cursor = exequery( $connection, $query );
								if ( mysql_affected_rows( ) <= 0 )
								{
												echo "-ERR "._( "同步用户失败" );
												exit( );
								}
				}
				$map_value_str = td_trim( $map_value_str );
				if ( $map_value_str != "" )
				{
								$query = "insert into USER_MAP (USER_ID,USER_GUID) values ".$map_value_str;
								$cursor = exequery( $connection, $query );
								if ( mysql_affected_rows( ) <= 0 )
								{
												echo "-ERR "._( "增加用户映射失败" );
												exit( );
								}
				}
}
catch ( adLDAPException $e )
{
				echo "-ERR ".var_export( $e, TRUE );
				exit( );
}
echo "+OK";
?>
