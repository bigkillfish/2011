<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$CSS_ARRAY = array( "/pda/style/list.css" );
$JS_ARRAY = array( );
include_once( "../auth.php" );
include_once( "run_role.php" );
include_once( "inc/utility_flow.php" );
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "保存表单" );
echo "</span>\r\n</div>\r\n<div class=\"list_main\">\r\n";
$RUN_ROLE = run_role( $RUN_ID, $PRCS_ID );
if ( find_id( $RUN_ROLE, 2 ) )
{
				echo "<div class=\"message\">无权限！</div>";
				exit( );
}
$query = "SELECT * from FLOW_TYPE WHERE FLOW_ID='".$FLOW_ID."'";
$cursor1 = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor1 ) )
{
				$FORM_ID = $ROW['FORM_ID'];
				$FLOW_TYPE = $ROW['FLOW_TYPE'];
				include_once( "inc/workflow_form.php" );
}
$table_name = "flow_data_".$FLOW_ID;
update_table( $FLOW_ID, $ELEMENT_ARRAY );
$sql = " select 1 from ".$table_name." where run_id='{$RUN_ID}' limit 1";
$cursor = exequery( $connection, $sql );
if ( mysql_fetch_array( $cursor ) )
{
				$sql = "select BEGIN_USER,BEGIN_TIME from FLOW_RUN where RUN_ID='".$RUN_ID."'";
				$cursor = exequery( $connection, $sql );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$begin_user = $ROW['BEGIN_USER'];
								$begin_time = $ROW['BEGIN_TIME'];
				}
				$sql = "insert into ".$table_name."(id,run_id,run_name,begin_user,begin_time";
				$sql_value = " values(null,'".$RUN_ID."','{$RUN_NAME}','{$begin_user}','{$begin_time}'";
				foreach ( $_POST as $key => $value )
				{
								if ( find_id( $HIDDEN_STR, $key ) )
								{
								}
								else
								{
												continue;
								}
								if ( strtolower( substr( $key, 0, 4 ) ) == "data" )
								{
												$sql .= ",".$key." ";
												$sql_value .= " ,'".$value."' ";
								}
				}
				$sql_last = $sql.") ".$sql_value.")";
}
else
{
				$sql = " update ".$table_name." set run_name='{$RUN_NAME}',";
				foreach ( $_POST as $key => $value )
				{
								if ( find_id( $HIDDEN_STR, $key ) )
								{
								}
								else
								{
												continue;
								}
								if ( strtolower( substr( $key, 0, 4 ) ) == "data" )
								{
												$sql .= "{$key} = '{$value}' ,";
								}
				}
				$sql = substr( $sql, 0, strlen( $sql ) - 1 );
				$sql_last = $sql.( " where run_id='".$RUN_ID."' limit 1" );
}
$cursor = exequery( $connection, $sql_last );
foreach ( $_POST as $key => $value )
{
				if ( strtolower( substr( $key, 0, 4 ) ) == "data" )
				{
								$ITEM_ID = substr( $key, 5 );
								$query = "update FLOW_RUN_DATA set ITEM_DATA='".$value."' where RUN_ID='{$RUN_ID}' and ITEM_ID='{$ITEM_ID}'";
								exequery( $connection, $query );
				}
}
echo "   <div class=\"message\">";
echo _( "保存成功" );
echo "</div>\r\n   <div align=\"center\">\r\n      <a class=\"ButtonB\" href=\"edit.php?P=";
echo $P;
echo "&FLOW_ID=";
echo $FLOW_ID;
echo "&RUN_ID=";
echo $RUN_ID;
echo "&PRCS_ID=";
echo $PRCS_ID;
echo "&FLOW_PRCS=";
echo $FLOW_PRCS;
echo "\">";
echo _( "继续编辑" );
echo "</a>&nbsp;\r\n      <a class=\"ButtonA\" href=\"turn.php?P=";
echo $P;
echo "&FLOW_ID=";
echo $FLOW_ID;
echo "&RUN_ID=";
echo $RUN_ID;
echo "&PRCS_ID=";
echo $PRCS_ID;
echo "&FLOW_PRCS=";
echo $FLOW_PRCS;
echo "\">";
echo _( "转交" );
echo "</a>\r\n   </div>\r\n</div>\r\n</body>\r\n</html>";
?>
