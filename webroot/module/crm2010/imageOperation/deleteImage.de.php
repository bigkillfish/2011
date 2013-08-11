<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "general/crm/inc/header.php" );
include_once( "inc/utility_all.php" );
include_once( "inc/utility_file.php" );
include_once( "general/crm/inc/uploadImages.php" );
echo "\r\n<html>\r\n<head>\r\n<title></title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n</head>\r\n\r\n<body class=\"bodycolor\" topmargin=\"5\">\r\n\r\n";
$query = "select ATTACHMENT_ID,ATTACHMENT_NAME from ".$DB_NAME.( " where id='".$id."'" );
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$ATTACHMENT_ID_OLD = $ROW['ATTACHMENT_ID'];
				$ATTACHMENT_NAME_OLD = $ROW['ATTACHMENT_NAME'];
}
if ( $ATTACHMENT_NAME != "" )
{
				deleteimage( $ATTACHMENT_ID, $ATTACHMENT_NAME, $MODULE );
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
				$ATTACHMENT_ID_NEW = $ATTACHMENT_ID1;
				$ATTACHMENT_NAME_NEW = $ATTACHMENT_NAME1;
				$query = "update ".$DB_NAME.( " set ATTACHMENT_ID='".$ATTACHMENT_ID_NEW."',ATTACHMENT_NAME='{$ATTACHMENT_NAME_NEW}' where id='{$id}'" );
				exequery( $connection, $query );
}
echo "</body>\r\n</html>\r\n<script>\r\n\tparent.window.location.reload();\r\n</script>\t\r\n";
?>
