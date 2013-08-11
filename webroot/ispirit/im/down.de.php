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
header( "Content-type: text/html; charset=".$MYOA_CHARSET );
$ID = intval( $ID );
if ( $ID == 0 )
{
				echo "-ERR "._( "无效的文件ID" );
				exit( );
}
$query = "select FILE_NAME from IM_OFFLINE_FILE where ID='".$ID."' and DEST_UID='{$LOGIN_UID}'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$FILE_NAME = $ROW['FILE_NAME'];
}
else
{
				echo "-ERR "._( "找不到文件" );
				exit( );
}
$MODULE = "im";
if ( substr( $FILE_NAME, 0, 1 ) == "*" )
{
				$POS = strpos( $FILE_NAME, "." );
				$ATTACHMENT_ID = substr( $FILE_NAME, 1, $POS );
				$ATTACHMENT_NAME = substr( $FILE_NAME, $POS + 1 );
				$FILE_PATH = attach_real_path( $ATTACHMENT_ID, $ATTACHMENT_NAME, $MODULE );
}
else
{
				$FILE_PATH = $ROOT_PATH."../IM/users/".$LOGIN_UID."/".$FILE_NAME;
}
if ( $REJECT != "1" )
{
				if ( file_exists( $FILE_PATH ) )
				{
								$query = "delete from IM_OFFLINE_FILE where ID='".$ID."'";
								exequery( $connection, $query );
								echo "-ERR "._( "文件已被删除或转移" );
								exit( );
				}
				ob_end_clean( );
				header( "Cache-control: private" );
				header( "Content-type: application/octet-stream" );
				header( "Accept-Ranges: bytes" );
				header( "Content-Length: ".sprintf( "%u", @filesize( $FILE_PATH ) ) );
				header( "Content-Disposition: attachment; ".get_attachment_filename( $ATTACHMENT_NAME ) );
				$handle = @fopen( $FILE_PATH, "rb" );
				if ( $handle )
				{
								echo "-ERR "._( "打开文件错误" );
								exit( );
				}
				while ( !@feof( $handle ) )
				{
								echo fread( $handle, 8192 );
				}
				@fclose( $handle );
}
if ( substr( $FILE_NAME, 0, 1 ) == "*" )
{
				delete_attach( $ATTACHMENT_ID, $ATTACHMENT_NAME, $MODULE );
}
@unlink( $FILE_PATH );
$query = "delete from IM_OFFLINE_FILE where ID='".$ID."'";
exequery( $connection, $query );
?>
