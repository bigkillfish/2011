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
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "ÔÄ¶ÁÎÄ¼þ" );
echo "</span>\r\n</div>\r\n";
$query = "SELECT * from FILE_CONTENT where CONTENT_ID='".$CONTENT_ID."' and USER_ID='{$LOGIN_USER_ID}'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$SUBJECT = $ROW['SUBJECT'];
				$SEND_TIME = $ROW['SEND_TIME'];
				$CONTENT = $ROW['CONTENT'];
				$ATTACHMENT_ID = $ROW['ATTACHMENT_ID'];
				$ATTACHMENT_NAME = $ROW['ATTACHMENT_NAME'];
				$SUBJECT = htmlspecialchars( $SUBJECT );
}
else
{
				exit( );
}
echo "<div class=\"list_main\">\r\n   <div class=\"read_title\">";
echo $SUBJECT;
echo " </div>\r\n   <div class=\"read_time\">";
echo substr( $SEND_TIME, 0, 16 );
echo "</div>\r\n";
if ( $ATTACHMENT_ID != "" && $ATTACHMENT_NAME != "" )
{
				echo "   <div class=\"read_attachment\">";
				echo _( "¸½¼þ£º" );
				echo attach_link_pda( $ATTACHMENT_ID, $ATTACHMENT_NAME, $P );
				echo "</div>\r\n";
}
echo "   <div class=\"read_content\">";
echo $CONTENT;
echo "</div>\r\n</div> \r\n</body>\r\n</html>\r\n";
?>
