<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function getProdTypeList( $PARENT_ID )
{
				global $connection;
				global $CRM_CONTEXT_PATH;
				global $CRM_CONTEXT_IMG_PATH;
				global $PARA_TARGET;
				global $PARA_URL;
				$query = "SELECT id, product_type_code, product_type_name FROM CRM_PRODUCT_TYPE ";
				$query .= "WHERE parent_id=\"".$PARENT_ID."\" order by product_type_code";
				$cursor = exequery( $connection, $query );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$ID = $ROW['id'];
								$PRODUCT_TYPE_CODE = $ROW['product_type_code'];
								$PRODUCT_TYPE_NAME = $ROW['product_type_name'];
								$PRODUCT_TYPE_CODE = htmlspecialchars( $PRODUCT_TYPE_CODE );
								$PRODUCT_TYPE_CODE = stripslashes( $PRODUCT_TYPE_CODE );
								$PRODUCT_TYPE_NAME = htmlspecialchars( $PRODUCT_TYPE_NAME );
								$PRODUCT_TYPE_NAME = stripslashes( $PRODUCT_TYPE_NAME );
								$CHILD_COUNT = 0;
								$query1 = "SELECT 1 from CRM_PRODUCT_TYPE where parent_id='".$ID."'";
								$cursor1 = exequery( $connection, $query1 );
								if ( $ROW1 = mysql_fetch_array( $cursor1 ) )
								{
												++$CHILD_COUNT;
								}
								if ( 0 < $CHILD_COUNT )
								{
												$JSON = "./type_tree.php?PARENT_ID=".$ID."&PARA_TARGET={$PARA_TARGET}&PARA_URL={$PARA_URL}";
												$IS_LAZY = TRUE;
								}
								$ONCHECK = $showButton && $DEPT_PRIV1 == "1" ? "click_node" : "";
								$URL = "{$PARA_URL}?PROD_TYPE=".$ID;
								$ORG_ARRAY[] = array( "title" => td_iconv( $PRODUCT_TYPE_NAME, ini_get( "default_charset" ), "utf-8" ), "isFolder" => FALSE, "isLazy" => $IS_LAZY, "key" => $ID, "dept_id" => "pro_".$ID, "icon" => $IS_ORG == 1 ? "org.png" : FALSE, "url" => td_iconv( $URL, ini_get( "default_charset" ), "utf-8" ), "tooltip" => td_iconv( $PRODUCT_TYPE_NAME, ini_get( "default_charset" ), "utf-8" ), "json" => td_iconv( $JSON, ini_get( "default_charset" ), "utf-8" ), "target" => $PARA_TARGET, "onCheck" => td_iconv( $ONCHECK, ini_get( "default_charset" ), "utf-8" ) );
				}
				return json_encode( $ORG_ARRAY );
}

include_once( "general/crm/inc/header.php" );
ob_end_clean( );
echo getprodtypelist( $PARENT_ID );
?>
