<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
include_once( "inc/utility_all.php" );
include_once( "inc/utility_file.php" );
ob_end_clean( );
if ( isset( $se ) && trim( $se ) != "" )
{
				$str_add = " and MSG_CONTENT_SIMPLE like '%".$se."%' ";
}
$query = "SELECT GROUP_UID from IM_GROUP where GROUP_ID='".$MSG_GROUP_ID."'";
$cursor = exequery( $connection, $query );
if ( ( $ROW = mysql_fetch_array( $cursor ) ) && !find_id( $ROW['GROUP_UID'], $LOGIN_UID ) )
{
				exit( );
}
if ( isset( $TOTAL_ITEMS ) )
{
				$query = "SELECT count(*) from IM_GROUP_MSG where MSG_GROUP_ID='".$MSG_GROUP_ID."'".$str_add;
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$TOTAL_ITEMS = $ROW[0];
				}
}
if ( $PAGE_SIZE )
{
				$PAGE_SIZE = 10;
}
if ( isset( $start ) )
{
				$start = $TOTAL_ITEMS - $PAGE_SIZE;
}
$start = $start < 0 ? 0 : $start;
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<title></title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"./style/smsbox.css\" />\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"/theme/1/style.css\">\r\n<script type=\"text/javascript\" src=\"/inc/js/utility.js\"></script>\r\n<script type=\"text/javascript\" src=\"/inc/js_lang.php\"></script>\r\n<script type=\"text/javascript\" src=\"/inc/js/attach.js\"></script>\r\n<script src=\"/ispirit/im/js/group_sms.js\"></script>\r\n</head>\r\n<body class=\"group_body\">\r\n<div id=\"topNav\">\r\n<form action=\"group_msg_history.php\" name=\"form1\" method=\"get\">\r\n\t";
echo _( "当前群记录" );
echo "&nbsp;";
echo _( "查询：" );
echo "<input type=\"text\" name=\"se\" class=\"SmallInput\" value=\"";
echo $se;
echo "\" />\r\n\t<input type=\"submit\" value=";
echo _( "搜索" );
echo " class=\"SmallButton\" />\r\n\t<input type=\"hidden\" name=\"MSG_GROUP_ID\" value=\"";
echo $MSG_GROUP_ID;
echo "\" />\r\n\t<input type=\"hidden\" name=\"start\" value=\"0\" />\r\n</form>\r\n</div>\r\n<br><a id=\"bottom1\" href=\"#bottom\"></a>\t<br>\r\n";
$CUR_TIME = date( "Y-m-d", time( ) );
$query = "SELECT MSG_ID,MSG_CONTENT,MSG_TIME,MSG_GROUP_ID,ATTACHMENT_ID,ATTACHMENT_NAME,MSG_USER_NAME,FROM_UNIXTIME(MSG_TIME) as MSG_TIME from IM_GROUP_MSG where MSG_GROUP_ID='".$MSG_GROUP_ID."' ".$str_add.( " order by MSG_ID limit ".$start.",{$PAGE_SIZE}" );
$cursor = exequery( $connection, $query );
$MSG_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$MSG_COUNT;
				$MSG_ID = $ROW['MSG_ID'];
				$MSG_CONTENT = $ROW['MSG_CONTENT'];
				$MSG_TIME = $ROW['MSG_TIME'];
				$MSG_GROUP_ID = $ROW['MSG_GROUP_ID'];
				$ATTACHMENT_ID = $ROW['ATTACHMENT_ID'];
				$ATTACHMENT_NAME = $ROW['ATTACHMENT_NAME'];
				$MSG_USER_NAME = $ROW['MSG_USER_NAME'];
				echo "<div>\r\n\t<div class=\"user_time\">";
				echo $MSG_USER_NAME;
				echo "&nbsp;&nbsp;\r\n\r\n";
				if ( substr( $MSG_TIME, 0, 10 ) == $CUR_TIME )
				{
								echo substr( $MSG_TIME, 11 );
				}
				else
				{
								echo $MSG_TIME;
				}
				echo "</div>\r\n\t<div>\r\n";
				echo $MSG_CONTENT;
				if ( is_image( $ATTACHMENT_NAME ) )
				{
								echo attach_link( $ATTACHMENT_ID, $ATTACHMENT_NAME, 1, 1, 1, 0, 0, 1, 0 );
				}
				else
				{
								$ATTACHMENT_ID_ARRAY = explode( ",", $ATTACHMENT_ID );
								$ATTACHMENT_NAME_ARRAY = explode( "*", $ATTACHMENT_NAME );
								$ARRAY_COUNT = sizeof( $ATTACHMENT_ID_ARRAY );
								$I = 0;
								for ( ;	$I < $ARRAY_COUNT;	++$I	)
								{
												if ( $ATTACHMENT_ID_ARRAY[$I] == "" )
												{
																$MODULE = "im";
																$ATTACHMENT_ID1 = $ATTACHMENT_ID_ARRAY[$I];
																$YM = substr( $ATTACHMENT_ID1, 0, strpos( $ATTACHMENT_ID1, "_" ) );
																if ( $YM )
																{
																				$ATTACHMENT_ID1 = substr( $ATTACHMENT_ID1, strpos( $ATTACHMENT_ID, "_" ) + 1 );
																}
																$ATTACHMENT_ID_ENCODED = attach_id_encode( $ATTACHMENT_ID1, $ATTACHMENT_NAME_ARRAY[$I] );
																if ( is_image( $ATTACHMENT_NAME_ARRAY[$I] ) )
																{
																				$IMG_ATTR = @getimagesize( @attach_real_path( @$ATTACHMENT_ID_ARRAY[$I], @$ATTACHMENT_NAME_ARRAY[$I] ) );
																				if ( is_array( $IMG_ATTR ) && 0 < $IMG_ATTR[0] && 0 < $IMG_ATTR[1] )
																				{
																								$WIDTH = floor( $IMG_ATTR[0] * 100 / $IMG_ATTR[1] );
																				}
																				else
																				{
																								$WIDTH = 100;
																				}
																				echo "                <a href=\"/inc/attach.php?MODULE=";
																				echo $MODULE;
																				echo "&YM=";
																				echo $YM;
																				echo "&ATTACHMENT_ID=";
																				echo $ATTACHMENT_ID_ENCODED;
																				echo "&ATTACHMENT_NAME=";
																				echo urlencode( $ATTACHMENT_NAME_ARRAY[$I] );
																				echo "\"><img src=\"/inc/attach.php?MODULE=";
																				echo $MODULE;
																				echo "&YM=";
																				echo $YM;
																				echo "&ATTACHMENT_ID=";
																				echo $ATTACHMENT_ID_ENCODED;
																				echo "&ATTACHMENT_NAME=";
																				echo urlencode( $ATTACHMENT_NAME_ARRAY[$I] );
																				echo "\" border=\"0\"  width=\"";
																				echo $WIDTH;
																				echo "\" height=\"100\" alt=\"";
																				echo $ATTACHMENT_NAME_ARRAY[$I];
																				echo "\"></a>　\r\n";
																}
												}
								}
				}
				echo "  </div>\r\n</div>\r\n";
}
echo "\r\n<div style=\"padding-bottom:10px;\"></div>\r\n\r\n<a name=\"bottom\"></a>\r\n<br>\r\n<script>\r\nvar obj_a = document.getElementById(\"bottom1\");\r\nif(document.all) //for IE\r\n   obj_a.click();\r\nelse if(document.createEvent){ //for FF\r\n\t var ev = document.createEvent('HTMLEvents');\r\n   ev.initEvent('click', false, true);\r\n   obj_a.dispatchEvent(ev);\r\n}\r\n</script>\r\n";
if ( $PAGE_SIZE <= $TOTAL_ITEMS )
{
				echo "<div id=\"bottomNav\">\r\n";
				echo page_bar( $start, $TOTAL_ITEMS, $PAGE_SIZE );
				echo "</div>\r\n";
}
echo "</body>\r\n</html>\r\n\r\n";
?>
