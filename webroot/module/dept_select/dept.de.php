<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
ob_end_clean( );
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<title></title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"/theme/";
echo $LOGIN_THEME;
echo "/style.css\" />\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"/theme/";
echo $LOGIN_THEME;
echo "/menu_left.css\" />\r\n</head>\r\n<body topmargin=\"1\" leftmargin=\"0\">\r\n<div class=\"moduleContainer treeList\">\r\n";
if ( $TO_ID == "" || $TO_ID == "undefined" )
{
				$TO_ID = "TO_ID";
				$TO_NAME = "TO_NAME";
}
$PARA_URL = "dept_list.php";
$PARA_TARGET = "dept_list";
$PARA_ID = "PRIV_OP";
$PARA_VALUE = $PRIV_OP.( ".TO_ID=".$TO_ID.".TO_NAME={$TO_NAME}" );
$PRIV_NO_FLAG = $PRIV_OP;
$xname = "dept_select";
$showButton = 1;
include_once( "inc/dept_list/index.php" );
echo "</div>\r\n<script>\r\nfunction click_node(id,checked)\r\n{\r\n   id = id.substr(5);\r\n\tparent.";
echo $PARA_TARGET;
echo ".location=\"dept_list.php?MODULE_ID=";
echo $MODULE_ID;
echo "&DEPT_ID=\"+id+\"&CHECKED=\"+checked+\"&TO_ID=";
echo $TO_ID;
echo "&TO_NAME=";
echo $TO_NAME;
echo "&FORM_NAME=";
echo $FORM_NAME;
echo "&MANAGE_FLAG=";
echo $MANAGE_FLAG;
echo "&USE_UID=";
echo $USE_UID;
echo "&FORM_NAME=";
echo $FORM_NAME;
echo "\";\r\n}\r\n</script>\r\n</body>\r\n</html>\r\n";
?>
