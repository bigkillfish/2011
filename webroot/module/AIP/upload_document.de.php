<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/conn.php" );
ob_end_clean( );
if ( !$YM || !$ATTACHMENT_ID || !$MODULE )
{
				exit( );
}
$FILENAME = $ATTACH_PATH2.$MODULE."/".$YM."/".$ATTACHMENT_ID.".aip";
if ( 0 < $_FILES['file']['error'] )
{
				echo "Return Code: ".$_FILES['file']['error'];
}
else
{
				if ( $_FILES['AIP_FILE']['name'] != "" )
				{
								@move_uploaded_file( @$_FILES['AIP_FILE']['tmp_name'], $FILENAME );
								echo "ok";
								exit( );
				}
}
?>
