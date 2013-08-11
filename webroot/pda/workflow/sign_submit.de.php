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
$query = "SELECT OP_FLAG from FLOW_RUN_PRCS where USER_ID='".$LOGIN_USER_ID."' AND RUN_ID='{$RUN_ID}' AND PRCS_ID='{$PRCS_ID}' AND FLOW_PRCS='{$FLOW_PRCS}'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$OP_FLAG = $ROW['OP_FLAG'];
}
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"sign.php?P=";
echo $P;
echo "&FLOW_ID=";
echo $FLOW_ID;
echo "&RUN_ID=";
echo $RUN_ID;
echo "&PRCS_ID=";
echo $PRCS_ID;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "会签" );
echo "</span>\r\n\t<div class=\"list_top_right\">\r\n";
if ( $OP_FLAG )
{
				echo "    <a class=\"ButtonB\" href=\"stop.php?P=";
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
				echo "    <a class=\"ButtonA\" href=\"turn.php?P=";
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
echo "\t</div>\r\n</div>\r\n<div class=\"list_main\">\r\n";
if ( run_role( $RUN_ID, $PRCS_ID ) )
{
				echo "<div class=\"message\">无权限！</div>";
				exit( );
}
if ( trim( $CONTENT ) == "" )
{
				echo "<div class=\"message\">会签意见不能为空！</div>";
}
else
{
				$EDIT_TIME = date( "Y-m-d H:i:s", time( ) );
				$query = "INSERT INTO FLOW_RUN_FEEDBACK (RUN_ID,PRCS_ID,USER_ID,CONTENT,ATTACHMENT_ID,ATTACHMENT_NAME,EDIT_TIME) VALUES (".$RUN_ID.",{$PRCS_ID},'{$LOGIN_USER_ID}','{$CONTENT}','','','{$EDIT_TIME}')";
				exequery( $connection, $query );
				echo "<div class=\"message\">会签意见保存成功</div>";
}
echo "</div>\r\n</body>\r\n</html>";
?>
