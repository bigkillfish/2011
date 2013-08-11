<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "general/crm/inc/header.php" );
include_once( "general/crm/inc/utility_file.php" );
ob_start( );
echo "\r\n<html>\r\n<head>\r\n<title></title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n</head>\r\n\r\n<body class=\"bodycolor\" topmargin=\"5\">\r\n\r\n";
$contract_id = intval( strip_tags( addslashes( $contract_id ) ) );
if ( $contract_id != "" )
{
				$table = "crm_contract";
				$field_id = "contract_file";
				$field_name = "contract_file_name";
				$id = $contract_id;
				$module_name = "contract";
}
$query = "SELECT ".$field_id." AS ATTACHMENT_ID,\r\n\t\t\t\t".$field_name." AS ATTACHMENT_NAME\r\n\t\t\tFROM ".$table.( " WHERE id = '".$id."'" );
$cursor = exequery( $connection, $query );
$ATTACHMENT_NAME_OLD = "";
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$ATTACHMENT_ID_OLD = $ROW['ATTACHMENT_ID'];
				$ATTACHMENT_NAME_OLD = $ROW['ATTACHMENT_NAME'];
}
if ( $ATTACHMENT_NAME != "" )
{
				crm_delete_attach( $ATTACHMENT_ID, $ATTACHMENT_NAME, $module_name );
				$ATTACHMENT_ID_ARRAY = explode( ",", $ATTACHMENT_ID_OLD );
				$ATTACHMENT_NAME_ARRAY = explode( "*", $ATTACHMENT_NAME_OLD );
				$ARRAY_COUNT = sizeof( $ATTACHMENT_ID_ARRAY );
				$I = 0;
				for ( ;	$I < $ARRAY_COUNT;	++$I	)
				{
								if ( $ATTACHMENT_ID_ARRAY[$I] == $ATTACHMENT_ID )
								{
								}
								else
								{
												continue;
								}
								$ATTACHMENT_ID1 .= $ATTACHMENT_ID_ARRAY[$I].",";
								$ATTACHMENT_NAME1 .= $ATTACHMENT_NAME_ARRAY[$I]."*";
				}
				$ATTACHMENT_ID = $ATTACHMENT_ID1;
				$ATTACHMENT_NAME = $ATTACHMENT_NAME1;
				$query = "update ".$table." set ".$field_id.( "='".$ATTACHMENT_ID."'," ).$field_name.( "='".$ATTACHMENT_NAME."' where id='{$id}'" );
				exequery( $connection, $query );
}
echo "\r\n</body>\r\n</html>\r\n";
?>
