<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "auth.php" );
include_once( "inc/utility_file.php" );
$AID = intval( $AID );
$ATTACHMENT_NAME = urldecode( $ATTACHMENT_NAME );
$ATTACHMENT_ID = attach_id_decode( $ATTACHMENT_ID, $ATTACHMENT_NAME );
if ( stristr( $MODULE, "/" ) || stristr( $MODULE, "\\" ) || stristr( $YM, "/" ) || stristr( $YM, "\\" ) || stristr( $ATTACHMENT_ID, "/" ) || stristr( $ATTACHMENT_ID, "\\" ) || stristr( $ATTACHMENT_NAME, "/" ) || stristr( $ATTACHMENT_NAME, "\\" ) )
{
				message( _( "错误" ), _( "参数含有非法字符。" ) );
				exit( );
}
if ( 0 < $AID )
{
				$ATTACHMENT_ID_LONG = $AID."@".$YM."_".$ATTACHMENT_ID;
}
else if ( $YM != "" )
{
				$ATTACHMENT_ID_LONG = $YM."_".$ATTACHMENT_ID;
}
else
{
				$ATTACHMENT_ID_LONG = $ATTACHMENT_ID;
}
echo $ATTACHMENT_ID_LONG.".".$ATTACHMENT_NAME;
$FILE_PATH = attach_real_path( $ATTACHMENT_ID_LONG, $ATTACHMENT_NAME, $MODULE );
if ( $FILE_PATH === FALSE )
{
				message( _( "错误" ), sprintf( _( "文件[%s]不存在" ), htmlspecialchars( $ATTACHMENT_NAME ) ) );
				exit( );
}
if ( is_office( $ATTACHMENT_NAME ) )
{
				oc_log( $ATTACHMENT_ID_LONG, $ATTACHMENT_NAME, 3 );
}
$FILE_EXT = strtolower( substr( $ATTACHMENT_NAME, strrpos( $ATTACHMENT_NAME, "." ) + 1 ) );
if ( $DIRECT_VIEW || $FILE_EXT == ".mht" )
{
				switch ( $FILE_EXT )
				{
								case ".jpg" :
								case ".bmp" :
								case ".gif" :
								case ".png" :
								case ".wmv" :
								case ".html" :
								case ".htm" :
								case ".wav" :
								case ".mid" :
								case ".mht" :
												$COTENT_TYPE = 0;
												$COTENT_TYPE_DESC = "application/octet-stream";
												break;
								case ".pdf" :
												$COTENT_TYPE = 0;
												$COTENT_TYPE_DESC = "application/pdf";
												break;
								case ".swf" :
												$COTENT_TYPE = 0;
												$COTENT_TYPE_DESC = "application/x-shockwave-flash";
												break;
								default :
												$COTENT_TYPE = 1;
												$COTENT_TYPE_DESC = "application/octet-stream";
								}
								else
								{
												$COTENT_TYPE = 1;
												$COTENT_TYPE_DESC = "application/octet-stream";
				}
}
ob_end_clean( );
header( "Cache-control: private" );
header( "Content-type: ".$COTENT_TYPE_DESC );
header( "Accept-Ranges: bytes" );
header( "Content-Length: ".sprintf( "%u", filesize( $FILE_PATH ) ) );
if ( $COTENT_TYPE == 1 )
{
				header( "Content-Disposition: attachment;".get_attachment_filename( $ATTACHMENT_NAME ) );
}
else
{
				header( "Content-Disposition: ".get_attachment_filename( $ATTACHMENT_NAME ) );
}
$handle = fopen( $FILE_PATH, "rb" );
$contents = "";
while ( !feof( $handle ) )
{
				echo $contents = fread( $handle, 8192 );
}
fclose( $handle );
?>
