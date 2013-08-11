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
include_once( "inc/utility_all.php" );
$PAGE_SIZE = 7;
if ( !isset( $start ) || $start == "" )
{
				$start = 0;
}
if ( isset( $TOTAL_ITEMS ) )
{
				$query = "SELECT count(*) from FLOW_RUN_PRCS,FLOW_RUN,FLOW_TYPE WHERE FLOW_RUN_PRCS.RUN_ID=FLOW_RUN.RUN_ID and FLOW_RUN.FLOW_ID=FLOW_TYPE.FLOW_ID and USER_ID='".$LOGIN_USER_ID."' and PRCS_FLAG<'3' and DEL_FLAG=0 and not (TOP_FLAG='1' and PRCS_FLAG=1)";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$TOTAL_ITEMS = $ROW[0];
				}
}
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"../main.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "工作流" );
echo "</span>\r\n</div>\r\n<div class=\"list_main\">\r\n";
$query = "SELECT * from FLOW_RUN_PRCS,FLOW_RUN,FLOW_TYPE WHERE FLOW_RUN_PRCS.RUN_ID=FLOW_RUN.RUN_ID and FLOW_RUN.FLOW_ID=FLOW_TYPE.FLOW_ID and USER_ID='".$LOGIN_USER_ID."' and DEL_FLAG=0 and PRCS_FLAG<'3' and not (TOP_FLAG='1' and PRCS_FLAG=1) order by FLOW_RUN.RUN_ID desc limit {$start},{$PAGE_SIZE}";
$cursor = exequery( $connection, $query );
$FLOW_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$FLOW_COUNT;
				$PRCS_ID = $ROW['PRCS_ID'];
				$RUN_ID = $ROW['RUN_ID'];
				$FLOW_ID = $ROW['FLOW_ID'];
				$PRCS_FLAG = $ROW['PRCS_FLAG'];
				$FLOW_PRCS = $ROW['FLOW_PRCS'];
				$OP_FLAG = $ROW['OP_FLAG'];
				if ( $OP_FLAG == "1" )
				{
								$OP_FLAG_DESC = _( "主办" );
				}
				if ( $PRCS_FLAG == "1" )
				{
								$STATUS = _( "未接收" );
				}
				else if ( $PRCS_FLAG == "2" )
				{
								$STATUS = _( "已接收" );
				}
				$query = "SELECT * from FLOW_RUN WHERE RUN_ID='".$RUN_ID."'";
				$cursor1 = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor1 ) )
				{
								$FLOW_ID = $ROW['FLOW_ID'];
								$RUN_NAME = $ROW['RUN_NAME'];
				}
				$query = "SELECT * from FLOW_TYPE WHERE FLOW_ID='".$FLOW_ID."'";
				$cursor1 = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor1 ) )
				{
								$FLOW_NAME = $ROW['FLOW_NAME'];
								$FLOW_TYPE = $ROW['FLOW_TYPE'];
				}
				if ( $FLOW_TYPE == "1" )
				{
								$query = "SELECT PRCS_NAME,FEEDBACK from FLOW_PROCESS WHERE FLOW_ID='".$FLOW_ID."' AND PRCS_ID='{$FLOW_PRCS}'";
								$cursor1 = exequery( $connection, $query );
								if ( $ROW = mysql_fetch_array( $cursor1 ) )
								{
												$PRCS_NAME = sprintf( _( "第%s步：" ), $PRCS_ID ).$ROW['PRCS_NAME'];
												$FEEDBACK = $ROW['FEEDBACK'];
								}
				}
				else
				{
								$PRCS_NAME = sprintf( _( "第%s步" ), $PRCS_ID );
								$FEEDBACK = 0;
				}
				echo "   <div class=\"list_item\">\r\n      <div class=\"list_item_subject\">";
				echo $start + $FLOW_COUNT;
				echo ". [";
				echo $RUN_ID;
				echo "] - <b>";
				echo $FLOW_NAME;
				echo "</b> - ";
				echo $RUN_NAME;
				echo "</div>\r\n      <div class=\"list_item_time\">";
				echo $PRCS_NAME;
				echo " ";
				echo $OP_FLAG_DESC;
				echo "</div>\r\n      <div class=\"list_item_time\"></div>\r\n      <div class=\"list_item_arrow\"></div>\r\n      <div class=\"list_item_op\">\r\n         <a href=\"form.php?P=";
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
				echo _( "表单" );
				echo "</a>\r\n";
				if ( $OP_FLAG )
				{
								echo "         <a href=\"stop.php?P=";
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
								echo _( "办理完毕" );
								echo "</a>\r\n";
				}
				else
				{
								echo "         <a href=\"edit.php?P=";
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
								echo _( "主办" );
								echo "</a>\r\n         <a href=\"turn.php?P=";
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
								echo "</a>\r\n";
				}
				if ( $FEEDBACK != 1 )
				{
								echo "         <a href=\"sign.php?P=";
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
								echo _( "会签" );
								echo "</a>\r\n";
				}
				if ( $FLOW_TYPE != "1" )
				{
								echo "         <a href=\"stop.php?P=";
								echo $P;
								echo "&FLOW_ID=";
								echo $FLOW_ID;
								echo "&RUN_ID=";
								echo $RUN_ID;
								echo "&PRCS_ID=";
								echo $PRCS_ID;
								echo "\">";
								echo _( "结束流程" );
								echo "</a>\r\n";
				}
				echo "      </div>\r\n   </div>\r\n";
}
if ( $FLOW_COUNT == 0 )
{
				echo "<div class=\"message\">无待办工作</div>";
}
echo "</div>\r\n<div id=\"list_bottom\">\r\n\t<div class=\"list_bottom_left\">";
echo pda_page_bar( $start, $TOTAL_ITEMS, $PAGE_SIZE );
echo "</div>\r\n</div>\r\n</body>\r\n</html>\r\n";
?>
