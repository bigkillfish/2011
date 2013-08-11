<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "./auth.php" );
include_once( "inc/utility_file.php" );
ob_end_clean( );
$DEST_UID = intval( $DEST_UID );
if ( $DEST_UID == 0 )
{
				echo "-ERR "._( "接收方ID无效" );
				exit( );
}
$MODULE = "im";
if ( 1 <= count( $_FILES ) )
{
				$ATTACHMENTS = upload( "ATTACHMENT", $MODULE );
				ob_end_clean( );
				$ATTACHMENT_ID = substr( $ATTACHMENTS['ID'], 0, -1 );
				$ATTACHMENT_NAME = substr( $ATTACHMENTS['NAME'], 0, -1 );
}
else
{
				echo "-ERR "._( "无文件上传" );
				exit( );
}
$FILE_SIZE = attach_size( $ATTACHMENT_ID, $ATTACHMENT_NAME, $MODULE );
if ( $FILE_SIZE )
{
				echo "-ERR "._( "文件上传失败" );
				exit( );
}
$query = "insert into IM_OFFLINE_FILE (TIME,SRC_UID,DEST_UID,FILE_NAME,FILE_SIZE,FLAG) values ('".date( "Y-m-d H:i:s" ).( "','".$LOGIN_UID."','{$DEST_UID}','*" ).( $ATTACHMENT_ID.".".$ATTACHMENT_NAME ).( "','".$FILE_SIZE."','0')" );
$cursor = exequery( $connection, $query );
if ( $cursor === FALSE )
{
				echo "-ERR "._( "数据库操作失败" );
				exit( );
}
$FILE_ID = mysql_insert_id( );
if ( $FILE_ID == 0 )
{
				echo "-ERR "._( "数据库操作失败2" );
				exit( );
}
echo "+OK ".$FILE_ID;
exit( );
?>
