<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/conn.php" );
$USERNAME = $_GET['USERNAME'];
$query = "SELECT SECURE_KEY_SN from USER where USER_ID='".$USERNAME."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$SECURE_KEY_SN = $ROW['SECURE_KEY_SN'];
				if ( $SECURE_KEY_SN != "" )
				{
								echo "1";
				}
				else
				{
								echo "0";
				}
}
else
{
				echo _( "无此用户" );
}
?>
