<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "./auth.php" );
include_once( "../inc/utility.php" );
$TYPE = $TYPE != "1" ? 0 : 1;
if ( isset( $OA_UID ) )
{
				$query = "select UID from USER where UID='".$OA_UID."'";
}
else
{
				$query = "select UID from USER where USER_ID='".$OA_USER."'";
}
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$UID = $ROW['UID'];
				new_sms_remind( $UID, 1, $TYPE );
				echo "100#|#";
}
else
{
				echo "301#|#".sprintf( _( "OA用户[%s]不存在" ), isset( $OA_UID ) ? $OA_UID : $OA_USER );
}
?>
