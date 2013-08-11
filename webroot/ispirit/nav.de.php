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
echo _( "OA精灵导航" );
echo "</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n</head>\r\n<script>\r\nfunction openURL(URL)\r\n{\r\n   main.location=URL;\r\n}\r\nfunction SetTitle()\r\n{\r\n   if(typeof(window.external.OA_SMS) == 'undefined' || typeof(main.document) != 'object' || !main.document.title)\r\n      return;\r\n   \r\n   document.title = main.document.title;\r\n   window.external.OA_SMS(document.title, \"\", \"NAV_TITLE\");\r\n}\r\nfunction SetSize(width, height)\r\n{\r\n   if(typeof(window.external.OA_SMS) == 'undefined')\r\n      return;\r\n   \r\n   window.external.OA_SMS(width, height, \"SET_SIZE\");\r\n}\r\nfunction SetMax(width, height)\r\n{\r\n   if(typeof(window.external.OA_SMS) == 'undefined')\r\n      return;\r\n   \r\n   window.external.OA_SMS(\"\", \"\", \"SET_MAX\");\r\n}\r\n</script>\r\n<frameset rows=\"30,*\"  cols=\"*\" frameborder=\"0\" border=\"0\" framespacing=\"0\">\r\n    <frame id=\"shortcut\" name=\"shortcut\" scrolling=\"no\" noresize src=\"../general/shortcut.php?I_VER=2\" frameborder=\"0\">\r\n    <frame id=\"main\" name=\"main\" scrolling=\"auto\" noresize src=\"";
echo $_GET['URL'];
echo "\" frameborder=\"0\" onload=\"SetTitle()\">\r\n</frameset>\r\n</html>\r\n\r\n\r\n";
?>
