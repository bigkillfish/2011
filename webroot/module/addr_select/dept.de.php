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
echo "\r\n<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<title></title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"/theme/";
echo $LOGIN_THEME;
echo "/style.css\" />\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"/theme/";
echo $LOGIN_THEME;
echo "/menu_left.css\" />\r\n<script src=\"/inc/js/hover_tr.js\"></script>\r\n<script language=\"JavaScript\">\r\nvar $ = function(id) {return document.getElementById(id);};\r\nvar CUR_ID=\"1\";\r\nfunction clickMenu(ID)\r\n{\r\n    var el=$(\"module_\"+CUR_ID);\r\n    var link=$(\"link_\"+CUR_ID);\r\n    if(ID==CUR_ID)\r\n    {\r\n       if(el.style.display==\"none\")\r\n       {\r\n           el.style.display='';\r\n           link.className=\"active\";\r\n       }\r\n       else\r\n       {\r\n           el.style.display=\"none\";\r\n           link.className=\"\";\r\n       }\r\n    }\r\n    else\r\n    {\r\n       el.style.display=\"none\";\r\n       link.className=\"\";\r\n       $(\"module_\"+ID).style.display=\"\";\r\n       $(\"link_\"+ID).className=\"active\";\r\n    }\r\n\r\n    CUR_ID=ID;\r\n}\r\nvar ctroltime=null,key=\"\";\r\nfunction CheckSend()\r\n{\r\n\tvar kword=$(\"kword\");\r\n\tif(kword.value==\"按个人信息搜索...\")\r\n\t   kword.value=\"\";\r\n  if(kword.value==\"\" && $('search_icon').src.indexOf(\"/images/quicksearch.gif\")==-1)\r\n\t{\r\n\t   $('search_icon').src=\"/images/quicksearch.gif\";\r\n\t}\r\n\tif(key!=kword.value && kword.value!=\"\")\r\n\t{\r\n     key=kword.value;\r\n\t   parent.user.location=\"query.php?FIELD=";
echo $FIELD;
echo "&TO_ID=";
echo $TO_ID;
echo "&GROUP_ID_STR=\"+$(\"GROUP_ID_STR\").value+\"&KWORD=\"+kword.value;\r\n\t   if($('search_icon').src.indexOf(\"/images/quicksearch.gif\")>=0)\r\n\t   {\r\n\t   \t   $('search_icon').src=\"/images/closesearch.gif\";\r\n\t   \t   $('search_icon').title=\"清除关键字\";\r\n\t   \t   $('search_icon').onclick=function(){kword.value='按个人信息搜索...';$('search_icon').src=\"/images/quicksearch.gif\";$('search_icon').title=\"\";$('search_icon').onclick=null;};\r\n\t   }\r\n  }\r\n  ctroltime=setTimeout(CheckSend,100);\r\n}\r\n</script>\r\n</head>\r\n\r\n<body class=\"bodycolor\"  topmargin=\"1\" leftmargin=\"0\">\r\n<div style=\"border:1px solid #000000;margin-left:2px;background:#FFFFFF;\">\r\n  <input type=\"text\" id=\"kword\" name=\"kword\" value=\"按个人信息搜索...\" onfocus=\"ctroltime=setTimeout(CheckSend,100);\" onblur=\"clearTimeout(ctroltime);if(this.value=='')this.value='按个人信息搜索...';\" class=\"SmallInput\" style=\"border:0px; color:#A0A0A0;width:100px;\"><img id=\"search_icon\" src=\"/images/quicksearch.gif\" align=absmiddle style=\"cursor:pointer;\">\r\n</div>\r\n<ul>\r\n";
$GROUP_ID_STR = "";
if ( find_id( $LOGIN_FUNC_STR, "10" ) )
{
				echo "  <li><a href=\"javascript:clickMenu('1');\" id=\"link_1\" class=\"active\" title=\"点击伸缩列表\"><span>个人通讯簿</span></a></li>\r\n  <div id=\"module_1\" class=\"moduleContainer\">\r\n    <table class=\"TableBlock trHover\" width=\"100%\" align=\"center\">\r\n      <tr class=\"TableData\">\r\n        <td align=\"center\" onclick=\"parent.user.location='user.php?GROUP_ID=0&USER_ID=";
				echo $LOGIN_USER_ID;
				echo "&FIELD=";
				echo $FIELD;
				echo "&TO_ID=";
				echo $TO_ID;
				echo "'\" style=\"cursor:pointer\">默认</td>\r\n      </tr>\r\n";
				$query = "SELECT * from ADDRESS_GROUP where USER_ID='".$LOGIN_USER_ID."' order by GROUP_NAME";
				$cursor = exequery( $connection, $query );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$GROUP_ID = $ROW['GROUP_ID'];
								$GROUP_NAME = $ROW['GROUP_NAME'];
								$GROUP_ID_STR .= $GROUP_ID.",";
								echo "      <tr class=\"TableData\">\r\n        <td align=\"center\" onclick=\"parent.user.location='user.php?GROUP_ID=";
								echo $GROUP_ID;
								echo "&USER_ID=";
								echo $LOGIN_USER_ID;
								echo "&FIELD=";
								echo $FIELD;
								echo "&TO_ID=";
								echo $TO_ID;
								echo "'\" style=\"cursor:pointer\">";
								echo $GROUP_NAME;
								echo "</td>\r\n      </tr>\r\n";
				}
				echo "    </table>\r\n  </div>\r\n";
}
if ( find_id( $LOGIN_FUNC_STR, "106" ) )
{
				echo "  <li><a href=\"javascript:clickMenu('2');\" id=\"link_2\" class=\"\" title=\"点击伸缩列表\"><span>公共通讯簿</span></a></li>\r\n  <div id=\"module_2\" class=\"moduleContainer\" style=\"display:none;\">\r\n    <table class=\"TableBlock trHover\" width=\"100%\" align=\"center\">\r\n      <tr class=\"TableData\">\r\n    <td align=\"center\" onclick=\"parent.user.location='user.php?GROUP_ID=0&FIELD=";
				echo $FIELD;
				echo "&TO_ID=";
				echo $TO_ID;
				echo "'\" style=\"cursor:pointer\">默认</td>\r\n  </tr>\r\n";
				$query = "SELECT * from ADDRESS_GROUP where USER_ID='' order by GROUP_NAME";
				$cursor = exequery( $connection, $query );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$GROUP_ID = $ROW['GROUP_ID'];
								$GROUP_NAME = $ROW['GROUP_NAME'];
								$PRIV_DEPT = $ROW['PRIV_DEPT'];
								$PRIV_ROLE = $ROW['PRIV_ROLE'];
								$PRIV_USER = $ROW['PRIV_USER'];
								if ( $PRIV_DEPT != "ALL_DEPT" && !find_id( $PRIV_DEPT, $LOGIN_DEPT_ID ) && !find_id( $PRIV_ROLE, $LOGIN_USER_PRIV ) && !find_id( $PRIV_USER, $LOGIN_USER_ID ) )
								{
								}
								else
								{
												$GROUP_ID_STR .= $GROUP_ID.",";
												echo "      <tr class=\"TableData\">\r\n        <td align=\"center\" onclick=\"parent.user.location='user.php?GROUP_ID=";
												echo $GROUP_ID;
												echo "&FIELD=";
												echo $FIELD;
												echo "&TO_ID=";
												echo $TO_ID;
												echo "'\" style=\"cursor:pointer\">";
												echo $GROUP_NAME;
												echo "</td>\r\n      </tr>\r\n";
								}
				}
				echo "    </table>\r\n  </div>\r\n";
}
echo "  <li><a href=\"query_user_cond.php?FIELD=";
echo $FIELD;
echo "&TO_ID=";
echo $TO_ID;
echo "\" id=\"link_3\" class=\"\" title=\"点击伸缩列表\" target=\"user\"><span>OA用户查询</span></a></li>\r\n</ul>\r\n<input type=\"hidden\" id=\"GROUP_ID_STR\" value=\"";
echo $GROUP_ID_STR;
echo "\">\r\n</body>\r\n</html>\r\n";
?>
