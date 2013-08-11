<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

require_once( "inc/auth.php" );
include_once( "inc/utility_all.php" );
ob_clean( );
require_once( "config.php" );
require_once( "func.php" );
require_once( "inc/utility_msg.php" );
require_once( "user.php" );
$action_arr = array( "add", "siglequery", "whosendmsg", "mutisend" );
$action = htmlspecialchars( $action );
if ( !isset( $action ) && !in_array( $action, $action_arr ) )
{
				echo "err";
				exit( );
}
if ( $action == "add" )
{
				$msg = td_iconv( htmlspecialchars( $msg ), "utf-8", $MYOA_CHARSET );
				$to_uid = intval( $to_uid );
				$str = "";
				$SEND_TIME = date( "H:i:s", time( ) );
				send_msg( $LOGIN_UID, $to_uid, $C['msg_type'], $msg );
				$str .= "<div class=\"mycust-list line1 clear\" style=\"display:none;\">";
				$str .= "<div class=\"mycust-dioavatar\">";
				$str .= "<a href=\"#\" class=\"avatar\"><div class=\"mycust-online\"></div><img src=\"".showavatar( $USER_ARRAY[$LOGIN_UID]['AVATAR'], $USER_ARRAY[$LOGIN_UID]['SEX'] )."\" /></a>";
				$str .= "</div>";
				$str .= "<div class=\"mycust-diobox\">";
				$str .= "<span class=\"mycust-list-user\"><span class=\"mycust-list-time\">".$SEND_TIME."</span>".$USER_ARRAY[$LOGIN_UID]['NAME']."</span>";
				$str .= "<div class=\"mycust-list-msg\">".$msg."</div>";
				$str .= "</div>";
				$str .= "</div>";
				echo $str;
}
if ( $action == "siglequery" )
{
				$FROM_UID = intval( $to_uid );
				$id_str_prefix = $id_str = $final_str = $_str = $online_type = $str = $msg_type_name = "";
				$query = "SELECT MSG_ID,FROM_UID,SEND_TIME,CONTENT,MSG_TYPE from message where (TO_UID='".$LOGIN_UID."' and FROM_UID='{$FROM_UID}') and DELETE_FLAG!='1' and REMIND_FLAG = 1 order by MSG_ID desc";
				$cursor = exequery( $connection, $query );
				$rc = mysql_affected_rows( );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$MSG_ID = $ROW['MSG_ID'];
								$FROM_UID = $ROW['FROM_UID'];
								$TO_UID = $ROW['TO_UID'];
								$SEND_TIME = $ROW['SEND_TIME'];
								$CONTENT = $ROW['CONTENT'];
								$MSG_TYPE = $ROW['MSG_TYPE'];
								$SEND_TIME = date( "H:i:s", $SEND_TIME );
								++$count;
								$line_style = $FROM_UID == $LOGIN_UID ? "line1" : "line2";
								$id_str .= $id_str_prefix.$MSG_ID;
								$id_str_prefix = ",";
								$online_type = $MSG_TYPE == 3 ? "<div class=\"mycust-online\"></div>" : "";
								$msg_type_name = $MSG_TYPE == 3 ? " - 消息来自微讯" : "";
								$str .= "<div class=\"mycust-list ".$line_style." clear\" style=\"display:none;\">";
								$str .= "<div class=\"mycust-dioavatar\">";
								$str .= "<a href=\"#\" class=\"avatar\">".$online_type."<img src=\"".showavatar( $USER_ARRAY[$FROM_UID]['AVATAR'], $USER_ARRAY[$FROM_UID]['SEX'] )."\" /></a>";
								$str .= "</div>";
								$str .= "<div class=\"mycust-diobox\">";
								$str .= "<span class=\"mycust-list-user\"><span class=\"mycust-list-time\">".$SEND_TIME."</span>".$USER_ARRAY[$FROM_UID]['NAME']."<span class=\"mycust-list-from\">".$msg_type_name."</span></span>";
								$str .= "<div class=\"mycust-list-msg\">".$CONTENT."</div>";
								$str .= "</div>";
								$str .= "</div>";
								$final_str .= $str.$final_str;
								$_str = "";
				}
				if ( 0 < $rc )
				{
								$query1 = "UPDATE message SET REMIND_FLAG = 2 WHERE MSG_ID IN (".$id_str.")";
								exequery( $connection, $query1 );
				}
				else
				{
								echo "NO";
								exit( );
				}
				echo $final_str;
}
if ( $action == "whosendmsg" )
{
				$charset = ini_get( "default_charset" );
				$TO_UID = intval( $to_uid );
				$new_data = array( );
				if ( ag( "iPad" ) )
				{
								$fix_for_pad = $C['optimizeiPad'];
				}
				$MSG_USER_LIST = array( );
				$MSG_LIST = array( );
				$new_msg = $str = "";
				$query_num = $fix_for_pad['sms-list-show-num'] != "" ? $fix_for_pad['sms-list-show-num'] : 7;
				$query = "SELECT FROM_UID,TO_UID,REMIND_FLAG,SEND_TIME,CONTENT from message where (TO_UID='".$LOGIN_UID."' or FROM_UID='{$LOGIN_UID}') and DELETE_FLAG!='1' order by SEND_TIME DESC";
				$cursor = exequery( $connection, $query );
				while ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$FROM_UID = $ROW['FROM_UID'];
								$TO_UID = $ROW['TO_UID'];
								$SEND_TIME = $ROW['SEND_TIME'];
								$REMIND_FLAG = $ROW['REMIND_FLAG'];
								$CONTENT = $ROW['CONTENT'];
								if ( $TO_UID == $LOGIN_UID && !array_key_exists( "USER_".$FROM_UID, $MSG_USER_LIST ) )
								{
												$MSG_USER_LIST["USER_".$FROM_UID] = 1;
												$MSG_LIST["USER_".$FROM_UID] = array( $FROM_UID, $SEND_TIME, $REMIND_FLAG == 1 ? 1 : 0, $CONTENT );
								}
								if ( $FROM_UID == $LOGIN_UID && !array_key_exists( "USER_".$TO_UID, $MSG_USER_LIST ) )
								{
												$MSG_USER_LIST["USER_".$TO_UID] = "USER_".$TO_UID;
												$MSG_LIST["USER_".$TO_UID] = array( $TO_UID, $SEND_TIME, 0, $CONTENT );
								}
								if ( $query_num <= count( $MSG_LIST ) )
								{
								}
				}
				$MSG_NUM = count( $MSG_LIST );
				if ( $MSG_NUM <= 0 )
				{
								echo "NO";
								exit( );
				}
				foreach ( $MSG_LIST as $k => $v )
				{
								$SEND_TIME = timeintval( $v[1] );
								$new_msg = 0 < $v[2] ? "ui-btn-up-e udf-new-msg" : "ui-btn-up-c";
								$str .= "<li data-iconpos=\"right\" class=\"ui-btn ".$new_msg." ui-btn-icon-right ui-li ".$fix_for_pad['sms-list-content-li']."\"><div class=\"ui-btn-inner ui-li\"><div class=\"ui-btn-text\">";
								$str .= "<img src=\"".showavatar( $USER_ARRAY[$v[0]]['AVATAR'], $USER_ARRAY[$v[0]]['SEX'] )."\" class=\"ui-li-thumb\"/>";
								$str .= "<a href=\"msg.php?FROM_UID=".$FROM_UID."\" data-transition=\"slide\" rel=\"external\" data-transition=\"slide\" ajax-data=\"false\" class=\"ui-link-inherit\">";
								$str .= "<p class=\"ui-li-aside ui-li-desc\">".$SEND_TIME."</p>";
								$str .= "<h3 class=\"ui-li-heading\">".$USER_ARRAY[$v[0]]['NAME']."</h3>";
								$str .= "<p class=\"ui-li-desc\">".$v[3]."</p>";
								$str .= "</a>";
								$str .= "</div><span class=\"ui-icon ui-icon-arrow-r\"></span></div></li>";
				}
				echo $str;
}
if ( $action == "mutisend" )
{
				$msg = td_iconv( htmlspecialchars( $msg ), "utf-8", $MYOA_CHARSET );
				$str = "";
				$SEND_TIME = date( "H:i:s", time( ) );
				send_msg( $LOGIN_UID, $to_uid, $C['msg_type'], $msg );
				echo "+OK";
}
?>
