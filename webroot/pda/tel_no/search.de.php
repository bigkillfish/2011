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
mysql_select_db( "BUS", $connection );
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "�����ʱ��ѯ" );
echo "</span>\r\n</div>\r\n<div class=\"list_main\">\r\n";
$query = "SELECT * from POST_TEL where 1=1 ";
if ( $AREA != "" )
{
				$query .= " and (CITY like '%".$AREA."%' or COUNTY like '%{$AREA}%' or TOWN like '%{$AREA}%')";
}
if ( $TEL_NO != "" )
{
				$query .= " and TEL_NO like '%".$TEL_NO."%'";
}
if ( $POST_NO != "" )
{
				$query .= " and POST_NO like '%".$POST_NO."%'";
}
$cursor = exequery( $connection, $query );
$TEL_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$TEL_COUNT;
				if ( 20 < $TEL_COUNT )
				{
								$PROVINCE = $ROW['PROVINCE'];
								$CITY = $ROW['CITY'];
								$COUNTY = $ROW['COUNTY'];
								$TOWN = $ROW['TOWN'];
								$TEL_NO = $ROW['TEL_NO'];
								$POST_NO = $ROW['POST_NO'];
								echo "   <div class=\"list_item\">\r\n      ";
								echo $TEL_COUNT;
								echo ".<b>";
								echo $PROVINCE;
								echo " - ";
								echo $AREA;
								echo "</b><br>\r\n      ";
								echo _( "ʡ(ֱϽ��/������)" );
								echo ":";
								echo $PROVINCE;
								echo "<br>\r\n      ";
								echo _( "����" );
								echo ":";
								echo $CITY;
								echo "<br>\r\n      ";
								echo _( "��/��" );
								echo ":";
								echo $COUNTY;
								echo "<br>\r\n      ";
								echo _( "�ֵ�" );
								echo ":";
								echo $TOWN;
								echo "<br>\r\n      ";
								echo _( "����" );
								echo ":";
								echo $TEL_NO;
								echo "<br>\r\n      ";
								echo _( "�ʱ�" );
								echo ":";
								echo $POST_NO;
								echo "<br>\r\n   </div>\r\n";
				}
}
if ( $TEL_COUNT == 0 )
{
				echo "<div class=\"message\">�޷��������ļ�¼</div>";
}
echo "</div>\r\n</body>\r\n</html>\r\n";
?>
