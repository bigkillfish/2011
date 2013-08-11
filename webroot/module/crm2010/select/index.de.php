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
include_once( "general/crm/utils/dataview/dataview.interface.php" );
include_once( "general/crm/utils/search/search.interface.php" );
$entity_array = array( "account_select" => _( "客户" ), "contact_select" => _( "客户联系人" ), "opportunity_select" => _( "机会" ), "order_select" => _( "订单" ), "supplier_select" => _( "供应商" ), "supplier_contact_select" => _( "供应商联系人" ), "quotation_select" => _( "报价单" ), "depository_select" => _( "仓库" ), "product_type_select" => _( "产品类别" ), "purchase_order_select" => _( "采购订单" ) );
$query = "SELECT field_name FROM crm_sys_uv_field WHERE uv_id = (SELECT id FROM crm_sys_uv WHERE entity='".$entity."') ORDER BY field_no";
$cursor = exequery( $connection, $query );
while ( $row = mysql_fetch_object( $cursor ) )
{
				$field_name_arr[] = $row->field_name;
}
if ( $field_name_arr == "" )
{
				message( _( "提示" ), _( "创建实体数据失败" ) );
				exit( );
}
$row_num = 0;
if ( $field_name_arr != "" )
{
				$main_table = "";
				$query_select = "";
				$query_join = "";
				$page_fields = "";
				$len = count( $field_name_arr );
				$i = 0;
				for ( ;	$i < $len;	++$i	)
				{
								$field_name_str_arr = explode( ":", $field_name_arr[$i] );
								$main_table = $field_name_str_arr[0];
								$table_header .= $field_name_str_arr[6].":";
								if ( $field_name_str_arr[2] == "F" && $field_name_str_arr[3] != "" && $field_name_str_arr[4] != "" && $field_name_str_arr[5] != "" )
								{
												$join_table = $field_name_str_arr[3];
												$join_table_alias = $field_name_str_arr[3]."_".$field_name_str_arr[0]."_".$field_name_str_arr[5];
												$join_on = $join_table_alias.".".$field_name_str_arr[4]."=".$field_name_str_arr[0].".".$field_name_str_arr[1];
												$join_and = "";
												$query_join .= " LEFT OUTER JOIN ".$join_table." AS ".$join_table_alias." ON ".$join_on;
												if ( $join_and != "" )
												{
																$query_join .= " AND ".$join_and;
												}
												$query_select .= ",".$join_table_alias.".".$field_name_str_arr[5];
								}
								else
								{
												$query_select .= ",".$field_name_str_arr[0].".".$field_name_str_arr[1];
								}
								++$row_num;
				}
}
if ( $query_select != "" )
{
				$query = "SELECT ".$main_table.".id".$query_select;
				$query .= " FROM ".$main_table;
				$query_join .= " LEFT OUTER JOIN USER AS USER_CRM_ACCOUNT_LOGIN_USER_ID ON USER_CRM_ACCOUNT_LOGIN_USER_ID.user_id=".$main_table.".create_man \r\n\t\t\t\tLEFT OUTER JOIN DEPARTMENT AS DEPARTMENT_CRM_ACCOUNT_DEPT_ID ON DEPARTMENT_CRM_ACCOUNT_DEPT_ID.dept_id=USER_CRM_ACCOUNT_LOGIN_USER_ID.dept_id";
				$query .= $query_join;
				$query_count = "SELECT COUNT(*)";
				$query_count .= " FROM ".$main_table;
				$query_count .= $query_join;
}
if ( $row_num != 0 )
{
				$query_where = " WHERE ".$main_table.".deleted = 0 ";
				if ( $entity != "product_type_select" )
				{
								$query_where .= " AND ('".$LOGIN_USER_ID."' = 'admin' OR {$main_table}.create_man='{$LOGIN_USER_ID}' OR FIND_IN_SET('{$LOGIN_DEPT_ID}',{$main_table}.to_id) OR FIND_IN_SET('{$LOGIN_USER_ID}',{$main_table}.copy_to_id) \r\n\tOR FIND_IN_SET('{$LOGIN_USER_PRIV}',{$main_table}.priv_id) OR FIND_IN_SET('{$LOGIN_USER_ID}',DEPARTMENT_CRM_ACCOUNT_DEPT_ID.manager) OR FIND_IN_SET('{$LOGIN_USER_ID}',DEPARTMENT_CRM_ACCOUNT_DEPT_ID.leader1) OR FIND_IN_SET('{$LOGIN_USER_ID}',DEPARTMENT_CRM_ACCOUNT_DEPT_ID.leader2))";
				}
				if ( !( $where_cnt != 0 ) && !( $where_cnt != "" ) )
				{
								$i = 0;
								for ( ;	$i < $where_cnt;	++$i	)
								{
												$field_str = "where_field".$i;
												$value_str = "where_value".$i;
												$where_field = $$field_str;
												$where_value = $$value_str;
												$query_where .= "AND ".$main_table.".{$where_field}='".$where_value."' ";
								}
				}
				$I = 0;
				for ( ;	$I < $cnt;	++$I	)
				{
								$FIELD = "field".$I;
								$VALUE = "value".$I;
								$OP = "op".$I;
								$query_where .= " AND ".$$FIELD;
								if ( $$OP == "is" )
								{
												$query_where .= " = '".$$VALUE."' ";
								}
								else if ( $$OP == "cts" )
								{
												$query_where .= " like '%".$$VALUE."%' ";
								}
				}
				$query_count .= $query_where;
				$cursor = exequery( $connection, $query_count );
				if ( $row = mysql_fetch_array( $cursor ) )
				{
								$TOTAL_COUNT = $row[0];
				}
				if ( $TOTAL_COUNT == 0 )
				{
								$TOTAL_PAGE = 1;
				}
				else
				{
								$TOTAL_PAGE = intval( ( $TOTAL_COUNT + $LIST_PAGE_SIZE - 1 ) / $LIST_PAGE_SIZE );
				}
				if ( $CUR_PAGE == "" || $CUR_PAGE == 0 )
				{
								$CUR_PAGE = 1;
				}
				else if ( $TOTAL_PAGE < $CUR_PAGE )
				{
								$CUR_PAGE = $TOTAL_PAGE;
				}
				$START_POS = ( $CUR_PAGE - 1 ) * $LIST_PAGE_SIZE;
				$query_limit = " limit ".$START_POS.",".$LIST_PAGE_SIZE;
				echo "\t\t<style>\r\n\t\t\ttd{white-space: nowrap;}\r\n\t\t</style>\r\n\t\t<title>";
				echo _( "选择" );
				echo $entity_array[$entity];
				echo "</title>\r\n\t\t<script src=\"/inc/js/module.js\"></script>\r\n\t\t<script src=\"";
				echo $CRM_CONTEXT_JS_PATH;
				echo "/dataview.js\"></script>\r\n\t\t<script src=\"";
				echo $CRM_CONTEXT_JS_PATH;
				echo "/operation.js\"></script>\r\n\t\t<script src=\"";
				echo $CRM_CONTEXT_LANGUAGE_PATH;
				echo "/general.js\"></script>\r\n\t\t<script src=\"/module/Datepicker/WdatePicker.js\"></script>\r\n\r\n\t\t<div style=\"margin:5px;\"><img src='";
				echo $CRM_CONTEXT_IMG_PATH;
				echo "/module_icon/small/search.png' align=\"absMiddle\" width=32 height=32/><span class=\"crm_big20_bold\">";
				echo _( "选择" );
				echo $entity_array[$entity];
				echo "</span></div>\r\n\t\t<table width=\"98%\"  align=\"center\">\r\n\t\t<tr><td width=\"100%\">\r\n\t\t<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" >\r\n\t\t<tr>\r\n\t\t<td><img src=\"";
				echo $CRM_CONTEXT_IMG_PATH;
				echo "/search/top_left_conner.png\" /></td>\r\n\t\t<td class=\"search_top_border\" width=\"100%\"></td>\r\n\t\t<td><img src=\"";
				echo $CRM_CONTEXT_IMG_PATH;
				echo "/search/top_right_conner.png\" /></td>\r\n\t\t</tr>\r\n\t\t<tr>\r\n\t\t<td class=\"search_left_border\"></td>\r\n\t\t<td>\r\n\r\n\t\t<!--start search field -->\r\n\t\t";
				$I = 0;
				for ( ;	$I < $cnt;	++$I	)
				{
								$FIELD = "field".$I;
								$VALUE = "value".$I;
								if ( $$FIELD == "CRM_ACCOUNT.account_name" )
								{
												$ACCOUNT_NAME = $$VALUE;
								}
								else if ( $$FIELD == "CRM_ACCOUNT.account_code" )
								{
												$ACCOUNT_CODE = $$VALUE;
								}
								else if ( $$FIELD == "CRM_ACCOUNT.account_mobile" )
								{
												$ACCOUNT_MOBILE = $$VALUE;
								}
								else if ( $$FIELD == "CRM_ACCOUNT.account_email" )
								{
												$ACCOUNT_EMAIL = $$VALUE;
								}
								else if ( $$FIELD == "CRM_ACCOUNT_CONTACT.contact_name" )
								{
												$CONTACT_NAME = $$VALUE;
								}
								else if ( $$FIELD == "CRM_ACCOUNT_CONTACT.contact_certificate_code" )
								{
												$CONTACT_CERTIFICATE_CODE = $$VALUE;
								}
								else if ( $$FIELD == "CRM_ACCOUNT_CONTACT.contact_birthday" )
								{
												$CONTACT_BIRTHDAY = $$VALUE;
								}
								else if ( $$FIELD == "CRM_ACCOUNT_CONTACT.contact_email" )
								{
												$CONTACT_EMAIL = $$VALUE;
								}
								else if ( $$FIELD == "CRM_OPPORTUNITY.opportunity_name" )
								{
												$OPPORTUNITY_NAME = $$VALUE;
								}
								else if ( $$FIELD == "CRM_ACCOUNT_CONTACT.opportunity_principal" )
								{
												$OPPORTUNITY_PRINCIPAL = $$VALUE;
								}
								else if ( $$FIELD == "USER_CRM_OPPORTUNITY_user_name.USER_NAME" )
								{
												$SHOW_OPPORTUNITY_PRINCIPAL = $$VALUE;
								}
								else if ( $$FIELD == "CRM_ORDER.order_code" )
								{
												$ORDER_CODE = $$VALUE;
								}
								else if ( $$FIELD == "CRM_ORDER.order_name" )
								{
												$ORDER_NAME = $$VALUE;
								}
								else if ( $$FIELD == "CRM_ORDER.order_sign_date" )
								{
												$ORDER_SIGN_DATE = $$VALUE;
								}
								else if ( $$FIELD == "CRM_QUOTATION.quotation_code" )
								{
												$QUOTATION_CODE = $$VALUE;
								}
								else if ( $$FIELD == "CRM_QUOTATION.quotation_title" )
								{
												$QUOTATION_TITLE = $$VALUE;
								}
								else if ( $$FIELD == "CRM_QUOTATION.quotation_date" )
								{
												$QUOTATION_DATE = $$VALUE;
								}
								else if ( $$FIELD == "CRM_QUOTATION.quotation_period" )
								{
												$QUOTATION_PERIOD = $$VALUE;
								}
								else if ( $$FIELD == "CRM_DEPOSITORY.depository_code" )
								{
												$DEPOSITORY_CODE = $$VALUE;
								}
								else if ( $$FIELD == "CRM_DEPOSITORY.depository_name" )
								{
												$DEPOSITORY_NAME = $$VALUE;
								}
								else if ( $$FIELD == "CRM_DEPOSITORY.dept_id" )
								{
												$DEPT_ID = $$VALUE;
								}
								else if ( $$FIELD == "DEPARTMENT_CRM_DEPOSITORY_dept_name.dept_name" )
								{
												$SHOW_DEPT_ID = $$VALUE;
								}
								else if ( $$FIELD == "CRM_SUPPLIER.supplier_code" )
								{
												$SUPPLIER_CODE = $$VALUE;
								}
								else if ( $$FIELD == "CRM_SUPPLIER.supplier_name" )
								{
												$SUPPLIER_NAME = $$VALUE;
								}
								else if ( $$FIELD == "CRM_SUPPLIER.supplier_phone" )
								{
												$SUPPLIER_PHONE = $$VALUE;
								}
								else if ( $$FIELD == "CRM_SUPPLIER.supplier_email" )
								{
												$SUPPLIER_EMAIL = $$VALUE;
								}
								else if ( $$FIELD == "CRM_PRODUCT_TYPE.product_type_name" )
								{
												$PRODUCT_TYPE_NAME = $$VALUE;
								}
								else if ( $$FIELD == "CRM_PRODUCT_TYPE.product_type_code" )
								{
												$PRODUCT_TYPE_CODE = $$VALUE;
								}
								else if ( $$FIELD == "CRM_PURCHASE_ORDER.purchase_code" )
								{
												$PURCHASE_CODE = $$VALUE;
								}
								else if ( $$FIELD == "CRM_PURCHASE_ORDER.purchase_name" )
								{
												$PURCHASE_NAME = $$VALUE;
								}
								else if ( $$FIELD == "CRM_SUPPLIER.supplier_name" )
								{
												$SUPPLIER_NAME = $$VALUE;
								}
								else if ( $$FIELD == "CRM_PURCHASE_ORDER.purchase_date" )
								{
												$PURCHASE_DATE = $$VALUE;
								}
								else if ( $$FIELD == "CRM_SUPPLIER_CONTACT.supplier_contact_name" )
								{
												$SUPPLIER_CONTACT_NAME = $$VALUE;
								}
								else if ( $$FIELD == "CRM_SUPPLIER_CRM_SUPPLIER_CONTACT_supplier_name.supplier_name" )
								{
												$SUPPLIER_NAME = $$VALUE;
								}
								else if ( $$FIELD == "CRM_SUPPLIER_CONTACT.supplier_contact_mobile" )
								{
												$SUPPLIER_CONTACT_MOBILE = $$VALUE;
								}
								else if ( $$FIELD == "CRM_SUPPLIER_CONTACT.supplier_contact_email" )
								{
												$SUPPLIER_CONTACT_EMAIL = $$VALUE;
								}
				}
				echo "\t\t<form name=\"form1\" action=\"#\" method=\"post\">\r\n\t\t";
				if ( $entity == "account_select" )
				{
								echo "\t\t\t<table width = \"100%\">\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td width = \"100%\">\r\n\t\t\t\t\t\t<table cellpadding=\"2px\" cellspacing=\"2px\" width=\"100%\">\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t ";
								printsctrloftext( _( "客户名称：" ), "account_name", "{$ACCOUNT_NAME}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrloftext( _( "客户编码：" ), "account_code", "{$ACCOUNT_CODE}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrloftext( _( "客户手机：" ), "account_mobile", "{$ACCOUNT_MOBILE}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrloftext( "E-MAIL：", "account_email", "{$ACCOUNT_EMAIL}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td align = \"left\" valign = \"bottom\">\r\n\t\t\t\t\t\t<script>\r\n\t\t\t\t\t\t\tvar fields=new Array('CRM_ACCOUNT.account_name','CRM_ACCOUNT.account_code','CRM_ACCOUNT.account_mobile','CRM_ACCOUNT.account_email'); \r\n\t\t\t\t\t\t\tvar ctrls=new Array('account_name','account_code','account_mobile','account_email');\r\n\t\t\t\t\t\t\tvar ops=new Array('cts','cts','cts','cts');\r\n\t\t\t\t\t\t</script>\r\n\t\t\t\t\t\t<img src=\"";
								echo $CRM_CONTEXT_IMG_PATH;
								echo "/search/search_new.png\" onclick = \"gotoViewPageBySearch(fields, ctrls, ops)\" style=\"margin-left:25px;\" />\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t";
				}
				if ( $entity == "contact_select" )
				{
								echo "\t\t\t<table width = \"100%\">\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td width = \"100%\">\r\n\t\t\t\t\t\t<table cellpadding=\"2px\" cellspacing=\"2px\" width=\"100%\">\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t ";
								printsctrloftext( _( "联系人姓名:" ), "contact_name", "{$CONTACT_NAME}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t ";
								printsctrloftext( _( "证件号码:" ), "contact_certificate_code", "{$CONTACT_CERTIFICATE_CODE}" );
								echo "\t\r\n\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrlofdate( _( "出生日期：" ), "contact_birthday", "{$CONTACT_BIRTHDAY}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrloftext( "E-MAIL：", "contact_email", "{$CONTACT_EMAIL}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td align = \"left\" valign = \"bottom\">\r\n\t\t\t\t\t\t<script>\r\n\t\t\t\t\t\t\tvar contact_fields=new Array('CRM_ACCOUNT_CONTACT.contact_name','CRM_ACCOUNT_CONTACT.contact_certificate_code','CRM_ACCOUNT_CONTACT.contact_birthday','CRM_ACCOUNT_CONTACT.contact_email'); \r\n\t\t\t\t\t\t\tvar contact_ctrls=new Array('contact_name','contact_certificate_code','contact_birthday','contact_email');\r\n\t\t\t\t\t\t\tvar contact_ops=new Array('cts','cts','is','cts');\r\n\t\t\t\t\t\t</script>\r\n\t\t\t\t\t\t<img src=\"";
								echo $CRM_CONTEXT_IMG_PATH;
								echo "/search/search_new.png\" onclick = \"gotoViewPageBySearch(contact_fields, contact_ctrls, contact_ops)\" style=\"margin-left:25px;\" />\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t";
				}
				if ( $entity == "opportunity_select" )
				{
								echo "\t\t\t<table width = \"100%\">\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td width = \"100%\">\r\n\t\t\t\t\t\t<table cellpadding=\"2px\" cellspacing=\"2px\" width=\"100%\">\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t ";
								printsctrloftext( _( "商机名称：" ), "opportunity_name", "{$OPPORTUNITY_NAME}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrlofsingleuser( _( "负责人:" ), "opportunity_principal", $OPPORTUNITY_PRINCIPAL, $SHOW_OPPORTUNITY_PRINCIPAL );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td align = \"left\" valign = \"bottom\">\r\n\t\t\t\t\t\t<script>\r\n\t\t\t\t\t\t\tvar opportuniy_fields=new Array('CRM_OPPORTUNITY.opportunity_name','CRM_OPPORTUNITY.opportunity_principal','USER_CRM_OPPORTUNITY_user_name.USER_NAME'); \r\n\t\t\t\t\t\t\tvar opportuniy_ctrls=new Array('opportunity_name','hd_opportunity_principal','opportunity_principal');\r\n\t\t\t\t\t\t\tvar opportuniy_ops=new Array('cts','is','is');\r\n\t\t\t\t\t\t</script>\r\n\t\t\t\t\t\t<img src=\"";
								echo $CRM_CONTEXT_IMG_PATH;
								echo "/search/search_new.png\" onclick = \"gotoViewPageBySearch(opportuniy_fields, opportuniy_ctrls, opportuniy_ops)\" style=\"margin-left:25px;\" />\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t";
				}
				if ( $entity == "order_select" )
				{
								echo "\t\t\t<table width = \"100%\">\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td width = \"100%\">\r\n\t\t\t\t\t\t<table cellpadding=\"2px\" cellspacing=\"2px\" width=\"100%\">\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t ";
								printsctrloftext( _( "订单编号：" ), "order_code", "{$ORDER_CODE}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrloftext( _( "订单名称：" ), "order_name", "{$ORDER_NAME}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrlofdate( _( "签订日期：" ), "order_sign_date", "{$ORDER_SIGN_DATE}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td align = \"left\" valign = \"bottom\">\r\n\t\t\t\t\t\t<script>\r\n\t\t\t\t\t\t\tvar order_fields=new Array('CRM_ORDER.order_code','CRM_ORDER.order_name','CRM_ORDER.order_sign_date'); \r\n\t\t\t\t\t\t\tvar order_ctrls=new Array('order_code','order_name','order_sign_date');\r\n\t\t\t\t\t\t\tvar order_ops=new Array('cts','cts','is');\r\n\t\t\t\t\t\t</script>\r\n\t\t\t\t\t\t<img src=\"";
								echo $CRM_CONTEXT_IMG_PATH;
								echo "/search/search_new.png\" onclick = \"gotoViewPageBySearch(order_fields, order_ctrls, order_ops)\" style=\"margin-left:25px;\" />\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t";
				}
				if ( $entity == "quotation_select" )
				{
								echo "\t\t\t<table width = \"100%\">\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td width = \"100%\">\r\n\t\t\t\t\t\t<table cellpadding=\"2px\" cellspacing=\"2px\" width=\"100%\">\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t ";
								printsctrloftext( _( "报价单编号：" ), "quotation_code", "{$QUOTATION_CODE}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrloftext( _( "报价单标题：" ), "quotation_title", "{$QUOTATION_TITLE}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrlofdate( _( "报价日期：" ), "quotation_date", "{$QUOTATION_DATE}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrlofdate( _( "报价有效期：" ), "quotation_period", "{$QUOTATION_PERIOD}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td align = \"left\" valign = \"bottom\">\r\n\t\t\t\t\t\t<script>\r\n\t\t\t\t\t\t\tvar quotation_fields=new Array('CRM_QUOTATION.quotation_code','CRM_QUOTATION.quotation_title','CRM_QUOTATION.quotation_date','CRM_QUOTATION.quotation_period'); \r\n\t\t\t\t\t\t\tvar quotation_ctrls=new Array('quotation_code','quotation_title','quotation_date','quotation_period');\r\n\t\t\t\t\t\t\tvar quotation_ops=new Array('cts','cts','is','is');\r\n\t\t\t\t\t\t</script>\r\n\t\t\t\t\t\t<img src=\"";
								echo $CRM_CONTEXT_IMG_PATH;
								echo "/search/search_new.png\" onclick = \"gotoViewPageBySearch(quotation_fields, quotation_ctrls, quotation_ops)\" style=\"margin-left:25px;\" />\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t";
				}
				if ( $entity == "depository_select" )
				{
								echo "\t\t\t<table width = \"100%\">\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td width = \"100%\">\r\n\t\t\t\t\t\t<table cellpadding=\"2px\" cellspacing=\"2px\" width=\"100%\">\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t ";
								printsctrloftext( _( "仓库编号：" ), "depository_code", "{$DEPOSITORY_CODE}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrloftext( _( "仓库名称：" ), "depository_name", "{$DEPOSITORY_NAME}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrlofsingledept( _( "所属部门：" ), "dept_id", "{$DEPT_ID}", "{$SHOW_DEPT_ID}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td align = \"left\" valign = \"bottom\">\r\n\t\t\t\t\t\t<script>\r\n\t\t\t\t\t\t\tvar depository_fields=new Array('CRM_DEPOSITORY.depository_code','CRM_DEPOSITORY.depository_name','CRM_DEPOSITORY.dept_id','DEPARTMENT_CRM_DEPOSITORY_dept_name.dept_name'); \r\n\t\t\t\t\t\t\tvar depository_ctrls=new Array('depository_code','depository_name','hd_dept_id','dept_id');\r\n\t\t\t\t\t\t\tvar depository_ops=new Array('cts','cts','is','is');\r\n\t\t\t\t\t\t</script>\r\n\t\t\t\t\t\t<img src=\"";
								echo $CRM_CONTEXT_IMG_PATH;
								echo "/search/search_new.png\" onclick = \"gotoViewPageBySearch(depository_fields, depository_ctrls, depository_ops)\" style=\"margin-left:25px;\" />\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t";
				}
				if ( $entity == "supplier_select" )
				{
								echo "\t\t\t<table width = \"100%\">\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td width = \"100%\">\r\n\t\t\t\t\t\t<table cellpadding=\"2px\" cellspacing=\"2px\" width=\"100%\">\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t ";
								printsctrloftext( _( "供应商编号：" ), "supplier_code", "{$SUPPLIER_CODE}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrloftext( _( "供应商名称：" ), "supplier_name", "{$SUPPLIER_NAME}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrloftext( _( "供应商电话：" ), "supplier_phone", "{$SUPPLIER_PHONE}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrloftext( "E-MAIL：", "supplier_email", "{$SUPPLIER_EMAIL}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td align = \"left\" valign = \"bottom\">\r\n\t\t\t\t\t\t<script>\r\n\t\t\t\t\t\t\tvar supplier_fields=new Array('CRM_SUPPLIER.supplier_code','CRM_SUPPLIER.supplier_name','CRM_SUPPLIER.supplier_phone','CRM_SUPPLIER.supplier_email'); \r\n\t\t\t\t\t\t\tvar supplier_ctrls=new Array('supplier_code','supplier_name','supplier_phone','supplier_email');\r\n\t\t\t\t\t\t\tvar supplier_ops=new Array('cts','cts','cts','cts');\r\n\t\t\t\t\t\t</script>\r\n\t\t\t\t\t\t<img src=\"";
								echo $CRM_CONTEXT_IMG_PATH;
								echo "/search/search_new.png\" onclick = \"gotoViewPageBySearch(supplier_fields, supplier_ctrls, supplier_ops)\" style=\"margin-left:25px;\" />\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t";
				}
				if ( $entity == "product_type_select" )
				{
								echo "\t\t\t<table width = \"100%\">\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td width = \"100%\">\r\n\t\t\t\t\t\t<table cellpadding=\"2px\" cellspacing=\"2px\" width=\"100%\">\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t ";
								printsctrloftext( _( "类别名称：" ), "product_type_name", "{$PRODUCT_TYPE_NAME}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrloftext( _( "类别编号：" ), "product_type_code", "{$PRODUCT_TYPE_CODE}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td align = \"left\" valign = \"bottom\">\r\n\t\t\t\t\t\t<script>\r\n\t\t\t\t\t\t\tvar crm_product_type_fields=new Array('CRM_PRODUCT_TYPE.product_type_name','CRM_PRODUCT_TYPE.product_type_code'); \r\n\t\t\t\t\t\t\tvar crm_product_type_ctrls=new Array('product_type_name','product_type_code');\r\n\t\t\t\t\t\t\tvar crm_product_type_ops=new Array('cts','cts');\r\n\t\t\t\t\t\t</script>\r\n\t\t\t\t\t\t<img src=\"";
								echo $CRM_CONTEXT_IMG_PATH;
								echo "/search/search_new.png\" onclick = \"gotoViewPageBySearch(crm_product_type_fields, crm_product_type_ctrls, crm_product_type_ops)\" style=\"margin-left:25px;\" />\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t";
				}
				if ( $entity == "purchase_order_select" )
				{
								echo "\t\t\t<table width = \"100%\">\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td width = \"100%\">\r\n\t\t\t\t\t\t<table cellpadding=\"2px\" cellspacing=\"2px\" width=\"100%\">\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t ";
								printsctrloftext( _( "采购单号：" ), "purchase_code", "{$PURCHASE_CODE}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrloftext( _( "采购主题" ), "purchase_name", "{$PURCHASE_NAME}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrloftext( _( "所属供应商" ), "supplier_name", "{$SUPPLIER_NAME}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t";
								printsctrlofdate( _( "采购日期" ), "purchase_date", "{$purchase_date}" );
								echo "\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t</table>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td align = \"left\" valign = \"bottom\">\r\n\t\t\t\t\t\t<script>\r\n\t\t\t\t\t\t\tvar purchase_order_fields=new Array('CRM_PURCHASE_ORDER.purchase_code','CRM_PURCHASE_ORDER.purchase_name','CRM_SUPPLIER.supplier_name','CRM_PURCHASE_ORDER.purchase_date'); \r\n\t\t\t\t\t\t\tvar purchase_order_ctrls=new Array('purchase_code','purchase_name','supplier_name','purchase_date');\r\n\t\t\t\t\t\t\tvar purchase_order_ops=new Array('cts','cts','cts','is');\r\n\t\t\t\t\t\t</script>\r\n\t\t\t\t\t\t<img src=\"";
								echo $CRM_CONTEXT_IMG_PATH;
								echo "/search/search_new.png\" onclick = \"gotoViewPageBySearch(purchase_order_fields, purchase_order_ctrls, purchase_order_ops)\" style=\"margin-left:25px;\" />\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t";
				}
				if ( $entity == "supplier_contact_select" )
				{
								echo "\t\t\t\t<table width = \"100%\">\r\n\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td width = \"100%\">\r\n\t\t\t\t\t\t\t<table cellpadding=\"2px\" cellspacing=\"2px\" width=\"100%\">\r\n\t\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t\t ";
								printsctrloftext( _( "联系人姓名：" ), "supplier_contact_name", "{$SUPPLIER_CONTACT_NAME}" );
								echo "\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t\t";
								printsctrloftext( _( "供应商名称：" ), "supplier_name", "{$SUPPLIER_NAME}" );
								echo "\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t\t<tr>\r\n\t\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t\t";
								printsctrloftext( _( "手机号码：" ), "supplier_contact_mobile", "{$SUPPLIER_CONTACT_MOBILE}" );
								echo "\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t\t\t\t\t";
								printsctrloftext( "E-MAIL：", "supplier_contact_email", "{$SUPPLIER_CONTACT_EMAIL}" );
								echo "\t\t\t\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t\t\t</tr>\r\n\t\t\t\t\t\t\t</table>\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<td align = \"left\" valign = \"bottom\">\r\n\t\t\t\t\t\t\t<script>\r\n\t\t\t\t\t\t\t\tvar supplier_contact_fields=new Array('CRM_SUPPLIER_CONTACT.supplier_contact_name','CRM_SUPPLIER_CRM_SUPPLIER_CONTACT_supplier_name.supplier_name','CRM_SUPPLIER_CONTACT.supplier_contact_mobile','CRM_SUPPLIER_CONTACT.supplier_contact_email'); \r\n\t\t\t\t\t\t\t\tvar supplier_contact_ctrls=new Array('supplier_contact_name','supplier_name','supplier_contact_mobile','supplier_contact_email');\r\n\t\t\t\t\t\t\t\tvar supplier_contact_ops=new Array('cts','cts','cts','cts');\r\n\t\t\t\t\t\t\t</script>\r\n\t\t\t\t\t\t\t<img src=\"";
								echo $CRM_CONTEXT_IMG_PATH;
								echo "/search/search_new.png\" onclick = \"gotoViewPageBySearch(supplier_contact_fields, supplier_contact_ctrls, supplier_contact_ops)\" style=\"margin-left:25px;\" />\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t</table>\r\n\t\t";
				}
				echo "\t\t</form>\r\n\t\t<!--end search field-->\r\n\t\t</td>\r\n\t\t<td class=\"search_right_border\"></td>\r\n\t\t</tr>\r\n\t\t<tr>\r\n\t\t<td><img src=\"";
				echo $CRM_CONTEXT_IMG_PATH;
				echo "/search/bottom_left_conner.png\" /></td>\r\n\t\t<td class=\"search_bottom_border\" width=\"100%\"></td>\r\n\t\t<td><img src=\"";
				echo $CRM_CONTEXT_IMG_PATH;
				echo "/search/bottom_right_conner.png\" /></td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\r\n\r\n\r\n\t\t<!-- start page bar -->\r\n\t\t<div style=\"float:right;margin-top:3px;padding-top:5px;\">\r\n\t\t\t<table cellpadding=\"0\" cellspacing=\"0\" class=\"page_bar\" width=\"330px\">\r\n\t\t\t\t<tr >\r\n\t\t\t\t\t<td class=\"page_bar_bg\"> ";
				echo sprintf( _( "第%s/%s页" ), $CUR_PAGE, $TOTAL_PAGE );
				echo "<a href=\"javascript:gotoViewPage(1)\">\r\n\t\t\t\t\t<img src=\"";
				echo $CRM_CONTEXT_IMG_PATH;
				echo "/page_bar/first_btn.png\"/></a>\r\n\t\t\t\t\t<a href=\"javascript:gotoViewPage(";
				echo $CUR_PAGE - 1;
				echo ")\"><img src=\"";
				echo $CRM_CONTEXT_IMG_PATH;
				echo "/page_bar/prev_btn.png\"/></a>\r\n\t\t\t\t\t<a href=\"javascript:gotoViewPage(";
				echo $CUR_PAGE + 1;
				echo ")\"><img src=\"";
				echo $CRM_CONTEXT_IMG_PATH;
				echo "/page_bar/next_btn.png\"/></a>\r\n\t\t\t\t\t<a href=\"javascript:gotoViewPage(";
				echo $TOTAL_PAGE;
				echo ")\"><img src=\"";
				echo $CRM_CONTEXT_IMG_PATH;
				echo "/page_bar/last_btn.png\"/></a>\r\n\t\t\t\t\t";
				echo sprintf( _( "共%s条" ), $TOTAL_COUNT );
				echo "&nbsp;";
				echo _( "转到" );
				echo "&nbsp;";
				echo sprintf( _( "第%s页" ), "&nbsp;<input type=\"text\" name=\"jumpPage\" style=\"width:30px;height:20px;\" class=\"efViewTextBox\" onKeyDown=\"jumpPage(this,event,".$TOTAL_PAGE.");\"/>&nbsp;" );
				echo "\t\t\t\t\t<img src=\"";
				echo $CRM_CONTEXT_IMG_PATH;
				echo "/page_bar/go_page.gif\" onClick=\"gotoViewPage(document.getElementById('jumpPage').value)\" title=\"";
				echo _( "跳转" );
				echo "\"/>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t</div>\r\n\t\t<div style=\"float:left;height:35px;\">\r\n\t\t</div>\r\n\t\t<!-- end page bar -->\r\n\t\t<!-- start data field-->\r\n\t\t<table cellpadding=\"0\" cellspacing=\"0\" width=\"98%\" align=\"center\">\r\n\t\t<tr>\r\n\t\t<td><img src=\"";
				echo $CRM_CONTEXT_IMG_PATH;
				echo "/list/top_left_conner.png\"/></td>\r\n\t\t<td class=\"list_top_border\" width=\"100%\"></td>\r\n\t\t<td><img src=\"";
				echo $CRM_CONTEXT_IMG_PATH;
				echo "/list/top_right_conner.png\"/></td>\r\n\t\t</tr>\r\n\t\t<tr>\r\n\t\t<td class=\"list_left_border\"></td>\r\n\t\t<td>\r\n\t\t<!--start data list-->\r\n\t\t<div style=\"overflow-x:auto; overflow-y:auto;height:";
				echo $DIV_HEIGHT - 25;
				echo "px; width:100%);\">\r\n\t\t<table class=\"CRM_TableList\" width=\"100%\" cellpadding=\"1px\" cellspacing=\"1px\">\r\n\t\t<tr class=\"CRM_TableHeader\">\r\n\t\t";
				$header_arr = explode( ":", $table_header );
				$header_len = count( $header_arr ) - 1;
				$i = 0;
				for ( ;	$i < $header_len;	++$i	)
				{
								printlistlabel( $header_arr[$i] );
				}
				echo "\t\t</tr>\r\n\t\t<script>\r\n\t\t\tvar select_obj=\"\";\r\n\t\t</script>\r\n\t\t";
				$query .= $query_where.( " ORDER BY ".$main_table.".id DESC" ).$query_limit;
				$cursor = exequery( $connection, $query );
				$COUNT = 0;
				while ( $row = mysql_fetch_object( $cursor ) )
				{
								++$COUNT;
								$LINE_CLASS = $COUNT % 2 == 0 ? "CRM_TableLine1" : "CRM_TableLine2";
								echo "<tr class='";
								echo $LINE_CLASS;
								echo "' id='";
								echo $COUNT;
								echo "' value='";
								echo $COUNT;
								echo "' onclick='select(";
								echo $COUNT;
								echo ",\"click\");' ondblclick='select(";
								echo $COUNT;
								echo ",\"dbclick\")' onmousemove='changestyle(";
								echo $COUNT;
								echo ");' height='25px'>";
								$right_count = 0;
								foreach ( $row as $key => $value )
								{
												if ( strpos( $value, "0000-00-00" ) === 0 || strpos( $value, "00:00:00" ) === 0 || $value == "" )
												{
																$value = "";
												}
												$title_value = $value;
												if ( 20 < strlen( $value ) )
												{
																$value = csubstr( $value, 0, 18 )."...";
												}
												echo "<td name='".$key."' value='{$value}' title=\"".htmlspecialchars( $title_value )."\"";
												if ( $key == "id" )
												{
																echo "style='display:none;'";
												}
												echo ">";
												$i = 0;
												for ( ;	$i < $data_cnt;	++$i	)
												{
																$selected_field = "selected_field".$i;
																$selected_value = "selected_value".$i;
																$page_selected_field = $$selected_field;
																$page_selected_value = iconv( "UTF-8", "GB2312", $$selected_value );
																if ( !( $key == $page_selected_field ) || !( $value == $page_selected_value ) )
																{
																				++$right_count;
																}
												}
												if ( $right_count == $data_cnt )
												{
																echo "\t\t\t\t\t<script>\r\n\t\t\t\t\t\tvar select_obj=document.getElementById(\"";
																echo $COUNT;
																echo "\");\r\n\t\t\t\t\t\tvar\tselect_org_class=\"";
																echo $LINE_CLASS;
																echo "\";\r\n\t\t\t\t\t\tselect_obj.className=\"select_tr\";\r\n\t\t\t\t\t</script>\r\n\t\t\t\t";
												}
												echo $value;
												echo "</td>";
								}
								echo "</tr>\n";
				}
				--$COUNT;
				for ( ;	$COUNT < $LIST_PAGE_SIZE - 1;	++$COUNT	)
				{
								$LINE_CLASS = $COUNT % 2 == 0 ? "CRM_TableLine1" : "CRM_TableLine2";
								echo "<tr class='";
								echo $LINE_CLASS;
								echo "'>";
								$J = 0;
								for ( ;	$J < $row_num;	++$J	)
								{
												printlistemptydata( );
								}
								echo "</tr>\n";
				}
				echo "\t\t</table>\r\n\t\t</div>\r\n\r\n\t\t<!--end data list-->\r\n\t\t</td>\r\n\t\t<td class=\"list_right_border\"></td>\r\n\t\t</tr>\r\n\t\t<tr>\r\n\t\t<td><img src=\"";
				echo $CRM_CONTEXT_IMG_PATH;
				echo "/list/bottom_left_conner.png\"/></td>\r\n\t\t<td class=\"list_bottom_border\" width=\"100%\"></td>\r\n\t\t<td><img src=\"";
				echo $CRM_CONTEXT_IMG_PATH;
				echo "/list/bottom_right_conner.png\"/></td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t\t<!-- end data field-->\r\n\t\t";
}
echo "<style>\r\n\t.select_tr td{background:#cbefcf;}\r\n\t.mouseover_tr td{background:#e6e8ed;}\r\n</style>\r\n<script>\r\n\tvar last_row;\r\n\tfunction select(row_num,eve){\r\n\t\torg_className=(row_num%2==0) ? \"CRM_TableLine1\" : \"CRM_TableLine2\";\r\n\t\tvar obj=document.getElementById(row_num);\r\n\t\tvar td_arr=obj.getElementsByTagName(\"td\");\r\n\t\tvar len=td_arr.length;\r\n\t\tvar data_cnt=getQueryString(\"data_cnt\");\r\n\t\tif(obj.className!=\"select_tr\"){\r\n\t\t\tif(select_obj!=\"\"){\r\n\t\t\t\tselect_obj.className=select_org_class;\r\n\t\t\t}\r\n\t\t\tif(last_row!=undefined){//为上一个选中的行单选恢复样式\r\n\t\t\t\tdocument.getElementById(last_row).className=(last_row%2==0) ? \"CRM_TableLine1\" : \"CRM_TableLine2\";\r\n\t\t\t}\r\n\t\t\tobj.className=\"select_tr\";\r\n\t\t\tfor(j=0;j<data_cnt;j++){\r\n\t\t\t\tvar fields=getQueryString(\"ctrl_field\"+j);\r\n\t\t\t\tvar values=getQueryString(\"ctrl_value\"+j);\r\n\t\t\t\tfor(i=0;i<len;i++){\r\n\t\t\t\t\tif(obj.childNodes[i].name==values){\r\n\t\t\t\t\t\twindow.opener.document.getElementById(fields).value=obj.childNodes[i].value;\r\n\t\t\t\t\t}\r\n\t\t\t\t}\r\n\t\t\t}\t\r\n\t\t}else{\r\n\t\t\tif(eve==\"click\"){\r\n\t\t\t\twindow.setTimeout(delay, 500)//单击加延时区分单双击事件\r\n\t\t\t\t\tfunction delay(){\r\n\t\t\t\t\t\tobj.className=org_className;\r\n\t\t\t\t\t\tfor(j=0;j<data_cnt;j++){\r\n\t\t\t\t\t\t\tvar fields=getQueryString(\"ctrl_field\"+j);\r\n\t\t\t\t\t\t\twindow.opener.document.getElementById(fields).value=\"\";\r\n\t\t\t\t\t\t}\r\n\t\t\t\t\t}\r\n\t\t\t}else if(eve==\"dbclick\"){\r\n\t\t\t\twindow.close();\r\n\t\t\t}\r\n\t\t}\r\n\t\tlast_row=row_num;\r\n\t}\r\n\t\r\n\tvar last_over_row=\"\";\r\n\tfunction changestyle(row_num){\r\n\t\torg_className=(row_num%2==0) ? \"CRM_TableLine1\" : \"CRM_TableLine2\";\r\n\t\tvar obj=document.getElementById(row_num);\r\n\t\tif(obj.className==\"select_tr\"){\r\n\t\t\t\r\n\t\t}else{\r\n\t\t\tif(last_over_row!=\"\"){\r\n\t\t\t\tif(document.getElementById(last_over_row).className==\"select_tr\"){\r\n\r\n\t\t\t\t}else{\r\n\t\t\t\t\tdocument.getElementById(last_over_row).className=(last_over_row%2==0) ? \"CRM_TableLine1\" : \"CRM_TableLine2\";\r\n\t\t\t\t}\r\n\t\t\t}\r\n\t\t\tobj.className=\"mouseover_tr\";\r\n\t\t\tlast_over_row=row_num;\r\n\t\t}\r\n\t}\r\n</script>";
?>
