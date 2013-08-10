<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

class ESBMessage
{

				private function __retMsg( $retCode )
				{
								switch ( $retCode )
								{
												case 0 :
																$retDesc = "成功";
																break;
												case -1 :
																$retDesc = "参数错误";
																break;
												case -2 :
																$retDesc = "数据包不存在";
																break;
												case -3 :
																$retDesc = "GUID不存在";
																break;
												case -4 :
																$retDesc = "写入数据库失败";
								}
								$retMsg = "{\"retCode\":".$retCode.",\"retMsg\":\"".$retDesc."\"}";
								return iconv( ini_get( "default_charset" ), "utf-8", $retMsg );
				}

				public function recvMessage( $filePath, $guid, $from )
				{
								global $connection;
								if ( empty( $from ) || empty( $guid ) || empty( $filePath ) )
								{
												return $this->__retMsg( -1 );
								}
								if ( file_exists( $filePath ) )
								{
												return $this->__retMsg( -2 );
								}
								$zip = zip_open( $filePath );
								if ( $zip )
								{
												do
												{
																if ( $zip_entry = zip_read( $zip ) )
																{
																				$fileName = basename( zip_entry_name( $zip_entry ) );
																}
												} while ( !( strcasecmp( $fileName, "data.xml" ) == 0 ) || !zip_entry_open( $zip, $zip_entry, "r" ) );
												$xml = zip_entry_read( $zip_entry, zip_entry_filesize( $zip_entry ) );
												zip_entry_close( $zip_entry );
												$dom = new DOMDocument( );
												$dom->loadXML( $xml );
												$module = $dom->getElementsByTagName( "MODULE" )->item( 0 )->nodeValue;
												$title = $dom->getElementsByTagName( "TITLE" )->item( 0 )->nodeValue;
												$title = iconv( "utf-8", ini_get( "default_charset" ), $title );
												$summary = serialize( array( "module" => $module, "title" => $title ) );
												$recv_time = time( );
												$filePath = mysql_real_escape_string( $filePath );
												$sql = "insert into `ESB_MSG_RECV` (GUID,FROM_DEPT,PATH,RECV_TIME,SUMMARY) values ('".$guid."', '{$from}', '{$filePath}', '{$recv_time}', '{$summary}')";
												exequery( $connection, $sql );
												if ( mysql_affected_rows( ) )
												{
																return $this->__retMsg( -4 );
												}
												zip_close( $zip );
								}
								if ( isset( $module ) )
								{
												$moduleHandlerName = ucfirst( $module )."Handler";
												if ( file_exists( HANDLER_CLASSPATH.$moduleHandlerName.".php" ) )
												{
																include( HANDLER_CLASSPATH.$moduleHandlerName.".php" );
																$handler = new ReflectionClass( $moduleHandlerName );
																if ( $handler->isInstantiable( ) )
																{
																				$handlerInstance = $handler->newInstance( $filePath, $from, $guid );
																				$handlerInstance->run( );
																}
												}
								}
								return $this->__retMsg( 0 );
				}

				public function updateState( $guid, $state, $to = "" )
				{
								global $connection;
								if ( empty( $guid ) || !is_numeric( $state ) )
								{
												return $this->__retMsg( -1 );
								}
								if ( $to != "" )
								{
												$sql = "select TO_DEPT,STATE from `ESB_MSG_SEND` where GUID = '".$guid."'";
												$cursur = exequery( $connection, $sql );
												if ( $row = mysql_fetch_array( $cursor ) )
												{
																$state_array = array( );
																$to_dept = $row['TO_DEPT'];
																$state = $row['STATE'];
																if ( $state != "" )
																{
																				$state_array = unserialize( $state );
																}
																$state_array["{$to}"] = $state;
																if ( find_id( $to_dept, $to ) )
																{
																				$to_dept .= $to.",";
																}
																$state = serialize( $state_array );
												}
								}
								$sql = "update `ESB_MSG_SEND` set STATE = '".$state."'";
								if ( $to_dept != "" )
								{
												$sql .= ", TO_DEPT ='".$to_dept."'";
								}
								$sql .= " where GUID = '".$guid."'";
								exequery( $connection, $sql );
								return $this->__retMsg( 0 );
				}

}

include_once( "inc/conn.php" );
include_once( "inc/utility.php" );
define( "HANDLER_CLASSPATH", $ROOT_PATH."inc/ESB/handlers/" );
?>
