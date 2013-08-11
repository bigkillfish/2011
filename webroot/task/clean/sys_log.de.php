<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/utility_all.php" );
$query = "select count(*) from SYS_LOG";
$cursor = exequery( $connection, $query );
if ( ( $ROW = mysql_fetch_array( $cursor ) ) && 100000 < $ROW[0] )
{
				$RESULT = copy_table( "SYS_LOG", "SYS_LOG_".date( "Ymd" ), TRUE, TRUE );
				if ( $RESULT !== TRUE )
				{
								echo $RESULT;
				}
}
?>
