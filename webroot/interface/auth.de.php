<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "../inc/conn.php" );
include_once( "../inc/check_type.php" );
ob_end_clean( );
if ( $USER_ID == "" || $PASSWORD == "" )
{
				echo "201#|#"._( "�û���������Ϊ��" );
				exit( );
}
$query = "select * from EXT_USER where USER_ID='".$USER_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$PWD = $ROW['PASSWORD'];
				$USE_FLAG = $ROW['USE_FLAG'];
				$AUTH_MODULE = $ROW['AUTH_MODULE'];
				$POSTFIX = $ROW['POSTFIX'];
				if ( md5( $PASSWORD ) != $PWD && md5( $PWD ) != $PASSWORD )
				{
								echo "203#|#"._( "�������" );
								exit( );
				}
				if ( $USE_FLAG == "0" )
				{
								echo "204#|#"._( "�ʺ���ͣ��" );
								exit( );
				}
}
echo "202#|#".$USER_ID;
exit( );
?>
