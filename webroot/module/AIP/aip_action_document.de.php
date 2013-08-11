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
$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
if ( $lActionType == "" )
{
				echo _( "´íÎó£ºÎ´Öª²Ù×÷£¡" );
				exit( );
}
switch ( $lActionType )
{
				case 1 :
								$query = "select print_max_count,print_cur_count from doc_recv_data where rid='".$rid."'";
								$cursor = exequery( $connection, $query );
								if ( $ROW = mysql_fetch_array( $cursor ) )
								{
												$print_max_count = $ROW['print_max_count'];
								}
								$print_cur_count = $ROW['print_cur_count'];
								if ( 0 < $print_cur_count )
								{
												echo "ok:".$print_cur_count;
								}
								else
								{
												echo "ok:0";
												return 1;
								}
				default :
								echo "ok";
}
?>
