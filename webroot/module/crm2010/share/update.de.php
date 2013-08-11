<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "general/crm/inc/header.php" );
if ( substr( $ids, -1 ) == "," )
{
				$ids = substr_replace( $ids, "", -1 );
}
switch ( $MODULE )
{
				case "account" :
								$table_name = "CRM_ACCOUNT";
								break;
				case "account_contact" :
								$table_name = "CRM_ACCOUNT_CONTACT";
								break;
				case "action" :
								$table_name = "CRM_ACTION";
								break;
				case "care" :
								$table_name = "CRM_ACCOUNT_CARE";
								break;
				case "account_contact" :
								$table_name = "CRM_ACCOUNT_CONTACT";
								break;
				case "CRM_COMPLAIN" :
								$table_name = "CRM_COMPLAIN";
								break;
				case "CRM_CUSTOMER_SERVICE" :
								$table_name = "CRM_CUSTOMER_SERVICE";
								break;
				case "CRM_MARKETING" :
								$table_name = "CRM_MARKETING";
								break;
				case "supplier_contact" :
								$table_name = "CRM_SUPPLIER_CONTACT";
								break;
				case "crm_procurement_payment" :
								$table_name = "CRM_PROCUREMENT_PAYMENT";
								break;
				case "purchase_order" :
								$table_name = "CRM_PURCHASE_ORDER";
								break;
				case "storage" :
								$table_name = "CRM_STORAGE";
								break;
				case "suppliers" :
								$table_name = "CRM_SUPPLIER";
								break;
				case "contract" :
								$table_name = "CRM_CONTRACT";
								break;
				case "opportunity" :
								$table_name = "CRM_OPPORTUNITY";
								break;
				case "order" :
								$table_name = "CRM_ORDER";
								break;
				case "CRM_SALEPAY" :
								$table_name = "CRM_SALEPAY";
								break;
				case "quotation" :
								$table_name = "CRM_QUOTATION";
								break;
				case "solutions" :
								$table_name = "CRM_SOLUTIONS";
								break;
				case "CRM_STOCKOUT" :
								$table_name = "CRM_STOCKOUT";
								break;
				case "depository" :
								$table_name = "CRM_DEPOSITORY";
								break;
				case "CRM_PRODUCT" :
								$table_name = "CRM_PRODUCT";
}
$query = "UPDATE ".$table_name.( " SET \r\n\t\t\t\tto_id\t\t\t\t\t='".$TO_ID."',\r\n\t\t\t\tcopy_to_id\t\t\t\t='{$COPY_TO_ID}',\r\n\t\t\t\tpriv_id\t\t\t\t\t='{$PRIV_ID}'\r\n\t\t\tWHERE " ).$table_name.( ".id IN (".$ids.")" );
$cursor = exequery( $connection, $query );
if ( mysql_affected_rows( ) != -1 )
{
				echo "\r\n\t\t\t<script>\r\n\t\t\t\talert('"._( "权限重新分配及记录共享成功" )."');\r\n\t\t\t\twindow.parent.close();\r\n\t\t\t</script>\r\n\t\t";
}
?>
