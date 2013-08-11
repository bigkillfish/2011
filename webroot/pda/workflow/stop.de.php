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
include_once( "inc/utility.php" );
$run_role = run_role( $RUN_ID, $PRCS_ID );
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "结束流程" );
echo "</span>\r\n</div>\r\n<div class=\"list_main\">\r\n";
if ( !find_id( $run_role, 1 ) && !find_id( $run_role, 4 ) )
{
				echo "<div class=\"message\">无权限！</div>";
}
else
{
				$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
				$query = "update FLOW_RUN_PRCS set PRCS_FLAG='4',DELIVER_TIME='".$CUR_TIME."' WHERE RUN_ID='{$RUN_ID}' and PRCS_ID='{$PRCS_ID}' and USER_ID='{$LOGIN_USER_ID}'";
				exequery( $connection, $query );
				echo "<div class=\"message\">工作办理完成！</div>";
}
echo "</div>";
?>
