<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "./auth.php" );
$now_date_time = date( "Y-m-d H:i:s" );
$query = "update FLOW_RUN_PRCS set ACTIVE_TIME='',PRCS_FLAG='2' where ACTIVE_TIME < '".$now_date_time."' and ACTIVE_TIME != '0000-00-00 00:00:00'";
exequery( $connection, $query );
echo "+OK";
?>
