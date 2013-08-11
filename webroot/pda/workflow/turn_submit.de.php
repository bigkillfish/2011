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
include_once( "general/workflow/list/turn/condition.php" );
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "工作转交" );
echo "</span>\r\n</div>\r\n<div class=\"list_main\">\r\n";
$RUN_ROLE = run_role( $RUN_ID, $PRCS_ID );
if ( find_id( $RUN_ROLE, 2 ) )
{
				echo "<div class=\"message\">无权限！</div>";
}
$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
$PRCS_ID_NEW = $PRCS_ID + 1;
if ( $PRCS_ID_NEXT == 0 )
{
				$query = "update FLOW_RUN_PRCS set PRCS_FLAG='4' WHERE RUN_ID='".$RUN_ID."' and PRCS_ID='{$PRCS_ID}' and FLOW_PRCS='{$FLOW_PRCS}'";
				exequery( $connection, $query );
				$query = "update FLOW_RUN_PRCS set DELIVER_TIME='".$CUR_TIME."' WHERE RUN_ID='{$RUN_ID}' and PRCS_ID='{$PRCS_ID}' and FLOW_PRCS='{$FLOW_PRCS}' and USER_ID='{$LOGIN_USER_ID}'";
				exequery( $connection, $query );
				$query = "select 1 FROM FLOW_RUN_PRCS WHERE RUN_ID='".$RUN_ID."' AND PRCS_FLAG IN (1,2) AND ((TOP_FLAG IN (0,1) AND OP_FLAG=1) OR TOP_FLAG=2)";
				$cursor = exequery( $connection, $query );
				if ( mysql_fetch_array( $cursor ) )
				{
								$query = "update FLOW_RUN set END_TIME='".$CUR_TIME."' WHERE RUN_ID='{$RUN_ID}'";
								exequery( $connection, $query );
				}
				$CONTENT = _( "结束流程" );
				$USER_IP = get_client_ip( );
				$query = "insert into FLOW_RUN_LOG (LOG_ID,RUN_ID,RUN_NAME,FLOW_ID,PRCS_ID,FLOW_PRCS,USER_ID,TIME,TYPE,IP,CONTENT) VALUES ('','".$RUN_ID."','{$RUN_NAME}','{$FLOW_ID}','{$PRCS_ID}','{$FLOW_PRCS}','{$LOGIN_USER_ID}','{$CUR_TIME}','1','{$USER_IP}','{$CONTENT}')";
				exequery( $connection, $query );
				echo "<div class=\"message\">工作已结束！</div>";
}
else
{
				$query = "select * from FLOW_TYPE where FLOW_ID='".$FLOW_ID."';";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$FREE_OTHER = $ROW['FREE_OTHER'];
				}
				$OTHER_ARRAY = array( );
				if ( $FREE_OTHER == 2 )
				{
								$PRCS_USER_OP_OLD = $PRCS_USER_OP;
								$PRCS_USER_OP = turn_other( $PRCS_USER_OP );
				}
				$query = "insert into FLOW_RUN_PRCS(RUN_ID,PRCS_ID,USER_ID,PRCS_FLAG,FLOW_PRCS,TIME_OUT,OP_FLAG,TOP_FLAG,PARENT,CREATE_TIME,OTHER_USER) values ('".$RUN_ID."','{$PRCS_ID_NEW}','{$PRCS_USER_OP}','1',{$PRCS_ID_NEXT},'','1','0','{$FLOW_PRCS}','{$CUR_TIME}','')";
				exequery( $connection, $query );
				$PRCS_USER = "";
				foreach ( $_POST as $k => $v )
				{
								if ( !( substr( $k, 0, 5 ) == "USER_" ) || !( $v != $PRCS_USER_OP ) )
								{
												$PRCS_USER .= $v.",";
								}
				}
				if ( $FREE_OTHER == 2 )
				{
								$PRCS_USER = turn_other( $PRCS_USER, $PRCS_USER_OP_OLD );
				}
				$PRCS_USER_ARRAY = explode( ",", rtrim( $PRCS_USER, "," ) );
				foreach ( $PRCS_USER_ARRAY as $v )
				{
								$query = "insert into FLOW_RUN_PRCS(RUN_ID,PRCS_ID,USER_ID,PRCS_FLAG,FLOW_PRCS,TIME_OUT,OP_FLAG,TOP_FLAG,PARENT,CREATE_TIME,OTHER_USER) values ('".$RUN_ID."','{$PRCS_ID_NEW}','{$v}','1',{$PRCS_ID_NEXT},'','0','0','{$FLOW_PRCS}','{$CUR_TIME}','{$OTHER_ARRAY[$TOK]}')";
								exequery( $connection, $query );
				}
				$query = "update FLOW_RUN_PRCS set DELIVER_TIME='".$CUR_TIME."',PRCS_FLAG='3' WHERE RUN_ID='{$RUN_ID}' and PRCS_ID='{$PRCS_ID}' and FLOW_PRCS='{$FLOW_PRCS}' and USER_ID='{$LOGIN_USER_ID}' and PRCS_FLAG in ('1','2')";
				exequery( $connection, $query );
				$USER_NAME_STR = "";
				$query = "SELECT USER_NAME FROM USER WHERE FIND_IN_SET(USER_ID,'".$PRCS_USER_OP.",{$PRCS_USER}')";
				$cursor = exequery( $connection, $query );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$USER_NAME_STR .= $ROW['USER_NAME'].",";
				}
				$USER_IP = get_client_ip( );
				$CONTENT = _( "转交至步骤".$PRCS_ID_NEW.",办理人:{$USER_NAME_STR}" );
				$query = "select RUN_NAME,FLOW_ID FROM FLOW_RUN WHERE RUN_ID='".$RUN_ID."'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$RUN_NAME = $ROW['RUN_NAME'];
								$FLOW_ID = $ROW['FLOW_ID'];
				}
				$query = "insert into FLOW_RUN_LOG (LOG_ID,RUN_ID,RUN_NAME,FLOW_ID,PRCS_ID,FLOW_PRCS,USER_ID,TIME,TYPE,IP,CONTENT) VALUES ('','".$RUN_ID."','{$RUN_NAME}','{$FLOW_ID}','{$PRCS_ID}','{$FLOW_PRCS}','{$LOGIN_USER_ID}','{$CUR_TIME}','1','{$USER_IP}','{$CONTENT}')";
				exequery( $connection, $query );
				echo "<div class=\"message\">工作已经转交下一步</div>";
}
echo "</div>\r\n</body>\r\n</html>";
?>
