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
				case "opportunity_select" :
								$table = "CRM_OPPORTUNITY_PRODUCTS_LIST";
								break;
				case "quotation_select" :
								$table = "CRM_QUOTATION_PRODUCTS_LIST";
								break;
				case "order_select" :
								$table = "CRM_ORDER_PRODUCTS_LIST";
								break;
				case "purchase_order_select" :
								$table = "CRM_PURCHASE_ORDER_PRODUCTS_LIST";
								break;
				default :
								$id = "";
								exit( );
}
echo "pList.deleteAll();pList.addRow();";
if ( $id != "" )
{
				$list_query = "SELECT \r\n\t\t\t\t".$table.".number,\r\n\t\t\t\t".$table.".product_id,\r\n\t\t\t\t".$table.".qty,\r\n\t\t\t\t".$table.".price,\r\n\t\t\t\t".$table.".total,\r\n\t\t\t\tCRM_PRODUCT_".$table.".product_code,\r\n\t\t\t\tCRM_PRODUCT_".$table.".product_name,\r\n\t\t\t\tCRM_PRODUCT_".$table.".product_code,\r\n\t\t\t\tCRM_PRODUCT_".$table.".product_specification,\r\n\t\t\t\tCRM_SYS_CODE_".$table."_MEASURE_ID.code_name AS measure_id\r\n\t\t\tFROM ".$table." \r\n\t\t\tLEFT OUTER JOIN CRM_PRODUCT AS CRM_PRODUCT_".$table." \r\n\t\t\t\tON CRM_PRODUCT_".$table.".id=".$table.".product_id  \r\n\t\t\tLEFT OUTER JOIN CRM_SYS_CODE AS CRM_SYS_CODE_".$table."_MEASURE_ID \r\n\t\t\t\tON CRM_SYS_CODE_".$table."_MEASURE_ID.code_type='MEASURE_ID' \r\n\t\t\t\tAND CRM_SYS_CODE_".$table."_MEASURE_ID.code_no=CRM_PRODUCT_".$table.".measure_id \r\n\t\t\tWHERE ".$table.( ".main_id='".$id."' AND " ).$table.".deleted=0 ORDER BY ".$table.".number ASC";
				$cursor = exequery( $connection, $list_query );
				$number = 0;
				echo "document.getElementById('selectedIds').value='';\ndocument.getElementById('selectedRowIds').value='';\n";
				while ( $row = mysql_fetch_object( $cursor ) )
				{
								++$number;
								foreach ( $row as $key => $value )
								{
												if ( $value === "0" || $value === "0.00" )
												{
																$value = "";
												}
												$$key = $value;
								}
								echo "pList.addRow();pList.fillDatas(";
								echo $number;
								echo ", {'product_id':'";
								echo $product_id;
								echo "','product_code': '";
								echo $product_code;
								echo "','product_name': '";
								echo $product_name;
								echo "','product_specification':'";
								echo $product_specification;
								echo "','product_measure':'";
								echo $measure_id;
								echo "','qty':'";
								echo $qty;
								echo "','price':'";
								echo $price;
								echo "'});\n";
								echo "document.getElementById('selectedIds').value+=".$product_id."+',';\n";
								echo "document.getElementById('selectedRowIds').value+=".$number."+',';\n";
				}
}
?>
