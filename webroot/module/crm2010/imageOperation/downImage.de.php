<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "general/crm/inc/header.php" );
include_once( "inc/utility_file.php" );
if ( stristr( $ATTACHMENT_ID, "/" ) || stristr( $ATTACHMENT_ID, "\\" ) )
{
				echo "<script>parent.alert('"._( "错误!参数含有非法字符!" )."')</scirpt>";
				exit( );
}
$MYOA_ATTACHMENT_NAME = $ATTACHMENT_NAME;
$URL = $ATTACH_PATH."crm/".$MODULE.$ATTACHMENT_ID.".".$ATTACHMENT_NAME;
if ( file_exists( $URL ) )
{
				echo "<script>parent.alert('"._( "抱歉，您所访问的文件不存在，可能已经被删除或转移，请联系OA管理员。" )."')</scirpt>";
				exit( );
}
$file_ext = strtolower( substr( $MYOA_ATTACHMENT_NAME, strpos( $MYOA_ATTACHMENT_NAME, "." ) ) );
if ( $DIRECT_VIEW )
{
				switch ( $file_ext )
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
												switch ( $file_ext )
												{
																case ".doc" :
																case ".dot" :
																				$COTENT_TYPE = $ATTACH_OFFICE_OPEN_IN_IE ? 0 : 1;
																				$COTENT_TYPE_DESC = $ATTACH_OFFICE_OPEN_IN_IE ? "application/msword" : "application/octet-stream";
																				break;
																case ".xls" :
																case ".xlc" :
																case ".xll" :
																case ".xlm" :
																case ".xlw" :
																case ".csv" :
																				$COTENT_TYPE = $ATTACH_OFFICE_OPEN_IN_IE ? 0 : 1;
																				$COTENT_TYPE_DESC = $ATTACH_OFFICE_OPEN_IN_IE ? "application/msexcel" : "application/octet-stream";
																				break;
																case ".ppt" :
																case ".pot" :
																case ".pps" :
																case ".ppz" :
																				$COTENT_TYPE = $ATTACH_OFFICE_OPEN_IN_IE ? 0 : 1;
																				$COTENT_TYPE_DESC = $ATTACH_OFFICE_OPEN_IN_IE ? "application/mspowerpoint" : "application/octet-stream";
																				break;
																case ".docx" :
																case ".dotx" :
																case ".xlsx" :
																case ".xltx" :
																case ".pptx" :
																case ".potx" :
																case ".ppsx" :
																				$COTENT_TYPE = $ATTACH_OFFICE_OPEN_IN_IE ? 0 : 1;
																				$COTENT_TYPE_DESC = $ATTACH_OFFICE_OPEN_IN_IE ? "application/vnd.openxmlformats" : "application/octet-stream";
																				break;
																case ".rm" :
																case ".rmvb" :
																				$COTENT_TYPE = 1;
																				$COTENT_TYPE_DESC = "audio/x-pn-realaudio";
																				break;
																default :
																				$COTENT_TYPE = 1;
																				$COTENT_TYPE_DESC = "application/octet-stream";
												}
				}
}
ob_end_clean( );
header( "Cache-control: private" );
header( "Content-type: ".$COTENT_TYPE_DESC );
header( "Accept-Ranges: bytes" );
header( "Content-Length: ".sprintf( "%u", filesize( $URL ) ) );
if ( stristr( $HTTP_USER_AGENT, "MSIE" ) && $ATTACH_UTF8 )
{
				$MYOA_ATTACHMENT_NAME = urlencode( iconv( ini_get( "default_charset" ), "utf-8", $MYOA_ATTACHMENT_NAME ) );
}
if ( $COTENT_TYPE == 1 )
{
				header( "Content-Disposition: attachment; ".get_attachment_filename( $MYOA_ATTACHMENT_NAME ) );
}
else
{
				header( "Content-Disposition: ".get_attachment_filename( $MYOA_ATTACHMENT_NAME ) );
}
readfile( $URL );
?>
