<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( !( $P_VER == "5" ) && !( $P_VER == "6" ) )
{
				$VALUE = each( &$_GET )[1];
				$KEY = each( &$_GET )[0];
				while ( each( &$_GET ) )
				{
								$$KEY = iconv( "utf-8", ini_get( "default_charset" ), $VALUE );
				}
				$VALUE = each( &$_POST )[1];
				$KEY = each( &$_POST )[0];
				while ( each( &$_POST ) )
				{
								$$KEY = iconv( "utf-8", ini_get( "default_charset" ), $VALUE );
				}
}
include_once( "inc/conn.php" );
include_once( "inc/td_core.php" );
$CLIENT = 0 < intval( $P_VER ) ? intval( $P_VER ) : 1;
$LOGIN_MSG = login_check( $USERNAME, $PASSWORD, "", "", "", $CLIENT );
if ( $LOGIN_MSG != "1" )
{
				if ( $P_VER == "6" )
				{
								echo "<script type=\"text/javascript\">\r\nif(typeof(window.Android) != 'undefined' && typeof(window.Android.loginerror) == 'function')\r\n   window.Android.loginerror();\r\n</script>\r\n";
								exit( );
				}
				header( "location: index.php?ERROR_NO=1&P_VER=".$P_VER );
				exit( );
}
$query = "SELECT IE_TITLE from INTERFACE";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$_SESSION['LOGIN_IE_TITLE'] = $ROW['IE_TITLE'];
}
$P = $LOGIN_UID.";".session_id( ).";".$P_VER;
header( "location: /pda/frames.php?P=".$P."&LOGIN_OK" );
?>
