<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "general/crm/inc/header.php" );
include_once( "inc/utility_org.php" );
include_once( "general/crm/utils/edview/edview.interface.php" );
include_once( $CRM_CONTEXT_PATH_REL."/utils/priv/op.priv.php" );
echo "<head>\r\n<title>";
echo _( "记录共享" );
echo "</title>\r\n<script src=\"/inc/js/module.js\"></script>\r\n<script>\r\n\tfunction validate(){\r\n\t\tif(document.getElementById('TO_ID').value==\"\" && document.getElementById('COPY_TO_ID').value==\"\" && document.getElementById('PRIV_ID').value==\"\"){\r\n\t\t\talert('";
echo _( "请至少填写一个值" );
echo "');\r\n\t\t\treturn false;\r\n\t\t}\r\n\t\tdocument.form1.submit();\r\n\t}\r\n</script>\r\n</head>\r\n<iframe name=\"FORMSUBMIT\" width=\"0\" height=\"0\" ></iframe>\r\n<form target=\"FORMSUBMIT\" name=\"form1\" method=\"post\" action=\"update.php\">\r\n\r\n";
checkoppriv( $MODULE, "010" );
printsharefield( $to_id, $to_name, $copy_to_id, $user_name, $priv_id, $priv_name );
echo "<table width=\"100%\">\r\n<tr>\r\n<td align='center'>\r\n<input type=\"hidden\" name=\"ids\" value=\"";
echo $ids;
echo "\">\r\n<input type=\"hidden\" name=\"MODULE\" value=\"";
echo $MODULE;
echo "\">\r\n<input type=\"button\" value=\" ";
echo _( "保存" );
echo "\" class=\"crm_SmallButton\" onclick='validate()'/>\r\n<input type=\"button\" value=\" ";
echo _( "关闭" );
echo "\" class=\"crm_SmallButton\" onClick=\"window.close()\"/>\r\n</td>\r\n</tr>\r\n</table>\r\n</form>";
?>
