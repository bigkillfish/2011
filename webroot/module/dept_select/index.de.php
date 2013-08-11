<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
if ( $TO_ID == "" || $TO_ID == "undefined" )
{
				$TO_ID = "TO_ID";
				$TO_NAME = "TO_NAME";
}
if ( $FORM_NAME == "" || $FORM_NAME == "undefined" )
{
				$FORM_NAME = "form1";
}
if ( $PRIV_OP == "undefined" )
{
				$PRIV_OP = "";
}
if ( $MODULE_ID == "undefined" )
{
				$MODULE_ID = "";
}
echo "\r\n<html>\r\n<head>\r\n<title>";
echo $PRIV_OP != "" ? _( "选择管理范围内的部门" ) : _( "选择部门" );
echo "</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n\r\n</head>\r\n\r\n<frameset rows=\"*,30\"  rows=\"*\" frameborder=\"NO\" border=\"1\" framespacing=\"0\" id=\"bottom\">\r\n  <frameset cols=\"180,*\"  rows=\"*\" frameborder=\"YES\" border=\"1\" framespacing=\"0\" id=\"bottom\">\r\n     <frame name=\"dept\" src=\"dept.php?MODULE_ID=";
echo $MODULE_ID;
echo "&TO_ID=";
echo $TO_ID;
echo "&TO_NAME=";
echo $TO_NAME;
echo "&PRIV_OP=";
echo $PRIV_OP;
echo "&FORM_NAME=";
echo $FORM_NAME;
echo "\">\r\n     <frame name=\"dept_list\" src=\"dept_list.php?MODULE_ID=";
echo $MODULE_ID;
echo "&TO_ID=";
echo $TO_ID;
echo "&TO_NAME=";
echo $TO_NAME;
echo "&PRIV_OP=";
echo $PRIV_OP;
echo "&FORM_NAME=";
echo $FORM_NAME;
echo "\">\r\n  </frameset>\r\n  <frame name=\"control\" scrolling=\"no\" src=\"control.php\">\r\n</frameset>";
?>
