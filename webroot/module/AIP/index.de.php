<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
if ( $OP == 4 )
{
				$IE_TITLE = _( "在线编辑" );
}
else
{
				$IE_TITLE = _( "在线阅读" );
}
echo "<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" />\r\n<title>";
echo $ATTACHMENT_NAME;
echo " - ";
echo $IE_TITLE;
echo "</title>\r\n<script type=\"text/javascript\" src=\"/inc/js_lang.php\"></script>\r\n<script type=\"text/javascript\" src=\"/inc/js/jquery/jquery.min.js\"></script>\r\n<script type=\"text/javascript\" src=\"/module/AIP/aip.js\"></script>\r\n<style>\r\nbody {\r\n\toverflow: hidden; margin; 0 px;\r\n\tpadding: 0px;\r\n}\r\n#content {\r\n\tbackground: #ffffff;\r\n\tborder-left: 1px #cccccc solid;\r\n\tborder-right: 1px #cccccc solid;\r\n\toverflow: hidden;\r\n\tclear: both;\r\n}\r\n</style>\r\n<script>\r\nvar is_build = false;\r\nvar oAIP;\r\njQuery.noConflict();\r\n(function($) {\r\n        $(\"aip\").css(\"display\",\"block\");\r\n\t$(document).ready(function(){\r\n\t    window.onresize=setBody;\r\n\r\n\t});\t\t\r\n})(jQuery)\r\n\r\nfunction setBody()\r\n{\r\n    var height = jQuery(window).height() - jQuery('#content').offset().top - jQuery(\"#footer\").height();\r\n    jQuery('#content').height(height);\r\n    jQuery('#aip').height(jQuery('#content').height());\r\n}\r\nfunction build_aip()\r\n{\r\n    var url = \"http://";
echo $_SERVER['HTTP_HOST'];
echo "/module/AIP/get_file.php?MODULE=";
echo $MODULE;
echo "&ATTACHMENT_ID=";
echo $YM;
echo "_";
echo $ATTACHMENT_ID;
echo "&ATTACHMENT_NAME=";
echo urlencode( $ATTACHMENT_NAME );
echo "\";\r\n    para = {\r\n        id : '0',\r\n        fileURL : url ,\r\n        convert : 0\r\n    };\r\n    oAIP = new AIP('aip',para);\r\n    oAIP.aip.focus();\r\n    is_build = true;\r\n}\r\n\r\nfunction NotifyCtrlReady()\r\n{\r\n    oAIP.OnCtrlReady();\r\n\r\n}\r\nif(!is_build)\r\n{\r\n    setTimeout(build_aip,1);\r\n}\r\n</script>\r\n<script language=\"javascript\" for=\"AIP_0\" event=\"NotifyCtrlReady\">\r\nsetTimeout(NotifyCtrlReady,1);\r\n</script>\r\n</head>\r\n<body class=\"bodycolor\">\r\n<div id=\"content\">\r\n    <div id=\"aip\">\r\n\t</div>\r\n</div>\r\n<table id=\"footer\" class=\"BlockBottom2\"><tr><td class=\"left\"></td><td class=\"center\"></td><td class=\"right\"></td></tr></table>\r\n\r\n<input type=\"hidden\" name=\"AID\" value=\"";
echo $AID;
echo "\">\r\n<input type=\"hidden\" name=\"MODULE\" value=\"";
echo $MODULE;
echo "\">\r\n<input type=\"hidden\" name=\"YM\" value=\"";
echo $YM;
echo "\">\r\n<input type=\"hidden\" name=\"ATTACHMENT_ID\" value=\"";
echo $ATTACHMENT_ID;
echo "\">\r\n<input type=\"hidden\" name=\"ATTACHMENT_NAME\" value=\"";
echo $ATTACHMENT_NAME;
echo "\">\r\n</body>\r\n</html>";
?>
