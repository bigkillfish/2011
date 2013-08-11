<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "general/crm/inc/header.php" );
echo "\r\n<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\t\r\n<title>";
echo _( "图片浏览" );
echo "</title>\r\n</head>\r\n<frameset rows=\"*,30\"  cols=\"*\" frameborder=\"NO\" border=\"0\" framespacing=\"0\" id=\"frame1\">\r\n    <frame name=\"open_main\" scrolling=\"yes\" src=\"openImageMain.php?FILE_NAME=";
echo $FILE_NAME;
echo "\" frameborder=\"0\">\r\n    <frame name=\"open_control\" scrolling=\"no\" noresize src=\"openImageControl.php?FILE_NAME=";
echo $FILE_NAME;
echo "\" frameborder=\"0\">\r\n</frameset>\r\n\r\n</html>\r\n";
?>
