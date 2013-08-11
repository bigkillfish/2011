<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
include_once( "inc/utility_file.php" );
ob_end_clean( );
$query = "SELECT GROUP_UID from IM_GROUP where GROUP_ID='".$MSG_GROUP_ID."'";
$cursor = exequery( $connection, $query );
if ( ( $ROW = mysql_fetch_array( $cursor ) ) && !find_id( $ROW['GROUP_UID'], $LOGIN_UID ) )
{
				exit( );
}
echo "<html>\r\n<head>\r\n<title></title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"/theme/1/style.css\">\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"./style/smsbox.css\" />\r\n<script src=\"/ispirit/im/js/group_sms.js\"></script>\r\n<script type=\"text/javascript\" src=\"/inc/js/utility.js\"></script>\r\n<script type=\"text/javascript\" src=\"/inc/js_lang.php\"></script>\r\n<script type=\"text/javascript\" src=\"/inc/js/attach.js\"></script>\r\n</head>\r\n<body class=\"group_body\">\r\n<a id=\"bottom1\" href=\"#bottom\"></a>\t\r\n";
$CUR_TIME = date( "Y-m-d", time( ) );
$MSG_COUNT1 = 0;
$query = "SELECT count(*) from IM_GROUP_MSG where MSG_GROUP_ID='".$MSG_GROUP_ID."' and left(FROM_UNIXTIME(MSG_TIME),10)='{$CUR_TIME}'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$MSG_COUNT1 = $ROW[0];
}
if ( $MSG_COUNT1 <= 20 )
{
				$FROM_COUNT = 0;
}
else
{
				$FROM_COUNT = $MSG_COUNT1 - 20;
}
$query = "SELECT MSG_ID,MSG_CONTENT,MSG_TIME,MSG_GROUP_ID,ATTACHMENT_ID,ATTACHMENT_NAME,MSG_USER_NAME,FROM_UNIXTIME(MSG_TIME) as MSG_TIME from IM_GROUP_MSG where MSG_GROUP_ID='".$MSG_GROUP_ID."' and left(FROM_UNIXTIME(MSG_TIME),10)='{$CUR_TIME}' order by MSG_ID limit {$FROM_COUNT},20";
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
				echo "&nbsp;&nbsp;\r\n";
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
																				echo "\" height=\"100\" alt=\"文件名：";
																				echo $ATTACHMENT_NAME_ARRAY[$I];
																				echo "\"></a>　\r\n";
																}
												}
								}
				}
				echo "\r\n  </div>\r\n</div>\r\n";
}
echo "<div style=\"padding-bottom:10px;\"></div>\r\n<a name=\"bottom\"></a>\r\n<script>\r\nvar obj_a = document.getElementById(\"bottom1\");\r\nif(document.all) //for IE\r\n   obj_a.click();\r\nelse if(document.createEvent){ //for FF\r\n\t var ev = document.createEvent('HTMLEvents');\r\n   ev.initEvent('click', false, true);\r\n   obj_a.dispatchEvent(ev);\r\n}\r\n</script>\r\n<form id='form1' name='form1' action='group_msg_send.php' method='post' enctype='multipart/form-data'>\r\n  <input type='hidden' name='MSG_GROUP_ID' />\r\n  <textarea style='display:none' type='hidden' name='MSG_CONTENT'></textarea>\r\n  <input style='display:none' type=\"file\" name=\"ATTACHMENT_0\" id=\"ATTACHMENT_0\" size=\"1\" hideFocus=\"true\" />\r\n</form>\r\n</body>\r\n</html>\r\n\r\n";
?>
