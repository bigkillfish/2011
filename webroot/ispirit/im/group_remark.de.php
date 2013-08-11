<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
$GROUP_UID = "";
$query = "select * from IM_GROUP where GROUP_ID='".$GROUP_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$GROUP_UID = $ROW['GROUP_UID'];
				$REMARK = $ROW['REMARK'];
}
ob_end_clean( );
if ( find_id( $GROUP_UID, $LOGIN_UID ) )
{
				echo "+OK ".$REMARK;
}
else
{
				echo "-ERR "._( "您不在该群组中" );
}
?>
