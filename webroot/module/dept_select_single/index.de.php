<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
include_once( "inc/utility_org.php" );
if ( $TO_ID == "" || $TO_ID == "undefined" )
{
				$TO_ID = "TO_ID";
				$TO_NAME = "TO_NAME";
}
if ( $PRIV_OP == "undefined" )
{
				$PRIV_OP = "";
}
if ( $FORM_NAME == "" || $FORM_NAME == "undefined" )
{
				$FORM_NAME = "form1";
}
echo "\r\n<html>\r\n<head>\r\n<title>";
echo _( "选择部门" );
echo "</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<style>\r\n.menulines{}\r\n</style>\r\n<script type=\"text/javascript\" src=\"/inc/js/utility.js\"></script>\r\n<script Language=\"JavaScript\">\r\nvar parent_window = getOpenner();\r\n\r\nfunction click_dept(dept_id)\r\n{\r\n  targetelement=$(dept_id);\r\n  dept_name=targetelement.title;\r\n\r\n  parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value=dept_id;\r\n  parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_NAME;
echo ".value=dept_name;\r\n  window.close();\r\n}\r\n\r\nfunction borderize_on(targetelement)\r\n{\r\n color=\"#003FBF\";\r\n targetelement.style.borderColor=\"black\";\r\n targetelement.style.backgroundColor=color;\r\n targetelement.style.color=\"white\";\r\n targetelement.style.fontWeight=\"bold\";\r\n}\r\n\r\nfunction begin_set()\r\n{\r\n  TO_VAL=parent_window.";
echo $FORM_NAME;
echo ".";
echo $TO_ID;
echo ".value;\r\n\r\n  for (step_i=0; step_i<allElements.length; step_i++)\r\n  {\r\n    if(allElements[step_i].className==\"menulines\")\r\n    {\r\n       dept_id=allElements[step_i].id;\r\n       if(TO_VAL==dept_id)\r\n          borderize_on(allElements[step_i]);\r\n    }\r\n  }\r\n}\r\n</script>\r\n</head>\r\n\r\n<body topmargin=\"1\" leftmargin=\"0\" class=\"bodycolor\" onload=\"begin_set()\">\r\n\r\n";
$PRIV_NO_FLAG = $PRIV_OP;
include_once( "inc/my_priv.php" );
if ( $DEPT_ID == "" )
{
				$DEPT_ID = 0;
				$LEVEL = 0;
}
while ( list( $ID, $DEPT ) = each( &$SYS_DEPARTMENT ) )
{
				if ( $ID == $DEPT_ID )
				{
								$LEVEL = $DEPT['DEPT_LEVEL'];
				}
				if ( !isset( $LEVEL ) && $ID != $DEPT_ID )
				{
								if ( $DEPT['DEPT_LEVEL'] <= $LEVEL && $ID != $DEPT_ID )
								{
												break;
								}
								else
								{
												$DEPT_NAME = $DEPT['DEPT_NAME'];
												$DEPT_NAME = htmlspecialchars( $DEPT_NAME );
								}
								if ( is_dept_priv( $ID, $DEPT_PRIV, $DEPT_ID_STR ) )
								{
												$OPTION_TEXT .= "\r\n  <tr class=TableData>\r\n    <td class='menulines' id='".$ID."' title='".$DEPT_NAME."' onclick=javascript:click_dept('".$ID."') style='cursor:pointer'>".str_repeat( _( "　" ), $DEPT['DEPT_LEVEL'] - 1 )."├".$DEPT_NAME."</a></td>\r\n  </tr>";
								}
				}
}
if ( $OPTION_TEXT == "" )
{
				message( _( "提示" ), _( "未定义或无可管理部门" ), "blank" );
}
else
{
				echo " <table class=\"TableBlock\" width=\"95%\">\r\n";
				echo $OPTION_TEXT;
}
echo "\r\n</body>\r\n</html>\r\n";
?>
