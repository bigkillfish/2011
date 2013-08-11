<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

class uc_note
{

				public $dbconfig = "";
				public $db = "";
				public $tablepre = "";
				public $appdir = "";

				public function _serialize( $arr, $htmlon = 0 )
				{
								if ( function_exists( "xml_serialize" ) )
								{
												include_once( OA_ROOT."./inc/uc_client/lib/xml.class.php" );
								}
								return xml_serialize( $arr, $htmlon );
				}

				public function uc_note( )
				{
				}

				public function test( $get, $post )
				{
								return API_RETURN_SUCCEED;
				}

				public function synlogin( $get, $post )
				{
								if ( API_SYNLOGIN )
								{
												return API_RETURN_FORBIDDEN;
								}
				}

				public function updateclient( $get, $post )
				{
								global $_G;
								if ( API_UPDATECLIENT )
								{
												return API_RETURN_FORBIDDEN;
								}
								$cachefile = OA_ROOT."./inc/uc_client/data/cache/settings.php";
								$fp = fopen( $cachefile, "w" );
								$s = "<?php\r\n";
								$s .= "\$_CACHE['settings'] = ".var_export( $post, TRUE ).";\r\n";
								fwrite( $fp, $s );
								fclose( $fp );
								return API_RETURN_SUCCEED;
				}

}

function authcode( $string, $operation = "DECODE", $key = "", $expiry = 0 )
{
				$ckey_length = 4;
				$key = md5( $key != "" ? $key : getglobal( "authkey" ) );
				$keya = md5( substr( $key, 0, 16 ) );
				$keyb = md5( substr( $key, 16, 16 ) );
				$keyc = $ckey_length ? $operation == "DECODE" ? substr( $string, 0, $ckey_length ) : substr( md5( microtime( ) ), 0 - $ckey_length ) : "";
				$cryptkey = $keya.md5( $keya.$keyc );
				$key_length = strlen( $cryptkey );
				$string = $operation == "DECODE" ? base64_decode( substr( $string, $ckey_length ) ) : sprintf( "%010d", $expiry ? $expiry + time( ) : 0 ).substr( md5( $string.$keyb ), 0, 16 ).$string;
				$string_length = strlen( $string );
				$result = "";
				$box = range( 0, 255 );
				$rndkey = array( );
				$i = 0;
				for ( ;	$i <= 255;	++$i	)
				{
								$rndkey[$i] = ord( $cryptkey[$i % $key_length] );
				}
				$j = $i = 0;
				for ( ;	$i < 256;	++$i	)
				{
								$j = ( $j + $box[$i] + $rndkey[$i] ) % 256;
								$tmp = $box[$i];
								$box[$i] = $box[$j];
								$box[$j] = $tmp;
				}
				$a = $j = $i = 0;
				for ( ;	$i < $string_length;	++$i	)
				{
								$a = ( $a + 1 ) % 256;
								$j = ( $j + $box[$a] ) % 256;
								$tmp = $box[$a];
								$box[$a] = $box[$j];
								$box[$j] = $tmp;
								$result .= chr( ord( $string[$i] ) ^ $box[( $box[$a] + $box[$j] ) % 256] );
				}
				if ( $operation == "DECODE" )
				{
								if ( ( substr( $result, 0, 10 ) == 0 || 0 < substr( $result, 0, 10 ) - time( ) ) && substr( $result, 10, 16 ) == substr( md5( substr( $result, 26 ).$keyb ), 0, 16 ) )
								{
												return substr( $result, 26 );
								}
								return "";
				}
				return $keyc.str_replace( "=", "", base64_encode( $result ) );
}

function dsetcookie( $var, $value = "", $life = 0, $prefix = 1, $httponly = FALSE )
{
				global $_G;
				$config = $_G['config']['cookie'];
				$_G['cookie'][$var] = $value;
				$var = ( $prefix ? $config['cookiepre'] : "" ).$var;
				$_COOKIE[$var] = $var;
				if ( $value == "" || $life < 0 )
				{
								$value = "";
								$life = -1;
				}
				$life = 0 < $life ? getglobal( "timestamp" ) + $life : $life < 0 ? getglobal( "timestamp" ) - 31536000 : 0;
				$path = $httponly && PHP_VERSION < "5.2.0" ? $config['cookiepath']."; HttpOnly" : $config['cookiepath'];
				$secure = $_SERVER['SERVER_PORT'] == 443 ? 1 : 0;
				if ( PHP_VERSION < "5.2.0" )
				{
								setcookie( $var, $value, $life, $path, $config['cookiedomain'], $secure );
				}
				else
				{
								setcookie( $var, $value, $life, $path, $config['cookiedomain'], $secure, $httponly );
				}
}

define( "UC_CLIENT_VERSION", "1.5.1" );
define( "UC_CLIENT_RELEASE", "20100501" );
define( "API_DELETEUSER", 0 );
define( "API_RENAMEUSER", 0 );
define( "API_GETTAG", 0 );
define( "API_SYNLOGIN", 1 );
define( "API_SYNLOGOUT", 0 );
define( "API_UPDATEPW", 0 );
define( "API_UPDATEBADWORDS", 0 );
define( "API_UPDATEHOSTS", 0 );
define( "API_UPDATEAPPS", 0 );
define( "API_UPDATECLIENT", 1 );
define( "API_UPDATECREDIT", 0 );
define( "API_GETCREDIT", 0 );
define( "API_GETCREDITSETTINGS", 0 );
define( "API_UPDATECREDITSETTINGS", 0 );
define( "API_ADDFEED", 0 );
define( "API_RETURN_SUCCEED", "1" );
define( "API_RETURN_FAILED", "-1" );
define( "API_RETURN_FORBIDDEN", "1" );
error_reporting( 0 );
define( "OA_ROOT", substr( dirname( __FILE__ ), 0, -3 ) );
require( OA_ROOT."./inc/uc_client/config.inc.php" );
$get = $post = array( );
$code = @$_GET['code'];
parse_str( authcode( $code, "DECODE", UC_KEY ), &$get );
if ( 3600 < time( ) - $get['time'] )
{
				exit( "Authracation has expiried" );
}
if ( empty( $get ) )
{
				exit( "Invalid Request" );
}
include_once( OA_ROOT."./inc/uc_client/lib/xml.class.php" );
$post = xml_unserialize( file_get_contents( "php://input" ) );
if ( in_array( $get['action'], array( "test", "deleteuser", "renameuser", "gettag", "synlogin", "synlogout", "updatepw", "updatebadwords", "updatehosts", "updateapps", "updateclient", "updatecredit", "getcredit", "getcreditsettings", "updatecreditsettings", "addfeed" ) ) )
{
				$uc_note = new uc_note( );
				echo $uc_note->$get['action']( $get, $post );
				exit( );
}
exit( API_RETURN_FAILED );
?>
