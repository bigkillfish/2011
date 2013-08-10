<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

class WSDL_Gen
{

				public static $baseTypes = array( 'int' => array( 'ns' => self::SOAP_XML_SCHEMA_VERSION, 'name' => "int" ), 'float' => array( 'ns' => self::SOAP_XML_SCHEMA_VERSION, 'name' => "float" ), 'string' => array( 'ns' => self::SOAP_XML_SCHEMA_VERSION, 'name' => "string" ), 'boolean' => array( 'ns' => self::SOAP_XML_SCHEMA_VERSION, 'name' => "boolean" ), 'unknown_type' => array( 'ns' => self::SOAP_XML_SCHEMA_VERSION, 'name' => "any" ) );
				public $types;
				public $operations = array( );
				public $className;
				public $ns;
				public $endpoint;
				public $complexTypes;
				private $mytypes = array( );
				private $style = SOAP_RPC;
				private $use = SOAP_ENCODED;

				const SOAP_XML_SCHEMA_VERSION = "http://www.w3.org/2001/XMLSchema";
				const SOAP_XML_SCHEMA_INSTANCE = "http://www.w3.org/2001/XMLSchema-instance";
				const SOAP_SCHEMA_ENCODING = "http://schemas.xmlsoap.org/soap/encoding/";
				const SOAP_ENVELOP = "http://schemas.xmlsoap.org/soap/envelope/";
				const SCHEMA_SOAP_HTTP = "http://schemas.xmlsoap.org/soap/http";
				const SCHEMA_SOAP = "http://schemas.xmlsoap.org/wsdl/soap/";
				const SCHEMA_WSDL = "http://schemas.xmlsoap.org/wsdl/";

				public function __construct( $className, $endpoint, $ns = FALSE )
				{
								$this->types = self::$baseTypes;
								$this->className = $className;
								if ( $ns )
								{
												$ns = $endpoint;
								}
								$this->ns = $ns;
								$this->endpoint = $endpoint;
								$this->createPHPTypes( );
								$class = new ReflectionClass( $className );
								$methods = $class->getMethods( );
								$this->discoverOperations( $methods );
								$this->discoverTypes( );
				}

				protected function discoverOperations( $methods )
				{
								foreach ( $methods as $method )
								{
												if ( !$method->isPublic( ) || $method->isConstructor( ) )
												{
																$this->operations[$method->getName( )]['input'] = array( );
																$this->operations[$method->getName( )]['output'] = array( );
																$doc = $method->getDocComment( );
																if ( preg_match_all( "|@param\\s+(?:object\\s+)?(\\w+)\\s+\\$(\\w+)|", $doc, $matches, PREG_SET_ORDER ) )
																{
																				foreach ( $matches as $match )
																				{
																								$this->mytypes[$match[1]] = 1;
																								$this->operations[$method->getName( )]['input'][] = array( "name" => $match[2], "type" => $match[1] );
																				}
																}
																if ( preg_match( "|@return\\s+(?:object\\s+)?(\\w+)|", $doc, $match ) )
																{
																				$this->mytypes[$match[1]] = 1;
																				$this->operations[$method->getName( )]['output'][] = array( "name" => "return", "type" => $match[1] );
																}
																$comment = trim( $doc );
																$commentStart = strpos( $comment, "/**" ) + 3;
																$comment = trim( substr( $comment, $commentStart, strlen( $comment ) - 5 ) );
																$description = "";
																$lines = preg_split( "(\\n\\r|\\r\\n\\|\\r|\\n)", $comment );
																foreach ( $lines as $line )
																{
																				$line = trim( $line );
																				$lineStart = strpos( $line, "*" );
																				if ( $lineStart === FALSE )
																				{
																								$lineStart = -1;
																				}
																				$line = trim( substr( $line, $lineStart + 1 ) );
																				if ( isset( $line[0] ) && !( $line[0] != "@" ) || !( 0 < strlen( $line ) ) )
																				{
																								$description .= "\n".$line;
																				}
																}
																$this->operations[$method->getName( )]['documentation'] = $description;
												}
								}
				}

				protected function discoverTypes( )
				{
								foreach ( array_keys( $this->mytypes ) as $type )
								{
												if ( isset( $this->types[$type] ) )
												{
																$this->addComplexType( $type );
												}
								}
				}

				protected function createPHPTypes( )
				{
								$this->complexTypes['mixed'] = array( array( "name" => "varString", "type" => "string" ), array( "name" => "varInt", "type" => "int" ), array( "name" => "varFloat", "type" => "float" ), array( "name" => "varArray", "type" => "array" ), array( "name" => "varBoolean", "type" => "boolean" ) );
								$this->types['mixed'] = array( "name" => "mixed", "ns" => $this->ns );
								$this->types['array'] = array( "name" => "array", "ns" => $this->ns );
				}

				protected function addComplexType( $className )
				{
								$class = new ReflectionClass( $className );
								$this->complexTypes[$className] = array( );
								$this->types[$className] = array( "name" => $className, "ns" => $this->ns );
								foreach ( $class->getProperties( ) as $prop )
								{
												$doc = $prop->getDocComment( );
												if ( preg_match( "|@var\\s+(?:object\\s+)?(\\w+)|", $doc, $match ) )
												{
																$type = $match[1];
																$this->complexTypes[$className][] = array( "name" => $prop->getName( ), "type" => $type );
																if ( isset( $this->types[$type] ) )
																{
																				$this->addComplexType( $type );
																}
												}
								}
				}

				protected function addMessages( $doc, $root )
				{
								foreach ( array( "input" => "", "output" => "Response" ) as $type => $postfix )
								{
												foreach ( $this->operations as $name => $params )
												{
																$el = $doc->createElementNS( self::SCHEMA_WSDL, "message" );
																$fullName = "{$name}".ucfirst( $postfix );
																$el->setAttribute( "name", $fullName );
																$part = $doc->createElementNS( self::SCHEMA_WSDL, "part" );
																$part->setAttribute( "element", "tns:".$fullName );
																$part->setAttribute( "name", "parameters" );
																$el->appendChild( $part );
																$root->appendChild( $el );
												}
								}
				}

				protected function addPortType( $doc, $root )
				{
								$el = $doc->createElementNS( self::SCHEMA_WSDL, "portType" );
								$el->setAttribute( "name", $this->className."PortType" );
								foreach ( $this->operations as $name => $params )
								{
												$op = $doc->createElementNS( self::SCHEMA_WSDL, "operation" );
												$op->setAttribute( "name", $name );
												$opDocu = $doc->createElementNS( self::SCHEMA_WSDL, "documentation" );
												$docuText = $params['documentation']( $params['documentation'] );
												$opDocu->appendChild( $docuText );
												$op->appendChild( $opDocu );
												foreach ( array( "input" => "", "output" => "Response" ) as $type => $postfix )
												{
																$sel = $doc->createElementNS( self::SCHEMA_WSDL, $type );
																$fullName = "{$name}".ucfirst( $postfix );
																$sel->setAttribute( "message", "tns:".$fullName );
																$sel->setAttribute( "name", $fullName );
																$op->appendChild( $sel );
												}
												$el->appendChild( $op );
								}
								$root->appendChild( $el );
				}

				protected function addBinding( $doc, $root )
				{
								$el = $doc->createElementNS( self::SCHEMA_WSDL, "binding" );
								$el->setAttribute( "name", $this->className."Binding" );
								$el->setAttribute( "type", "tns:".$this->className."PortType" );
								$s_binding = $doc->createElementNS( self::SCHEMA_SOAP, "binding" );
								$s_binding->setAttribute( "style", "document" );
								$s_binding->setAttribute( "transport", self::SCHEMA_SOAP_HTTP );
								$el->appendChild( $s_binding );
								foreach ( $this->operations as $name => $params )
								{
												$op = $doc->createElementNS( self::SCHEMA_WSDL, "operation" );
												$op->setAttribute( "name", $name );
												foreach ( array( "input", "output" ) as $type )
												{
																$sel = $doc->createElementNS( self::SCHEMA_WSDL, $type );
																$s_body = $doc->createElementNS( self::SCHEMA_SOAP, "body" );
																$s_body->setAttribute( "use", "literal" );
																$sel->appendChild( $s_body );
																$op->appendChild( $sel );
												}
												$el->appendChild( $op );
								}
								$root->appendChild( $el );
				}

				protected function addService( $doc, $root )
				{
								$el = $doc->createElementNS( self::SCHEMA_WSDL, "service" );
								$el->setAttribute( "name", $this->className."Service" );
								$port = $doc->createElementNS( self::SCHEMA_WSDL, "port" );
								$port->setAttribute( "name", $this->className."Port" );
								$port->setAttribute( "binding", "tns:".$this->className."Binding" );
								$addr = $doc->createElementNS( self::SCHEMA_SOAP, "address" );
								$this->endpoint( "location", $this->endpoint );
								$port->appendChild( $addr );
								$el->appendChild( $port );
								$root->appendChild( $el );
				}

				protected function addTypes( $doc, $root )
				{
								$types = $doc->createElementNS( self::SCHEMA_WSDL, "types" );
								$root->appendChild( $types );
								$el = $doc->createElementNS( self::SOAP_XML_SCHEMA_VERSION, "schema" );
								$el->setAttribute( "attributeFormDefault", "unqualified" );
								$el->setAttribute( "elementFormDefault", "unqualified" );
								$this->ns( "targetNamespace", $this->ns );
								$types->appendChild( $el );
								foreach ( $this->complexTypes as $name => $data )
								{
												if ( $name == "mixed" )
												{
																$ct = $doc->createElementNS( self::SOAP_XML_SCHEMA_VERSION, "complexType" );
																$ct->setAttribute( "name", $name );
																$all = $doc->createElementNS( self::SOAP_XML_SCHEMA_VERSION, "all" );
																foreach ( $data as $prop )
																{
																				$p = $doc->createElementNS( self::SOAP_XML_SCHEMA_VERSION, "element" );
																				$prop['name']( "name", $prop['name'] );
																				$prefix = $this->types[$prop['type']]['ns']( $this->types[$prop['type']]['ns'] );
																				$this->types[$prop['type']]( "type", "{$prefix}:".$this->types[$prop['type']]['name'] );
																				$all->appendChild( $p );
																}
																$ct->appendChild( $all );
																$el->appendChild( $ct );
												}
								}
								foreach ( $this->operations as $name => $params )
								{
												foreach ( array( "input" => "", "output" => "Response" ) as $type => $postfix )
												{
																$ce = $doc->createElementNS( self::SOAP_XML_SCHEMA_VERSION, "element" );
																$fullName = "{$name}".ucfirst( $postfix );
																$ce->setAttribute( "name", $fullName );
																$ce->setAttribute( "type", "tns:".$fullName );
																$el->appendChild( $ce );
																$ct = $doc->createElementNS( self::SOAP_XML_SCHEMA_VERSION, "complexType" );
																$ct->setAttribute( "name", $fullName );
																$ctseq = $doc->createElementNS( self::SOAP_XML_SCHEMA_VERSION, "sequence" );
																$ct->appendChild( $ctseq );
																foreach ( $params[$type] as $param )
																{
																				$pare = $doc->createElementNS( self::SOAP_XML_SCHEMA_VERSION, "element" );
																				$param['name']( "name", $param['name'] );
																				$prefix = $this->types[$param['type']]['ns']( $this->types[$param['type']]['ns'] );
																				$this->types[$param['type']]( "type", "{$prefix}:".$this->types[$param['type']]['name'] );
																				$ctseq->appendChild( $pare );
																}
																$el->appendChild( $ct );
												}
								}
				}

				public function toXML( )
				{
								$wsdl = new DomDocument( "1.0" );
								$root = $wsdl->createElement( "wsdl:definitions" );
								$root->setAttributeNS( "http://www.w3.org/2000/xmlns/", "xmlns:xsd", "http://www.w3.org/2001/XMLSchema" );
								$this->ns( "http://www.w3.org/2000/xmlns/", "xmlns:tns", $this->ns );
								$root->setAttributeNS( "http://www.w3.org/2000/xmlns/", "xmlns:soap-env", self::SCHEMA_SOAP );
								$root->setAttributeNS( "http://www.w3.org/2000/xmlns/", "xmlns:wsdl", self::SCHEMA_WSDL );
								$root->setAttributeNS( "http://www.w3.org/2000/xmlns/", "xmlns:soapenc", self::SOAP_SCHEMA_ENCODING );
								$this->ns( "targetNamespace", $this->ns );
								$this->addTypes( $wsdl, $root );
								$this->addMessages( $wsdl, $root );
								$this->addPortType( $wsdl, $root );
								$this->addBinding( $wsdl, $root );
								$this->addService( $wsdl, $root );
								$wsdl->appendChild( $root );
								return $wsdl->saveXML( );
				}

}

?>
