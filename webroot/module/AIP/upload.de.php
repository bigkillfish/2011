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
if ( !$RUN_ID || !$T_ID || !$MODULE )
{
				exit( );
}
if ( $ATTACHMENT_ID == "" )
{
				$ATTACH_ID = mt_rand( );
				$YM = date( "ym", time( ) );
				$PATH = $ATTACH_PATH2.$MODULE;
				if ( file_exists( $PATH ) )
				{
								mkdir( $PATH, 448 );
				}
				$PATH = $PATH."/".$YM;
				if ( file_exists( $PATH ) )
				{
								mkdir( $PATH, 448 );
				}
				$FILENAME = $PATH."/".$ATTACH_ID.".aip";
				if ( file_exists( $FILENAME ) )
				{
								$ATTACH_ID = mt_rand( );
								$FILENAME = $PATH."/".$ATTACH_ID.".aip";
				}
				$ATTACH_ID = $YM."_".$ATTACH_ID;
				$query = "update FLOW_RUN set AIP_FILES = CONCAT(AIP_FILES,'".$T_ID.":{$ATTACH_ID}\n') WHERE RUN_ID='{$RUN_ID}'";
				@exequery( $connection, $query );
}
else
{
				$YM = substr( $ATTACHMENT_ID, 0, strpos( $ATTACHMENT_ID, "_" ) );
				$ATTACHMENT_ID = substr( $ATTACHMENT_ID, strpos( $ATTACHMENT_ID, "_" ) + 1 );
				$FILENAME = $ATTACH_PATH2.$MODULE."/".$YM."/".$ATTACHMENT_ID.".aip";
}
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
