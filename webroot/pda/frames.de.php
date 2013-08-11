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
if ( $P_VER == "" )
{
				$FRAME_ROWS = "*,0,40";
}
else
{
				$FRAME_ROWS = "*";
}
echo "<script type=\"text/javascript\" src=\"/inc/js/utility.js\"></script>\r\n<script type=\"text/javascript\" src=\"./js/frames.js\"></script>\r\n<script type=\"text/javascript\">\r\nvar p = \"";
echo $P;
echo "\";\r\nvar p_ver = \"";
echo $P_VER;
echo "\";\r\nvar p_client = \"";
echo $P_CLIENT;
echo "\";\r\nvar online_ref_sec = \"";
echo $ONLINE_REF_SEC;
echo "\";\r\n</script>\r\n<frameset id=\"frame1\" rows=\"";
echo $FRAME_ROWS;
echo "\" cols=\"*\" frameborder=\"no\" border=\"0\" framespacing=\"0\">\r\n   <frame name=\"main\" scrolling=\"auto\" noresize src=\"main.php?P=";
echo $P;
echo "\" frameborder=\"0\" />\r\n";
if ( $P_VER == "" )
{
				echo "   <frame name=\"message\" scrolling=\"no\" noresize src=\"\" frameborder=\"0\" />\r\n   <frame name=\"foot\" scrolling=\"no\" noresize src=\"foot.php?P=";
				echo $P;
				echo "\" frameborder=\"0\" />\r\n";
}
echo "</frameset>\r\n<noframes>";
echo _( "您的浏览器不支持框架" );
echo "</noframes>\r\n</body>\r\n</html>\r\n";
?>
