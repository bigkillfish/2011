<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "general/crm/inc/header.php" );
$MODULE = "product";
$MODULE_NAME = _( "选择产品" );
$MODULE_TITLE = _( "产品管理" );
echo "<body style=\"padding:0pt 2pt;margin:0pt 2pt\">\r\n<div class='small' width=\"100%\">\r\n<img src='";
echo $CRM_CONTEXT_IMG_PATH;
echo "/module_icon/small/";
echo $MODULE;
echo ".png' align=\"absMiddle\"/><span class=\"crm_big20_bold\">";
echo $MODULE_NAME;
echo "</span>\r\n</div>\r\n</body>";
?>
