<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "general/crm/inc/header.php" );
ob_end_clean( );
switch ( $entity )
{
				case "quotation_select" :
								$query = "SELECT \r\n\t\t\t\tCRM_QUOTATION.opportunities_id,\r\n\t\t\t\tCRM_OPPORTUNITY_CRM_QUOTATION_OPPORTUNITIES_ID.opportunity_name,\r\n\t\t\t\tCRM_QUOTATION.account_id,\r\n\t\t\t\tCRM_ACCOUNT_CRM_QUOTATION_ACCOUNT_ID.account_name ,\r\n\t\t\t\tCRM_QUOTATION.contact_id,\r\n\t\t\t\tCRM_ACCOUNT_CONTACT_CRM_QUOTATION_CONTACT_ID.contact_name \r\n\t\t\t\tFROM CRM_QUOTATION \r\n\t\t\t\tLEFT OUTER JOIN CRM_OPPORTUNITY AS CRM_OPPORTUNITY_CRM_QUOTATION_OPPORTUNITIES_ID ON CRM_OPPORTUNITY_CRM_QUOTATION_OPPORTUNITIES_ID.id=CRM_QUOTATION.opportunities_id \r\n\t\t\t\tLEFT OUTER JOIN CRM_ACCOUNT AS CRM_ACCOUNT_CRM_QUOTATION_ACCOUNT_ID ON CRM_ACCOUNT_CRM_QUOTATION_ACCOUNT_ID.id=CRM_QUOTATION.account_id \r\n\t\t\t\tLEFT OUTER JOIN CRM_ACCOUNT_CONTACT AS CRM_ACCOUNT_CONTACT_CRM_QUOTATION_CONTACT_ID ON CRM_ACCOUNT_CONTACT_CRM_QUOTATION_CONTACT_ID.id=CRM_QUOTATION.contact_id \r\n\t\t\t\tWHERE CRM_QUOTATION.id='".$id."'";
								break;
				case "opportunity_select" :
								$query = "SELECT \r\n\t\t\t\tCRM_OPPORTUNITY.account_id,\r\n\t\t\t\tCRM_ACCOUNT_CRM_OPPORTUNITY_ACCOUNT_ID.account_name ,\r\n\t\t\t\tCRM_OPPORTUNITY.contact_id,\r\n\t\t\t\tCRM_ACCOUNT_CONTACT_CRM_OPPORTUNITY_CONTACT_ID.contact_name \r\n\t\t\t\tFROM CRM_OPPORTUNITY \r\n\t\t\t\tLEFT OUTER JOIN CRM_ACCOUNT AS CRM_ACCOUNT_CRM_OPPORTUNITY_ACCOUNT_ID ON CRM_ACCOUNT_CRM_OPPORTUNITY_ACCOUNT_ID.id=CRM_OPPORTUNITY.account_id \r\n\t\t\t\tLEFT OUTER JOIN CRM_ACCOUNT_CONTACT AS CRM_ACCOUNT_CONTACT_CRM_OPPORTUNITY_CONTACT_ID ON CRM_ACCOUNT_CONTACT_CRM_OPPORTUNITY_CONTACT_ID.id=CRM_OPPORTUNITY.contact_id \r\n\t\t\t\tWHERE CRM_OPPORTUNITY.id='".$id."'";
								break;
				case "order_select" :
								$query = "SELECT \r\n\t\t\t\tCRM_ORDER.account_id,\r\n\t\t\t\tCRM_ACCOUNT_CRM_ORDER_ACCOUNT_ID.account_name,\r\n\t\t\t\tCRM_ORDER.order_amount  \r\n\t\t\t\tFROM CRM_ORDER \r\n\t\t\t\tLEFT OUTER JOIN CRM_ACCOUNT AS CRM_ACCOUNT_CRM_ORDER_ACCOUNT_ID ON CRM_ACCOUNT_CRM_ORDER_ACCOUNT_ID.id=CRM_ORDER.account_id \r\n\t\t\t\tWHERE  CRM_ORDER.id='".$id."'";
								break;
				case "purchase_order_select" :
								$query = "select \r\n\t\t\t\tCRM_PURCHASE_ORDER.purchase_name,\r\n\t\t\t\tCRM_PURCHASE_ORDER.purchase_date,\r\n\t\t\t\tCRM_PURCHASE_ORDER.depository_id,\r\n\t\t\t\tCRM_DEPOSITORY.depository_name,\r\n\t\t\t\tCRM_PURCHASE_ORDER.charge_man,\r\n\t\t\t\tUSER.USER_NAME as charge_man_name \r\n\t\t\t\tFROM CRM_PURCHASE_ORDER \r\n\t\t\t\tLEFT JOIN CRM_DEPOSITORY on CRM_DEPOSITORY.id = CRM_PURCHASE_ORDER.depository_id \r\n\t\t\t\tleft join USER ON USER.USER_ID = CRM_PURCHASE_ORDER.charge_man\r\n\t\t\t\twhere CRM_PURCHASE_ORDER.id='".$id."'";
								break;
				default :
								$id = "";
}
$return_str = "ok||||";
if ( $id != "" && $entity != "purchase_order_select" )
{
				$cursor = exequery( $connection, $query );
				if ( $row = mysql_fetch_array( $cursor ) )
				{
								$opportunities_id = $row['opportunities_id'];
								if ( $opportunities_id == "0" )
								{
												$opportunities_id = "";
								}
								$opportunity_name = $row['opportunity_name'];
								$account_id = $row['account_id'];
								if ( $account_id == "0" )
								{
												$account_id = "";
								}
								$account_name = $row['account_name'];
								$contact_id = $row['contact_id'];
								if ( $contact_id == "0" )
								{
												$contact_id = "";
								}
								$order_amount = $row['order_amount'];
								$contact_name = $row['contact_name'];
								if ( $entity == "order_select" )
								{
												$return_str = "ok|".$account_id."|".$account_name."|".$order_amount."|";
								}
								else
								{
												$return_str = "ok|".$account_id."|".$account_name."|".$contact_id."|".$contact_name."|".$opportunities_id."|".$opportunity_name."|";
								}
				}
}
else if ( $id != "" && $entity == "purchase_order_select" )
{
				$cursor = exequery( $connection, $query );
				if ( $row = mysql_fetch_array( $cursor ) )
				{
								$depository_id = $row['depository_id'];
								if ( $depository_id == 0 )
								{
												$depository_id = "";
								}
								$depository_name = $row['depository_name'];
								$storage_date = $row['purchase_date'];
								if ( strpos( $storage_date, "0000-00-00" ) === 0 || strpos( $storage_date, "00:00:00" ) === 0 )
								{
												$storage_date = "";
								}
								$charge_man = $row['charge_man'];
								$charge_man_name = $row['charge_man_name'];
								$purchase_order_id = $parent_purchase_order_id;
								$purchase_name = $row['purchase_name'];
								$return_str = "ok|".$depository_id."|".$depository_name."|".$storage_date."|".$charge_man."|".$charge_man_name."|null|";
				}
}
echo $return_str;
?>
