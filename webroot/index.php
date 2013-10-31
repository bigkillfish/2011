<?php
header( "cache-control: no-store, no-cache, must-revalidate" );
ob_start( );
include_once( "inc/update.php" );
include_once( "inc/session.php" );
session_start( );
$RandomData = rand( 1000, 20000 );
$KEY_RANDOMDATA = $RandomData;
session_register( "KEY_RANDOMDATA" );
include_once( "inc/utility.php" );
include_once( "inc/conn.php" );
include_once( "inc/td_core.php" );
if ( get_client_ip( ) == $_SERVER['SERVER_ADDR'] && !file_exists( $ROOT_PATH."inc/td_install.php" ) )
{
    file_put_contents( $ROOT_PATH."inc/td_install.php", strtoupper( dechex( time( ) ) ) );
    $query = "SELECT PASSWORD from USER where USER_ID='admin'";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $PASSWORD = $ROW['PASSWORD'];
        if ( crypt( "", $PASSWORD ) == $PASSWORD )
        {
            $TIPS = "<div align=\"center\">".sprintf( _( "»¶Ó­Ê¹ÓÃ%s£¬µÇÂ¼ÕÊºÅ%s£¬ÃÜÂëÎª¿Õ" ), "<a href=\"http://".$TD_MYOA_WEB_SITE."\" target=\"_blank\">".$TD_MYOA_PRODUCT_NAME."</a>", "<a href=\"javascript:;\"  onclick=\"form1.UNAME.value='admin';\">admin</a>" )."</div>";
        }
    }
}
$query = "SELECT * from INTERFACE";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $IE_TITLE = $ROW['IE_TITLE'];
    $ATTACHMENT_ID1 = $ROW['ATTACHMENT_ID1'];
    $ATTACHMENT_NAME1 = $ROW['ATTACHMENT_NAME1'];
    $TEMPLATE = $ROW['TEMPLATE'];
}
$query = "SELECT * from SYS_PARA where PARA_NAME='LOGIN_KEY' or PARA_NAME='SEC_USER_MEM' or PARA_NAME='MIIBEIAN'";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
    if ( $ROW['PARA_NAME'] == "LOGIN_KEY" )
    {
        $LOGIN_KEY = $ROW['PARA_VALUE'];
    }
    else if ( $ROW['PARA_NAME'] == "SEC_USER_MEM" )
    {
        $SEC_USER_MEM = $ROW['PARA_VALUE'];
    }
    else if ( $ROW['PARA_NAME'] == "MIIBEIAN" )
    {
        $MIIBEIAN = trim( $ROW['PARA_VALUE'] );
    }
}
$LANGUAGE = "";
if ( $MYOA_IS_UN == 1 )
{
    $LABEL_USER = _( "ÓÃ»§Ãû£º" );
    $LABEL_PASSWORD = _( "ÃÜ¡¡Âë£º" );
    $LABEL_LANGUAGE = _( "Óï¡¡ÑÔ£º" );
    $LABEL_SUBMIT = _( "µÇÂ¼" );
    $LANGUAGE = "<select name=\"LANGUAGE\" onchange=\"ChgLang();\" class=\"language\">";
    $LANG_ARRAY = get_lang_array( );
    foreach ( $LANG_ARRAY as $LANG => $LANG_DESC )
    {
        $LANGUAGE .= "<option value=\"".$LANG."\"".( $LANG == $_COOKIE['LANG_COOKIE'] ? " selected" : "" ).">".$LANG_DESC."</option>";
    }
    $LANGUAGE .= "</select>";
}
if ( $MIIBEIAN != "" )
{
    $MIIBEIAN = "<a href=\"http://www.miibeian.gov.cn/\" target=\"_blank\">".$MIIBEIAN."</a>";
}
if ( stristr( $ATTACHMENT_NAME1, ".swf" ) )
{
    $LOGO_TYPE = "swf";
}
if ( $ATTACHMENT_ID1 != "" && $ATTACHMENT_NAME1 != "" )
{
    $ATTACHMENT_PATH = $ATTACH_PATH.$ATTACHMENT_ID1."/".$ATTACHMENT_NAME1;
    if ( file_exists( $ATTACHMENT_PATH ) )
    {
        $LOGO_PATH = "/inc/attach_logo.php";
        $IMG_ATTR = getimagesize( $ATTACHMENT_PATH );
    }
}
else if ( $TEMPLATE == "2008" )
{
    $LOGO_PATH = "templates/2008/logo.png";
    $IMG_ATTR = getimagesize( "templates/2008/logo.png" );
}
$LOGO_WIDTH = $IMG_ATTR[0];
$LOGO_HEIGHT = $IMG_ATTR[1];
if ( 800 < $LOGO_WIDTH )
{
    $LOGO_WIDTH = 800;
}
if ( 600 < $LOGO_HEIGHT )
{
    $LOGO_HEIGHT = 600;
}
$AUTOCOMPLETE = "autocomplete=\"off\"";
$USER_NAME_COOKIE = $SEC_USER_MEM == "1" ? $_COOKIE['USER_NAME_COOKIE'] : "";
if ( $USER_NAME_COOKIE == "" )
{
    $FOCUS = "UNAME";
}
else
{
    $FOCUS = "PASSWORD";
}
if ( $LOGIN_KEY == "1" && !stristr( $_SERVER['HTTP_USER_AGENT'], "Firefox" ) )
{
    $JAVA_SCRIPT .= "<script src=\"/inc/tdPass.js\"></script>\r\n<script type=\"text/javascript\">\r\nvar \$ = function(id) {return document.getElementById(id);};\r\nvar userAgent = navigator.userAgent.toLowerCase();\r\nvar is_opera = userAgent.indexOf(\"opera\") != -1 && opera.version();\r\nvar is_ie = (userAgent.indexOf(\"msie\") != -1 && !is_opera) && userAgent.substr(userAgent.indexOf(\"msie\") + 5, 3);\r\nfunction CheckForm()\r\n{\r\n   var theDevice=document.getElementById(\"tdPass\");\r\n   KeySN=READ_SN(theDevice);\r\n   Digest=COMPUTE_DIGEST(theDevice,".$RandomData.");\r\n   Key_UserID=READ_KEYUSER(theDevice);\r\n   document.form1.KEY_SN.value=KeySN;\r\n   document.form1.KEY_DIGEST.value=Digest;\r\n   document.form1.KEY_USER.value=Key_UserID;\r\n\r\n   return true;\r\n}\r\nfunction showTdPassObject()\r\n{\r\n   document.getElementById(\"tdPassObject\").innerHTML='<object id=\"tdPass\" name=\"tdPass\" CLASSID=\"clsid:0272DA76-96FB-449E-8298-178876E0EA89\"\tCODEBASE=\"/inc/tdPass.cab#Version=1,0,6,413\" BORDER=\"0\" VSPACE=\"0\" HSPACE=\"0\" ALIGN=\"TOP\" HEIGHT=\"0\" WIDTH=\"0\"></object>';\r\n   document.getElementById(\"installTdPass\").style.display=\"none\";\r\n}\r\nfunction showInstallObject()\r\n{\r\n   try{\r\n      var tdPass=new ActiveXObject(\"FT_ND_SC.ePsM8SC.1\");\r\n      showTdPassObject();\r\n   }\r\n   catch(e){//alert(e.description)\r\n      document.getElementById(\"installTdPass\").style.display=\"\";\r\n   }\r\n}\r\n".( $MYOA_IS_UN ? "\r\nfunction ChgLang()\r\n{\r\n   document.cookie = \"LANG_COOKIE=\" + document.form1.LANGUAGE.value;\r\n   location=\"index.php\";\r\n}" : "" )."\r\nif(is_ie)\r\n   window.attachEvent(\"onload\", showInstallObject);\r\nelse\r\n   window.addEventListener(\"load\", showInstallObject,false);\r\n</script>";
    $USB_KEY_OBJECT = "\r\n  <input type=\"hidden\" name=\"KEY_SN\" value=\"\">\r\n  <input type=\"hidden\" name=\"KEY_USER\" value=\"\">\r\n  <input type=\"hidden\" name=\"KEY_DIGEST\" value=\"\">\r\n  <div id=\"tdPassObject\"></div>";
    $USB_KEY_OPTION = "<a id=\"installTdPass\" href=\"javascript:showTdPassObject();\" style=\"display:none;\">"._( "°²×°USB Key²å¼þ" )."</a>";
}
else
{
    $JAVA_SCRIPT .= "\r\n<script type=\"text/javascript\">\r\nfunction CheckForm()\r\n{\r\n   return true;\r\n}\r\n".( $MYOA_IS_UN ? "\r\nfunction ChgLang()\r\n{\r\n   document.cookie = \"LANG_COOKIE=\" + document.form1.LANGUAGE.value;\r\n   location=\"index.php\";\r\n}" : "" )."\r\n</script>";
}
$ON_SUBMIT = "return CheckForm();";
if ( $LOGO_TYPE == "swf" )
{
    $LOGO_IMG = "<OBJECT classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"/inc/swflash.cab\" WIDTH=\"".$LOGO_WIDTH."\" HEIGHT=\"".$LOGO_HEIGHT."\">\r\n         <PARAM NAME=\"movie\" VALUE=\"".$LOGO_PATH."\">\r\n         <PARAM NAME=\"quality\" VALUE=\"high\">\r\n         <EMBED src=\"".$LOGO_PATH."\" quality=\"high\" TYPE=\"application/x-shockwave-flash\" PLUGINSPAGE=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash\"></EMBED>\r\n        </OBJECT>";
}
else
{
    $LOGO_IMG = "<img src=\"".$LOGO_PATH."\" width=\"".$LOGO_WIDTH."\" height=\"".$LOGO_HEIGHT."\">";
}
$ANTIVIRUS_SCRIPT = file_get_contents( $ROOT_PATH."inc/antivirus.txt" );
if ( file_exists( $ROOT_PATH.( "templates/".$TEMPLATE."/index.html" ) ) )
{
    $OUTPUT_HTML = file_get_contents( $ROOT_PATH.( "templates/".$TEMPLATE."/index.html" ) );
}
else
{
    $OUTPUT_HTML = file_get_contents( $ROOT_PATH."templates/default/index.html" );
}
$OUTPUT_HTML = str_replace( array(
    "{charset}",
    "{title}",
    "{javascript}",
    "{focus_filed}",
    "{autocomplete}",
    "{form_submit}",
    "{logo_img}",
    "{username_cookie}",
    "{usbkey_object}",
    "{antivirus_script}",
    "{usb_key_option}",
    "{tips}",
    "{miibeian}",
    "{update_tips}",
    "{language}",
    "{label_user}",
    "{label_password}",
    "{label_language}",
    "{label_submit}"
), array(
    $MYOA_CHARSET,
    $IE_TITLE,
    $JAVA_SCRIPT,
    $FOCUS,
    $AUTOCOMPLETE,
    $ON_SUBMIT,
    $LOGO_IMG,
    $USER_NAME_COOKIE,
    $USB_KEY_OBJECT,
    $ANTIVIRUS_SCRIPT,
    $USB_KEY_OPTION,
    $TIPS,
    $MIIBEIAN,
    $UPDATE_TIPS,
    $LANGUAGE,
    $LABEL_USER,
    $LABEL_PASSWORD,
    $LABEL_LANGUAGE,
    $LABEL_SUBMIT
), $OUTPUT_HTML );
echo $OUTPUT_HTML;
?>
