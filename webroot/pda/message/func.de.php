<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function Ag( $device )
{
				return strpos( $_SERVER['HTTP_USER_AGENT'], $device );
}

function DeviceAgent( )
{
				$agent = strtolower( $_SERVER['HTTP_USER_AGENT'] );
				if ( strpos( $agent, "mac" ) )
				{
								return "IOS";
				}
				if ( strpos( $agent, "android" ) )
				{
								return "Android";
				}
				return "unknow";
}

function showAvatar( $avatar, $sex )
{
				return avatar_path( $avatar, $sex );
}

require_once( "inc/mb.php" );
?>
