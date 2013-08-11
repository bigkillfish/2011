<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

ob_start( );
$CSS_ARRAY = array( "/pda/style/list.css" );
include_once( "../auth.php" );
include_once( "inc/utility_file.php" );
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "ÔÄ¶ÁÐÂÎÅ" );
echo "</span>\r\n</div>\r\n";
$query = "SELECT * from NEWS where NEWS_ID='".$NEWS_ID."' and PUBLISH='1' and (TO_ID='ALL_DEPT' or find_in_set('{$LOGIN_DEPT_ID}',TO_ID) or find_in_set('{$LOGIN_USER_PRIV}',PRIV_ID) or find_in_set('{$LOGIN_USER_ID}',USER_ID))";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$NEWS_ID = $ROW['NEWS_ID'];
				$SUBJECT = $ROW['SUBJECT'];
				$PROVIDER = $ROW['PROVIDER'];
				$NEWS_TIME = $ROW['NEWS_TIME'];
				$FORMAT = $ROW['FORMAT'];
				$SUBJECT = htmlspecialchars( $SUBJECT );
				$CONTENT = $ROW['CONTENT'];
				$ATTACHMENT_ID = $ROW['ATTACHMENT_ID'];
				$ATTACHMENT_NAME = $ROW['ATTACHMENT_NAME'];
				$query1 = "SELECT * from USER where USER_ID='".$PROVIDER."'";
				$cursor1 = exequery( $connection, $query1 );
				if ( $ROW = mysql_fetch_array( $cursor1 ) )
				{
								$FROM_NAME = $ROW['USER_NAME'];
				}
				else
				{
								$FROM_NAME = $FROM_ID;
				}
				if ( $FORMAT == "2" )
				{
								header( "location: ".$CONTENT );
				}
}
else
{
				exit( );
}
echo "<div class=\"list_main\">\r\n   <div class=\"read_title\">";
echo $SUBJECT;
echo "</div>\r\n   <div class=\"read_time\">";
echo $FROM_NAME;
echo " ";
echo substr( $NEWS_TIME, 0, 16 );
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
echo "</div>\r\n</div>\r\n</body>\r\n</html>\r\n";
?>
