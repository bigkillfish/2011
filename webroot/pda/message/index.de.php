<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

require_once( "header.php" );
require_once( "user.php" );
require_once( "inc/utility_all.php" );
require_once( "inc/department.php" );
if ( ag( "iPad" ) )
{
				$fix_for_pad = $C['optimizeiPad'];
}
echo "<script type=\"text/javascript\">\r\n\r\nfunction msg_mon(){\r\n\t$.ajax({\r\n      type: 'GET',\r\n      url: '/attachment/new_sms/' + loginUser.uid + '.sms',\r\n      data: {'now': new Date().getTime()},\r\n      success: function(data){\r\n   \t\tif(data==\"01\" || data==\"11\"){\r\n   \t\t\t$.ajax({\r\n\t\t\t\t\ttype: \"GET\",\r\n\t\t\t\t\turl: \"action.php\",\r\n\t\t\t\t\tdata: {\"action\":\"whosendmsg\",\"to_uid\":loginUser.uid},\r\n\t\t\t\t\tcache: false,\r\n\t\t\t\t\tsuccess: function(m){\r\n\t\t\t\t\t\tif(m && m!=\"NO\"){\r\n\t\t\t\t\t\t\tif($('.no_msg')) $('.no_msg').hide();\r\n\t\t\t\t\t\t\t$.mobile.pageLoading();\r\n\t\t\t\t\t\t\t$(\"#sms-list-content > ul.ui-listview\").empty().html(m);\r\n\t\t\t\t\t\t\t$.mobile.silentScroll($('#sms-list-content').height());\r\n\t\t\t\t\t\t}else{\r\n\t\t\t\t\t\t\t$(\"#sms-list-content > ul.ui-listview\").empty();\r\n\t\t\t\t\t\t\t$('.no_msg').show();\r\n\t\t\t\t\t\t}\r\n\t\t\t\t\t\t$.mobile.pageLoading(true);\r\n\t\t\t\t\t}\r\n\t\t\t\t});\r\n   \t\t}\r\n   \t}\r\n   });\r\n}\r\n</script>\r\n<body> \r\n<div data-role=\"page\" data-theme=\"b\" id=\"sms-list-page\">\r\n\t<div data-role=\"header\" class=\"ui-btn-up-b\">\r\n\t\t<a data-icon=\"myapp-write-sms\" href=\"muti_send.php\" data-theme=\"b\" data-transition=\"slideup\" data-ajax=\"false\">";
echo _( "群发微讯" );
echo "</a>\r\n\t\t<h1>";
echo $LOGIN_USER_NAME;
echo "</h1>\r\n\t\t<a data-icon=\"grid\" href=\"#contact-list-page\" data-theme=\"b\" data-ajax=\"true\" data-transition=\"";
echo $deffect[deviceagent( )]['flip'];
echo "\">";
echo _( "联系人" );
echo "</a>\r\n\t</div><!-- /header -->\r\n   <div data-role=\"content\" id=\"sms-list-content\">\r\n";
$MSG_USER_LIST = array( );
$MSG_LIST = array( );
$new_msg = $style = "";
$query_num = $fix_for_pad['sms-list-show-num'] != "" ? $fix_for_pad['sms-list-show-num'] : 7;
$query = "SELECT FROM_UID,TO_UID,REMIND_FLAG,SEND_TIME,CONTENT from message where (TO_UID='".$LOGIN_UID."' or FROM_UID='{$LOGIN_UID}') and DELETE_FLAG!='1' order by SEND_TIME DESC";
$cursor = exequery( $connection, $query );
$rc = mysql_affected_rows( );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$FROM_UID = $ROW['FROM_UID'];
				$TO_UID = $ROW['TO_UID'];
				$SEND_TIME = $ROW['SEND_TIME'];
				$REMIND_FLAG = $ROW['REMIND_FLAG'];
				$CONTENT = $ROW['CONTENT'];
				if ( $TO_UID == $LOGIN_UID && !array_key_exists( "USER_".$FROM_UID, $MSG_USER_LIST ) )
				{
								$MSG_USER_LIST["USER_".$FROM_UID] = 1;
								$MSG_LIST["USER_".$FROM_UID] = array( $FROM_UID, $SEND_TIME, $REMIND_FLAG == 1 ? 1 : 0, $CONTENT );
				}
				if ( $FROM_UID == $LOGIN_UID && !array_key_exists( "USER_".$TO_UID, $MSG_USER_LIST ) )
				{
								$MSG_USER_LIST["USER_".$TO_UID] = "USER_".$TO_UID;
								$MSG_LIST["USER_".$TO_UID] = array( $TO_UID, $SEND_TIME, 0, $CONTENT );
				}
				if ( $query_num <= count( $MSG_LIST ) )
				{
				}
}
$MSG_NUM = count( $MSG_LIST );
if ( 0 < $MSG_NUM )
{
				echo "         <ul data-role=\"listview\" class=\"ui-listview\">\r\n         ";
				foreach ( $MSG_LIST as $k => $v )
				{
								$SEND_TIME = timeintval( $v[1] );
								$new_msg = $v[2] == 1 ? " data-theme=\"e\"" : "";
								$style = $v[2] == 1 ? " udf-new-msg" : "";
								echo "\t\t\t<li data-iconpos=\"right\" class=\"";
								echo $fix_for_pad['sms-list-content-li'].$style;
								echo "\" ";
								echo $new_msg;
								echo ">\r\n            <img src=\"";
								echo showavatar( $USER_ARRAY[$v[0]]['AVATAR'], $USER_ARRAY[$v[0]]['SEX'] );
								echo "\" class=\"ui-li-thumb\"/>\r\n            <a href=\"msg.php?FROM_UID=";
								echo $v[0];
								echo "\" rel=\"external\" data-transition=\"slide\" ajax-data=\"false\">\r\n               <p class=\"ui-li-aside\">";
								echo $SEND_TIME;
								echo "</p>\r\n               <h3>";
								echo $USER_ARRAY[$v[0]]['NAME'];
								echo "</h3>\r\n               <p>";
								echo $v[3];
								echo "&nbsp;</p>\r\n            </a>\r\n\t\t\t</li>\r\n\t\t";
				}
				echo "\t\t   </ul>\r\n   ";
}
echo "   \r\n   ";
if ( 0 < $MSG_NUM )
{
				$display = "display:none";
}
echo "   <div class=\"no_msg\" style=\"";
echo $display;
echo "\">";
echo _( "暂无新消息！" );
echo "</div>\r\n</div><!-- /content -->\r\n</div>\r\n\r\n\r\n<div data-role=\"page\" data-theme=\"b\" id=\"contact-list-page\">\r\n\t<div data-role=\"header\" class=\"ui-btn-up-b\" data-theme=\"b\">\r\n\t\t<h1>";
echo _( "常用联系人" );
echo "</h1>\r\n\t\t<a href=\"index.php#sms-list-page\" data-role=\"button\" data-icon=\"arrow-l\" data-transition=\"slideup\" data-ajax=\"false\">";
echo _( "后退" );
echo "</a>\r\n\t</div><!-- /header -->\r\n\r\n\t<div data-role=\"content\" id=\"frequent-contact-list-content\">\r\n\t\t<ul data-role=\"listview\" data-inset=\"true\" data-theme=\"c\" data-dividertheme=\"b\" id=\"frequent-contacts\">\r\n\t\t\t<li data-role=\"list-divider\">";
echo _( "常用联系人" );
echo "</li>\r\n\t\t\t";
if ( isset( $_COOKIE['CookieArray'] ) )
{
				foreach ( $_COOKIE['CookieArray'] as $k => $v )
				{
								if ( $v == $LOGIN_UID )
								{
												echo " \t\t\t<li class=\"udf_contact_li\"><a href=\"msg.php?FROM_UID=";
												echo $v;
												echo "\" rel=\"external\" data-transition=\"slide\" ajax-data=\"false\">";
												echo $USER_ARRAY[$v]['NAME'];
												echo " - (";
												echo $SYS_DEPARTMENT[$USER_ARRAY[$v]['DEPT_ID']]['DEPT_NAME'];
												echo ")</a></li>\r\n \t\t\t";
								}
				}
}
else
{
				echo " \t\t\t<li><a rel=\"external\" data-transition=\"slide\" ajax-data=\"false\">";
				echo _( "暂无常用联系人" );
				echo "</a></li>\r\n \t\t\t";
}
echo "\t\t</ul>\r\n\t</div>\r\n</div><!--//常用联系人-->\r\n<script type=\"text/javascript\">\r\nvar timer_msg_mon = null;\r\ntimer_msg_mon = window.setInterval(msg_mon, monInterval.MSG_LIST_REF_SEC*1000);\r\n</script>\r\n</body>\r\n</html>\r\n";
?>
