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
include_once( "inc/utility_ubb.php" );
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "会签" );
echo "</span>\r\n\t<div class=\"list_top_right\"><a class=\"ButtonA\" href=\"javascript:document.form1.submit();\">";
echo _( "保存" );
echo "</a></div>\r\n</div>\r\n<div class=\"list_main\">\r\n";
if ( run_role( $RUN_ID, $PRCS_ID ) )
{
				echo "<div class=\"message\">无权限！</div>";
				exit( );
}
echo "   <form action=\"sign_submit.php\"  method=\"post\" name=\"form1\">\r\n   ";
echo _( "会签意见：" );
echo "<br />\r\n   <textarea style=\"width:100%;\" name=\"CONTENT\" rows=\"3\" wrap=\"on\">";
echo $CONTENT;
echo "</textarea>\r\n   <input type=\"hidden\" name=\"P\" value=\"";
echo $P;
echo "\">\r\n   <input type=\"hidden\" name=\"FLOW_ID\" value=\"";
echo $FLOW_ID;
echo "\">\r\n   <input type=\"hidden\" name=\"RUN_ID\" value=\"";
echo $RUN_ID;
echo "\">\r\n   <input type=\"hidden\" name=\"PRCS_ID\" value=\"";
echo $PRCS_ID;
echo "\">\r\n   <input type=\"hidden\" name=\"FLOW_PRCS\" value=\"";
echo $FLOW_PRCS;
echo "\">\r\n   </form>\r\n   <br />\r\n";
$query = "SELECT * from FLOW_TYPE WHERE FLOW_ID='".$FLOW_ID."'";
$cursor1 = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor1 ) )
{
				$FLOW_NAME = $ROW['FLOW_NAME'];
				$FLOW_TYPE = $ROW['FLOW_TYPE'];
}
$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
$query = "SELECT * from FLOW_RUN_PRCS where USER_ID='".$LOGIN_USER_ID."' AND RUN_ID='{$RUN_ID}' AND PRCS_ID='{$PRCS_ID}'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$PRCS_FLAG = $ROW['PRCS_FLAG'];
				$TOP_FLAG = $ROW['TOP_FLAG'];
				if ( $PRCS_FLAG == 1 )
				{
								$query = "update FLOW_RUN_PRCS set PRCS_FLAG='2',PRCS_TIME='".$CUR_TIME."' WHERE USER_ID='{$LOGIN_USER_ID}' AND RUN_ID={$RUN_ID} AND PRCS_ID={$PRCS_ID}";
								exequery( $connection, $query );
				}
}
$query = "SELECT PRCS_ID,FLOW_PRCS from FLOW_RUN_PRCS WHERE RUN_ID='".$RUN_ID."'";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$PRCS_ID1 = $ROW['PRCS_ID'];
				$FLOW_PRCS1 = $ROW['FLOW_PRCS'];
				$query = "SELECT PRCS_NAME from FLOW_PROCESS WHERE FLOW_ID='".$FLOW_ID."' AND PRCS_ID='{$FLOW_PRCS1}'";
				$cursor1 = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor1 ) )
				{
								$PRCS_NAME = $ROW['PRCS_NAME'];
				}
				$FLOW_PRCS_ARRAY[$FLOW_PRCS1] = $PRCS_NAME;
				if ( $PRCS_ID_ARRAY[$PRCS_ID1] == "" )
				{
								$PRCS_ID_ARRAY[$PRCS_ID1] = $PRCS_NAME;
				}
				else if ( find_id( $PRCS_ID_ARRAY[$PRCS_ID1], $PRCS_NAME ) )
				{
								$PRCS_ID_ARRAY .= $PRCS_ID1;
				}
}
$SIGNLOOK_ARR = array( );
if ( $FLOW_TYPE == 1 )
{
				$query1 = "select PRCS_ID,SIGNLOOK FROM FLOW_PROCESS WHERE FLOW_ID='".$FLOW_ID."'";
				$cursor1 = exequery( $connection, $query1 );
				while ( $ROW = mysql_fetch_array( $cursor1 ) )
				{
								$SIGNLOOK_ARR[$ROW['PRCS_ID']] = $ROW['SIGNLOOK'];
				}
}
$query = "SELECT * from FLOW_RUN_FEEDBACK where RUN_ID=".$RUN_ID." order by PRCS_ID,EDIT_TIME";
$cursor = exequery( $connection, $query );
$FEEDBACK_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$FEEDBACK_COUNT;
				$FEED_ID = $ROW['FEED_ID'];
				$PRCS_ID1 = $ROW['PRCS_ID'];
				$FLOW_PRCS1 = $ROW['FLOW_PRCS'];
				$USER_ID = $ROW['USER_ID'];
				$CONTENT = $ROW['CONTENT'];
				$ATTACHMENT_ID = $ROW['ATTACHMENT_ID'];
				$ATTACHMENT_NAME1 = $ROW['ATTACHMENT_NAME'];
				$EDIT_TIME = $ROW['EDIT_TIME'];
				$FEED_SIGN_DATA = $ROW['SIGN_DATA'];
				if ( $FLOW_TYPE == 1 )
				{
								$SIGNLOOK1 = $SIGNLOOK_ARR["{$FLOW_PRCS1}"];
								if ( $SIGNLOOK1 == 2 && $PRCS_ID1 != $PRCS_ID && $USER_ID != $LOGIN_USER_ID )
								{
								}
								else
								{
								}
				}
				else
				{
								$CONTENT_VIEW = htmlspecialchars( $CONTENT );
								$CONTENT_VIEW = ubb2xhtml( $CONTENT_VIEW );
								$CONTENT_VIEW = nl2br( $CONTENT_VIEW );
								$query1 = "SELECT USER_NAME,DEPT_ID from USER where USER_ID='".$USER_ID."'";
								$cursor1 = exequery( $connection, $query1 );
								if ( $ROW = mysql_fetch_array( $cursor1 ) )
								{
												$USER_NAME = $ROW['USER_NAME'];
												$DEPT_ID = $ROW['DEPT_ID'];
												$DEPT_NAME = dept_long_name( $DEPT_ID );
								}
								else
								{
												$USER_NAME = $USER_ID;
								}
								echo "   \r\n   <b>";
								echo sprintf( _( "第%s步" ), $PRCS_ID1 );
								echo " ";
								echo 0 < $FLOW_PRCS1 ? $FLOW_PRCS_ARRAY[$FLOW_PRCS1] : $PRCS_ID_ARRAY[$PRCS_ID1];
								echo "</b>\r\n   <u title=\"";
								echo _( "部门：" );
								echo $DEPT_NAME;
								echo "\" style=\"cursor:hand\">";
								echo $USER_NAME;
								echo "</u></b>\r\n   <i>";
								echo $EDIT_TIME;
								echo "</i>\r\n   <div class=\"content\">\r\n      ";
								echo $CONTENT_VIEW;
								echo "   </div>\r\n";
				}
}
echo "</div>\r\n</body>\r\n</html>";
?>
