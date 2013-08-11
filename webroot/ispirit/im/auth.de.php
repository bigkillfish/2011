<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/session.php" );
session_start( );
include_once( "inc/conn.php" );
include_once( "inc/utility.php" );
ob_start( );
if ( !session_is_registered( "LOGIN_USER_ID" ) || $LOGIN_USER_ID == "" || !session_is_registered( "LOGIN_UID" ) || $LOGIN_UID == "" )
{
				sleep( 1 );
				if ( !session_is_registered( "LOGIN_USER_ID" ) || $LOGIN_USER_ID == "" || !session_is_registered( "LOGIN_UID" ) || $LOGIN_UID == "" )
				{
								echo "-ERR "._( "ÓÃ»§Î´µÇÂ½" );
								exit( );
				}
}
?>
