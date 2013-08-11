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
echo "\r\n<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"../main.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "今日日程" );
echo "</span>\r\n\t<div class=\"list_top_right\"><a class=\"ButtonB\" href=\"new.php?P=";
echo $P;
echo "\">";
echo _( "新建日程" );
echo "</a></div>\r\n</div>\t\r\n<div class=\"list_main\">\r\n";
$CUR_DATE = date( "Y-m-d", time( ) );
$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
$CUR_TIME_U = time( );
$query = "SELECT * from CALENDAR where USER_ID='".$LOGIN_USER_ID."' and to_days(from_unixtime(CAL_TIME))=to_days('{$CUR_DATE}') order by CAL_TIME ";
$cursor = exequery( $connection, $query );
$CAL_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$CAL_COUNT;
				$CAL_ID = $ROW['CAL_ID'];
				$CAL_TIME = $ROW['CAL_TIME'];
				$CAL_TIME = date( "Y-m-d H:i:s", $CAL_TIME );
				$END_TIME = $ROW['END_TIME'];
				$END_TIME = date( "Y-m-d H:i:s", $END_TIME );
				$CAL_TIME = strtok( $CAL_TIME, " " );
				$CAL_TIME = strtok( " " );
				$CAL_TIME = substr( $CAL_TIME, 0, 5 );
				$END_TIME = strtok( $END_TIME, " " );
				$END_TIME = strtok( " " );
				$END_TIME = substr( $END_TIME, 0, 5 );
				$CONTENT = $ROW['CONTENT'];
				$CONTENT = str_replace( "<", "&lt", $CONTENT );
				$CONTENT = str_replace( ">", "&gt", $CONTENT );
				$CONTENT = stripslashes( $CONTENT );
				echo "  <div class=\"list_item\">\r\n    <a  hidefocus=\"hidefocus\" >\r\n       <div class=\"list_item_subject\">";
				echo $CAL_TIME;
				echo "-";
				echo $END_TIME;
				echo " ";
				echo $CONTENT;
				echo "</div>\r\n       <div class=\"list_item_time\"></div>\r\n       <div class=\"list_item_arrow\"></div>\r\n    </a>      \r\n      <div class=\"list_item_op\">\r\n         <a href=\"edit.php?P=";
				echo $P;
				echo "&CAL_ID=";
				echo $CAL_ID;
				echo "\">";
				echo _( "修改" );
				echo "</a>\r\n      </div>  \r\n   </div>   \r\n";
}
$query = "SELECT * from AFFAIR where USER_ID='".$LOGIN_USER_ID."' and BEGIN_TIME<='{$CUR_TIME_U}' order by REMIND_TIME";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$AFF_ID = $ROW['AFF_ID'];
				$USER_ID = $ROW['USER_ID'];
				$TYPE = $ROW['TYPE'];
				$REMIND_DATE = $ROW['REMIND_DATE'];
				$REMIND_TIME = $ROW['REMIND_TIME'];
				$CONTENT = $ROW['CONTENT'];
				$FLAG = 0;
				if ( $TYPE == "2" )
				{
								$FLAG = 1;
				}
				else if ( $TYPE == "3" && date( "w", time( ) ) == $REMIND_DATE )
				{
								$FLAG = 1;
				}
				else if ( $TYPE == "4" && date( "j", time( ) ) == $REMIND_DATE )
				{
								$FLAG = 1;
				}
				else if ( $TYPE == "5" )
				{
								$REMIND_ARR = explode( "-", $REMIND_DATE );
								$REMIND_DATE_MON = $REMIND_ARR[0];
								$REMIND_DATE_DAY = $REMIND_ARR[1];
								if ( date( "n", time( ) ) == $REMIND_DATE_MON && date( "j", time( ) ) == $REMIND_DATE_DAY )
								{
												$FLAG = 1;
								}
				}
				if ( $FLAG == 1 )
				{
								++$CAL_COUNT;
								echo "      <a class=\"list_item\" hidefocus=\"hidefocus\" >\r\n       <div class=\"list_item_subject\">";
								echo substr( $REMIND_TIME, 0, 5 );
								echo " ";
								echo $CONTENT;
								echo "</div>\r\n       <div class=\"list_item_time\"></div>\r\n       <div class=\"list_item_arrow\"></div>\r\n    </a>    \r\n     \r\n";
				}
}
if ( $CAL_COUNT == 0 )
{
				echo "<div class='message'>"._( "暂无日程安排" )."</div>";
}
echo "</div>\r\n\r\n</body>\r\n</html>\r\n";
?>
