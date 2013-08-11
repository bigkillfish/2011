<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "./auth.php" );
include_once( "../inc/utility_sms1.php" );
if ( find_id( $AUTH_MODULE, "4" ) )
{
				echo "205#|#"._( "服务未授权" );
				exit( );
}
while ( list( $k, $v ) = each( &$_POST ) )
{
				$$k = trim( $v );
}
while ( list( $k, $v ) = each( &$_GET ) )
{
				$$k = trim( $v );
}
if ( $START_TIME != "" && !is_date_time( $START_TIME ) )
{
				echo "301#|#"._( "START_TIME无效" );
				exit( );
}
if ( $END_TIME != "" && !is_date_time( $END_TIME ) )
{
				echo "302#|#"._( "END_TIME无效" );
				exit( );
}
if ( $BEGIN_USER )
{
				$WHERE_STR = " and a.BEGIN_USER='".$BEGIN_USER."'";
}
if ( $DEPT_ID )
{
				$WHERE_STR = " and c.DEPT_ID='".$DEPT_ID."'";
}
if ( $FLOW_ID )
{
				$WHERE_STR = " and a.FLOW_ID='".$FLOW_ID."'";
}
if ( $START_TIME )
{
				$WHERE_STR = " and a.BEGIN_TIME>'".$START_TIME."'";
}
if ( $END_TIME )
{
				$WHERE_STR = " and a.BEGIN_TIME<'".$END_TIME."'";
}
if ( $COUNT )
{
				$LIMIT = " LIMIT 0,".$COUNT;
}
if ( !$START_TIME && !$END_TIME )
{
				$START_TIME = date( "Y-m-d H:i:s", strtotime( "-2 month" ) );
				$END_TIME = date( "Y-m-d H:i:s", time( ) );
				$WHERE_STR .= " and a.BEGIN_TIME>'".$START_TIME."' and a.BEGIN_TIME<'{$END_TIME}'";
}
$XML_OUT .= "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
$XML_OUT .= "<WorkFlow>\r\n";
$query = "select a.RUN_ID,RUN_NAME,c.USER_NAME,d.PRCS_NAME from FLOW_RUN AS a,FLOW_RUN_PRCS AS b,USER AS c,FLOW_PROCESS AS d where a.RUN_ID=b.RUN_ID AND c.USER_ID=b.USER_ID AND b.PRCS_FLAG IN(1,2) AND d.PRCS_ID=b.FLOW_PRCS ".$WHERE_STR."ORDER BY a.RUN_ID DESC".$LIMIT;
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_assoc( $cursor ) )
{
				$XML_OUT .= "\t<RUN>\r\n";
				foreach ( $ROW as $K => $V )
				{
								$XML_OUT .= "\t\t<".$K."><![CDATA[".$V."]]></".$K.">\r\n";
				}
				$XML_OUT .= "\t</RUN>\r\n";
}
$XML_OUT .= "</WorkFlow>\r\n";
$XML_OUT = iconv( ini_get( "default_charset" ), "utf-8", $XML_OUT );
ob_end_clean( );
header( "Content-type: text/xml" );
echo $XML_OUT;
?>
