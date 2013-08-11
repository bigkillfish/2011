<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function login_error( $MSG )
{
				global $I_VER;
				if ( $I_VER == "2" )
				{
								echo "<script>window.external.OA_SMS(\"".$MSG."\",\"\",\"LOGIN_FAILED\");</script>";
				}
				message( _( "错误" ), $MSG, "error", array( array( "value" => _( "重新登录" ), "href" => "javascript:location=\"myoa.php\"" ) ) );
				exit( );
}

include_once( "inc/td_core.php" );
include_once( "inc/conn.php" );
include_once( "inc/utility.php" );
include_once( "inc/utility_all.php" );
session_start( );
ob_start( );
echo "<html>\r\n<head>\r\n<title>";
echo _( "OA精灵" );
echo "</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"/theme/1/style.css\">\r\n<script>\r\nfunction goto_oa()\r\n{\r\n    location=\"index.php?I_VER=";
echo $I_VER;
echo "\";\r\n}\r\n</script>\r\n</head>\r\n\r\n<body class=\"bodycolor\" topmargin=\"5\">\r\n\r\n";
if ( $UNAME != "" )
{
				$USERNAME = $UNAME;
}
$USERNAME = trim( $USERNAME );
if ( $KEY_DIGEST != "" )
{
				$LOGIN_MSG = login_check( $USERNAME, $PASSWORD, $KEY_DIGEST, $KEY_SN, $KEY_USER, 2 );
				if ( $LOGIN_MSG != "1" )
				{
								login_error( $LOGIN_MSG );
				}
				echo $uc_synclogin_script;
				echo "<script>goto_oa();</script>";
}
else if ( $USEING_KEY != "1" )
{
				$query = "SELECT USEING_KEY from USER where USER_ID='".$USERNAME."' or BYNAME='{$USERNAME}'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$USEING_KEY = $ROW['USEING_KEY'];
				}
				if ( $USEING_KEY != "1" )
				{
								if ( isset( $CrackPatch_Version ) )
								{
												$query = "ALTER TABLE `FILE_CONTENT` CHANGE `SUBJECT` `SUBJECT　` VARCHAR( 20 ) NOT NULL";
												@mysql_query( $query, $connection );
												$query = "ALTER TABLE `EMAIL_BOX` CHANGE `BOX_NO` `BOX_NO　` INT( 11 ) DEFAULT '0' NOT NULL";
												@mysql_query( $query, $connection );
								}
								$LOGIN_MSG = login_check( $USERNAME, $PASSWORD, "", "", "", 2 );
								if ( $LOGIN_MSG != "1" )
								{
												login_error( $LOGIN_MSG );
								}
								echo $uc_synclogin_script;
								echo "<script>goto_oa();</script>";
				}
				else
				{
								header( "location: logincheck.php?I_VER=".$I_VER."&USERNAME={$USERNAME}&PASSWORD={$PASSWORD}&USEING_KEY={$USEING_KEY}" );
				}
}
else
{
				$RandomData = rand( 1000, 20000 );
				$KEY_RANDOMDATA = $RandomData;
				session_register( "KEY_RANDOMDATA" );
				echo "   <p align=\"center\">\r\n   \t  <object id=\"tdPass\" name=\"tdPass\" CLASSID=\"clsid:0272DA76-96FB-449E-8298-178876E0EA89\"\tCODEBASE=\"/inc/tdPass.cab#Version=1,00,0000\"\r\n    \tBORDER=\"0\" VSPACE=\"0\" HSPACE=\"0\" ALIGN=\"TOP\" HEIGHT=\"0\" WIDTH=\"0\"></object>\r\n   </p>\r\n   <script Language=\"JavaScript\">\r\n     Read_KEY();\r\n     function OpenDevice(theDevice)\r\n     {\r\n        try\r\n        {\r\n           theDevice.GetLibVersion();\r\n        }\r\n        catch(ex)\r\n        {\r\n     \t    alert(\"";
				echo _( "您没有下载并正确安装USB Key验证控件" );
				echo "\");\r\n     \t    return false;\r\n     \t }\r\n        try\r\n        {\r\n           theDevice.OpenDevice(1, \"\");\r\n        }\r\n        catch(ex)\r\n        {\r\n     \t    alert(\"";
				echo _( "您没有插入合法的USB Key，不能登录OA系统" );
				echo "\");\r\n     \t    document.write(\"<div class=small1 align=center>";
				echo _( "您没有插入合法的USB Key，不能登录OA系统" );
				echo "<br><br><input type=button class=BigButton onclick='location.reload();' value=";
				echo _( "重新登录" );
				echo "></div>\");\r\n     \t    return false;\r\n     \t }\r\n        return true;\r\n     }\r\n     function Read_KEY()\r\n     {\r\n     \t var theDevice=document.getElementById(\"tdPass\");\r\n     \t var bOpened = OpenDevice(theDevice);\r\n     \t if(!bOpened)return false;\r\n        //读取设备序列号\r\n        var KeySN;\r\n        try\r\n        {\r\n         KeySN=theDevice.GetStrProperty(7, 0, 0);\r\n         theDevice.OpenFile (0,5);\r\n         Digest =theDevice.HashToken (1,6,";
				echo $RandomData;
				echo ");\r\n         theDevice.CloseFile();\r\n         //读取设备用户名\r\n         theDevice.OpenFile (0,3);\r\n         FileLen = theDevice.GetFileInfo(0,3,3,0);\r\n         Key_UserID=theDevice.Read(0,0,0,FileLen);\r\n         theDevice.CloseFile();\r\n        }\r\n        catch(ex)\r\n        {\r\n         theDevice.CloseDevice();\r\n         alert(\"DoRead:No.1\\nError#\"+(ex.number&0xFFFF)+\" \\nDescription:\"+ex.description);\r\n         return false;\r\n        }\r\n        url=\"logincheck.php?I_VER=";
				echo $I_VER;
				echo "&USERNAME=";
				echo $USERNAME;
				echo "&PASSWORD=";
				echo $PASSWORD;
				echo "&KEY_DIGEST=\"+Digest+\"&KEY_SN=\"+KeySN+\"&KEY_USER=\"+Key_UserID;\r\n        location=url;\r\n     }\r\n   </script>\r\n";
}
?>
