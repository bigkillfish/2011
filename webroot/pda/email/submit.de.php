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
include_once( "inc/utility_sms1.php" );
echo "<body>\r\n<div id=\"list_top\">\r\n\t<div class=\"list_top_left\"><a class=\"ButtonBack\" href=\"index.php?P=";
echo $P;
echo "\"></a></div>\r\n\t<span class=\"list_top_center\">";
echo _( "邮件发送" );
echo "</span>\r\n</div>\r\n<div class=\"list_main\">\r\n   <div class=\"message\">\r\n";
$SEND_TIME = time( );
if ( $TO_NAME2 != "" )
{
				$query = "SELECT * from WEBMAIL where USER_ID='".$LOGIN_USER_ID."' and EMAIL_PASS!='' limit 1";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$EMAIL = $ROW['EMAIL'];
								$SMTP_SERVER = $ROW['SMTP_SERVER'];
								$LOGIN_TYPE = $ROW['LOGIN_TYPE'];
								$SMTP_PASS = $ROW['SMTP_PASS'];
								$SMTP_PORT = $ROW['SMTP_PORT'];
								$SMTP_SSL = $ROW['SMTP_SSL'] == "1" ? "ssl" : "";
								$EMAIL_PASS = $ROW['EMAIL_PASS'];
								$EMAIL_PASS = td_authcode( $EMAIL_PASS, "DECODE" );
								if ( $LOGIN_TYPE == "1" )
								{
												$SMTP_USER = substr( $EMAIL, 0, strpos( $EMAIL, "@" ) );
								}
								else
								{
												$SMTP_USER = $EMAIL;
								}
								if ( $SMTP_PASS == "yes" )
								{
												$SMTP_PASS = $EMAIL_PASS;
								}
								else
								{
												$SMTP_PASS = "";
								}
								$result = send_mail( $EMAIL, $TO_NAME2, $SUBJECT, $CONTENT, $SMTP_SERVER, $SMTP_USER, $SMTP_PASS, TRUE, $LOGIN_USER_NAME, $REPLY_TO, $CC, $BCC, $ATTACHMENT, TRUE, $SMTP_PORT, $SMTP_SSL );
								if ( $result === TRUE )
								{
												echo _( "外部邮件发送成功" );
								}
								else
								{
												$query = "update EMAIL_BODY set SEND_FLAG='0' where BODY_ID=".$BODY_ID;
												exequery( $connection, $query );
												echo _( "外部邮件发送失败" );
								}
				}
				else
				{
								echo _( "您没有定义Internet邮箱！" );
				}
}
$TO_NAME_ARRAY1 = explode( ",", $TO_NAME1 );
do
{
				if ( list( , $value ) = each( &$TO_NAME_ARRAY1 ) )
				{
								if ( $value )
								{
												$query = "select USER_ID from USER WHERE USER_NAME='".$value."'";
												$cursor = exequery( $connection, $query );
												do
												{
												} while ( !( $ROW = mysql_fetch_array( $cursor ) ) );
												$TO_ID .= $ROW['USER_ID'].",";
								} while ( 1 );
				}
}
if ( $TO_ID == "" )
{
				echo _( "无此OA用户！" );
}
else
{
				$query = "insert into EMAIL_BODY(FROM_ID,TO_ID2,SUBJECT,CONTENT,SEND_TIME,SEND_FLAG,SMS_REMIND,FROM_WEBMAIL,TO_WEBMAIL) values ('".$LOGIN_USER_ID."','{$TO_ID}','{$SUBJECT}','{$CONTENT}','{$SEND_TIME}','1','1','{$EMAIL}','{$TO_NAME2}')";
				exequery( $connection, $query );
				$BODY_ID = mysql_insert_id( );
				$TOK = strtok( $TO_ID, "," );
				while ( $TOK != "" )
				{
								if ( $TOK == "" )
								{
												$TOK = strtok( "," );
								}
								else
								{
												$query = "insert into EMAIL(TO_ID,READ_FLAG,DELETE_FLAG,BODY_ID) values ('".$TOK."','0','0','{$BODY_ID}')";
												exequery( $connection, $query );
												$ROW_ID = mysql_insert_id( );
												$REMIND_URL = "email/?MAIN_URL=".urlencode( "inbox/read_email/?BOX_ID=0&EMAIL_ID=".$ROW_ID );
												$SMS_CONTENT = _( "请查收我的邮件！\n主题：" ).csubstr( $SUBJECT1, 0, 100 );
												send_sms( "", $LOGIN_USER_ID, $TOK, 2, $SMS_CONTENT, $REMIND_URL );
												$TOK = strtok( "," );
								}
				}
				echo _( "邮件发送成功" );
}
echo "   </div>\r\n</div>\r\n</body>\r\n</html>";
?>
