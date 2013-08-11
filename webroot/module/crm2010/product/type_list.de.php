<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "general/crm/inc/header.php" );
echo "\r\n<ul>\r\n   <li><a href=\"javascript:;\" target=\"";
echo $TARGET;
echo "\" title=\"";
echo _( "产品分类" );
echo "\" id=\"link_1\" class=\"active\"><span>";
echo _( "产品分类" );
echo "</span></a></li>\r\n   <div>\r\n   ";
if ( !isset( $xtree ) || $xtree == "" )
{
				$xtree = "./type_tree.php?PARENT_ID=-1&PARA_TARGET=".$PARA_TARGET."&PARA_URL={$PARA_URL}";
}
echo "   <link rel=\"stylesheet\" type=\"text/css\" href=\"/images/org/ui.dynatree.css\">\r\n   <script type=\"text/javascript\" src=\"/inc/js_lang.php\"></script>\r\n<script type=\"text/javascript\" src=\"/inc/js/tree.js\"></script>\r\n   <div id=\"tree\"></div>\r\n   <script language=\"javascript\" type=\"text/javascript\">\r\n   var tree = new Tree(\"tree\", \"";
echo $xtree;
echo "\");\r\n   tree.BuildTree();\r\n   </script>\r\n   </div>\r\n</ul>\r\n\r\n";
?>
