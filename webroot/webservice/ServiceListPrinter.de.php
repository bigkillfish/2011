<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

class ServiceListPrinter
{

				private $soapClasses;
				private $reqURL;
				private $reqSelf;
				private $nsBase;
				private $reqClass;
				private $reqClassFile;
				private $wsdlReq;
				private $baseURL;

				public function __construct( $nsBase )
				{
								$classes = array( );
								foreach ( glob( CLASSPATH."*.class.php" ) as $fileName )
								{
												$classes[] = substr( $fileName, 10, -10 );
								}
								$this->soapClasses = $classes;
								$this->reqURL = $_SERVER['REQUEST_URI'];
								$this->nsBase = $nsBase;
								$this->reqSelf = $_SERVER['PHP_SELF'];
								$protocol = isset( $_SERVER['HTTPS'] ) ? "https://" : "http://";
								$this->baseURL = $protocol.$_SERVER['HTTP_HOST'];
								$this->reqClass = FALSE;
								$this->reqClassFile = FALSE;
								$this->wsdlReq = FALSE;
								if ( isset( $_SERVER['PATH_INFO'] ) )
								{
												$reqClass = str_replace( "/", "", $_SERVER['PATH_INFO'] );
												if ( in_array( $reqClass, $classes ) )
												{
																$this->reqClass = $reqClass;
																$this->reqClassFile = $reqClass.".class.php";
																if ( strcasecmp( $_SERVER['QUERY_STRING'], "WSDL" ) == 0 )
																{
																				$this->wsdlReq = TRUE;
																}
												}
								}
				}

				public function isNonSoapRequest( )
				{
								return $this->reqClass === FALSE || $this->wsdlReq;
				}

				public function getRequestClass( )
				{
								return $this->reqClass;
				}

				public function getRequestClassNS( )
				{
								return $this->nsBase.$this->reqClass;
				}

				public function show( )
				{
								if ( $this->wsdlReq )
								{
												$this->showWsdl( );
								}
								else
								{
												$this->showServiceList( );
								}
				}

				protected function showWsdl( )
				{
								require_once( CLASSPATH.$this->reqClassFile );
								$wsdlgen = new WSDL_Gen( $this->reqClass, $this->baseURL.$this->reqSelf, $this->nsBase.$this->reqClass );
								header( "Content-Type: text/xml" );
								echo $wsdlgen->toXML( );
				}

				protected function showServiceList( )
				{
								echo "<h1>Services</h1>";
								foreach ( $this->soapClasses as $cls )
								{
												echo "<h2>";
												echo $cls;
												echo "</h2><span class='wsdl-link'>(<a href=\"";
												echo $this->reqURL;
												echo "/";
												echo $cls;
												echo "?WSDL\">WSDL</a>)</span><h3>Functions</h3>";
												require_once( CLASSPATH."{$cls}.class.php" );
												$gen = new WSDL_Gen( $cls, $this->baseURL.$this->reqSelf, $this->nsBase.$cls );
												echo "<table>";
												foreach ( $gen->operations as $operName => $oper )
												{
																echo "<tr><td>";
																$retMsg = $oper['output'];
																$retString = "void";
																if ( 0 < count( $retMsg ) )
																{
																				$retString = $retMsg[0]['type'];
																}
																$paramMsg = $oper['input'];
																$paramString = "";
																if ( 0 < count( $paramMsg ) )
																{
																				foreach ( $paramMsg as $paramEntry )
																				{
																								if ( 0 < strlen( $paramString ) )
																								{
																												$paramString .= ", ";
																								}
																								$paramString .= "{$paramEntry['type']} {$paramEntry['name']}";
																				}
																}
																echo $retString;
																echo " ";
																echo $operName;
																echo "(";
																echo $paramString;
																echo ")</td><td>";
																echo $oper['documentation'];
																echo "</td></tr>";
												}
												echo "</table>";
								}
								echo "<hr/>";
				}

}

require_once( "WSDL_Gen.php" );
?>
