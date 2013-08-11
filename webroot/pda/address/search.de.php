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
include_once( "inc/utility.php" );
$GROUP_ID_STR = "";
$query = "select GROUP_ID from ADDRESS_GROUP where USER_ID='".$LOGIN_USER_ID."' or  (USER_ID='' and (find_in_set('{$LOGIN_USER_ID}',PRIV_USER) or PRIV_DEPT='ALL_DEPT' or find_in_set('{$LOGIN_DEPT_ID}',PRIV_DEPT) or find_in_set('{$LOGIN_USER_PRIV}',PRIV_ROLE)))";
$cursor = exequery( $connection, $query );
$GROUP_COUNT = 1;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$GROUP_ID = $ROW['GROUP_ID'];
				$GROUP_ID_STR .= $GROUP_ID.",";
}
$GROUP_ID_STR .= "0";
$PAGE_SIZE = 10;
if ( !isset( $start ) || $start == "" )
{
				$start = 0;
}
if ( isset( $TOTAL_ITEMS ) )
{
				$query = "SELECT count(*) from ADDRESS where GROUP_ID in (".$GROUP_ID_STR.")";
				if ( $PSN_NAME != "" )
				{
								$query .= " and PSN_NAME like '%".$PSN_NAME."%'";
				}
				if ( $DEPT_NAME != "" )
				{
								$query .= " and DEPT_NAME like '%".$DEPT_NAME."%'";
				}
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$TOTAL_ITEMS = $ROW[0];
				}
}
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "通讯簿查询" );
echo "</span>\r\n</div>\r\n<div class=\"list_main\">\r\n";
$query = "SELECT * from ADDRESS where GROUP_ID in (".$GROUP_ID_STR.")";
if ( $PSN_NAME != "" )
{
				$query .= " and PSN_NAME like '%".$PSN_NAME."%'";
}
if ( $DEPT_NAME != "" )
{
				$query .= " and DEPT_NAME like '%".$DEPT_NAME."%'";
}
$query .= " limit ".$start.",{$PAGE_SIZE}";
$cursor = exequery( $connection, $query );
$ADD_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$ADD_COUNT;
				$GROUP_ID = $ROW['GROUP_ID'];
				$PSN_NAME = $ROW['PSN_NAME'];
				$SEX = $ROW['SEX'];
				$BIRTHDAY = $ROW['BIRTHDAY'];
				$MINISTRATION = $ROW['MINISTRATION'];
				$DEPT_NAME = $ROW['DEPT_NAME'];
				$TEL_NO_DEPT = $ROW['TEL_NO_DEPT'];
				$TEL_NO_HOME = $ROW['TEL_NO_HOME'];
				$MOBIL_NO = $ROW['MOBIL_NO'];
				$EMAIL = $ROW['EMAIL'];
				$query1 = "select * from ADDRESS_GROUP where GROUP_ID='".$GROUP_ID."'";
				$cursor1 = exequery( $connection, $query1 );
				if ( $ROW1 = mysql_fetch_array( $cursor1 ) )
				{
								$GROUP_NAME = $ROW1['GROUP_NAME'];
				}
				if ( $GROUP_ID == 0 )
				{
								$GROUP_NAME = _( "默认" );
				}
				switch ( $SEX )
				{
								case "0" :
												$SEX = _( "男" );
								case "1" :
												$SEX = _( "女" );
								default :
												echo "   <div class=\"list_item\">\r\n      ";
												echo $start + $ADD_COUNT;
												echo ".<b>";
												echo $GROUP_NAME;
												echo "</b> ";
												echo $PSN_NAME;
												echo ":";
												echo $SEX;
												echo "<br>\r\n      ";
												echo _( "单位" );
												echo ":";
												echo $DEPT_NAME;
												echo "<br>\r\n      ";
												echo _( "职务" );
												echo ":";
												echo $MINISTRATION;
												echo "<br>\r\n      ";
												echo _( "生日" );
												echo ":";
												echo $BIRTHDAY;
												echo "<br>\r\n      ";
												echo _( "工作电话" );
												echo ":";
												echo $TEL_NO_DEPT;
												echo "<br>\r\n      ";
												echo _( "家庭电话" );
												echo ":";
												echo $TEL_NO_HOME;
												echo "<br>\r\n      ";
												echo _( "手机" );
												echo ":";
												echo $MOBIL_NO;
												echo "<br>\r\n      Email:";
												echo $EMAIL;
												echo "<br>\r\n   </div>\r\n";
								}
								if ( $ADD_COUNT == 0 )
								{
												echo "<div class=\"message\">无符合条件的记录</div>";
								}
								echo "</div>\r\n<div id=\"list_bottom\">\r\n\t<div class=\"list_bottom_left\">";
								echo pda_page_bar( $start, $TOTAL_ITEMS, $PAGE_SIZE );
								echo "</div>\r\n</div>\r\n</body>\r\n</html>\r\n";
}
?>
