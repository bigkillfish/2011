<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function pda_page_bar( $current_start_item, $total_items, $page_size = 10, $var_name = "start", $script_href = NULL, $direct_print = FALSE )
{
				if ( $current_start_item < 0 || $total_items < $current_start_item )
				{
								$current_start_item = 0;
				}
				if ( $script_href == NULL )
				{
								$script_href = $_SERVER['PHP_SELF'];
				}
				if ( $_SERVER['QUERY_STRING'] != "" )
				{
								$script_href .= "?".$_SERVER['QUERY_STRING'];
				}
				$script_href = preg_replace( "/^(.+)(\\?|&)TOTAL_ITEMS=[^&]+&?(.*)$/i", "$1$2$3", $script_href );
				$script_href = preg_replace( "/^(.+)(\\?|&)PAGE_SIZE=[^&]+&?(.*)$/i", "$1$2$3", $script_href );
				$script_href = preg_replace( "/^(.+)(\\?|&)".$var_name."=[^&]+&?(.*)$/i", "$1$2$3", $script_href );
				if ( substr( $script_href, -1 ) == "&" || substr( $script_href, -1 ) == "?" )
				{
								$script_href = substr( $script_href, 0, -1 );
				}
				$hyphen = strstr( $script_href, "?" ) === FALSE ? "?" : "&";
				$num_pages = ceil( $total_items / $page_size );
				$cur_page = floor( $current_start_item / $page_size ) + 1;
				$result_str .= "<script>function goto_page(){var page_no=parseInt(document.getElementById('page_no').value);if(isNaN(page_no)||page_no<1||page_no>".$num_pages."){alert(\"".sprintf( _( "页数必须为1-%s" ), $num_pages )."\");return;}window.location=\"".$script_href.$hyphen.$var_name."=\"+(page_no-1)*".$page_size."+\"&TOTAL_ITEMS=".$total_items."&PAGE_SIZE=".$page_size."\";} function input_page_no(){if(event.keyCode==13) goto_page();if(event.keyCode<47||event.keyCode>57) event.returnValue=false;}</script>";
				$result_str .= "<div id=\"pageArea\" class=\"pageArea\">\n".sprintf( _( "第%s页" ), "<span id=\"pageNumber\" class=\"pageNumber\">".$cur_page."/".$num_pages."</span>" );
				if ( $cur_page <= 1 )
				{
								$result_str .= "<a href=\"javascript:;\" id=\"pageFirst\" class=\"pageFirstDisable\" title=\""._( "首页" )."\"></a><a href=\"javascript:;\" id=\"pagePrevious\" class=\"pagePreviousDisable\" title=\""._( "上一页" )."\"></a>";
				}
				else
				{
								$result_str .= "<a href=\"".$script_href.$hyphen.$var_name."=0&TOTAL_ITEMS=".$total_items."&PAGE_SIZE=".$page_size."\" id=\"pageFirst\" class=\"pageFirst\" title=\""._( "首页" )."\"></a><a href=\"".$script_href.$hyphen.$var_name."=".( $current_start_item - $page_size )."&TOTAL_ITEMS=".$total_items."&PAGE_SIZE=".$page_size."\" id=\"pagePrevious\" class=\"pagePrevious\" title=\""._( "上一页" )."\"></a>";
				}
				if ( $num_pages <= $cur_page )
				{
								$result_str .= "<a href=\"javascript:;\" id=\"pageNext\" class=\"pageNextDisable\" title=\""._( "下一页" )."\"></a><a href=\"javascript:;\" id=\"pageLast\" class=\"pageLastDisable\" title=\""._( "末页" )."\"></a>";
				}
				else
				{
								$result_str .= "<a href=\"".$script_href.$hyphen.$var_name."=".( $current_start_item + $page_size )."&TOTAL_ITEMS=".$total_items."&PAGE_SIZE=".$page_size."\" id=\"pageNext\" class=\"pageNext\" title=\""._( "下一页" )."\"></a><a href=\"".$script_href.$hyphen.$var_name."=".( 0 < $total_items % $page_size ? $total_items - $total_items % $page_size : $total_items - $page_size )."&TOTAL_ITEMS=".$total_items."&PAGE_SIZE=".$page_size."\" id=\"pageLast\" class=\"pageLast\" title=\""._( "末页" )."\"></a>";
				}
				$result_str .= "</div>";
				if ( $direct_print )
				{
								echo $result_str;
				}
				else
				{
								return $result_str;
				}
}

function relogin( )
{
				global $P_VER;
				include_once( "inc/td_config.php" );
				echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"DTD/xhtml1-strict.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<title></title>\r\n<meta name=\"viewport\" content=\"width=device-width\" />\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" />\r\n</head>\r\n<body>\r\n<br><br>\r\n<center>";
				echo _( "用户未登录，请重新登录！" );
				echo "<br><br><a target=\"_top\" href=\"/pda/?P_VER=";
				echo $P_VER;
				echo "\">";
				echo _( "重新登录" );
				echo "</a></center>\r\n</body>\r\n</html>\r\n";
				exit( );
}

$MY_ARRAY = explode( ";", $P );
$PDA_UID = $MY_ARRAY[0];
$PDA_SID = trim( $MY_ARRAY[1] );
$P_VER = trim( $MY_ARRAY[2] );
$P_CLIENT = 0 < intval( $P_VER ) ? intval( $P_VER ) : 1;
if ( $PDA_UID == "" || $PDA_SID == "" )
{
				relogin( );
}
ob_start( );
include_once( "inc/session.php" );
include_once( "inc/conn.php" );
include_once( "inc/utility.php" );
session_id( $PDA_SID );
session_start( );
if ( $_SESSION['LOGIN_USER_ID'] == "" || $_SESSION['LOGIN_UID'] == "" || $PDA_UID != $LOGIN_UID )
{
				relogin( );
}
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"DTD/xhtml1-strict.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<title>";
echo $LOGIN_IE_TITLE;
echo "</title>\r\n<meta name=\"viewport\" content=\"width=device-width\" />\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" />\r\n";
if ( is_array( $CSS_ARRAY ) )
{
				foreach ( $CSS_ARRAY as $CSS )
				{
								echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$CSS."\" />";
				}
}
if ( is_array( $JS_ARRAY ) )
{
				foreach ( $JS_ARRAY as $JS )
				{
								echo "<script type=\"text/javascript\" src=\"".$JS."\"></script>";
				}
}
echo "</head>\r\n";
?>
