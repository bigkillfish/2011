<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/td_config.php" );
if ( $FILE_NAME == "" || stristr( $FILE_NAME, ".." ) || stristr( $FILE_NAME, "/" ) || stristr( $FILE_NAME, "\\" ) )
{
				exit( );
}
$FILE_PATH = "./update/".$FILE_NAME;
if ( file_exists( $FILE_PATH ) )
{
				header( "HTTP/1.1 404 Not Found" );
				exit( );
}
ob_end_clean( );
readfile( $FILE_PATH );
?>
