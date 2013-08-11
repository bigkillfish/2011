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
$query = "SELECT GROUP_UID from IM_GROUP where GROUP_ID='".$MSG_GROUP_ID."'";
$cursor = exequery( $connection, $query );
if ( ( $ROW = mysql_fetch_array( $cursor ) ) && !find_id( $ROW['GROUP_UID'], $LOGIN_UID ) )
{
				ob_end_clean( );
				exit( );
}
$CUR_TIME = time( );
ob_end_clean( );
$MSG_CONTENT = str_replace( "onclick=imgClick(this);", "", $MSG_CONTENT );
$MSG_CONTENT = str_replace( "onerror=imgErr(this);", "", $MSG_CONTENT );
$MSG_CONTENT_SIMPLE = strip_tags( $MSG_CONTENT );
$query = "insert into IM_GROUP_MSG(MSG_UID,MSG_CONTENT,MSG_TIME,MSG_GROUP_ID,ATTACHMENT_ID,ATTACHMENT_NAME,MSG_USER_NAME,MSG_CONTENT_SIMPLE) values ('".$LOGIN_UID."','{$MSG_CONTENT}','{$CUR_TIME}','{$MSG_GROUP_ID}','{$ATTACHMENT_ID}','{$ATTACHMENT_NAME}','{$LOGIN_USER_NAME}','{$MSG_CONTENT_SIMPLE}')";
exequery( $connection, $query );
$query = "flush table IM_GROUP_MSG;";
exequery( $connection, $query );
header( "location: group_msg_list.php?MSG_GROUP_ID=".$MSG_GROUP_ID );
?>
