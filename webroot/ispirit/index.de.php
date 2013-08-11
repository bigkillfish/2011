<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
echo "<html>\r\n<head>\r\n<title>";
echo _( "OA精灵" );
echo "</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n</head>\r\n<script>\r\nvar bIMLogin = false;\r\nfunction ispirit_js(op_str)\r\n{\r\n   if(op_str==\"show_sms\")\r\n   {\r\n      if(arguments.length > 1)\r\n         frames['status_bar'].show_sms(arguments[1]);\r\n   }\r\n   else if(op_str==\"sms_mon\")\r\n   {\r\n      frames['status_bar'].sms_mon();\r\n   }\r\n   else if(op_str==\"set_sms_ref\")\r\n   {\r\n      bIMLogin = true;\r\n      frames['status_bar'].set_sms_ref();\r\n   }\r\n   else if(op_str==\"set_no_sms\")\r\n   {\r\n      frames['status_bar'].set_no_sms();\r\n   }\r\n   else if(op_str==\"update_org\")\r\n   {\r\n      frames['ipanel'].ispirit_update_org();\r\n   }\r\n   else if(op_str==\"new_msg_remind\")\r\n   {\r\n      var ipanel_org = frames['ipanel'].frames['org'];\r\n      if(arguments.length > 1 && ipanel_org && typeof(ipanel_org.ispirit_new_msg_remind) == 'function')\r\n         ipanel_org.ispirit_new_msg_remind(arguments[1]);\r\n   }\r\n   else if(op_str==\"cancel_msg_remind\")\r\n   {\r\n      var ipanel_org = frames['ipanel'].frames['org'];\r\n      if(arguments.length > 1 && ipanel_org && typeof(ipanel_org.ispirit_cancel_msg_remind) == 'function')\r\n         ipanel_org.ispirit_cancel_msg_remind(arguments[1]);\r\n   }\r\n   else if(op_str==\"send_email\")\r\n   {\r\n      if(arguments.length >= 3)\r\n         frames['ipanel'].send_email1(arguments[1], arguments[2])\r\n   }\r\n   else if(op_str==\"weixun_share\")\r\n   {\r\n\t   if(arguments.length > 2 && frames['ipanel'].frames['blank'])\r\n         frames['ipanel'].frames['blank'].location = '/general/ipanel/ispirit_api.php?API=weixun_share&SHARE_FLAG=' + arguments[2] + '&CONTENT=' + escape(arguments[1]);\r\n   }\r\n   else if(op_str==\"on_status\")\r\n   {\r\n\t   if(arguments.length > 1 && frames['ipanel'].frames['blank'])\r\n         frames['ipanel'].frames['blank'].location = '/general/ipanel/ispirit_api.php?API=on_status&CONTENT=' + escape(arguments[1]);\r\n   }\r\n   else if(op_str==\"show_im_panel\")\r\n   {\r\n      frames['ipanel'].view_menu(2);\r\n   }\r\n}\r\n</script>\r\n\r\n<frameset rows=\"*,20\"  cols=\"*\" frameborder=\"NO\" border=\"0\" framespacing=\"0\" id=\"frame0\">\r\n    <frame name=\"ipanel\" scrolling=\"no\" noresize src=\"/general/ipanel?ISPIRIT=1&I_VER=";
echo $I_VER;
echo "\" frameborder=\"0\">\r\n    <frame name=\"status_bar\" scrolling=\"no\" noresize src=\"status_bar.php?I_VER=";
echo $I_VER;
echo "\" frameborder=\"0\">\r\n</frameset><noframes></noframes>\r\n\r\n</html>\r\n";
?>
