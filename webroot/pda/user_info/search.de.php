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
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "人员查询" );
echo "</span>\r\n</div>\r\n<div class=\"list_main\">\r\n";
$query = "SELECT * from USER where USER_NAME like '%".$USER_NAME."%' and DEPT_ID!='0' limit 0,20";
$cursor = exequery( $connection, $query );
$USER_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$USER_COUNT;
				$USER_NAME = $ROW['USER_NAME'];
				$USER_PRIV = $ROW['USER_PRIV'];
				$DEPT_ID = $ROW['DEPT_ID'];
				$SEX = $ROW['SEX'];
				$TEL_NO_DEPT = $ROW['TEL_NO_DEPT'];
				$MOBIL_NO = $ROW['MOBIL_NO'];
				$EMAIL = $ROW['EMAIL'];
				$MOBIL_NO_HIDDEN = $ROW['MOBIL_NO_HIDDEN'];
				$query1 = "SELECT * from USER_PRIV where USER_PRIV='".$USER_PRIV."'";
				$cursor1 = exequery( $connection, $query1 );
				if ( $ROW = mysql_fetch_array( $cursor1 ) )
				{
								$USER_PRIV = $ROW['PRIV_NAME'];
				}
				$DEPT_LONG_NAME = dept_long_name( $DEPT_ID );
				if ( $SEX == 0 )
				{
								$SEX = _( "男" );
				}
				else
				{
								$SEX = _( "女" );
				}
				echo "   <div class=\"list_item\">\r\n      ";
				echo $USER_COUNT;
				echo ".<b>";
				echo $USER_NAME;
				echo "</b>";
				echo _( "：" );
				echo $SEX;
				echo "<br>\r\n      ";
				echo _( "部门：" );
				echo $DEPT_LONG_NAME;
				echo "<br>\r\n      ";
				echo _( "角色：" );
				echo $USER_PRIV;
				echo "<br>\r\n";
				if ( $TEL_NO_DEPT != "" )
				{
								echo "      ";
								echo _( "工作电话：" );
								echo $TEL_NO_DEPT;
								echo "<br>\r\n";
				}
				if ( $MOBIL_NO != "" )
				{
								echo "      ";
								echo _( "手机：" );
								if ( $MOBIL_NO_HIDDEN != "1" )
								{
												echo $MOBIL_NO;
								}
								else
								{
												echo _( "不公开" );
								}
								echo "<br>\r\n";
				}
				if ( $EMAIL != "" )
				{
								echo "      ";
								echo _( "Email：" );
								echo "<u>";
								echo $EMAIL;
								echo "</u><br>\r\n";
				}
				echo "   </div>\r\n";
}
if ( $USER_COUNT == 0 )
{
				echo "<div class=\"message\">无符合条件的人员</div>";
}
echo "</div>\r\n</body>\r\n</html>\r\n";
?>
