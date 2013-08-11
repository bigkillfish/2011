<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$USER_ARRAY = $USER_ARRAY_ORDER_BYDEPT = array( );
$query = "SELECT UID,USER_ID,USER_NAME,USER_NAME_INDEX,AVATAR,SEX,DEPT_ID FROM USER WHERE DEPT_ID!= 0 AND NOT_LOGIN !=1";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$USER_ARRAY[$ROW['UID']] = array( "UID" => $ROW['UID'], "USER_ID" => $ROW['USER_ID'], "NAME" => $ROW['USER_NAME'], "AVATAR" => $ROW['AVATAR'], "SEX" => $ROW['SEX'], "NAME_INDEX" => $ROW['USER_NAME_INDEX'], "DEPT_ID" => $ROW['DEPT_ID'] );
				$USER_ARRAY_ORDER_BYDEPT[$ROW['DEPT_ID']]['UID'] = $ROW['UID'].",".$USER_ARRAY_ORDER_BYDEPT[$ROW['DEPT_ID']]['UID'];
}
?>
