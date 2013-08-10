<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "inc/conn.php" );
include_once( "ServiceListPrinter.php" );
define( "CLASSPATH", "./classes/" );
define( "OAWEBSERVICE", "http://".$_SERVER['HTTP_HOST']."/webservice/server.php/" );
$slp = new ServiceListPrinter( OAWEBSERVICE );
if ( $slp->isNonSoapRequest( ) )
{
				$slp->show( );
}
else
{
				$soapClass = $slp->getRequestClass( );
				include( CLASSPATH.$soapClass.".class.php" );
				$server = new SoapServer( NULL, array( "uri" => OAWEBSERVICE.( "/".$soapClass ) ) );
				$server->setClass( $soapClass );
				$server->handle( );
}
?>
