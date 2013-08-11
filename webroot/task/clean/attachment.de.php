<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/utility_all.php" );
backup_tables( "attachment" );
$query = "delete from ATTACHMENT where DEL_FLAG=1";
exequery( $connection, $query );
$query = "optimize table ATTACHMENT";
exequery( $connection, $query );
?>
