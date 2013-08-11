<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$CSS_ARRAY = array( "/pda/style/main.css" );
$JS_ARRAY = array( );
include_once( "./auth.php" );
include_once( "inc/utility.php" );
$query = "SELECT BANNER_TEXT,WEATHER_CITY from INTERFACE";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$BANNER_TEXT = $ROW['BANNER_TEXT'];
				$WEATHER_CITY = $ROW['WEATHER_CITY'];
}
$BANNER_TEXT = trim( $BANNER_TEXT );
$BANNER_CLASS = $BANNER_TEXT != "" ? "" : "product";
$FONT_SIZE = 16 + ceil( ( 36 - strlen( $BANNER_TEXT ) ) / 2 );
$FONT_SIZE = max( 16, $FONT_SIZE );
$FONT_SIZE = min( 24, $FONT_SIZE );
$BANNER_STYLE = "font-size:".$FONT_SIZE."px;";
if ( strlen( $WEATHER_CITY ) == 5 )
{
				$query = "SELECT WEATHER_CITY from USER where UID='".$LOGIN_UID."'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								if ( strlen( $ROW['WEATHER_CITY'] ) == 5 )
								{
												$WEATHER_CITY = $ROW['WEATHER_CITY'];
								}
								else
								{
												$WEATHER_CITY = "";
								}
				}
}
$MODULE_ARRAY = array( );
if ( find_id( $LOGIN_FUNC_STR, "3" ) )
{
				$MODULE_ARRAY[] = array( "text" => _( "任务提醒" ), "href" => "sms?P=".$P, "image" => "style/images/icon/sms.jpg" );
}
if ( find_id( $LOGIN_FUNC_STR, "1" ) )
{
				$MODULE_ARRAY[] = array( "text" => _( "内部邮件" ), "href" => "email?P=".$P, "image" => "style/images/icon/email.jpg" );
}
if ( find_id( $LOGIN_FUNC_STR, "4" ) )
{
				$MODULE_ARRAY[] = array( "text" => _( "公告通知" ), "href" => "notify?P=".$P, "image" => "style/images/icon/notify.jpg" );
}
if ( find_id( $LOGIN_FUNC_STR, "147" ) )
{
				$MODULE_ARRAY[] = array( "text" => _( "内部新闻" ), "href" => "news?P=".$P, "image" => "style/images/icon/news.jpg" );
}
if ( find_id( $LOGIN_FUNC_STR, "8" ) )
{
				$MODULE_ARRAY[] = array( "text" => _( "今日日程" ), "href" => "calendar?P=".$P, "image" => "style/images/icon/calendar.jpg" );
}
if ( find_id( $LOGIN_FUNC_STR, "9" ) )
{
				$MODULE_ARRAY[] = array( "text" => _( "工作日志" ), "href" => "diary?P=".$P, "image" => "style/images/icon/diary.jpg" );
}
if ( find_id( $LOGIN_FUNC_STR, "16" ) )
{
				$MODULE_ARRAY[] = array( "text" => _( "我的文件" ), "href" => "file_folder?P=".$P, "image" => "style/images/icon/folder.jpg" );
}
if ( find_id( $LOGIN_FUNC_STR, "5" ) )
{
				$MODULE_ARRAY[] = array( "text" => _( "工作流" ), "href" => "workflow?P=".$P, "image" => "style/images/icon/workflow.jpg" );
}
$MODULE_ARRAY[] = array( "text" => _( "人员查询" ), "href" => "user_info?P=".$P, "image" => "style/images/icon/query.jpg" );
if ( find_id( $LOGIN_FUNC_STR, "10" ) )
{
				$MODULE_ARRAY[] = array( "text" => _( "通讯簿" ), "href" => "address?P=".$P, "image" => "style/images/icon/address.jpg" );
}
if ( find_id( $LOGIN_FUNC_STR, "21" ) || find_id( $LOGIN_FUNC_STR, "22" ) )
{
				$MODULE_ARRAY[] = array( "text" => _( "区号邮编" ), "href" => "tel_no?P=".$P, "image" => "style/images/icon/zipcode.jpg" );
}
if ( strlen( $WEATHER_CITY ) == 5 )
{
				$MODULE_ARRAY[] = array( "text" => _( "天气预报" ), "href" => "weather?P=".$P, "image" => "style/images/icon/weather.jpg" );
}
echo "<body>\r\n<div id=\"main_top\" class=\"";
echo $BANNER_CLASS;
echo "\" style=\"";
echo $BANNER_STYLE;
echo "\">";
echo $BANNER_TEXT;
echo "</div>\r\n<div id=\"main\">\r\n<table>\r\n";
$I = 0;
for ( ;	$I < count( $MODULE_ARRAY );	++$I	)
{
				if ( $I % 4 == 0 )
				{
								echo "<tr>\n";
				}
				echo "   <td><a href=\"".$MODULE_ARRAY[$I]['href']."\"><img src=\"".$MODULE_ARRAY[$I]['image']."\" /><div>".$MODULE_ARRAY[$I]['text']."</div></a></td>\n";
				if ( $I % 4 == 3 )
				{
								echo "</tr>\n";
				}
}
if ( 0 < $I % 4 )
{
				$J = 0;
				for ( ;	$J < 4 - $I % 4;	++$J	)
				{
								echo "   <td>&nbsp;</td>\n";
				}
				echo "</tr>\n";
}
echo "</table>\r\n</div>\r\n\r\n</body>\r\n</html>\r\n";
?>
