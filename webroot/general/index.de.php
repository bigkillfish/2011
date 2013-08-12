<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

include_once( "inc/auth.php" );
include_once( "inc/utility_all.php" );
if ( !find_id( $MYOA_FASHION_THEME, $LOGIN_THEME ) )
{
    $query = "SELECT * from INTERFACE";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $IE_TITLE = $ROW['IE_TITLE'];
    }
    echo "<html>\r\n<head>\r\n<title>";
    echo $IE_TITLE;
    echo "</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=";
    echo $MYOA_CHARSET;
    echo "\">\r\n<script type=\"text/javascript\" src=\"/inc/js/utility.js\"></script>\r\n<script type=\"text/javascript\">\r\nself.moveTo(0,0);\r\nself.resizeTo(screen.availWidth,screen.availHeight);\r\nself.focus();\r\n\r\nrelogin=0;\r\nfunction exit()\r\n{\r\n  if(document.body.clientWidth-event.clientX<50||event.altKey||event.ctrlKey)\r\n  {\r\n";
    if ( $ISPIRIT == 1 )
    {
        echo "return;";
    }
    echo "  var req = new_req();\r\n\treq.open(\"GET\", \"relogin.php\", true);\r\n\treq.send('');\r\n  }\r\n}\r\n\r\n</script>\r\n</head>\r\n";
    include_once( "inc/antivirus.txt" );
    echo "<frameset rows=\"50,*,20\"  cols=\"*\" frameborder=\"no\" border=\"0\" framespacing=\"0\" id=\"frame1\" onbeforeunload=\"exit();\">\r\n    <frame name=\"banner\" id=\"banner\" scrolling=\"no\" noresize=\"noresize\" src=\"topbar.php\" frameborder=\"0\">\r\n    <frameset rows=\"*\"  cols=\"250,*\" frameborder=\"no\" border=\"0\" framespacing=\"0\" id=\"frame2\">\r\n       <frame name=\"leftmenu\" id=\"leftmenu\" scrolling=\"no\" noresize=\"noresize\" src=\"ipanel\" frameborder=\"0\">\r\n       <frame name=\"table_index\" id=\"table_index\" scrolling=\"no\" src=\"table.php\" frameborder=\"0\">\r\n    </frameset>\r\n    <frame name=\"status_bar\" id=\"status_bar\" scrolling=\"no\" noresize=\"noresize\" src=\"status_bar\" frameborder=\"0\">\r\n</frameset><noframes></noframes>\r\n</html>\r\n";
    exit( );
}
include_once( "inc/utility_all.php" );
include_once( "inc/td_core.php" );
include_once( "inc/chinese_date.php" );
include_once( "inc/sys_function_all.php" );
ob_end_clean( );
$IS_REGISTERED = tdoa_check_reg( );
if ( !$IS_REGISTERED )
{
    $TRAIL_LEFT = ( strtotime( $TD_TRAIL_EXPIRE ) - strtotime( date( "Y-m-d" ) ) ) / 86400;
    if ( rand( 0, 1000 ) < 50 )
    {
        $result = itask( array( "PARA_1" ) );
        if ( $result !== FALSE )
        {
            $TRAIL_EXPIRE = intval( $result[0] );
            if ( -157680000 < $TRAIL_EXPIRE )
            {
                $TRAIL_LEFT = $TRAIL_EXPIRE / 86400;
            }
        }
    }
    if ( $TRAIL_LEFT <= 0 )
    {
        header( "location: /inc/expired.php" );
    }
}
$SYS_PARA = get_sys_para( "LOG_OUT_TEXT,STATUS_TEXT_MARQUEE,SEC_SHOW_IP" );
while ( list( $KEY, $VALUE ) = each( &$SYS_PARA ) )
{
    $$KEY = $VALUE;
}
$query = "SELECT * from INTERFACE";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $IE_TITLE = $ROW['IE_TITLE'];
    $BANNER_TEXT = $ROW['BANNER_TEXT'];
    $BANNER_FONT = $ROW['BANNER_FONT'];
    $ATTACHMENT_ID = $ROW['ATTACHMENT_ID'];
    $ATTACHMENT_NAME = $ROW['ATTACHMENT_NAME'];
    $IMG_WIDTH = $ROW['IMG_WIDTH'];
    $IMG_HEIGHT = $ROW['IMG_HEIGHT'];
    $WEATHER_CITY = $ROW['WEATHER_CITY'];
    $SHOW_RSS = $ROW['SHOW_RSS'];
    $NOTIFY_TEXT = $ROW['NOTIFY_TEXT'];
    $STATUS_TEXT = $ROW['STATUS_TEXT'];
    if ( strstr( $BANNER_FONT, "?" ) )
    {
        $BANNER_FONT = substr( $BANNER_FONT, 0, strpos( $BANNER_FONT, "?" ) );
    }
    $SHOW_NOTIFY = trim( str_replace( array( "&nbsp;", "&#160;" ), array( "", "" ), strip_tags( $NOTIFY_TEXT ) ) ) != "";
}
$TEXT_ARRAY = explode( "\n", $STATUS_TEXT );
$STATUS_TEXT = "";
$I = 0;
for ( ; $I < count( $TEXT_ARRAY ); ++$I )
{
    $TEXT = trim( $TEXT_ARRAY[$I] );
    if ( !( $TEXT == "" ) )
    {
        $STATUS_TEXT .= htmlspecialchars( $TEXT )."<br>";
    }
}
if ( $STATUS_TEXT == "" )
{
    $STATUS_TEXT = "&nbsp;";
}
$STATUS_TEXT_MARQUEE = 0 < intval( $STATUS_TEXT_MARQUEE ) ? intval( $STATUS_TEXT_MARQUEE ) : 60;
if ( $LOG_OUT_TEXT == "" )
{
    $LOG_OUT_TEXT = sprintf( _( "您正在使用%s%s 网络智能办公系统%s" ), "\n", $TD_MYOA_PRODUCT_NAME, "\n\n" );
}
$LOG_OUT_TEXT = str_replace( array( "\n", "\r", "\"" ), array( "\\n", "", "\\\"" ), $LOG_OUT_TEXT );
$query = "SELECT UNIT_NAME from UNIT";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $UNIT_NAME = $ROW['UNIT_NAME'];
}
if ( $UNIT_NAME == "" )
{
    $UNIT_NAME = "&nbsp;";
}
$SHOW_IP = $SEC_SHOW_IP == "2" || $LOGIN_USER_PRIV == 1;
$query = "SELECT * from USER where UID='".$LOGIN_UID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $DEPT_ID = $ROW['DEPT_ID'];
    $USER_PRIV = $ROW['USER_PRIV'];
    $SEX = $ROW['SEX'];
    $BKGROUND = $ROW['BKGROUND'];
    $ON_STATUS = $ROW['ON_STATUS'];
    $SHORTCUT = $ROW['SHORTCUT'];
    $PORTAL_ID_STR = $ROW['PORTAL'];
    $MENU_IMAGE = $ROW['MENU_IMAGE'];
    $MENU_EXPAND = $ROW['MENU_EXPAND'];
    $SHOW_RSS_USER = $ROW['SHOW_RSS'];
    $SMS_ON = $ROW['SMS_ON'];
    $CALL_SOUND = $ROW['CALL_SOUND'];
    if ( strlen( $WEATHER_CITY ) == 5 && strlen( $ROW['WEATHER_CITY'] ) == 5 )
    {
        $WEATHER_CITY = $ROW['WEATHER_CITY'];
    }
    else
    {
        $WEATHER_CITY = "";
    }
    if ( $MENU_IMAGE == "" )
    {
        $MENU_IMAGE = "0";
    }
    $USER_TITLE = _( "部门：" ).dept_long_name( $DEPT_ID )."\n"._( "角色：" ).td_trim( getprivnamebyid( $USER_PRIV ) );
    $PORTAL_ID_STR = $PORTAL_ID_STR == "" ? "5" : $PORTAL_ID_STR;
}
$SEX = $SEX != "0" && $SEX != "1" ? "1" : $SEX;
$ON_STATUS = $ON_STATUS < 1 || 4 < $ON_STATUS ? "0" : $ON_STATUS;
if ( $ON_STATUS_SET != "" && $ON_STATUS_SET != $ON_STATUS )
{
    $query = "update USER set ON_STATUS='".$ON_STATUS_SET."' where USER_ID='{$LOGIN_USER_ID}'";
    exequery( $connection, $query );
    $ON_STATUS = $ON_STATUS_SET;
}
if ( $CALL_SOUND == "" )
{
    $CALL_SOUND = "1";
}
$SOUND_URL = "/wav/1.swf";
if ( $CALL_SOUND != "0" )
{
    if ( $CALL_SOUND == "-1" )
    {
        include_once( "inc/utility_file.php" );
        $URL_ARRAY = attach_url_old( "swf", $LOGIN_UID.".swf" );
        $SOUND_URL = $URL_ARRAY['view'];
    }
    else
    {
        $SOUND_URL = "/wav/".$CALL_SOUND.".swf";
    }
}
$NEW_SMS_HTML = "<div onclick='show_sms();' title='"._( "点击查看新消息" )."'><img src='/images/sms1.gif' border='0' height='12'> "._( "新消息" )."</div>";
if ( $CALL_SOUND != "0" )
{
    $NEW_SMS_SOUND_HTML = "<object id='sms_sound' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='/inc/swflash.cab' width='0' height='0'><param name='movie' value='".$SOUND_URL."'><param name=quality value=high><embed id='sms_sound' src='{$SOUND_URL}' width='0' height='0' quality='autohigh' wmode='opaque' type='application/x-shockwave-flash' plugspace='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></embed></object>";
}
else
{
    $NEW_SMS_SOUND_HTML = "";
}
$USER_FUNC_ID_STR = $LOGIN_FUNC_STR;
if ( $LOGIN_USER_ID == "admin" )
{
    $USER_FUNC_ID_STR .= "32,33,56,";
}
$SHORTCUT = td_trim( $SHORTCUT );
if ( $SHORTCUT == "" )
{
    $SHORTCUT = "1,4,147,8,130,5,131,9,16,15,76,62";
}
$SHORTCUT = check_id( $USER_FUNC_ID_STR, $SHORTCUT, TRUE );
$SHORTCUT = td_trim( $SHORTCUT );
if ( $SHORTCUT != "" && !strstr( $SHORTCUT, "," ) )
{
    $SHORTCUT .= ",-1";
}
$LOGO_TEXT = "";
if ( $ATTACHMENT_ID == "" && $ATTACHMENT_NAME == "" && $BANNER_TEXT == "" )
{
    if ( file_exists( $ROOT_PATH.( "theme/".$LOGIN_THEME."/product.png" ) ) )
    {
        $LOGO_TEXT .= "<img src=\"/theme/".$LOGIN_THEME."/product.png\" align=\"absmiddle\">";
    }
    else
    {
        $LOGO_TEXT .= "<span id=\"banner_text\" style=\"".$BANNER_FONT."\">&nbsp;".$TD_MYOA_PRODUCT_NAME."</span>";
    }
}
else
{
    if ( $ATTACHMENT_ID != "" && $ATTACHMENT_NAME != "" )
    {
        include_once( "inc/utility_file.php" );
        $URL_ARRAY = attach_url_old( $ATTACHMENT_ID, $ATTACHMENT_NAME );
        $LOGO_TEXT .= "<img src=\"".$URL_ARRAY['view']."\" width=\"".$IMG_WIDTH."\" height=\"".$IMG_HEIGHT."\" align=\"absmiddle\">";
    }
    if ( $BANNER_TEXT != "" )
    {
        $LOGO_TEXT .= "<span id=\"banner_text\" style=\"".$BANNER_FONT."\">&nbsp;".htmlspecialchars( $BANNER_TEXT )."</span>";
    }
}
list( $CUR_YEAR, $CUR_MON, $CUR_DAY, $CUR_HOUR, $CUR_MINITE, $CUR_SECOND ) = datetimeex( hexdec( dechex( time( ) + 1 ) ) );
$CUR_DATETIME = "{$CUR_YEAR},{$CUR_MON},{$CUR_DAY},{$CUR_HOUR},{$CUR_MINITE},{$CUR_SECOND}";
$CUR_DATE = $CUR_YEAR."-".$CUR_MON."-".$CUR_DAY;
$DATETIME = "<div id=\"time_area\"></div>";
$DATETIME .= "<div id=\"date\" title=\"".format_date( $CUR_DATE )."\">";
if ( is_holiday( $CUR_DATE ) )
{
    $DATETIME .= is_holiday( $CUR_DATE );
}
else
{
    $DATETIME .= date( _( "n月j日" ) );
}
$DATETIME .= get_week( $CUR_DATE )."";
$DATETIME .= "</div>";
$mdate = chinese_date( $CUR_YEAR, $CUR_MON, $CUR_DAY );
$DATETIME .= sprintf( " <div id=\"mdate\" title=\"%s %s\">", _( "农历" ), $mdate );
if ( is_festival( $mdate ) )
{
    $DATETIME .= is_festival( $mdate );
}
else
{
    $DATETIME .= _( "农历" ).$mdate;
}
$DATETIME .= "</div>";
$PARA_ARRAY = get_sys_para( "MENU_DISPLAY,MENU_EXPAND_SINGLE" );
while ( list( $PARA_NAME, $PARA_VALUE ) = each( &$PARA_ARRAY ) )
{
    $$PARA_NAME = $PARA_VALUE;
}
$MENU_ARRAY = array( );
$FUNC_ARRAY = array( );
$SUB_FUNC_ARRAY = array( );
$SYS_FUNCTION = array_values( $SYS_FUNCTION );
$FUNC_COUNT = count( $SYS_FUNCTION );
$I = 0;
for ( ; $I < $FUNC_COUNT; ++$I )
{
    $FUNC_ID = $SYS_FUNCTION[$I]['FUNC_ID'];
    $MENU_ID = $SYS_FUNCTION[$I]['MENU_ID'];
    $FUNC_CODE = $SYS_FUNCTION[$I]['FUNC_CODE'];
    if ( $FUNC_ID != "" && !find_id( $USER_FUNC_ID_STR, $FUNC_ID ) )
    {
    }
    else if ( $FUNC_ID == "" && strlen( $MENU_ID ) == 2 )
    {
        $MENU_ARRAY[$MENU_ID] = $SYS_FUNCTION[$I];
    }
    else if ( strlen( $MENU_ID ) == 4 )
    {
        $FUNC_ARRAY[$FUNC_ID] = $SYS_FUNCTION[$I];
    }
    else if ( strlen( $MENU_ID ) == 6 )
    {
        $PARENT_ID = 0;
        $J = $I;
        for ( ; 0 <= $J; --$J )
        {
            if ( !( $SYS_FUNCTION[$J]['MENU_ID'] == substr( $MENU_ID, 0, 4 ) ) )
            {
                continue;
            }
            $PARENT_ID = $SYS_FUNCTION[$J]['FUNC_ID'];
            break;
        }
        $SUB_FUNC_ARRAY[$PARENT_ID][$FUNC_ID] = $SYS_FUNCTION[$I];
    }
}
$NEW_FUNC_ARRAY = array( );
foreach ( $FUNC_ARRAY as $FUNC_ITEM )
{
    $FUNC_ID = $FUNC_ITEM['FUNC_ID'];
    $MENU_ID = $FUNC_ITEM['MENU_ID'];
    $FUNC_CODE = $FUNC_ITEM['FUNC_CODE'];
    if ( substr( $FUNC_CODE, 0, 1 ) == "@" && count( $SUB_FUNC_ARRAY[$FUNC_ID] ) <= 0 )
    {
        $NEW_FUNC_ARRAY[substr( $MENU_ID, 0, 2 )][$FUNC_ID] = $FUNC_ITEM;
    }
}
$FUNC_ARRAY = $NEW_FUNC_ARRAY;
$MENU_JS_STR = "";
foreach ( $MENU_ARRAY as $MENU_ITEM )
{
    $MENU_ID = $MENU_ITEM['MENU_ID'];
    if ( !( count( $FUNC_ARRAY[$MENU_ID] ) <= 0 ) )
    {
        $MENU_JS_STR .= "\"".$MENU_ID."\",";
    }
}
$FUNC_JS_STR = "";
foreach ( $FUNC_ARRAY as $MENU_ID => $ITEM_ARRAY )
{
    $JS_STR = "";
    foreach ( $ITEM_ARRAY as $FUNC_ITEM )
    {
        $FUNC_ID = $FUNC_ITEM['FUNC_ID'];
        $JS_STR .= "\"".$FUNC_ID."\",";
    }
    $FUNC_JS_STR .= "second_array[\"m".$MENU_ID."\"] = [".td_trim( $JS_STR )."];\n";
}
$SUB_FUNC_JS_STR = "";
foreach ( $SUB_FUNC_ARRAY as $PARENT_ID => $ITEM_ARRAY )
{
    $JS_STR = "";
    foreach ( $ITEM_ARRAY as $FUNC_ITEM )
    {
        $FUNC_ID = $FUNC_ITEM['FUNC_ID'];
        $JS_STR .= "\"".$FUNC_ID."\",";
    }
    $SUB_FUNC_JS_STR .= "third_array[\"f".$PARENT_ID."\"] = [".td_trim( $JS_STR )."];\n";
}
$THEME_JS_STR = "";
$THEME_ARRAY = array( );
$THEME_ARRAY = array_filter( explode( ",", $MYOA_FASHION_THEME ) );
$_tmp_theme_name = "";
foreach ( $THEME_ARRAY as $v )
{
    $_tmp_theme_name = @file_get_contents( $ROOT_PATH."/theme/".$v."/theme.ini" );
    $SPLITER = _( "：" );
    $pos = strpos( $_tmp_theme_name, $SPLITER );
    if ( $pos !== FALSE )
    {
        $_tmp_theme_name = substr( $_tmp_theme_name, $pos + strlen( $SPLITER ) );
    }
    $THEME_JS_STR .= "themeArray[\"".$v."\"] = {src:\"/images/themeswitch/theme_thumb_".$v.".jpg\", title:\"".$_tmp_theme_name."\"};\n";
}
$PORTAL_LOAD_ARRAY = "";
$PORTAL_JS_STR = "";
$query = "SELECT * from PORTAL where DISABLED='0' order by ORDER_NO";
$cursor = exequery( $connection, $query );
$OFFSET = floor( ( 7 - mysql_num_rows( $cursor ) ) / 2 );
$COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) )
{
    $PORTAL_ID = $ROW['PORTAL_ID'];
    $PORTAL_NAME = $ROW['PORTAL_NAME'];
    $PORTAL_URL = $ROW['PORTAL_URL'];
    $PORTAL_IMG = $ROW['PORTAL_IMG'];
    $CLOSABLE = $ROW['CLOSABLE'];
    if ( find_id( $PORTAL_ID_STR, $PORTAL_ID ) )
    {
        $PORTAL_LOAD_ARRAY[$PORTAL_ID] = $COUNT + $OFFSET;
    }
    $PORTAL_IMG = substr( $PORTAL_IMG, 0, strrpos( $PORTAL_IMG, "." ) ).( $MYOA_IS_UN && find_id( "zh-TW,en,", $LANG_COOKIE ) ? "_".$LANG_COOKIE : "" ).substr( $PORTAL_IMG, strrpos( $PORTAL_IMG, "." ) );
    $PORTAL_JS_STR .= "portalArray[\"".( $COUNT + $OFFSET )."\"] = {src:\"".$PORTAL_IMG."\", url:\"".$PORTAL_URL."\", title:\"".$PORTAL_NAME."\", closable:\"".( $CLOSABLE == "1" ? "true" : "false" )."\"};\n";
    ++$COUNT;
}
$PORTAL_ID_ARRAY = explode( ",", $PORTAL_ID_STR );
$PORTAL_ID_STR = "";
foreach ( $PORTAL_ID_ARRAY as $PORTAL_ID )
{
    if ( !( td_trim( $PORTAL_LOAD_ARRAY[$PORTAL_ID] ) == "" ) )
    {
        $PORTAL_ID_STR .= "\"".$PORTAL_LOAD_ARRAY[$PORTAL_ID]."\",";
    }
}
$USER_TOTAL_COUNT = 1;
$query = "SELECT count(*) from USER where NOT_LOGIN='0'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $USER_TOTAL_COUNT = $ROW[0];
}
$USER_COUNT = 0;
$query = "select count(*) from USER_ONLINE";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $USER_COUNT = $ROW[0];
}
$USER_COUNT = max( 1, $USER_COUNT );
$PARA_URL1 = "";
$PARA_URL2 = "ipanel/user/user_info.php";
$PARA_TARGET = "_blank";
$PARA_ID = "WINDOW";
$PARA_VALUE = "1";
$PRIV_NO_FLAG = "0";
$MANAGE_FLAG = "0";
$xname = "ipanel_user_all";
$showButton = "0";
$OP_SMS = "1";
$MODULE_ID = 2;
$NOT_OUTPUT_TREE = 1;
include_once( "inc/user_list/index.php" );
$JSON_URL0 = "/inc/online.php?PARA_URL2=".$PARA_URL2."&PARA_TARGET={$PARA_TARGET}&PARA_ID={$PARA_ID}&PARA_VALUE={$PARA_VALUE}&SHOW_IP={$SHOW_IP}&PWD={$PWD}&OP_SMS={$OP_SMS}";
$JSON_URL1 = $xtree;
echo "<html>\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=";
echo $MYOA_CHARSET;
echo "\" />\r\n<title>";
echo htmlspecialchars( $IE_TITLE );
echo "</title>\r\n   <link rel=\"stylesheet\" type=\"text/css\" href=\"/theme/";
echo $LOGIN_THEME;
echo "/index.css\" />\r\n";
if ( $MYOA_IS_UN && find_id( "zh-TW,en,", $LANG_COOKIE ) && find_id( $MYOA_FASHION_THEME, $LOGIN_THEME ) )
{
    echo "   <link rel=\"stylesheet\" type=\"text/css\" href=\"/theme/";
    echo $LOGIN_THEME;
    echo "/un_";
    echo $LANG_COOKIE;
    echo ".css\" />\r\n";
}
echo "   <link rel=\"stylesheet\" type=\"text/css\" href=\"/theme/";
echo $LOGIN_THEME;
echo "/tree.css\" />\r\n   <link rel=\"stylesheet\" type=\"text/css\" href=\"/images/org/ui.dynatree.css\" />\r\n   <script type=\"text/javascript\" src=\"/inc/js/jquery/jquery.min.js\"></script>\r\n   <script type=\"text/javascript\" src=\"/inc/js/jquery/jquery-ui.custom.min.js\"></script>\r\n   <script type=\"text/javascript\" src=\"/inc/js/jquery/jquery.ui.autocomplete.min.js\"></script>\r\n   <script type=\"text/javascript\" src=\"/inc/js/jquery/jquery.effects.bounce.min.js\"></script>\r\n   <script type=\"text/javascript\" src=\"/inc/js/jquery/jquery.cookie.js\"></script>\r\n   <script type=\"text/javascript\" src=\"/inc/js/jquery/jquery.plugins.js\"></script>\r\n   <script type=\"text/javascript\" src=\"/inc/js_lang.php\"></script>\r\n   <script type=\"text/javascript\" src=\"/inc/sys_function_";
echo bin2hex( $LANG_COOKIE );
echo ".js\"></script>\r\n   <script type=\"text/javascript\" src=\"/inc/js/utility.js\"></script>\r\n   <script type=\"text/javascript\" src=\"/inc/js/index.js\"></script>\r\n   <script type=\"text/javascript\" src=\"/inc/js/sterm.js\"></script>\r\n   <script type=\"text/javascript\" src=\"/inc/js/weather.js\"></script>\r\n   <script type=\"text/javascript\" src=\"/inc/js/tree.js\"></script>\r\n</head>\r\n<script type=\"text/javascript\">\r\nself.moveTo(0,0);\r\nself.resizeTo(screen.availWidth,screen.availHeight);\r\nself.focus();\r\n\r\nvar bEmailPriv = ";
echo find_id( $LOGIN_FUNC_STR, "1" ) ? "true" : "false";
echo ";\r\nvar bSmsPriv   = ";
echo find_id( $LOGIN_FUNC_STR, "3" ) ? "true" : "false";
echo ";\r\nvar bTabStyle = true;\r\nvar OA_TIME = new Date(";
echo $CUR_DATETIME;
echo ");\r\nvar bInitWeather = ";
echo strlen( $WEATHER_CITY ) == 5 ? "true" : "false";
echo ";\r\nvar weatherCity = \"";
echo $WEATHER_CITY;
echo "\";\r\nvar menuExpand = \"";
echo $MENU_EXPAND;
echo "\";\r\nvar shortcutArray = Array(";
echo $SHORTCUT;
echo ");\r\nvar loginUser = {uid:";
echo $LOGIN_UID;
echo ", user_id:\"";
echo str_replace( "\"", "\\\"", $LOGIN_USER_ID );
echo "\", user_name:\"";
echo str_replace( "\"", "\\\"", $LOGIN_USER_NAME );
echo "\"};\r\nvar logoutText = \"";
echo $LOG_OUT_TEXT;
echo "\";\r\nvar monInterval = {online:";
echo $ONLINE_REF_SEC;
echo ",sms:";
echo $SMS_REF_SEC;
echo "};\r\nvar ispirit = \"";
echo $ISPIRIT;
echo "\";\r\nvar statusTextScroll = ";
echo $STATUS_TEXT_MARQUEE;
echo ";\r\nvar newSmsHtml = \"";
echo $NEW_SMS_HTML;
echo "\";\r\nvar newSmsSoundHtml = \"";
echo $NEW_SMS_SOUND_HTML;
echo "\";\r\nvar show_ip = ";
echo $SHOW_IP ? "1" : "0";
echo ";\r\nvar unit_name = '";
echo str_replace( "'", "\\'", $UNIT_NAME );
echo "';\r\nvar orgTree0 = orgTree1 = null;\r\nvar jsonURL0 = '";
echo $JSON_URL0;
echo "';\r\nvar jsonURL1 = '";
echo $JSON_URL1;
echo "';\r\nvar user_total_count = \"";
echo $USER_TOTAL_COUNT;
echo "\";\r\nvar portalArray = [];\r\n";
echo $PORTAL_JS_STR;
echo "\r\nvar themeArray = [];\r\n";
echo $THEME_JS_STR;
echo "\r\nvar portalLoadArray = [";
echo td_trim( $PORTAL_ID_STR );
echo "];\r\n\r\n//-- 一级菜单 --\r\nvar first_array = [";
echo td_trim( $MENU_JS_STR );
echo "];\r\n\r\n//-- 二级菜单 --\r\nvar second_array = [];\r\n";
echo $FUNC_JS_STR;
echo "\r\n//-- 三级菜单 --\r\nvar third_array = [];\r\n";
echo $SUB_FUNC_JS_STR;
echo "\r\n//-- 当前系统主题\r\nvar ostheme = ";
echo $LOGIN_THEME;
echo ";\r\n</script>\r\n<body>\r\n   <div id=\"loading\" class=\"loading\" style=\"width:100%;height:100%;margin-top:100px;padding-top:100px;text-align:center;color:#1547b8;font-size:32px;font-family:";
echo _( "微软雅黑,宋体" );
echo ";\"></div>\r\n   <div id=\"north\">\r\n      <div id=\"north_left\">\r\n         <table><tr><td>";
echo $LOGO_TEXT;
echo "</td></tr></table>\r\n      </div>\r\n      <div id=\"north_right\">\r\n         <div id=\"datetime\">";
echo $DATETIME;
echo "</div>\r\n         <div id=\"weather\"></div>\r\n         <!-- 天气预报 -->\r\n         <div id=\"area_select\">\r\n           <div>\r\n              <select id=\"province\" onChange=\"Province_onchange(this.options.selectedIndex);\">\r\n                <option value=\"";
echo _( "选择省" );
echo "\">";
echo _( "选择省" );
echo "</option>\r\n              </select>\r\n           </div>\r\n           <div>\r\n              <select id=\"chinacity\">\r\n                <option value=\"";
echo _( "选择城市" );
echo "\">";
echo _( "选择城市" );
echo "</option>\r\n              </select>\r\n           </div>\r\n           <div>\r\n              <input type=\"button\" value=\"";
echo _( "确定" );
echo "\" class=\"SmallButton\" onClick=\"GetWeather('1');\">\r\n              <input type=\"button\" value=\"";
echo _( "取消" );
echo "\" class=\"SmallButton\" onClick=\"\$('area_select').style.display='none';\$('weather').style.display='block';\">\r\n           </div>\r\n         </div>\r\n      </div>\r\n   </div>\r\n   <div id=\"taskbar\">\r\n      <div id=\"taskbar_left\">\r\n         <a href=\"javascript:;\" id=\"start_menu\" hidefocus=\"hidefocus\"></a>\r\n      </div>\r\n      <div id=\"taskbar_center\">\r\n         <div id=\"tabs_left_scroll\"></div>\r\n         <div id=\"tabs_container\"></div>\r\n         <div id=\"tabs_right_scroll\"></div>\r\n      </div>\r\n      <div id=\"taskbar_right\">\r\n         <a id=\"portal\" href=\"javascript:;\" hidefocus=\"hidefocus\" title=\"";
echo _( "门户切换" );
echo "\"></a>\r\n         <a id=\"person_info\" href=\"javascript:;\" hidefocus=\"hidefocus\" title=\"";
echo _( "控制面板" );
echo "\"></a>\r\n         <a id=\"theme\" href=\"javascript:;\" hidefocus=\"hidefocus\" title=\"";
echo _( "更换皮肤" );
echo "\"></a>\r\n         <a id=\"logout\" href=\"###\" hidefocus=\"hidefocus\" title=\"";
echo _( "注销登录" );
echo "\"></a>\r\n         <a id=\"hide_topbar\" href=\"javascript:;\" hidefocus=\"hidefocus\" title=\"";
echo _( "隐藏顶部" );
echo "\"></a>\r\n";
if ( !$IS_REGISTERED )
{
    echo "         <a id=\"reg\" href=\"javascript:;\" onClick=\"openURL('reg', '";
    echo _( "软件注册" );
    echo "', '/inc/reg.php?TAB=1');\">";
    echo _( "软件注册" );
    echo "</a>\r\n";
}
echo "      </div>\r\n   </div>\r\n   <div id=\"funcbar\">\r\n      <div id=\"funcbar_left\"></div>\r\n      <div id=\"funcbar_right\">\r\n         <div class=\"search\">\r\n            <div class=\"search-body\">\r\n               <div class=\"search-input\"><input id=\"keyword\" type=\"text\" value=\"\"></div>\r\n               <div id=\"search_clear\" class=\"search-clear\" style=\"display:none;\" onClick=\"document.getElementById('keyword').value = '';this.style.display = 'none';\"></div>\r\n            </div>\r\n         </div>\r\n      </div>\r\n   </div>\r\n   <div id=\"center\">\r\n      <!-- 门户切换 -->\r\n      <div id=\"portal_panel\" class=\"over-mask-layer\">\r\n         <div class=\"icon\"></div>\r\n         <div class=\"left\"></div>\r\n         <div class=\"center\" id=\"portal_slider\"></div>\r\n         <div class=\"right\"></div>\r\n         <div class=\"close\">\r\n            <a class=\"btn-black-a\" href=\"javascript:;\" onClick=\"openURL(40, '";
echo _( "门户设置" );
echo "', 'person_info/?MAIN_URL=portal');\" hidefocus=\"hidefocus\">";
echo _( "设置" );
echo "</a>\r\n            <a class=\"btn-black-a\" href=\"javascript:;\" onClick=\"jQuery('#portal').click();\" hidefocus=\"hidefocus\">";
echo _( "关闭" );
echo "</a>\r\n         </div>\r\n      </div>\r\n      \r\n      <!-- 主题切换 -->\r\n      <div id=\"theme_panel\" class=\"over-mask-layer\">\r\n         <div class=\"icon\"></div>\r\n         <div class=\"center\" id=\"theme_slider\"></div>\r\n         <div class=\"close\">\r\n            <a class=\"btn-black-a\" href=\"javascript:;\" onClick=\"jQuery('#theme').click();\" hidefocus=\"hidefocus\">";
echo _( "关闭" );
echo "</a>\r\n         </div>\r\n         <div class=\"bottom\"></div>\r\n      </div>\r\n      \r\n      <div id=\"overlay_panel\"></div>\r\n   </div>\r\n   <div id=\"south\">\r\n      <table>\r\n         <tr>\r\n            <td class=\"left\"><div id=\"online_link\" onClick=\"ViewOnlineUser()\" title=\"";
echo sprintf( _( "共 %s 人，%s 人在线" ), $USER_TOTAL_COUNT, $USER_COUNT );
echo "\">";
echo sprintf( _( "在线%s人" ), "<span id=\"user_count\">".$USER_COUNT."</span>" );
echo "</div></td>\r\n            <td class=\"left\"><div id=\"new_sms\"></div><span id=\"new_sms_sound\" style=\"width:1px;height:1px;\"></span></td>\r\n            <td class=\"center\">\r\n            \t<div id=\"status_text\">";
echo $STATUS_TEXT;
echo "</div>\r\n            </td>        \r\n";
if ( !$IS_REGISTERED )
{
    echo "            <td class=\"reg\" onClick=\"";
    if ( $LOGIN_USER_PRIV == "1" )
    {
        echo "openURL('reg', '"._( "软件注册" )."', '/inc/reg.php?TAB=1');";
    }
    echo "\">";
    echo sprintf( _( "软件注册前可运行 %s 天" ), "<span class=\"days\">".$TRAIL_LEFT."</span>" );
    echo "</td>\r\n";
}
else if ( tdoa_sn_version( ) == "X" )
{
    $DAYS_LEFT = tdoa_check_experience( );
    if ( $DAYS_LEFT <= 30 )
    {
        echo "            <td class=\"reg\">";
        echo sprintf( _( "体验版将于 %s 天后到期" ), "<span class=\"days\">".$DAYS_LEFT."</span>" );
        echo "</td>\r\n";
    }
}
echo "<script language=\"javascript\">\r\nfunction show_feedback()\r\n{\r\n   mytop=(screen.availHeight-430)/2;\r\n   myleft=(screen.availWidth-600)/2;\r\n   window.open(\"/module/feedback/\",\"\",\"height=450,width=600,status=0,toolbar=no,menubar=no,location=no,scrollbars=yes,top=\"+mytop+\",left=\"+myleft+\",resizable=yes\");\r\n}\r\n</script>\r\n            <td style=\"cursor:hand;\" class=\"right\">\r\n";
if ( $LOGIN_USER_PRIV == 1 )
{
    echo "            \t<div onClick=\"show_feedback()\" title=\"";
    echo _( "将问题提交给开发商进行解决" );
    echo "\">";
    echo _( "问题反馈" );
    echo "</div>\r\n";
}
echo "            </td>\r\n            <td class=\"right\">\r\n            \t<a id=\"nocbox\" class=\"ipanel_tab\" href=\"javascript:;\" panel=\"noc_panel\" title=\"";
echo _( "事务提醒" );
echo "\" hidefocus=\"hidefocus\"></a>\r\n               <a id=\"smsbox\" class=\"ipanel_tab\" href=\"javascript:;\" panel=\"smsbox_panel\" title=\"";
echo _( "微讯盒子" );
echo "\" hidefocus=\"hidefocus\"></a>\r\n";
if ( !$LOGIN_NOT_VIEW_USER )
{
    echo "\t\t\t\t\t\r\n               <a id=\"org\" class=\"ipanel_tab\" href=\"javascript:;\" panel=\"org_panel\" title=\"";
    echo _( "组织" );
    echo "\" hidefocus=\"hidefocus\"></a>\r\n";
}
echo "            </td>\r\n         </tr>\r\n      </table>\r\n   </div>\r\n   \r\n   <!-- 导航菜单 -->\r\n   <div id=\"start_menu_panel\">\r\n      <div class=\"panel-head\"></div>\r\n      <!-- 登录用户信息 -->\r\n      <div class=\"panel-user\">\r\n         <div class=\"avatar\">\r\n            <img src=\"";
echo avatar_path( $LOGIN_AVATAR );
echo "\" align=\"absmiddle\" />\r\n            <div class=\"status_icon status_icon_";
echo $ON_STATUS;
echo "\"></div>\r\n            <div id=\"on_status\">\r\n               <a href=\"javascript:;\" status=\"1\" class=\"on_status_1\" hidefocus=\"hidefocus\">";
echo _( "在线" );
echo "</a>\r\n               <a href=\"javascript:;\" status=\"2\" class=\"on_status_2\" hidefocus=\"hidefocus\">";
echo _( "忙碌" );
echo "</a>\r\n               <a href=\"javascript:;\" status=\"3\" class=\"on_status_3\" hidefocus=\"hidefocus\">";
echo _( "离开" );
echo "</a>\r\n            </div>\r\n         </div>\r\n         <div class=\"name\" title=\"";
echo $USER_TITLE;
echo "\">";
echo htmlspecialchars( $LOGIN_USER_NAME );
echo "</div>\r\n         <div class=\"tools\">\r\n            <a class=\"logout\" href=\"###\" onClick=\"logout();\" hidefocus=\"hidefocus\" title=\"";
echo _( "注销" );
echo "\"></a>\r\n            <a class=\"exit\" href=\"###\" onClick=\"exit();\" hidefocus=\"hidefocus\" title=\"";
echo _( "退出" );
echo "\"></a>\r\n         </div>\r\n      </div>\r\n      <div class=\"panel-menu\">\r\n         <!-- 一级菜单 -->\r\n         <div id=\"first_panel\">\r\n            <div class=\"scroll-up\"></div>\r\n            <ul id=\"first_menu\"></ul>\r\n            <div class=\"scroll-down\"></div>\r\n         </div>\r\n         <!-- 二级级菜单 -->\r\n         <div id=\"second_panel\">\r\n            <div class=\"second-panel-head\"></div>\r\n            <div class=\"second-panel-menu\"><ul id=\"second_menu\"></ul></div>\r\n            <div class=\"second-panel-foot\"></div>\r\n         </div>\r\n      </div>\r\n      <div class=\"panel-foot\"></div>\r\n   </div>\r\n   <div id=\"overlay_startmenu\"></div>\r\n\r\n   <!-- 事务提醒 -->\r\n   <div id=\"new_sms_mask\"></div>\r\n   <div id=\"new_sms_panel\">\r\n      <div class=\"button\">\r\n         <a class=\"btn-white-big\" href=\"javascript:;\" onClick=\"ViewNewSms();\" hidefocus=\"hidefocus\">";
echo _( "打开" );
echo "</a>&nbsp;&nbsp;\r\n         <a class=\"btn-white-big\" href=\"javascript:;\" onClick=\"CloseRemind();\" hidefocus=\"hidefocus\">";
echo _( "关闭" );
echo "</a>\r\n      </div>\r\n   </div>\r\n   \r\n   <!-- 事务提醒 -->\r\n   <div id=\"new_noc_panel\">\r\n   \t<div id=\"new_noc_title\">\r\n   \t\t\t<span class=\"noc_iterm_num\">";
echo sprintf( _( "共%s条提醒" ), "&nbsp;<span></span>&nbsp;" );
echo "</span>\r\n   \t\t\t<span class=\"noc_iterm_close\"></span>\r\n            <span class=\"noc_iterm_history\"><a id=\"check_remind_histroy\" href=\"javascript:;\" hidefocus=\"hidefocus\">";
echo _( "查看历史记录" );
echo "</a></span>\r\n   \t</div> \r\n   \t<div id=\"nocbox_tips\"></div>\r\n   \t<div id=\"new_noc_list\"></div>\r\n   \t<div class=\"button\">\r\n         <a id=\"ViewAllNoc\" class=\"btn-white-big\" href=\"javascript:;\" hidefocus=\"hidefocus\">";
echo _( "全部已阅" );
echo "</a>\r\n         <a id=\"ViewDetail\" class=\"btn-white-big\" href=\"javascript:;\" hidefocus=\"hidefocus\">";
echo _( "全部详情" );
echo "</a>\r\n         <a id=\"CloseBtn\" class=\"btn-white-big\" href=\"javascript:;\" hidefocus=\"hidefocus\">";
echo _( "关闭" );
echo "</a>\r\n      </div>\t\t\t\t\t\r\n   </div>\r\n   \r\n   <!-- 短信箱 -->\r\n   <div id=\"smsbox_panel\" class=\"dialog\" >\r\n      <div class=\"head\">\r\n         <div class=\"head-left\"></div>\r\n         <div class=\"head-center\">\r\n            <div class=\"head-title\">";
echo _( "微讯盒子" );
echo "</div>\r\n            <div class=\"head-close\"></div>\r\n         </div>\r\n         <div class=\"head-right\"></div>\r\n      </div>\r\n      <div class=\"center\">\r\n";
if ( find_id( $USER_FUNC_ID_STR, "3" ) )
{
    echo "         <div class=\"center-left\">\r\n            <div id=\"smsbox_op_all\">\r\n               <a href=\"javascript:;\" id=\"smsbox_read_all\" hidefocus=\"hidefocus\">";
    echo _( "全部已阅" );
    echo "</a>\r\n            </div>\r\n            <div id=\"smsbox_scroll_up\"></div>\r\n            <div id=\"smsbox_list\">\r\n               <div id=\"smsbox_list_container\" class=\"list-container\"></div>\r\n            </div>\r\n            <div id=\"smsbox_scroll_down\"></div>\r\n         </div>\r\n         <div class=\"center-right\">\r\n            <div class=\"center-toolbar\">\r\n               <a href=\"javascript:;\" id=\"smsbox_toolbar_read\" hidefocus=\"hidefocus\" title=\"";
    echo _( "已阅以下微讯" );
    echo "\">";
    echo _( "已阅" );
    echo "</a>\r\n               <a href=\"javascript:;\" id=\"smsbox_toolbar_delete\" hidefocus=\"hidefocus\" title=\"";
    echo _( "删除以下微讯" );
    echo "\">";
    echo _( "删除" );
    echo "</a>\r\n            </div>\r\n            <div id=\"smsbox_msg_container\" class=\"center-chat\"></div>\r\n            <div class=\"rapid-reply\">\r\n            \t <select id=\"smsbox_rapid_reply\" class=\"SmallInput\" title=\"";
    echo _( "请到系统管理->系统代码->微讯快捷回复 进行设置" );
    echo "\">\r\n            \t \t<option value=\"\">";
    echo _( "快捷回复" );
    echo "</option>\r\n            \t \t";
    echo code_list( "SMS_QUICK_REPLY", "{$QUECK_TYPE}" );
    echo "            \t </select>\r\n            </div>\r\n            <div class=\"center-reply\">\r\n               <textarea id=\"smsbox_textarea\"></textarea>\r\n               <a id=\"smsbox_send_msg\" href=\"javascript:;\" hidefocus=\"hidefocus\">";
    echo _( "发送" );
    echo "</a>\r\n            </div>\r\n         </div>\r\n         <div id=\"smsbox_tips\" class=\"center-tips\"></div>\r\n         <div id=\"no_sms\">\r\n            <div class=\"no-msg\" title=\"";
    echo _( "暂无新微讯" );
    echo "\">\r\n               <div class=\"close-tips\">";
    echo sprintf( _( "本窗口%s秒后自动关闭" ), " <span id=\"smsbox_close_countdown\">3</span> " );
    echo "</div>\r\n               <a class=\"btn-white-big\" href=\"javascript:;\" onClick=\"send_msg('', '');jQuery('#smsbox').click();\" hidefocus=\"hidefocus\">";
    echo _( "发微讯" );
    echo "</a>&nbsp;&nbsp;\r\n               <a class=\"btn-white-big\" href=\"javascript:;\" onClick=\"jQuery('#smsbox').click();\" hidefocus=\"hidefocus\">";
    echo _( "关闭" );
    echo "</a>\r\n            </div>\r\n         </div>\r\n";
}
else
{
    echo "         <div id=\"no_sms_priv\">\r\n            ";
    echo _( "您没有消息管理模块的权限" );
    echo "         </div>\r\n";
}
echo "      </div>\r\n      <div class=\"foot\">\r\n         <div class=\"foot-left\"></div>\r\n         <div class=\"foot-center\"></div>\r\n         <div class=\"foot-right\"></div>\r\n      </div>\r\n      <div class=\"corner\"></div>\r\n   </div>\r\n\r\n   <!-- 组织机构 -->\r\n   <div id=\"org_panel\" class=\"ipanel\">\r\n      <div class=\"head\">\r\n         <div class=\"left\"><a href=\"javascript:;\" onClick=\"ActiveUserTab(this)\" id=\"user_online_tab\" class=\"active\" hidefocus=\"hidefocus\"><span><img src=\"/images/user_list3/user.png\" align=\"absMiddle\"> ";
echo _( "在线" );
echo "</span></a></div>\r\n         <div class=\"right\"><a href=\"javascript:;\" onClick=\"ActiveUserTab(this)\" hidefocus=\"hidefocus\"><span><img src=\"/images/user_list3/group.png\" align=\"absMiddle\"> ";
echo _( "全部" );
echo "</span></a></div>\r\n      </div>\r\n      <div class=\"center\">\r\n         <div class=\"top\">\r\n            <div id=\"user_online\"><div id=\"orgTree0\"></div></div>\r\n            <div id=\"user_all\" style=\"display:none;\"><div id=\"orgTree1\"></div></div>\r\n         </div>\r\n         <div class=\"bottom\">\r\n            <a class=\"btn-white-b\" href=\"javascript:;\" onClick=\"SearchUser();\" hidefocus=\"hidefocus\">";
echo _( "人员查询" );
echo "</a>&nbsp;&nbsp;\r\n            <a class=\"btn-white-b\" href=\"javascript:;\" onClick=\"jQuery('#org').click();\" hidefocus=\"hidefocus\">";
echo _( "关闭" );
echo "</a>\r\n         </div>\r\n      </div>\r\n      <div class=\"foot\">\r\n         <div class=\"left\"></div>\r\n         <div class=\"right\"></div>\r\n      </div>\r\n      <div class=\"corner\"></div>\r\n   </div>\r\n   \r\n   <div id=\"overlay\"></div>\r\n</body>\r\n</html>";
?>
