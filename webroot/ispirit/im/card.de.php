<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
include_once( "inc/utility_all.php" );
include_once( "inc/utility_file.php" );
$UID = $UID == "" ? $LOGIN_UID : $UID;
$query = "SELECT * from USER where UID='".$UID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$USER_ID = $ROW['USER_ID'];
				$USER_NAME = $ROW['USER_NAME'];
				$DEPT_ID = $ROW['DEPT_ID'];
				$USER_PRIV = $ROW['USER_PRIV'];
				$SEX = $ROW['SEX'];
				$BIRTHDAY = $ROW['BIRTHDAY'];
				$TEL_NO_DEPT = $ROW['TEL_NO_DEPT'];
				$MOBIL_NO = $ROW['MOBIL_NO'];
				$MOBIL_NO_HIDDEN = $ROW['MOBIL_NO_HIDDEN'];
				$EMAIL = $ROW['EMAIL'];
				$QQ = $ROW['OICQ_NO'];
				$PHOTO = $ROW['PHOTO'];
				$DEPT_LONG_NAME = dept_long_name( $DEPT_ID );
				$DEPT_NAME = $DEPT_ID == "0" ? _( "外部/离职人员" ) : dept_name( $DEPT_ID );
				$query = "SELECT PRIV_NAME from USER_PRIV where USER_PRIV='".$USER_PRIV."'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$PRIV_NAME = $ROW['PRIV_NAME'];
				}
				$query = "select CLIENT from USER_ONLINE where UID='".$UID."'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$CLIENT_TYPE = get_client_type( $ROW['CLIENT'] )._( "在线" );
								$CLIENT_CLASS = "online-".$ROW['CLIENT'];
				}
				else
				{
								$CLIENT_TYPE = _( "离线" );
								$CLIENT_CLASS = "offline";
				}
				$HRMS_PHOTO = "";
				$query = "select PHOTO_NAME from HR_STAFF_INFO where USER_ID='".$USER_ID."'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$HRMS_PHOTO = $ROW['PHOTO_NAME'];
				}
				if ( $PHOTO != "" )
				{
								$URL_ARRAY = attach_url_old( "photo", $PHOTO );
				}
				else if ( $HRMS_PHOTO != "" )
				{
								$URL_ARRAY = attach_url_old( "hrms_pic", $HRMS_PHOTO );
				}
				else
				{
								$URL_ARRAY = attach_url_old( "photo", "photo_".$SEX.".jpg" );
				}
				$AVATAR = $URL_ARRAY['view'];
				if ( find_id( $LOGIN_FUNC_STR, "1" ) )
				{
								$EMAIL_HREF = "/general/email/new/?TO_WEBMAIL=".$EMAIL;
				}
				else
				{
								$EMAIL_HREF = "mailto:".$EMAIL;
				}
}
ob_end_clean( );
echo "<html>\r\n<head>\r\n<title></title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"./style/card.css\" />\r\n</head>\r\n<body>\r\n<table class=\"card\">\r\n   <tr>\r\n      <td colspan=\"2\" valign=\"top\">\r\n         <div class=\"avatar\"><a href=\"/general/ipanel/user/user_info.php?USER_ID=";
echo $USER_ID;
echo "&WINDOW=1\" target=\"_blank\"><img src=\"";
echo $AVATAR;
echo "\"></a></div>\r\n         <div class=\"info\">\r\n            <div class=\"name\">";
echo $USER_NAME;
echo "</div>\r\n            <div class=\"priv\">";
echo $PRIV_NAME;
echo "</div>\r\n            <div class=\"online ";
echo $CLIENT_CLASS;
echo "\">";
echo $CLIENT_TYPE;
echo "</div>\r\n         </div>\r\n      </td>\r\n   </tr>\r\n   <tr>\r\n      <td class=\"left\" nowrap=\"nowrap\">";
echo _( "部门：" );
echo "</td>\r\n      <td class=\"right\" title=\"";
echo $DEPT_LONG_NAME;
echo "\">";
echo $DEPT_NAME;
echo "</td>\r\n   </tr>\r\n";
if ( $MOBIL_NO_HIDDEN != "1" )
{
				echo "   <tr>\r\n      <td class=\"left\" nowrap>";
				echo _( "手机：" );
				echo "</td>\r\n      <td class=\"right\" title=\"";
				echo $MOBIL_NO;
				echo "\">";
				echo $MOBIL_NO;
				echo "</td>\r\n   </tr>\r\n";
}
echo "   <tr>\r\n      <td class=\"left\" nowrap>";
echo _( "电话：" );
echo "</td>\r\n      <td class=\"right\" title=\"";
echo $TEL_NO_DEPT;
echo "\">";
echo $TEL_NO_DEPT;
echo "</td>\r\n   </tr>\r\n   <tr>\r\n      <td class=\"left\" nowrap>";
echo _( "邮箱：" );
echo "</td>\r\n      <td class=\"right\" title=\"";
echo $EMAIL;
echo "\"><a href=\"";
echo $EMAIL_HREF;
echo "\" target=\"_blank\">";
echo $EMAIL;
echo "</a></td>\r\n   </tr>\r\n   <tr>\r\n      <td class=\"left\" nowrap>";
echo _( "QQ：" );
echo "</td>\r\n      <td class=\"right\">";
echo $QQ;
echo "</td>\r\n   </tr>\r\n</table>\r\n</body>\r\n</html>";
?>
