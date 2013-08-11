<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$CSS_ARRAY = array( "/pda/style/list.css" );
$JS_ARRAY = array( );
include_once( "../auth.php" );
include_once( "inc/utility_file.php" );
echo "<body>\r\n";
$query = "SELECT * from EMAIL,EMAIL_BODY where EMAIL_BODY.BODY_ID=EMAIL.BODY_ID and EMAIL_ID='".$EMAIL_ID."' and TO_ID='{$LOGIN_USER_ID}' and (EMAIL.DELETE_FLAG='' or EMAIL.DELETE_FLAG='0' or EMAIL.DELETE_FLAG='2')";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$FROM_ID = $ROW['FROM_ID'];
				$SUBJECT = $ROW['SUBJECT'];
				$CONTENT = $ROW['CONTENT'];
				$SEND_TIME = $ROW['SEND_TIME'];
				$SEND_TIME = date( "Y-m-d H:i:s", $SEND_TIME );
				$IMPORTANT = $ROW['IMPORTANT'];
				$ATTACHMENT_ID = $ROW['ATTACHMENT_ID'];
				$ATTACHMENT_NAME = $ROW['ATTACHMENT_NAME'];
				$SUBJECT = htmlspecialchars( $SUBJECT );
				$CONTENT = stripslashes( $CONTENT );
				if ( $IMPORTANT == "0" || $IMPORTANT == "" )
				{
								$IMPORTANT_DESC = "";
				}
				else if ( $IMPORTANT == "1" )
				{
								$IMPORTANT_DESC = "<font color=red>"._( "重要" )."</font>";
				}
				else if ( $IMPORTANT == "2" )
				{
								$IMPORTANT_DESC = "<font color=red"._( "非常重要" )."></font>";
				}
				$query1 = "SELECT USER_NAME from USER where USER_ID='".$FROM_ID."'";
				$cursor1 = exequery( $connection, $query1 );
				if ( $ROW = mysql_fetch_array( $cursor1 ) )
				{
								$FROM_NAME = $ROW['USER_NAME'];
				}
				else
				{
								$FROM_NAME = $FROM_ID;
				}
}
else
{
				exit( );
}
echo "<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "阅读邮件" );
echo "</span>\r\n\t<div class=\"list_top_right\"><a class=\"ButtonA\" href=\"new.php?P=";
echo $P;
echo "&EMAIL_ID=";
echo $EMAIL_ID;
echo "&FROM_ID=";
echo $FROM_ID;
echo "&FROM_NAME=";
echo $FROM_NAME;
echo "&FLAG=1&SUBJECT=";
echo $SUBJECT;
echo "\">";
echo _( "回复" );
echo "</a>\r\n\t\t<a class=\"ButtonA\" href=\"delete.php?P=";
echo $P;
echo "&EMAIL_ID=";
echo $EMAIL_ID;
echo "\">";
echo _( "删除" );
echo "</a>\r\n\t\t</div>\r\n</div>\r\n<div class=\"list_main\">\r\n   <div class=\"read_title\">";
echo $SUBJECT;
echo " ";
echo $IMPORTANT_DESC;
echo "</div>\r\n   <div class=\"read_time\">";
echo $FROM_NAME;
echo " ";
echo substr( $SEND_TIME, 0, 16 );
echo "</div>\r\n";
if ( $ATTACHMENT_ID != "" && $ATTACHMENT_NAME != "" )
{
				echo "   <div class=\"read_attachment\">";
				echo _( "附件：" );
				echo attach_link_pda( $ATTACHMENT_ID, $ATTACHMENT_NAME, $P );
				echo "</div>\r\n";
}
echo "   <div class=\"read_content\">";
echo $CONTENT;
echo "</div>\r\n</div>\r\n</body>\r\n</html>\r\n";
?>
