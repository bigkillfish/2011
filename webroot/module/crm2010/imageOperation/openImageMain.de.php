<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
echo "<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<title>";
echo _( "图片浏览" );
echo "</title>\r\n</head>\r\n<body>\r\n<div align=center>\t\r\n<table border=\"0\" topmargin=0 cellpadding=0 cellspacing=0 \">\r\n<tr align=\"center\" valign=\"center\">\r\n\t<td align=\"center\" valign=\"center\">\r\n    <img src=\"";
echo $FILE_NAME;
echo "\" alt=\"";
echo _( "鼠标滚轮缩放，点击图片翻页" );
echo "\" border=0  id=\"image\">\r\n  </td>\r\n</tr>\r\n</table>\r\n</div>\r\n</body>\r\n</html>";
?>
