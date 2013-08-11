<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$query_num = $fix_for_pad['sms-list-show-num'] != "" ? $fix_for_pad['sms-list-show-num'] : 7;
$query = "SELECT FROM_UID from message where TO_UID='".$LOGIN_UID."' and DELETE_FLAG!='1' group by FROM_UID order by MSG_ID desc limit 0,".$query_num;
$cursor = exequery( $connection, $query );
$rc = mysql_affected_rows( );
while ( $ROW1 = mysql_fetch_array( $cursor ) )
{
				$FROM_UID = $ROW1['FROM_UID'];
				$new_msg = "";
				$query1 = "SELECT FROM_UID,TO_UID,SEND_TIME,CONTENT,REMIND_FLAG from message where (TO_UID='".$LOGIN_UID."' AND FROM_UID='{$FROM_UID}') OR (TO_UID='{$FROM_UID}' AND FROM_UID='{$LOGIN_UID}') and DELETE_FLAG!='1' order by MSG_ID desc limit 1";
				$cursor1 = exequery( $connection, $query1 );
				if ( $ROW = mysql_fetch_array( $cursor1 ) )
				{
								$TO_UID = $ROW['TO_UID'];
								$SEND_TIME = $ROW['SEND_TIME'];
								$CONTENT = $ROW['CONTENT'];
								$REMIND_FLAG = $ROW['REMIND_FLAG'];
								$SEND_TIME = timeintval( $SEND_TIME );
								$new_msg = $REMIND_FLAG == 1 ? "data-theme=\"e\"" : "";
								echo "<li data-iconpos=\"right\" class=\"";
								echo $fix_for_pad['sms-list-content-li'];
								echo "\" ";
								echo $new_msg;
								echo ">\r\n\t\t\t<img src=\"";
								echo showavatar( $USER_ARRAY[$FROM_UID]['AVATAR'] );
								echo "\" class=\"ui-li-thumb\"/>\r\n\t\t\t<a href=\"msg.php?FROM_UID=";
								echo $FROM_UID;
								echo "\" rel=\"external\" data-transition=\"slide\" ajax-data=\"false\">\r\n\t\t\t\t<p class=\"ui-li-aside\">";
								echo $SEND_TIME;
								echo "</p>\r\n\t\t\t\t<h3>";
								echo $USER_ARRAY[$FROM_UID]['NAME'];
								echo "</h3>\r\n\t\t\t\t<p>";
								echo $CONTENT;
								echo "&nbsp;</p>\r\n\t\t\t</a>\r\n</li>\r\n";
				}
}
?>
