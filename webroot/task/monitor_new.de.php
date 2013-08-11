<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "../inc/conn.php" );
$conn = @mysql_pconnect( $MYSQL_SERVER, $MYSQL_USER, $MYSQL_PASS, @MYSQL_CLIENT_COMPRESS );
mysql_select_db( "sms", $conn );
$query = "SELECT * from sms where Send_Time = '0000-00-00 00:00:00'";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_assoc( $cursor ) )
{
				$FLOW_ID = $ROW['FLOW_ID'];
				$RUN_NAME = $ROW['RUN_NAME'];
				$ORG_ID = $ROW['ORG_ID'];
				$D_1 = $ROW['D_1'];
				$D_2 = $ROW['D_2'];
				$D_3 = $ROW['D_3'];
				$D_4 = $ROW['D_4'];
				$D_5 = $ROW['D_5'];
				$D_6 = $ROW['D_6'];
				$D_7 = $ROW['D_7'];
				$D_8 = $ROW['D_8'];
				$D_9 = $ROW['D_9'];
				$D_10 = $ROW['D_10'];
				$D_11 = $ROW['D_11'];
				$D_12 = $ROW['D_12'];
				$D_13 = $ROW['D_13'];
				$D_14 = $ROW['D_14'];
				$D_15 = $ROW['D_15'];
				$FLOW_ARR[] = $ROW;
}
print_r( $FLOW_ARR );
echo "+OK";
?>
