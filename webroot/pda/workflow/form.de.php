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
include_once( "inc/utility_file.php" );
include_once( "inc/utility_flow.php" );
include_once( "run_role.php" );
$RUN_ROLE = run_role( $RUN_ID, $PRCS_ID );
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "查看表单" );
echo "</span>\r\n</div>\r\n<div class=\"list_main\">\r\n";
if ( $RUN_ROLE )
{
				echo "<div class=\"message\">无权限！</div>";
				exit( );
}
$query = "SELECT * from FLOW_TYPE WHERE FLOW_ID='".$FLOW_ID."'";
$cursor1 = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor1 ) )
{
				$FORM_ID = $ROW['FORM_ID'];
}
$query1 = "SELECT * from FLOW_RUN where RUN_ID='".$RUN_ID."'";
$cursor1 = exequery( $connection, $query1 );
if ( $ROW = mysql_fetch_array( $cursor1 ) )
{
				$RUN_NAME = $ROW['RUN_NAME'];
				$ATTACHMENT_ID = $ROW['ATTACHMENT_ID'];
				$ATTACHMENT_NAME = $ROW['ATTACHMENT_NAME'];
				$BEGIN_TIME = $ROW['BEGIN_TIME'];
}
echo "<b>";
echo _( "名称/文号" );
echo "</b>:";
echo $RUN_NAME;
echo "<br />\r\n<b>";
echo _( "流水号" );
echo "</b>:";
echo $RUN_ID;
echo "<br />\r\n<b>";
echo _( "流程开始" );
echo "</b>:";
echo $BEGIN_TIME;
echo "<br />\r\n<b>";
echo _( "附件" );
echo "</b>:";
echo attach_link_pda( $ATTACHMENT_ID, $ATTACHMENT_NAME, $P );
echo "<hr>\r\n";
$query = "select HIDDEN_ITEM from FLOW_PROCESS,FLOW_RUN_PRCS where FLOW_PROCESS.FLOW_ID=".$FLOW_ID." and FLOW_RUN_PRCS.RUN_ID={$RUN_ID} and FLOW_RUN_PRCS.USER_ID='{$LOGIN_USER_ID}' and FLOW_PROCESS.PRCS_ID=FLOW_RUN_PRCS.PRCS_ID";
$cursor = exequery( $connection, $query );
$HIDDEN_STR = "";
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$HIDDEN_STR .= $ROW['HIDDEN_ITEM'];
}
$query = "SELECT * from FLOW_RUN_DATA where RUN_ID='".$RUN_ID."' order by ITEM_ID";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$ITEM_ID = $ROW['ITEM_ID'];
				$ITEM_DATA = $ROW['ITEM_DATA'];
				$STR = "DATA_".$ITEM_ID;
				$$STR = $ITEM_DATA;
}
include_once( "inc/workflow_form.php" );
foreach ( $ELEMENT_ARRAY as $ENAME => $ELEMENT_ARR )
{
				$ECLASS = $ELEMENT_ARR['CLASS'];
				$ITEM_ID = $ELEMENT_ARR['ITEM_ID'];
				$EVALUE = $ELEMENT_ARR['VALUE'];
				$ETITLE = $ELEMENT_ARR['TITLE'];
				$ETAG = $ELEMENT_ARR['TAG'];
				$ETITLE = str_replace( "<", "&lt", $ETITLE );
				$ETITLE = str_replace( ">", "&gt", $ETITLE );
				$ETITLE = stripslashes( $ETITLE );
				$STR = "DATA_".$ITEM_ID;
				$ITEM_VALUE = $$STR;
				if ( find_id( $HIDDEN_STR, $ETITLE ) )
				{
								$ITEM_VALUE = "";
				}
				if ( $ECLASS != "LIST_VIEW" )
				{
								$ITEM_VALUE = str_replace( "\r\n", " ", $ITEM_VALUE );
				}
				if ( $ECLASS == "AUTO" && $ETAG == "SELECT" && $ITEM_VALUE != "" )
				{
								$EDATAFLD = $ELEMENT_ARR['DATAFLD'];
								switch ( $EDATAFLD )
								{
												case "SYS_LIST_DEPT" :
																$query_auto = "SELECT * from DEPARTMENT where DEPT_ID='".$ITEM_VALUE."'";
																$cursor_auto = exequery( $connection, $query_auto );
																if ( $ROW = mysql_fetch_array( $cursor_auto ) )
																{
																				$ITEM_VALUE = $ROW['DEPT_NAME'];
																}
												case "SYS_LIST_PRIV" :
																$query_auto = "SELECT * from USER_PRIV where USER_PRIV=".$ITEM_VALUE;
																$cursor_auto = exequery( $connection, $query_auto );
																if ( $ROW = mysql_fetch_array( $cursor_auto ) )
																{
																				$ITEM_VALUE = $ROW['PRIV_NAME'];
																}
												case "SYS_LIST_USER" :
												case "SYS_LIST_PRCSUSER1" :
												case "SYS_LIST_PRCSUSER2" :
																$query_auto = "SELECT * from USER where USER_ID='".$ITEM_VALUE."'";
																$cursor_auto = exequery( $connection, $query_auto );
																if ( $ROW = mysql_fetch_array( $cursor_auto ) )
																{
																				$ITEM_VALUE = $ROW['USER_NAME'];
																}
												case "SYS_LIST_SQL" :
												}
												else if ( $ECLASS == "LIST_VIEW" )
												{
																$ITEM_VALUE = str_replace( "\r\n", "|", $ITEM_VALUE );
																$ITEM_VALUE = str_replace( "`", ",", $ITEM_VALUE );
												}
												else
												{
																if ( $ECLASS == "SIGN" )
																{
																				$ITEM_VALUE = "";
																}
																else
																{
																				if ( $ECLASS == "AUTO" && $ITEM_VALUE == "{MACRO}" )
																				{
																								$ITEM_VALUE = "";
																				}
																				$ITEM_VALUE = str_replace( "<", "&lt", $ITEM_VALUE );
																				$ITEM_VALUE = str_replace( ">", "&gt", $ITEM_VALUE );
																				$ITEM_VALUE = stripslashes( $ITEM_VALUE );
																				if ( $ENAME == "INPUT" && strstr( $ELEMENT, "type=checkbox" ) )
																				{
																								if ( $ITEM_VALUE == "on" )
																								{
																												$ITEM_VALUE = _( "是" );
																								}
																								else
																								{
																												$ITEM_VALUE = _( "否" );
																								}
																				}
																}
												default :
																echo "<b>".$ETITLE."</b>:".$ITEM_VALUE."<br />";
												}
												echo "<hr>";
												if ( strstr( $PRINT_MODEL, "#[MACRO_SIGN]" ) )
												{
																$query = "SELECT PRCS_ID,FLOW_PRCS from FLOW_RUN_PRCS WHERE RUN_ID=".$RUN_ID;
																$cursor = exequery( $connection, $query );
																while ( $ROW = mysql_fetch_array( $cursor ) )
																{
																				$PRCS_ID1 = $ROW['PRCS_ID'];
																				$FLOW_PRCS1 = $ROW['FLOW_PRCS'];
																				$query = "SELECT PRCS_NAME from FLOW_PROCESS WHERE FLOW_ID=".$FLOW_ID." AND PRCS_ID={$FLOW_PRCS1}";
																				$cursor1 = exequery( $connection, $query );
																				if ( $ROW = mysql_fetch_array( $cursor1 ) )
																				{
																								$PRCS_NAME = $ROW['PRCS_NAME'];
																				}
																				if ( $PRCS_ID_ARRAY[$PRCS_ID1] == "" )
																				{
																								$PRCS_ID_ARRAY[$PRCS_ID1] = $PRCS_NAME;
																				}
																				else if ( $PRCS_ID_ARRAY[$PRCS_ID1] != $PRCS_NAME )
																				{
																								$PRCS_ID_ARRAY .= $PRCS_ID1;
																				}
																}
																$query = "SELECT * from FLOW_RUN_FEEDBACK where RUN_ID=".$RUN_ID." order by PRCS_ID,EDIT_TIME";
																$cursor = exequery( $connection, $query );
																$FEEDBACK_COUNT = 0;
																while ( $ROW = mysql_fetch_array( $cursor ) )
																{
																				++$FEEDBACK_COUNT;
																				$USER_ID = $ROW['USER_ID'];
																				$PRCS_ID1 = $ROW['PRCS_ID'];
																				$CONTENT = $ROW['CONTENT'];
																				$EDIT_TIME = $ROW['EDIT_TIME'];
																				$CONTENT = str_replace( "<", "&lt", $CONTENT );
																				$CONTENT = str_replace( ">", "&gt", $CONTENT );
																				$CONTENT = stripslashes( $CONTENT );
																				$CONTENT = str_replace( "\n", "<br />", $CONTENT );
																				$query1 = "SELECT USER_NAME,DEPT_ID from USER where USER_ID='".$USER_ID."'";
																				$cursor1 = exequery( $connection, $query1 );
																				if ( $ROW = mysql_fetch_array( $cursor1 ) )
																				{
																								$USER_NAME = $ROW['USER_NAME'];
																								$DEPT_ID = $ROW['DEPT_ID'];
																								$DEPT_NAME = dept_long_name( $DEPT_ID );
																				}
																				if ( $PRCS_ID1 != 0 )
																				{
																								$SIGN_CONTENT .= "<b>".sprintf( _( "第%s步" ), $PRCS_ID1 )."</b> ".$PRCS_ID_ARRAY[$PRCS_ID1];
																				}
																				$SIGN_CONTENT .= " ".$USER_NAME."({$DEPT_NAME}):{$CONTENT} {$EDIT_TIME} <br />";
																}
																echo $SIGN_CONTENT;
												}
												if ( find_id( $RUN_ROLE, 2 ) )
												{
																echo "<a class=\"ButtonA\" href=\"turn.php?P=";
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
																echo "</a>&nbsp;\r\n";
												}
												if ( find_id( $RUN_ROLE, 4 ) )
												{
																echo "<a class=\"ButtonA\" href=\"sign.php?P=";
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
												echo "</div>\r\n</body>\r\n</html>";
				}
}
?>
