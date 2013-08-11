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
$JS_ARRAY = array( );
include_once( "../auth.php" );
include_once( "inc/utility_file.php" );
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "阅读公告通知" );
echo "</span>\r\n</div>\t\r\n";
$CUR_DATE = date( "Y-m-d", time( ) );
$query = "SELECT * from NOTIFY where NOTIFY_ID='".$NOTIFY_ID."' and (TO_ID='ALL_DEPT' or find_in_set('{$LOGIN_DEPT_ID}',TO_ID) or find_in_set('{$LOGIN_USER_PRIV}',PRIV_ID) or find_in_set('{$LOGIN_USER_ID}',USER_ID)) and begin_date<='{$CUR_DATE}' and (end_date>='{$CUR_DATE}' or end_date is null) and PUBLISH='1'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$FROM_ID = $ROW['FROM_ID'];
				$SUBJECT = $ROW['SUBJECT'];
				$CONTENT = $ROW['CONTENT'];
				$ATTACHMENT_ID = $ROW['ATTACHMENT_ID'];
				$ATTACHMENT_NAME = $ROW['ATTACHMENT_NAME'];
				$FORMAT = $ROW['FORMAT'];
				$SUBJECT = htmlspecialchars( $SUBJECT );
				$CONTENT = stripslashes( $CONTENT );
				$BEGIN_DATE = $ROW['BEGIN_DATE'];
				$BEGIN_DATE = strtok( $BEGIN_DATE, " " );
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
				if ( $FORMAT == "2" )
				{
								$CONTENT = "<a href='".$CONTENT."'>{$CONTENT}</a>";
				}
}
else
{
				exit( );
}
echo "<div class=\"list_main\">\r\n   <div class=\"read_title\">";
echo $SUBJECT;
echo " </div>\r\n   <div class=\"read_time\">";
echo $FROM_NAME;
echo " ";
echo substr( $BEGIN_DATE, 0, 16 );
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
