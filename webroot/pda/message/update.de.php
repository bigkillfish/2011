<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

require_once( "inc/auth.php" );
require_once( "inc/utility_all.php" );
require_once( "inc/mb.php" );
$count = 0;
$query = "SELECT UID,USER_NAME from USER";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$count;
				$UID = $ROW['UID'];
				$USER_NAME = $ROW['USER_NAME'];
				$USER_NAME_INDEX = getchnprefix( $USER_NAME );
				$sql1 = "UPDATE USER SET USER_NAME_INDEX = '".$USER_NAME_INDEX."' WHERE UID={$UID}";
				exequery( $connection, $sql1 );
}
echo _( "成功更新" ).$count._( "条数据" );
?>
