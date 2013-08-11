<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

require_once( "inc/auth.php" );
require_once( "inc/mb.php" );
require_once( "inc/utility_all.php" );
require_once( "inc/department.php" );
ob_clean( );
$str = "";
$count = 0;
$style = "";
$_sname = td_iconv( htmlspecialchars( $sname ), "utf-8", $MYOA_CHARSET );
$prefix = getchnprefix( $_sname );
$query = "SELECT UID,USER_NAME,DEPT_ID FROM USER WHERE DEPT_ID!= 0 AND NOT_LOGIN !=1 AND (USER_NAME_INDEX like '".$prefix."%' or USER_NAME_INDEX like '%".$prefix."%' or USER_NAME_INDEX like '%".$prefix."') ORDER BY USER_NAME ASC";
$cursor = exequery( $connection, $query );
$rc = mysql_affected_rows( );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
				++$count;
				$UID = $ROW['UID'];
				$USER_NAME = $ROW['USER_NAME'];
				$DEPT_ID = $ROW['DEPT_ID'];
				$DEPT_NAME = $SYS_DEPARTMENT[$DEPT_ID]['DEPT_NAME'];
				if ( 1 < $rc )
				{
								if ( $count == 1 )
								{
												$style = "ui-corner-top";
								}
								else
								{
												$style = "";
								}
								if ( $count == $rc )
								{
												$style = "ui-corner-bottom";
								}
				}
				else
				{
								$style = "ui-corner-top ui-corner-bottom";
				}
				$str .= "<div class=\"ui-checkbox\" uid=\"".$UID."\" username=\"".$USER_NAME."\" deptname=\"".$DEPT_NAME."\">\r\n\t\t\t\t\t<input type=\"checkbox\" data-theme=\"c\" class=\"custom\" id=\"checkbox-".$UID."a\" name=\"checkbox-".$UID."a\">\r\n\t\t\t\t\t<label for=\"checkbox-".$UID."a\" data-theme=\"c\" class=\"ui-btn ui-btn-icon-left ".$style." ui-btn-up-c\">\r\n\t\t\t\t\t\t<span class=\"ui-btn-inner ui-corner-top\">\r\n\t\t\t\t\t\t\t<span class=\"ui-btn-text\">".$USER_NAME." - <span class=\"dept_name\">£¨".$DEPT_NAME."£©</span></span>\r\n\t\t\t\t\t\t\t<span class=\"ui-icon ui-icon-ui-icon-checkbox-off ui-icon-checkbox-off\"></span>\r\n\t\t\t\t\t\t</span>\r\n\t\t\t\t\t</label>\r\n\t\t\t\t </div>";
}
echo $str;
?>
