<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/auth.php" );
include_once( "inc/user_online.php" );
echo "<html>\r\n<head>\r\n<title></title>\r\n</head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"./style/smsbox.css\" />\r\n<script language=javascript>\r\n\tsetInterval(\"location.reload()\",10000);\r\n</script>\r\n</head>\r\n<body class=\"group_body\">\r\n";
$ONLINE_USER_AYYAY = array( );
$ONLINE_USER_SEX_AYYAY = array( );
$ONLINE_USER_ON_STATUS_AYYAY = array( );
while ( list( $UID, $USER ) = each( &$SYS_ONLINE_USER ) )
{
				$ONLINE_USER_AYYAY[$UID] = $USER['USER_ID'];
				$ONLINE_USER_SEX_AYYAY[$UID] = $USER['SEX'];
				$ONLINE_USER_ON_STATUS_AYYAY[$UID] = $USER['ON_STATUS'];
}
$query = "select GROUP_UID FROM IM_GROUP where GROUP_ID='".$MSG_GROUP_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$GROUP_UID = $ROW['GROUP_UID'];
}
$GROUP_UID = td_trim( $GROUP_UID );
$query = "SELECT UID,USER_ID,SEX,USER_NAME from USER,USER_PRIV where USER.UID in (".$GROUP_UID.") and USER.USER_PRIV=USER_PRIV.USER_PRIV and USER.NOT_LOGIN!='1' order by PRIV_NO,USER_NO,USER_NAME";
$cursor = exequery( $connection, $query );
$ONLINE_USER_AYYAY2 = array( );
$UN_ONLINE_USER_AYYAY = array( );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				$SEX = $ROW['SEX'];
				$UID = $ROW['UID'];
				$USER_ID = $ROW['USER_ID'];
				$USER_NAME = $ROW['USER_NAME'];
				if ( in_array( $USER_ID, $ONLINE_USER_AYYAY ) )
				{
								$ONLINE_USER_AYYAY2[$USER_ID]['USER_NAME'] = $USER_NAME;
								$ONLINE_USER_AYYAY2[$USER_ID]['UID'] = $UID;
								$ONLINE_USER_AYYAY2[$USER_ID]['icon'] = "<img src='/images/org/U".$ONLINE_USER_SEX_AYYAY[$UID].$ONLINE_USER_ON_STATUS_AYYAY[$UID].".png' style='vertical-align:middle;' />";
				}
				else
				{
								$UN_ONLINE_USER_AYYAY[$USER_ID]['USER_NAME'] = $USER_NAME;
								$UN_ONLINE_USER_AYYAY[$USER_ID]['UID'] = $UID;
								if ( $SEX == 0 )
								{
												$UN_ONLINE_USER_AYYAY[$USER_ID]['icon'] = "<img src='/images/org/U00.png' style='vertical-align:middle;' />";
								}
								else
								{
												$UN_ONLINE_USER_AYYAY[$USER_ID]['icon'] = "<img src='/images/org/U10.png' style='vertical-align:middle;' />";
								}
				}
}
foreach ( $ONLINE_USER_AYYAY2 as $key => $value )
{
				echo "<div style='cursor:hand' onclick=\"window.external.OA_SMS('".$value['UID']."', '".$value['USER_NAME']."','SEND_MSG');\">".$value['icon'].$value['USER_NAME']."</div>";
}
foreach ( $UN_ONLINE_USER_AYYAY as $key => $value )
{
				echo "<div style='cursor:hand' onclick=\"window.external.OA_SMS('".$value['UID']."', '".$value['USER_NAME']."','SEND_MSG');\">".$value['icon'].$value['USER_NAME']."</div>";
}
echo "</body>\r\n</html>";
?>
