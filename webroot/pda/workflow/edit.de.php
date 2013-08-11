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
include_once( "inc/utility_flow.php" );
include_once( "inc/utility_file.php" );
include_once( "run_role.php" );
$RUN_ROLE = run_role( $RUN_ID, $PRCS_ID );
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "工作办理" );
echo "</span>\r\n\t<div class=\"list_top_right\"><a class=\"ButtonA\" href=\"javascript:document.form1.submit();\">";
echo _( "保存" );
echo "</a></div>\r\n</div>\r\n<div class=\"list_main\">\r\n";
if ( find_id( $RUN_ROLE, 2 ) )
{
				echo "<div class=\"message\">无主办权限！</div>";
				exit( );
}
$query = "SELECT FORM_ID,FLOW_TYPE from FLOW_TYPE WHERE FLOW_ID='".$FLOW_ID."'";
$cursor1 = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor1 ) )
{
				$FORM_ID = $ROW['FORM_ID'];
				$FLOW_TYPE = $ROW['FLOW_TYPE'];
				$query = "SELECT PARENT,TOP_FLAG,FREE_ITEM,PRCS_FLAG from FLOW_RUN_PRCS WHERE RUN_ID='".$RUN_ID."' AND PRCS_ID='{$PRCS_ID}' AND USER_ID='{$LOGIN_USER_ID}' AND FLOW_PRCS='{$FLOW_PRCS}' ORDER BY PRCS_FLAG LIMIT 1";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$PRCS_FLAG = $ROW['PRCS_FLAG'];
								$TOP_FLAG = $ROW['TOP_FLAG'];
								$PARENT = $ROW['PARENT'];
								$FREE_ITEM = $ROW['FREE_ITEM'];
				}
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
echo "<hr>\r\n<form action=\"edit_submit.php\" method=\"post\" name=\"form1\">\r\n";
$query = "select HIDDEN_ITEM from FLOW_PROCESS,FLOW_RUN_PRCS where FLOW_PROCESS.FLOW_ID=".$FLOW_ID." and FLOW_RUN_PRCS.RUN_ID={$RUN_ID} and FLOW_RUN_PRCS.USER_ID='{$LOGIN_USER_ID}' and FLOW_PROCESS.PRCS_ID=FLOW_RUN_PRCS.PRCS_ID";
$cursor = exequery( $connection, $query );
$HIDDEN_STR = "";
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$HIDDEN_STR .= $ROW['HIDDEN_ITEM'];
}
$query = "SELECT * from FLOW_PROCESS WHERE FLOW_ID='".$FLOW_ID."' AND PRCS_ID='{$FLOW_PRCS}'";
$cursor1 = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor1 ) )
{
				$PRCS_NAME = $ROW['PRCS_NAME'];
				$PRCS_ITEM = $ROW['PRCS_ITEM'];
				$PRCS_ITEM_AUTO = $ROW['PRCS_ITEM_AUTO'];
				$FEEDBACK = $ROW['FEEDBACK'];
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
$CUR_DATE = date( "Y-m-d" );
foreach ( $ELEMENT_ARRAY as $ENAME => $ELEMENT_ARR )
{
				$ECLASS = $ELEMENT_ARR['CLASS'];
				$ITEM_ID = $ELEMENT_ARR['ITEM_ID'];
				$EVALUE = $ELEMENT_ARR['VALUE'];
				$ETITLE = $ELEMENT_ARR['TITLE'];
				$ETAG = $ELEMENT_ARR['TAG'];
				$ITEM_ID = $ELEMENT_ARR['ITEM_ID'];
				$ELEMENT_OUT = $ELEMENT_ARR['CONTENT'];
				$ETITLE = str_replace( "<", "&lt", $ETITLE );
				$ETITLE = str_replace( ">", "&gt", $ETITLE );
				$ETITLE = stripslashes( $ETITLE );
				if ( $FLOW_TYPE == 2 && $FREE_ITEM != "" && !find_id( $FREE_ITEM, $ETITLE ) || $FLOW_TYPE == 1 && !find_id( $PRCS_ITEM, $ETITLE ) && !find_id( $PRCS_ITEM_AUTO, $ETITLE ) )
				{
								if ( $ECLASS == "DATE" )
								{
								}
								else
								{
												continue;
								}
								$STR = "DATA_".$ITEM_ID;
								$ITEM_VALUE = $$STR;
								if ( find_id( $HIDDEN_STR, $ETITLE ) )
								{
												$ITEM_VALUE = "";
								}
								if ( $ITEM_VALUE == "{MACRO}" )
								{
												$ITEM_VALUE = "";
								}
								if ( $ETAG == "INPUT" && $ECLASS != "AUTO" )
								{
												if ( strstr( $ELEMENT_OUT, "type=checkbox" ) )
												{
																$ELEMENT_OUT = str_ireplace( " value=\"on\"", "", $ELEMENT_OUT );
																$ELEMENT_OUT = str_ireplace( " value=\"\"", "", $ELEMENT_OUT );
																$ELEMENT_OUT = str_ireplace( " CHECKED", "", $ELEMENT_OUT );
																$ELEMENT_OUT = str_ireplace( " checked=\"checked\"", "", $ELEMENT_OUT );
																if ( $ITEM_VALUE == "on" )
																{
																				$ELEMENT_OUT = str_replace( "<".$ETAG, "<".$ETAG." CHECKED", $ELEMENT_OUT );
																}
												}
												else
												{
																$ELEMENT_OUT = str_replace( "value=".$EVALUE, "", $ELEMENT_OUT );
																$ELEMENT_OUT = str_replace( "<".$ETAG, "<".$ETAG." value=\"{$ITEM_VALUE}\" {$HIDDEN_STR}", $ELEMENT_OUT );
												}
								}
								else if ( $ETAG == "TEXTAREA" )
								{
												$ELEMENT_OUT = str_replace( ">".$EVALUE."<", ">\n".$ITEM_VALUE."<", $ELEMENT_OUT );
								}
								else if ( $ETAG == "SELECT" && $ECLASS != "AUTO" )
								{
												if ( $ITEM_VALUE != "" )
												{
																$ELEMENT_OUT = str_replace( " selected", "", $ELEMENT_OUT );
																$ELEMENT_OUT = str_replace( "<OPTION value=".$ITEM_VALUE.">", "<OPTION selected value=\"".$ITEM_VALUE."\">", $ELEMENT_OUT );
																$ELEMENT_OUT = str_replace( "<OPTION value=\"".$ITEM_VALUE."\">", "<OPTION selected value=\"".$ITEM_VALUE."\">", $ELEMENT_OUT );
												}
								}
								else
								{
												if ( $ECLASS == "RADIO" && $ETAG == "IMG" )
												{
																$RADIO_FIELD = $ELEMENT_ARR['RADIO_FIELD'];
																$RADIO_CHECK = $ELEMENT_ARR['RADIO_CHECK'];
																$RADIO_ARRAY = explode( "`", rtrim( $RADIO_FIELD, "`" ) );
																$ELEMENT_OUT = "";
																foreach ( $RADIO_ARRAY as $CHECKED => $RADIO )
																{
																				if ( $RADIO == $RADIO_CHECK )
																				{
																								$CHECKED = "checked";
																				}
																				$ELEMENT_OUT .= "<input type=\"radio\" name=\"".$ENAME."\" value=\"".$RADIO."\" ".$CHECKED."><label>".$RADIO."</label>&nbsp;";
																}
												}
												else if ( $ECLASS == "AUTO" )
												{
																$EDATAFLD = $ELEMENT_ARR['DATAFLD'];
																$AUTO_VALUE = "";
																if ( !( $ETAG == "INPUT" ) )
																{
																				break;
																				switch ( $EDATAFLD )
																				{
																								case "SYS_DATE" :
																												$AUTO_VALUE = $CUR_DATE;
																												break;
																								case "SYS_DATE_CN" :
																												$AUTO_VALUE = format_date( $CUR_DATE );
																												break;
																								case "SYS_DATE_CN_SHORT1" :
																												$AUTO_VALUE = format_date_short1( $CUR_DATE );
																												break;
																								case "SYS_DATE_CN_SHORT2" :
																												$AUTO_VALUE = format_date_short2( $CUR_DATE );
																												break;
																								case "SYS_DATE_CN_SHORT3" :
																												$AUTO_VALUE = format_date_short3( $CUR_DATE );
																												break;
																								case "SYS_DATE_CN_SHORT4" :
																												$AUTO_VALUE = date( "Y", time( ) );
																												break;
																								case "SYS_TIME" :
																												$AUTO_VALUE = $CUR_TIME1;
																												break;
																								case "SYS_DATETIME" :
																												$AUTO_VALUE = $CUR_TIME;
																												break;
																								case "SYS_WEEK" :
																												$AUTO_VALUE = get_week( $CUR_TIME );
																												break;
																								case "SYS_USERID" :
																												$AUTO_VALUE = $LOGIN_USER_ID;
																												break;
																								case "SYS_USERNAME" :
																												$query_auto = "SELECT USER_NAME from USER where USER_ID='".$LOGIN_USER_ID."'";
																												$cursor_auto = exequery( $connection, $query_auto );
																												if ( $ROW = mysql_fetch_array( $cursor_auto ) )
																												{
																																$AUTO_VALUE = $ROW['USER_NAME'];
																																break;
																												}
																								case "SYS_USERPRIV" :
																												$query_auto = "SELECT PRIV_NAME from USER_PRIV where USER_PRIV='".$LOGIN_USER_PRIV."'";
																												$cursor_auto = exequery( $connection, $query_auto );
																												if ( $ROW = mysql_fetch_array( $cursor_auto ) )
																												{
																																$AUTO_VALUE = $ROW['PRIV_NAME'];
																																break;
																												}
																								case "SYS_USERNAME_DATE" :
																												$query_auto = "SELECT USER_NAME from USER where USER_ID='".$LOGIN_USER_ID."'";
																												$cursor_auto = exequery( $connection, $query_auto );
																												if ( $ROW = mysql_fetch_array( $cursor_auto ) )
																												{
																																$AUTO_VALUE = $ROW['USER_NAME']." ".$CUR_DATE;
																																break;
																												}
																								case "SYS_USERNAME_DATETIME" :
																												$query_auto = "SELECT USER_NAME from USER where USER_ID='".$LOGIN_USER_ID."'";
																												$cursor_auto = exequery( $connection, $query_auto );
																												if ( $ROW = mysql_fetch_array( $cursor_auto ) )
																												{
																																$AUTO_VALUE = $ROW['USER_NAME']." ".$CUR_TIME;
																																break;
																												}
																								case "SYS_DEPTNAME" :
																												$AUTO_VALUE = dept_long_name( $LOGIN_DEPT_ID );
																												break;
																								case "SYS_DEPTNAME_SHORT" :
																												$query_auto = "SELECT DEPT_NAME from DEPARTMENT where DEPT_ID='".$LOGIN_DEPT_ID."'";
																												$cursor_auto = exequery( $connection, $query_auto );
																												if ( $ROW = mysql_fetch_array( $cursor_auto ) )
																												{
																																$AUTO_VALUE = $ROW['DEPT_NAME'];
																																break;
																												}
																								case "SYS_FORMNAME" :
																												$AUTO_VALUE = $FORM_NAME;
																												break;
																								case "SYS_RUNNAME" :
																												$AUTO_VALUE = $RUN_NAME;
																												break;
																								case "SYS_RUNDATE" :
																												$AUTO_VALUE = $PRCS_DATE;
																												break;
																								case "SYS_RUNDATETIME" :
																												$AUTO_VALUE = $BEGIN_TIME;
																												break;
																								case "SYS_RUNID" :
																												$AUTO_VALUE = $RUN_ID;
																												break;
																								case "SYS_AUTONUM" :
																												$AUTO_VALUE = $AUTO_NUM;
																												break;
																								case "SYS_IP" :
																												$AUTO_VALUE = get_client_ip( );
																												break;
																								case "SYS_SQL" :
																												$query_auto = "select PRIV_NO from USER_PRIV where USER_PRIV='".$LOGIN_USER_PRIV."'";
																												$cursor_auto = exequery( $connection, $query_auto );
																												if ( $ROW = mysql_fetch_array( $cursor_auto ) )
																												{
																																$LOGIN_USER_PRIV_NO = $ROW['PRIV_NO'];
																												}
																												$EDATASRC = $ELEMENT_ARR['DATASRC'];
																												$EDATASRC = str_replace( "`", "'", $EDATASRC );
																												$EDATASRC = str_replace( "&#13;&#10;", " ", $EDATASRC );
																												$EDATASRC = str_replace( "[SYS_USER_ID]", $LOGIN_USER_ID, $EDATASRC );
																												$EDATASRC = str_replace( "[SYS_DEPT_ID]", $LOGIN_DEPT_ID, $EDATASRC );
																												$EDATASRC = str_replace( "[SYS_PRIV_ID]", $LOGIN_USER_PRIV, $EDATASRC );
																												$EDATASRC = str_replace( "[SYS_PRIV_NO]", $LOGIN_USER_PRIV_NO, $EDATASRC );
																												$EDATASRC = str_replace( "[SYS_RUN_ID]", $RUN_ID, $EDATASRC );
																												$cursor_SYS_SQL = exequery( $connection, $EDATASRC );
																												if ( $ROW = mysql_fetch_array( $cursor_SYS_SQL ) )
																												{
																																$AUTO_VALUE = $ROW[0];
																																break;
																												}
																								case "SYS_MANAGER1" :
																												$TMP_DEPT_ID = $LOGIN_DEPT_ID;
																												$AUTO_VALUE = sys_manager( $TMP_DEPT_ID );
																												break;
																								case "SYS_MANAGER2" :
																												$TMP_DEPT_ID = dept_parent( $LOGIN_DEPT_ID, 1 );
																												$AUTO_VALUE = sys_manager( $TMP_DEPT_ID );
																												break;
																								case "SYS_MANAGER3" :
																												$TMP_DEPT_ID = dept_parent( $LOGIN_DEPT_ID, 0 );
																												$AUTO_VALUE = sys_manager( $TMP_DEPT_ID );
																				}
																				$ELEMENT_OUT = str_replace( "value=".$EVALUE, "", $ELEMENT_OUT );
																				$ELEMENT_OUT = str_replace( "value='".$EVALUE."'", "", $ELEMENT_OUT );
																				$ELEMENT_OUT = str_replace( "value=''", "", $ELEMENT_OUT );
																				$ELEMENT_OUT = str_replace( "<".$ETAG, "<".$ETAG." value='{$AUTO_VALUE}'", $ELEMENT_OUT );
																				if ( find_id( $PRCS_ITEM_AUTO, $ETITLE ) )
																				{
																								$ELEMENT_OUT = str_replace( "<".$ETAG, "<".$ETAG." readOnly value='{$AUTO_VALUE}'", $ELEMENT_OUT );
																				}
																}
																else
																{
																				do
																				{
																				} while ( 0 );
																				if ( $ETAG == "SELECT" )
																				{
																								$AUTO_VALUE = "<option value=\"\"";
																								if ( $ITEM_VALUE == "" )
																								{
																												$AUTO_VALUE .= " selected";
																								}
																								$AUTO_VALUE .= "></option>\n";
																								$POS = strpos( $ELEMENT_OUT, ">" ) + 1;
																								$POS1 = strpos( $ELEMENT_OUT, "</SELECT>", $POS );
																								$EVALUE = substr( $ELEMENT_OUT, $POS, $POS1 - $POS );
																								$ITEM_VALUE_TEXT = "";
																								switch ( $EDATAFLD )
																								{
																												case "SYS_LIST_DEPT" :
																																$AUTO_VALUE .= my_dept_tree( 0, $ITEM_VALUE, 0 );
																																if ( $ITEM_VALUE != "" )
																																{
																																				$query_auto = "SELECT DEPT_NAME from DEPARTMENT where DEPT_ID=".$ITEM_VALUE;
																																				$cursor_auto = exequery( $connection, $query_auto );
																																				if ( $ROW = mysql_fetch_array( $cursor_auto ) )
																																				{
																																								$ITEM_VALUE_TEXT = $ROW['DEPT_NAME'];
																																								break;
																																				}
																																}
																												case "SYS_LIST_USER" :
																																$query_auto = "SELECT USER_ID,USER_NAME from USER,USER_PRIV where USER.USER_PRIV=USER_PRIV.USER_PRIV order by PRIV_NO,USER_NO,USER_NAME";
																																$cursor_auto = exequery( $connection, $query_auto );
																																while ( $ROW = mysql_fetch_array( $cursor_auto ) )
																																{
																																				$USER_ID = $ROW['USER_ID'];
																																				$USER_NAME = $ROW['USER_NAME'];
																																				$AUTO_VALUE .= "<option value=\"".$USER_ID."\"";
																																				if ( $ITEM_VALUE == $USER_ID )
																																				{
																																								$AUTO_VALUE .= " selected";
																																								$ITEM_VALUE_TEXT = $USER_NAME;
																																				}
																																				$AUTO_VALUE .= ">".$USER_NAME."</option>\n";
																																}
																												case "SYS_LIST_PRIV" :
																																$query_auto = "SELECT USER_PRIV,PRIV_NAME from USER_PRIV order by PRIV_NO";
																																$cursor_auto = exequery( $connection, $query_auto );
																																while ( $ROW = mysql_fetch_array( $cursor_auto ) )
																																{
																																				$USER_PRIV = $ROW['USER_PRIV'];
																																				$PRIV_NAME = $ROW['PRIV_NAME'];
																																				$AUTO_VALUE .= "<option value=\"".$USER_PRIV."\"";
																																				if ( $ITEM_VALUE == $USER_PRIV )
																																				{
																																								$AUTO_VALUE .= " selected";
																																								$ITEM_VALUE_TEXT = $PRIV_NAME;
																																				}
																																				$AUTO_VALUE .= ">".$PRIV_NAME."</option>\n";
																																}
																												case "SYS_LIST_PRCSUSER1" :
																																$query_auto = "select PRCS_USER,PRCS_DEPT,PRCS_PRIV from FLOW_PROCESS where FLOW_ID='".$FLOW_ID."' order by PRCS_ID";
																																$cursor_auto = exequery( $connection, $query_auto );
																																$PRCS_USER = "";
																																$PRCS_DEPT = "";
																																$PRCS_PRIV = "";
																																$PRCS_DEPT_ALL = "";
																																while ( $ROW = mysql_fetch_array( $cursor_auto ) )
																																{
																																				if ( $ROW['PRCS_USER'] != "" )
																																				{
																																								$PRCS_USER .= $ROW['PRCS_USER'];
																																				}
																																				if ( $ROW['PRCS_DEPT'] != "" && $ROW['PRCS_DEPT'] != "ALL_DEPT" )
																																				{
																																								$PRCS_DEPT .= $ROW['PRCS_DEPT'];
																																				}
																																				else if ( $ROW['PRCS_DEPT'] == "ALL_DEPT" )
																																				{
																																								$PRCS_DEPT_ALL = "ALL_DEPT";
																																				}
																																				if ( $ROW['PRCS_PRIV'] != "" )
																																				{
																																								$PRCS_PRIV .= $ROW['PRCS_PRIV'];
																																				}
																																}
																																$query_auto = "SELECT USER_ID,USER_NAME from USER,USER_PRIV where USER.USER_PRIV=USER_PRIV.USER_PRIV AND NOT_LOGIN=0 AND (";
																																if ( $PRCS_DEPT && $PRCS_DEPT_ALL != "ALL_DEPT" )
																																{
																																				$query_auto .= "FIND_IN_SET(USER.DEPT_ID,'".$PRCS_DEPT."')";
																																}
																																else if ( $PRCS_DEPT_ALL == "ALL_DEPT" )
																																{
																																				$query_auto .= "1=1";
																																}
																																else
																																{
																																				$query_auto .= "1=0";
																																}
																																if ( $PRCS_USER )
																																{
																																				$query_auto .= " or FIND_IN_SET(USER.USER_ID,'".$PRCS_USER."')";
																																}
																																if ( $PRCS_PRIV )
																																{
																																				$query_auto .= " or FIND_IN_SET(USER.USER_PRIV,'".$PRCS_PRIV."')".flow_other_sql( $PRCS_PRIV );
																																}
																																$query_auto .= ") order by PRIV_NO,USER_NO,USER_NAME";
																																$cursor_auto = exequery( $connection, $query_auto );
																																while ( $ROW = mysql_fetch_array( $cursor_auto ) )
																																{
																																				$USER_ID = $ROW['USER_ID'];
																																				$USER_NAME = $ROW['USER_NAME'];
																																				$AUTO_VALUE .= "<option value=\"".$USER_ID."\"";
																																				if ( $ITEM_VALUE == $USER_ID )
																																				{
																																								$AUTO_VALUE .= " selected";
																																								$ITEM_VALUE_TEXT = $USER_NAME;
																																				}
																																				$AUTO_VALUE .= ">".$USER_NAME."</option>\n";
																																}
																												case "SYS_LIST_PRCSUSER2" :
																																if ( $EDIT_MODE )
																																{
																																				$query_auto = "select PRCS_USER,PRCS_DEPT,PRCS_PRIV from FLOW_PROCESS where FLOW_ID='".$FLOW_ID."' and PRCS_ID='{$FLOW_PRCS}'";
																																				$cursor_auto = exequery( $connection, $query_auto );
																																				$PRCS_USER = "";
																																				$PRCS_DEPT = "";
																																				$PRCS_PRIV = "";
																																				if ( $ROW = mysql_fetch_array( $cursor_auto ) )
																																				{
																																								if ( $ROW['PRCS_USER'] != "" )
																																								{
																																												$PRCS_USER = $ROW['PRCS_USER'];
																																								}
																																								if ( $ROW['PRCS_DEPT'] != "" && $ROW['PRCS_DEPT'] != "ALL_DEPT" )
																																								{
																																												$PRCS_DEPT = $ROW['PRCS_DEPT'];
																																								}
																																								else if ( $ROW['PRCS_DEPT'] == "ALL_DEPT" )
																																								{
																																												$PRCS_DEPT = "ALL_DEPT";
																																								}
																																								if ( $ROW['PRCS_PRIV'] != "" )
																																								{
																																												$PRCS_PRIV = $ROW['PRCS_PRIV'];
																																								}
																																				}
																																				if ( $ITEM_VALUE != "" )
																																				{
																																								$PRCS_USER .= $ITEM_VALUE;
																																				}
																																				$query_auto = "SELECT USER_ID,USER_NAME from USER,USER_PRIV where USER.USER_PRIV=USER_PRIV.USER_PRIV AND NOT_LOGIN=0 AND (";
																																				if ( $PRCS_DEPT && $PRCS_DEPT != "ALL_DEPT" )
																																				{
																																								$query_auto .= "FIND_IN_SET(USER.DEPT_ID,'".$PRCS_DEPT."')";
																																				}
																																				else if ( $PRCS_DEPT == "ALL_DEPT" )
																																				{
																																								$query_auto .= "1=1";
																																				}
																																				else
																																				{
																																								$query_auto .= "1=0";
																																				}
																																				if ( $PRCS_USER )
																																				{
																																								$query_auto .= " or FIND_IN_SET(USER.USER_ID,'".$PRCS_USER."')";
																																				}
																																				if ( $PRCS_PRIV )
																																				{
																																								$query_auto .= " or FIND_IN_SET(USER.USER_PRIV,'".$PRCS_PRIV."')".flow_other_sql( $PRCS_PRIV );
																																				}
																																				$query_auto .= ") order by PRIV_NO,USER_NO,USER_NAME";
																																				$cursor_auto = exequery( $connection, $query_auto );
																																				while ( $ROW = mysql_fetch_array( $cursor_auto ) )
																																				{
																																								$USER_ID = $ROW['USER_ID'];
																																								$USER_NAME = $ROW['USER_NAME'];
																																								$AUTO_VALUE .= "<option value=\"".$USER_ID."\"";
																																								if ( $ITEM_VALUE == $USER_ID )
																																								{
																																												$AUTO_VALUE .= " selected";
																																												$ITEM_VALUE_TEXT = $USER_NAME;
																																								}
																																								$AUTO_VALUE .= ">".$USER_NAME."</option>\n";
																																				}
																																}
																												case "SYS_LIST_SQL" :
																																$EDATASRC = $ELEMENT_ARR['DATASRC'];
																																$ELEMENT_OUT = str_replace( $EDATASRC, "", $ELEMENT_OUT );
																																$EDATASRC = str_replace( "`", "'", $EDATASRC );
																																$EDATASRC = str_replace( "&#13;&#10;", " ", $EDATASRC );
																																$EDATASRC = str_replace( "[SYS_USER_ID]", $LOGIN_USER_ID, $EDATASRC );
																																$EDATASRC = str_replace( "[SYS_DEPT_ID]", $LOGIN_DEPT_ID, $EDATASRC );
																																$EDATASRC = str_replace( "[SYS_PRIV_ID]", $LOGIN_USER_PRIV, $EDATASRC );
																																$EDATASRC = str_replace( "[SYS_PRIV_NO]", $LOGIN_USER_PRIV_NO, $EDATASRC );
																																$EDATASRC = str_replace( "[SYS_RUN_ID]", $RUN_ID, $EDATASRC );
																																$cursor_SYS_SQL = exequery( $connection, $EDATASRC );
																																$ITEM_VALUE_TEXT = $ITEM_VALUE;
																																while ( $ROW = mysql_fetch_array( $cursor_SYS_SQL ) )
																																{
																																				$AUTO_VALUE_SQL = $ROW[0];
																																				$AUTO_VALUE .= "<option value=\"".$AUTO_VALUE_SQL."\"";
																																				if ( $ITEM_VALUE == $AUTO_VALUE_SQL )
																																				{
																																								$AUTO_VALUE .= " selected";
																																				}
																																				$AUTO_VALUE .= ">".$AUTO_VALUE_SQL."</option>\n";
																																}
																												case "SYS_LIST_MANAGER1" :
																																$MANAGER_ARRAY = get_dept_manager( $LOGIN_DEPT_ID );
																																$AUTO_VALUE = array2list( &$MANAGER_ARRAY, $ITEM_VALUE );
																																break;
																												case "SYS_LIST_MANAGER2" :
																																$PARENT_DEPT_ID = get_dept_parent( $LOGIN_DEPT_ID );
																																$MANAGER_ARRAY = get_dept_manager( $PARENT_DEPT_ID );
																																$AUTO_VALUE = array2list( &$MANAGER_ARRAY, $ITEM_VALUE );
																																break;
																												case "SYS_LIST_MANAGER3" :
																																$TOP_DEPT_ID = get_dept_parent( $LOGIN_DEPT_ID, 1 );
																																$MANAGER_ARRAY = get_dept_manager( $TOP_DEPT_ID );
																																$AUTO_VALUE = array2list( &$MANAGER_ARRAY, $ITEM_VALUE );
																								}
																								$ELEMENT_OUT = substr( $ELEMENT_OUT, 0, strpos( $ELEMENT_OUT, ">" ) + 1 ).$AUTO_VALUE."</SELECT>";
																				}
																}
												}
												echo "<b>".$ETITLE."</b>:".$ELEMENT_OUT."<br />";
								}
				}
				echo "<hr>";
				$query = "SELECT * from FLOW_FORM_TYPE WHERE FORM_ID='".$FORM_ID."'";
				$cursor1 = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor1 ) )
				{
								$FORM_NAME = $ROW['FORM_NAME'];
								$PRINT_MODEL = $ROW['PRINT_MODEL_SHORT'];
				}
				if ( strstr( $PRINT_MODEL, "#[MACRO_SIGN" ) )
				{
								$query = "SELECT PRCS_ID,FLOW_PRCS from FLOW_RUN_PRCS WHERE RUN_ID='".$RUN_ID."'";
								$cursor = exequery( $connection, $query );
								while ( $ROW = mysql_fetch_array( $cursor ) )
								{
												$PRCS_ID1 = $ROW['PRCS_ID'];
												$FLOW_PRCS1 = $ROW['FLOW_PRCS'];
												$query = "SELECT PRCS_NAME from FLOW_PROCESS WHERE FLOW_ID=".$FLOW_ID." AND PRCS_ID='{$FLOW_PRCS1}'";
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
				echo "\">\r\n<input type=\"button\" class=\"ButtonA\" value=\"";
				echo _( "会签" );
				echo "\" onClick=\"location='sign.php?P=";
				echo $P;
				echo "&FLOW_ID=";
				echo $FLOW_ID;
				echo "&RUN_ID=";
				echo $RUN_ID;
				echo "&PRCS_ID=";
				echo $PRCS_ID;
				echo "&FLOW_PRCS=";
				echo $FLOW_PRCS;
				echo "'\">&nbsp;\r\n<input type=\"submit\" class=\"ButtonA\" value=\"";
				echo _( "保存" );
				echo "\">&nbsp;\r\n<input type=\"button\" class=\"ButtonA\" value=\"";
				echo _( "转交" );
				echo "\" onClick=\"location='turn.php?P=";
				echo $P;
				echo "&FLOW_ID=";
				echo $FLOW_ID;
				echo "&RUN_ID=";
				echo $RUN_ID;
				echo "&PRCS_ID=";
				echo $PRCS_ID;
				echo "&FLOW_PRCS=";
				echo $FLOW_PRCS;
				echo "'\">&nbsp;\r\n</form>\r\n\r\n</div>\r\n</body>\r\n</html>";
?>
