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
include_once( "inc/utility_all.php" );
include_once( "general/workflow/list/turn/condition.php" );
$query = "SELECT * from FLOW_TYPE WHERE FLOW_ID='".$FLOW_ID."'";
$cursor1 = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor1 ) )
{
				$FLOW_NAME = $ROW['FLOW_NAME'];
				$FLOW_TYPE = $ROW['FLOW_TYPE'];
				$FORM_ID = $ROW['FORM_ID'];
}
$query = "SELECT RUN_NAME,USER_NAME,PARENT_RUN from FLOW_RUN LEFT JOIN USER ON(FLOW_RUN.BEGIN_USER=USER.USER_ID) WHERE RUN_ID='".$RUN_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$RUN_NAME = $ROW['RUN_NAME'];
				$BEGIN_USER_NAME = $ROW['USER_NAME'];
				$PARENT_RUN = $ROW['PARENT_RUN'];
}
$query = "SELECT PRCS_NAME,PRCS_OUT,PRCS_OUT_SET,SYNC_DEAL,TURN_PRIV,PRCS_TO,USER_LOCK,TOP_DEFAULT,GATHER_NODE,CONDITION_DESC,REMIND_FLAG,VIEW_PRIV from FLOW_PROCESS WHERE FLOW_ID='".$FLOW_ID."' and PRCS_ID='{$FLOW_PRCS}'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$PRCS_NAME = $ROW['PRCS_NAME'];
				$PRCS_OUT = $ROW['PRCS_OUT'];
				$PRCS_OUT_SET = $ROW['PRCS_OUT_SET'];
				$SYNC_DEAL = $ROW['SYNC_DEAL'];
				$TURN_PRIV = $ROW['TURN_PRIV'];
				$GATHER_NODE = $ROW['GATHER_NODE'];
				$PRCS_TO = $ROW['PRCS_TO'];
				$PRCS_TO = str_replace( ",,", ",", $PRCS_TO );
				$CONDITION_DESC = $ROW['CONDITION_DESC'];
				$CONDITION_ARR = explode( "\n", $CONDITION_DESC );
				$CONDITION_DESC = $CONDITION_ARR[1];
				$REMIND_FLAG = $ROW['REMIND_FLAG'];
				$VIEW_PRIV_PRCS = $ROW['VIEW_PRIV'];
}
$FORM_DATA = get_form( $FORM_ID, $RUN_ID );
$NOT_PASS = check_condition( $FORM_DATA, $PRCS_OUT, $PRCS_OUT_SET, $RUN_ID, $PRCS_ID );
if ( substr( $NOT_PASS, 0, 5 ) == "SETOK" )
{
				$NOT_PASS = "";
}
if ( $OP == "MANAGE" )
{
				$NOT_PASS = "";
}
echo "<body>\r\n<div id=\"list_top\">\r\n";
if ( $PRCS_ID_NEXT )
{
				echo "\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
				echo $P;
				echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
				echo _( "工作转交" );
				echo "</span>\r\n";
				if ( $NOT_PASS == "" )
				{
								echo "\t<div class=\"list_top_right\"><a class=\"ButtonA\" href=\"javascript:document.form1.submit();\">";
								echo _( "继续" );
								echo "</a></div>\r\n";
				}
}
else
{
				echo "\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
				echo $P;
				echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
				echo _( "工作转交" );
				echo "</span>\r\n\t<div class=\"list_top_right\"><a class=\"ButtonA\" href=\"javascript:document.form1.submit();\">";
				echo _( "提交" );
				echo "</a></div>\r\n";
}
echo "</div>\r\n<div class=\"list_main\">\r\n";
$RUN_ROLE = run_role( $RUN_ID, $PRCS_ID );
if ( find_id( $RUN_ROLE, 2 ) )
{
				echo "<div class=\"message\">无权限！</div>";
}
if ( $NOT_PASS != "" )
{
				$NOT_PASS = str_replace( "\n", "<br>", $NOT_PASS );
				echo "<div class=\"message\">".$NOT_PASS."<div class=\"message\">";
				exit( );
}
echo _( "工作名称/文号：" );
echo $RUN_NAME;
echo "<br />\r\n";
echo _( "发起人：" );
echo $BEGIN_USER_NAME;
echo "<br />\r\n";
if ( $FLOW_TYPE == 1 )
{
				if ( $PRCS_ID_NEXT == "" )
				{
								echo _( "请选择下一步骤：" );
								echo "<br />\r\n";
								$query = "SELECT PRCS_NAME,PRCS_TO,REMIND_FLAG from FLOW_PROCESS WHERE FLOW_ID='".$FLOW_ID."' and PRCS_ID='{$FLOW_PRCS}'";
								$cursor = exequery( $connection, $query );
								if ( $ROW = mysql_fetch_array( $cursor ) )
								{
												$PRCS_NAME = $ROW['PRCS_NAME'];
												$PRCS_TO = $ROW['PRCS_TO'];
												$PRCS_TO = str_replace( ",,", ",", $PRCS_TO );
												$PRCS_TO = rtrim( $PRCS_TO, "," );
												$REMIND_FLAG = $ROW['REMIND_FLAG'];
								}
								if ( $PRCS_TO == "" )
								{
												$query = "SELECT MAX(PRCS_ID) from FLOW_PROCESS WHERE FLOW_ID=".$FLOW_ID;
												$PRCS_MAX = 0;
												$cursor = exequery( $connection, $query );
												if ( $ROW = mysql_fetch_array( $cursor ) )
												{
																$PRCS_MAX = $ROW[0];
												}
												if ( $FLOW_PRCS != $PRCS_MAX )
												{
																$PRCS_TO = $FLOW_PRCS + 1;
												}
												else
												{
																$PRCS_TO = "0";
												}
								}
								if ( $GATHER_NODE == 1 )
								{
												$PRE_PRCS_ID = $PRCS_ID - 1;
												$query = "select PRCS_ID FROM FLOW_PROCESS WHERE FLOW_ID='".$FLOW_ID."' AND ( FIND_IN_SET('{$FLOW_PRCS}',PRCS_TO) || (PRCS_ID={$FLOW_PRCS}-1 AND PRCS_TO=''))";
												$cursor = exequery( $connection, $query );
												while ( $ROW = mysql_fetch_array( $cursor ) )
												{
																$query1 = "select PRCS_FLAG from FLOW_RUN_PRCS WHERE RUN_ID='".$RUN_ID."' AND FLOW_PRCS='{$ROW['PRCS_ID']}' and OP_FLAG=1";
																$cursor1 = exequery( $connection, $query1 );
																if ( $ROW1 = mysql_fetch_array( $cursor1 ) )
																{
																				$PRCS_FLAG1 = $ROW1['PRCS_FLAG'];
																				if ( $PRCS_FLAG1 <= 2 )
																				{
																								$CANNOT_TURN = TRUE;
																				}
																}
																else
																{
																				$CANNOT_TURN = FALSE;
																}
																if ( find_id( $PARENT_STR, $ROW['PRCS_ID'] ) )
																{
																				if ( $CANNOT_TURN )
																				{
																								echo "<div class=\"message\">此步骤为强制合并步骤，尚有步骤未转交至此步骤，您不能继续转交下一步！</div>";
																				}
																}
												}
								}
								$count = 0;
								if ( $PRCS_TO == 0 )
								{
												echo "<form action=\"turn_submit.php\" method=\"post\" name=\"form1\"><input type=\"radio\" name=\"PRCS_ID_NEXT\" id=\"prcs_0\" value=\"0\" checked><label for=\"prcs_0\">结束流程</label><br />";
												++$count;
								}
								else
								{
												echo "<form action=\"turn.php\" method=\"post\" name=\"form1\">";
												$query1 = "SELECT * from FLOW_PROCESS where FLOW_ID='".$FLOW_ID."' and PRCS_ID IN ({$PRCS_TO})";
												$cursor1 = exequery( $connection, $query1 );
												$COUNT_PRCS_OK = 0;
												while ( $ROW = mysql_fetch_array( $cursor1 ) )
												{
																++$count;
																$PRCS_ID_NEXT = $ROW['PRCS_ID'];
																$PRCS_NAME = $ROW['PRCS_NAME'];
																$PRCS_IN = $ROW['PRCS_IN'];
																$PRCS_IN_SET = $ROW['PRCS_IN_SET'];
																$CONDITION_DESC = $ROW['CONDITION_DESC'];
																$CONDITION_ARR = explode( "\n", $CONDITION_DESC );
																$CONDITION_DESC = $CONDITION_ARR[0];
																$USER_LOCK = $ROW['USER_LOCK'];
																$TOP_DEFAULT = $ROW['TOP_DEFAULT'];
																$CHILD_FLOW = $ROW['CHILD_FLOW'];
																$AUTO_BASE_USER = $ROW['AUTO_BASE_USER'];
																$PRCS_IN_DESC = str_replace( "\n", "<br>", $PRCS_IN );
																$PRCS_IN_DESC = str_replace( "'include'", _( "'包含'" ), $PRCS_IN_DESC );
																$PRCS_IN_DESC = str_replace( "'exclude'", _( "'不包含'" ), $PRCS_IN_DESC );
																$PRCS_IN_DESC = str_replace( "''", _( "'空'" ), $PRCS_IN_DESC );
																$PRCS_IN_DESC = str_replace( "'", " ", $PRCS_IN_DESC );
																$PRCS_IN_DESC = str_replace( "'=='", _( "类型为" ), $PRCS_IN_DESC );
																$PRCS_IN_DESC = str_replace( "'!=='", _( "类型不能为" ), $PRCS_IN_DESC );
																$NOT_PASS = check_condition( $FORM_DATA, $PRCS_IN, $PRCS_IN_SET, $RUN_ID, $PRCS_ID );
																if ( substr( $NOT_PASS, 0, 5 ) == "SETOK" )
																{
																				$PRCS_IN_DESC = substr( $NOT_PASS, 5 );
																				$NOT_PASS = "";
																}
																if ( $NOT_PASS == "" )
																{
																				echo "          \t\r\n                \t<input type=\"radio\" name=\"PRCS_ID_NEXT\" id=\"prcs_";
																				echo $PRCS_ID_NEXT;
																				echo "\" value=\"";
																				echo $PRCS_ID_NEXT;
																				echo "\" ";
																				if ( $count == 1 )
																				{
																								echo "checked";
																				}
																				echo "><label for=\"prcs_";
																				echo $PRCS_ID_NEXT;
																				echo "\">";
																				echo $PRCS_NAME;
																				echo "</label><br />\r\n";
																				++$count;
																				++$COUNT_PRCS_OK;
																}
																else
																{
																				echo "            \t\t<label for=\"prcs_";
																				echo $PRCS_ID_NEXT;
																				echo "\">";
																				echo $PRCS_NAME;
																				echo " ";
																				echo $NOT_PASS;
																				echo "</label>\r\n";
																}
												}
								}
								if ( $COUNT_PRCS_OK == 0 )
								{
												echo "<div class=\"message\">没有符合条件的下一步骤!</div>";
								}
								if ( $count == 0 )
								{
												echo "<div class=\"message\">错误：尚未设置下一步骤!</div>";
								}
								echo "<input type=\"hidden\" name=\"P\" value=\"";
								echo $P;
								echo "\">\r\n<input type=\"hidden\" name=\"FLOW_ID\" value=\"";
								echo $FLOW_ID;
								echo "\">\r\n<input type=\"hidden\" name=\"RUN_ID\" value=\"";
								echo $RUN_ID;
								echo "\">\r\n<input type=\"hidden\" name=\"PRCS_ID\" value=\"";
								echo $PRCS_ID;
								echo "\">\r\n<input type=\"hidden\" name=\"FLOW_PRCS\" value=\"";
								echo $FLOW_PRCS;
								echo "\">\r\n</form>\r\n";
				}
				else
				{
								$PRCS_USER = get_prcs_user( $FLOW_ID, $PRCS_ID_NEXT );
								if ( sizeof( $PRCS_USER ) == 0 )
								{
												echo "<div class=\"message\">错误：尚未设置步骤经办权限!</div>";
								}
								else
								{
												$LIST = "";
												foreach ( $PRCS_USER['OP'] as $USER_ID => $USER_NAME )
												{
																$query = "SELECT DEPT_ID from USER where USER_ID = '".$USER_ID."'";
																$cursor = exequery( $connection, $query );
																if ( $ROW = mysql_fetch_array( $cursor ) )
																{
																				$DEPT_ID = $ROW['DEPT_ID'];
																}
																if ( $DEPT_ID == "0" )
																{
																				$LIST .= "<option value=\"".$USER_ID."\">".$USER_NAME."</option>";
																}
												}
												$CHECKBOX = "";
												$I = 0;
												foreach ( $PRCS_USER['OTHER'] as $USER_ID => $USER_NAME )
												{
																$query = "SELECT DEPT_ID from USER where USER_ID = '".$USER_ID."'";
																$cursor = exequery( $connection, $query );
																if ( $ROW = mysql_fetch_array( $cursor ) )
																{
																				$DEPT_ID = $ROW['DEPT_ID'];
																}
																if ( $DEPT_ID == "0" )
																{
																				$CHECKBOX .= "<input type=\"checkbox\" value=\"".$USER_ID."\" name=\"USER_".$I."\">".$USER_NAME."&nbsp;";
																				++$I;
																}
												}
												echo "<form action=\"turn_submit.php\"  method=\"post\" name=\"form1\">\r\n";
												echo _( "请选择办理人员：" );
												echo "<br />\r\n";
												echo _( "主办人：" );
												echo "<select name=\"PRCS_USER_OP\">\r\n";
												echo $LIST;
												echo "</select><br />\r\n";
												echo _( "经办人：" );
												echo $CHECKBOX;
												echo "<br>\r\n<input type=\"hidden\" name=\"P\" value=\"";
												echo $P;
												echo "\">\r\n<input type=\"hidden\" name=\"FLOW_ID\" value=\"";
												echo $FLOW_ID;
												echo "\">\r\n<input type=\"hidden\" name=\"RUN_ID\" value=\"";
												echo $RUN_ID;
												echo "\">\r\n<input type=\"hidden\" name=\"PRCS_ID\" value=\"";
												echo $PRCS_ID;
												echo "\">\r\n<input type=\"hidden\" name=\"PRCS_ID_NEXT\" value=\"";
												echo $PRCS_ID_NEXT;
												echo "\">\r\n<input type=\"hidden\" name=\"FLOW_PRCS\" value=\"";
												echo $FLOW_PRCS;
												echo "\">\r\n";
								}
				}
}
echo "</div>\r\n</body>\r\n</html>";
?>
