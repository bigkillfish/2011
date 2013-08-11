<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "../auth.php" );
include_once( "inc/utility_sms1.php" );
cancel_sms_remind( $SMS_ID );
header( "location: index.php?P=".$P );
?>
