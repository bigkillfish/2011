<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function deleteLog( $directory, $days )
{
				$handle = @opendir( $directory );
				while ( ( $filename = @readdir( $handle ) ) !== FALSE )
				{
								if ( $filename == "." || $filename == ".." )
								{
								}
								else
								{
												continue;
								}
								$filepath = $directory."/".$filename;
								if ( @( filemtime( $filepath ) < time( ) - $days * 86400 ) )
								{
												@unlink( $filepath );
								}
				}
				@closedir( $handle );
}

$directory = realpath( $ROOT_PATH."../logs/OfficeMail" );
if ( $directory !== FALSE )
{
				deletelog( $directory, $DAY_LOGS );
}
$directory = realpath( $ROOT_PATH."../logs/OfficeIm" );
if ( $directory !== FALSE )
{
				deletelog( $directory, $DAY_LOGS );
}
?>
