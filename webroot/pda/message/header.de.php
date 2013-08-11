<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

require_once( "inc/auth.php" );
ob_clean( );
require_once( "config.php" );
require_once( "func.php" );
echo "<!DOCTYPE html>\r\n<html>\r\n<head>\r\n\t<meta charset=\"";
echo $MYOA_CHARSET;
echo "\">\r\n\t<meta name=\"viewport\" content=\"width=device-width, minimum-scale=1, maximum-scale=1\">\r\n\t<title></title>\r\n\t<link rel=\"stylesheet\"  href=\"../style/jquery.mobile-1.0rc2.min.css.gz\" />\r\n\t<link rel=\"stylesheet\"  href=\"../style/message.css\" />\r\n   <script type=\"text/javascript\" src=\"/inc/js_lang.php\"></script>\r\n\t<script type=\"text/javascript\" src=\"../js/jquery-1.6.1.min.js.gz\"></script>\r\n\t<script type=\"text/javascript\" src=\"../js/jquery.mobile.min.js.gz\"></script>\r\n\t<script type=\"text/javascript\" src=\"../js/message.js\"></script>\r\n</head>\r\n<script>\r\nvar monInterval = {MSG_LIST_REF_SEC:";
echo $C['MSG_LIST_REF_SEC'];
echo ", MSG_DIOG_REF_SEC:";
echo $C['MSG_DIOG_REF_SEC'];
echo "};\r\nvar loginUser = {uid:";
echo $LOGIN_UID;
echo ", user_id:\"";
echo str_replace( "\"", "\\\"", $LOGIN_USER_ID );
echo "\", user_name:\"";
echo str_replace( "\"", "\\\"", $LOGIN_USER_NAME );
echo "\"};\r\n</script>";
?>
