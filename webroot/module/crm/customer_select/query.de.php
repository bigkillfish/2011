<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
echo "\r\n<html>\r\n<head>\r\n<title></title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n</head>\r\n\r\n<body bgcolor=\"#E8E8E8\" topmargin=\"5\">\r\n\r\n<center>\r\n\r\n <form method=\"post\" action=\"customer_info.php\" target=\"customer_info\" name=\"form1\">\r\n  ";
echo _( "客户名称：" );
echo "  <input type=\"text\" name=\"CUSTOMER_NAME\" size=\"10\" class=\"BigInput\">\r\n  <input type=\"submit\" name=\"Submit\" value=\"";
echo _( "模糊查询" );
echo "\" class=\"BigButton\">\r\n  <input type=\"hidden\" name=\"CUSTOMER_ID\" value=\"";
echo $CUSTOMER_ID;
echo "\">\r\n </form>\r\n</center>\r\n\r\n</body>\r\n</html>\r\n";
?>
