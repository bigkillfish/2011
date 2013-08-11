<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
echo "<html>\r\n<head>\r\n<title>";
echo _( "选择人员" );
echo "</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n\r\n</head>\r\n\r\n<frameset rows=\"*,30\"  rows=\"*\" frameborder=\"NO\" border=\"1\" framespacing=\"0\" id=\"bottom\">\r\n   <frameset cols=\"155,*\"  rows=\"*\" frameborder=\"YES\" border=\"1\" framespacing=\"0\" id=\"bottom\">\r\n      <frame name=\"dept\" src=\"dept.php?FIELD=";
echo $FIELD;
echo "&TO_ID=";
echo $TO_ID;
echo "&TO_NAME=";
echo $TO_NAME;
echo "&TO_COMPANY=";
echo $TO_COMPANY;
echo "\">\r\n      <frame name=\"user\" src=\"blank.php\">\r\n   </frameset>\r\n   <frame name=\"control\" scrolling=\"no\" src=\"control.php\">\r\n</frameset>";
?>
