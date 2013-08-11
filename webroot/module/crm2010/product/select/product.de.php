<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "general/crm/inc/header.php" );
include_once( "general/crm/utils/dataview/dataview.interface.php" );
include_once( "general/crm/utils/search/search.interface.php" );
$MODULE = "CRM_PRODUCT";
$MODULE_NAME = _( "产品管理" );
$COL_SIZE = 6;
$KEY_COLUMN = "CRM_PRODUCT.id";
$LIST_PAGE_SIZE = 20;
if ( $PROD_TYPE )
{
				$type = "AND CRM_PRODUCT.product_type_id = '".$PROD_TYPE."' ";
}
$LIST_CLAUSE = "CRM_PRODUCT.id,CRM_PRODUCT.product_code,CRM_PRODUCT.product_name,CRM_PRODUCT.product_specification,CRM_PRODUCT.measure_id,crm_product_type.product_type_name,CRM_PRODUCT.product_band ";
$FROM_CLAUSE = " FROM CRM_PRODUCT ";
$JOIN_CLAUSE = " LEFT OUTER JOIN crm_sys_code as crm_sys_code_CRM_PRODUCT_measure_id ON  crm_sys_code_CRM_PRODUCT_measure_id.code_type='MEASURE_ID'  AND crm_sys_code_CRM_PRODUCT_measure_id.code_no=CRM_PRODUCT.measure_id \r\nleft join crm_product_type on crm_product_type.Id = CRM_PRODUCT.product_type_id ";
$WHERE_CLAUSE = " WHERE CRM_PRODUCT.deleted = 0  ".$type." ";
$I = 0;
for ( ;	$I < $cnt;	++$I	)
{
				$FIELD = "field".$I;
				$VALUE = "value".$I;
				$OP = "op".$I;
				$WHERE_CLAUSE .= " AND ".$$FIELD;
				if ( $$OP == "is" )
				{
								$WHERE_CLAUSE .= " = '".$$VALUE."' ";
				}
				else if ( $$OP == "cts" )
				{
								$WHERE_CLAUSE .= " like '%".$$VALUE."%' ";
				}
}
$ORDER_CLAUSE = "";
if ( $ORDERFIELD != "" )
{
				$ORDER_CLAUSE .= " ORDER BY ".$ORDERFIELD." ".$ORDERTYPE;
}
else
{
				$ORDER_CLAUSE .= " ORDER BY ".$KEY_COLUMN." DESC ";
}
$query = "SELECT COUNT(*) ".$FROM_CLAUSE.$JOIN_CLAUSE.$WHERE_CLAUSE;
$cursor = exequery( $connection, $query );
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
$LIMIT_CLAUSE = " limit ".$START_POS.",".$LIST_PAGE_SIZE;
$I = 0;
for ( ;	$I < $cnt;	++$I	)
{
				$FIELD = "field".$I;
				$VALUE = "value".$I;
				if ( $$FIELD == "CRM_PRODUCT.product_name" )
				{
								$product_name = $$VALUE;
				}
				else if ( $$FIELD == "CRM_PRODUCT.product_code" )
				{
								$product_code = $$VALUE;
				}
				else if ( $$FIELD == "CRM_PRODUCT.product_specification" )
				{
								$product_specification = $$VALUE;
				}
				else if ( $$FIELD == "CRM_PRODUCT_TYPE.product_type_name" )
				{
								$product_type_name = $$VALUE;
				}
}
echo "\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<script src=\"/inc/js/module.js\"></script>\r\n<script src=\"";
echo $CRM_CONTEXT_LANGUAGE_PATH;
echo "/ch_us.lang.js\"></script>\r\n<script src=\"";
echo $CRM_CONTEXT_JS_PATH;
echo "/dataview.js\"></script>\r\n<script src=\"";
echo $CRM_CONTEXT_JS_PATH;
echo "/general.js\"></script>\r\n<script src=\"";
echo $CRM_CONTEXT_JS_PATH;
echo "/productlist/pickupprodlist.js\"></script>\r\n<script src=\"";
echo $CRM_CONTEXT_JS_PATH;
echo "/operation.js\"></script>\r\n<script src=\"/module/DatePicker/WdatePicker.js\"></script>\r\n\r\n</head>\r\n<body style=\"padding:0pt 2pt;margin:0pt 2pt\">\r\n\r\n<table width=\"98%\">\r\n<tr><td width=\"87%\">\r\n\r\n<!--start search field -->\r\n<!--end search field-->\r\n<script>\r\nvar fields=new Array('CRM_PRODUCT.product_name','CRM_PRODUCT.product_code','CRM_PRODUCT.product_specification'); \r\nvar ctrls=new Array('product_name','product_code','product_specification');\r\nvar ops=new Array('cts','cts','cts');\r\n</script>\r\n<table width = \"92%\">\r\n\t<tr>\r\n\t\t<td width = \"100%\">\r\n\t\t\t<table cellpadding=\"2px\" cellspacing=\"2px\" width=\"100%\">\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t ";
printsctrloftext( _( "产品编号" ), "product_code", "{$product_code}" );
echo "\t\t\t\t\t</td>\r\n\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t ";
printsctrloftext( _( "产品名称" ), "product_name", "{$product_name}" );
echo "\t\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t";
printsctrloftext( _( "产品型号" ), "product_specification", "{$product_specification}" );
echo "\t\t\t\t\t</td>\r\n\t\t\t\t\t<td class=\"search_condition_field\" width=\"20%\">\r\n\t\t\t\t\t\t";
printsctrloftext( _( "产品类别" ), "product_type_name", "{$product_type_name}" );
echo "\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t</td>\r\n\t\t<td align = \"left\" valign = \"bottom\">\r\n\t\t\t<script>\r\n\t\t\t\tvar product_fields=new Array('CRM_PRODUCT.product_code','CRM_PRODUCT.product_name','CRM_PRODUCT.product_specification','CRM_PRODUCT_TYPE.product_type_name'); \r\n\t\t\t\tvar  product_ctrls=new Array('product_code','product_name','product_specification','product_type_name');\r\n\t\t\t\tvar  product_ops=new Array('cts','cts','cts','cts');\r\n\t\t\t</script>\r\n\t\t\t<img src=\"";
echo $CRM_CONTEXT_IMG_PATH;
echo "/search/search_new.png\" onclick = \"gotoViewPageBySearch(product_fields, product_ctrls, product_ops)\" style=\"margin-left:25px;\" />\r\n\t\t</td>\r\n\t</tr>\r\n</table>\r\n<!-- start page bar -->\r\n<table cellpadding=\"0\" cellspacing=\"0\" class=\"page_bar\" width=\"400px\">\r\n<tr>\r\n<td class=\"page_bar_bg\" > ";
echo sprintf( _( "第%s/%s页" ), $CUR_PAGE, $TOTAL_PAGE );
echo "<a href=\"javascript:gotoViewPage(1)\"><img src=\"";
echo $CRM_CONTEXT_IMG_PATH;
echo "/page_bar/first_btn.png\"/></a><a href=\"javascript:gotoViewPage(";
echo $CUR_PAGE - 1;
echo ")\"><img src=\"";
echo $CRM_CONTEXT_IMG_PATH;
echo "/page_bar/prev_btn.png\"/></a><a href=\"javascript:gotoViewPage(";
echo $CUR_PAGE + 1;
echo ")\"><img src=\"";
echo $CRM_CONTEXT_IMG_PATH;
echo "/page_bar/next_btn.png\"/></a><a href=\"javascript:gotoViewPage(";
echo $TOTAL_PAGE;
echo ")\"><img src=\"";
echo $CRM_CONTEXT_IMG_PATH;
echo "/page_bar/last_btn.png\"/></a> &nbsp;";
echo _( "转到" );
echo "&nbsp;";
echo sprintf( _( "第%s页" ), "<input type=\"text\" name=\"jumpPage\" style=\"width:30px;height:20px;\"/>" );
echo "&nbsp;<img src = \"";
echo $CRM_CONTEXT_IMG_PATH;
echo "/page_bar/go_page.gif\" title=\"";
echo _( "转到" );
echo "\" onclick=\"gotoViewPage(document.getElementById('jumpPage').value)\" height = \"16\"> ";
echo sprintf( _( "共%s条" ), $TOTAL_COUNT );
echo "</td>\r\n</tr>\r\n</table>\r\n<!-- end page bar -->\r\n\r\n<!-- start data field-->\r\n<div id=\"dataContainer\" style=\"height:expression(document.body.clientHeight - \r\n85);position:absolute;border-top:1 solid #b8d1e2;overflow-y:auto;overflow-x:auto;\" >\r\n<table style=\"table-layout:fixed;\" class=\"CRM_TableList1\" width=\"105%\" cellpadding=\"3px\" cellspacing=\"0px\" align=\"center\">\r\n<tr style=\"position:relative;top:expression(getScrollTop(window.dataContainer));\" class=\"TableHeader\">\r\n";
if ( $ORDERFIELD == "CRM_PRODUCT.product_code" )
{
				printlistlabel1( _( "产品编号" ), "", 1, "CRM_PRODUCT.product_code", $ORDERTYPE );
}
else
{
				printlistlabel1( _( "产品编号" ), "", 1, "CRM_PRODUCT.product_code" );
}
if ( $ORDERFIELD == "CRM_PRODUCT.product_name" )
{
				printlistlabel1( _( "产品名称" ), "", 1, "CRM_PRODUCT.product_name", $ORDERTYPE );
}
else
{
				printlistlabel1( _( "产品名称" ), "", 1, "CRM_PRODUCT.product_name" );
}
if ( $ORDERFIELD == "CRM_PRODUCT.product_specification" )
{
				printlistlabel1( _( "产品型号" ), "", 1, "CRM_PRODUCT.product_specification", $ORDERTYPE );
}
else
{
				printlistlabel1( _( "产品型号" ), "", 1, "CRM_PRODUCT.product_specification" );
}
printlistlabel1( _( "计量单位" ) );
printlistlabel1( _( "产品类别" ) );
printlistlabel1( _( "生产厂商" ) );
echo "</td>\r\n</tr>\r\n";
$COUNT = 0;
$query = "SELECT ".$LIST_CLAUSE.$FROM_CLAUSE.$JOIN_CLAUSE.$WHERE_CLAUSE.$ORDER_CLAUSE.$LIMIT_CLAUSE;
$cursor = exequery( $connection, $query );
while ( $row = mysql_fetch_object( $cursor ) )
{
				foreach ( $row as $key => $value )
				{
								$$key = $value;
				}
				++$COUNT;
				$LINE_CLASS = $COUNT % 2 == 0 ? "CRM_TableLine1" : "CRM_TableLine2";
				echo "<tr class='".$LINE_CLASS."' id=\"tr_".$id."\" class=\"TableLine\" ";
				echo "onmouseover=\"setRowPointerRtnMutli(this, 'over')\" onmouseout=\"setRowPointerRtnMutli(this, 'out')\" onclick=\"setRowPointerRtnMutli(this, 'click')\" ";
				echo "value=\"".$id."\">";
				printlisttextdata1( "product_code", $id, "{$product_code}" );
				printlisttextdata1( "product_name", $id, "{$product_name}" );
				printlisttextdata1( "product_specification", $id, "{$product_specification}" );
				printlisttextdata1( "product_measure", $id, "{$measure_id}" );
				printlisttextdata1( "product_type", $id, "{$product_type_name}" );
				printlisttextdata1( "product_band", $id, "{$product_band}" );
				echo "</tr>";
}
$COUNT += 1;
for ( ;	$COUNT < $LIST_PAGE_SIZE;	++$COUNT	)
{
				$LINE_CLASS = $COUNT % 2 == 0 ? "CRM_TableLine1" : "CRM_TableLine2";
				echo "<tr class='";
				echo $LINE_CLASS;
				echo "'>";
				$J = 0;
				for ( ;	$J < $COL_SIZE;	++$J	)
				{
								printlistemptydata( );
				}
				echo "</tr>";
}
echo "</table>\r\n<input type=\"hidden\" id=\"selectIds\" name=\"selectIds\"  value=\"\">\r\n<input type=\"hidden\" id=\"selectedID\" name=\"selectedID\"  value=\"\">\r\n<input type=\"hidden\" id=\"PROD_TYPE\" name=\"PROD_TYPE\"  value=\"";
echo $PROD_TYPE;
echo "\">\r\n</div>\r\n<!-- end data field-->\r\n\r\n\r\n</body>\r\n\r\n\r\n\r\n";
?>
