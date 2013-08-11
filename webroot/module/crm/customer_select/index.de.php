<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
echo "\r\n<html>\r\n<head>\r\n<title>";
echo _( "选择客户" );
echo "</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n\r\n</head>\r\n\r\n<frameset cols=\"*\"  rows=\"40,*,40\" frameborder=\"YES\" border=\"1\" framespacing=\"0\" id=\"bottom\">\r\n  <frame name=\"query\" src=\"query.php\" scrolling=\"NO\" frameborder=\"YES\">\r\n  <frame name=\"customer_info\" src=\"customer_info.php\" frameborder=\"NO\">\r\n   <frame name=\"bottom\" src=\"bottom.php\" scrolling=\"NO\" frameborder=\"YES\">\r\n </frameset>\r\n\r\n</frameset>\r\n\r\n\r\n</html>\r\n";
?>
