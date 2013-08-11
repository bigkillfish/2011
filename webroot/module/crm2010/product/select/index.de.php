<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "general/crm/inc/header.php" );
$PARA_TARGET = "product_main";
$PARA_URL = "/module/crm2010/product/select/product.php";
$TYPE_URL = "/module/crm2010/product/type_list.php?PARA_TARGET=".$PARA_TARGET."&PARA_URL=".$PARA_URL;
echo "\r\n<title>";
echo _( "产品管理" );
echo "</title>\r\n<frameset rows=\"40,*\"  cols=\"*\" frameborder=\"NO\" border=\"0\" framespacing=\"0\" id=\"frame1\">\r\n    <frame name=\"product_title\" scrolling=\"no\" noresize src=\"product_title.php\" frameborder=\"NO\">\r\n    <frameset rows=\"*\"  cols=\"150,*\" frameborder=\"no\" border=\"0\" framespacing=\"0\" id=\"frame2\">\r\n       <frame name=\"type_list\" scrolling=\"auto\" noresize src=\"";
echo $TYPE_URL;
echo "\" frameborder=\"no\">\r\n       <frame name=\"product_main\" scrolling=\"auto\" src=\"";
echo $PARA_URL;
echo "\" frameborder=\"no\">\r\n    </frameset>\r\n</frameset>";
?>
