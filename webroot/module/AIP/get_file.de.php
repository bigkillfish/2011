<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/conn.php" );
include_once( "inc/utility_file.php" );
ob_end_clean( );
if ( $MODULE == "" || $ATTACHMENT_ID == "" )
{
				echo _( "参数错误！" );
}
$YM = substr( $ATTACHMENT_ID, 0, strpos( $ATTACHMENT_ID, "_" ) );
if ( $YM )
{
				$ATTACHMENT_ID = substr( $ATTACHMENT_ID, strpos( $ATTACHMENT_ID, "_" ) + 1 );
}
if ( $ATTACHMENT_NAME )
{
				$ATTACHMENT_NAME = "aip";
}
$FILE_PATH = $ATTACH_PATH2.$MODULE."/".$YM."/".$ATTACHMENT_ID.".".$ATTACHMENT_NAME;
if ( file_exists( $FILE_PATH ) )
{
				echo file_get_contents( $FILE_PATH );
}
else
{
				echo _( "错误：文件不存在" ).$FILE_PATH;
}
?>
