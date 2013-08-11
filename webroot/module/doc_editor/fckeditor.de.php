<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

class FCKeditor
{

				public $InstanceName;
				public $BasePath;
				public $Width;
				public $Height;
				public $ToolbarSet;
				public $Value;
				public $Config;

				public function __construct( $instanceName )
				{
								$this->InstanceName = $instanceName;
								$this->BasePath = "/module/doc_editor/";
								$this->Width = "100%";
								$this->Height = "100%";
								$this->ToolbarSet = "Default";
								$this->Value = "";
								$this->Config = array( );
				}

				public function Create( )
				{
								echo $this->CreateHtml( );
				}

				public function CreateHtml( )
				{
								$HtmlValue = htmlspecialchars( $this->Value );
								$Html = "";
								if ( $this->IsCompatible( ) )
								{
												if ( isset( $_GET['fcksource'] ) && $_GET['fcksource'] == "true" )
												{
																$File = "fckeditor.original.html";
												}
												else
												{
																$File = "fckeditor.html";
												}
												$Link = "{$this->BasePath}editor/{$File}?InstanceName={$this->InstanceName}";
												if ( $this->ToolbarSet != "" )
												{
																$Link .= "&amp;Toolbar=".$this->ToolbarSet;
												}
												$Html .= "<input type=\"hidden\" id=\"".$this->InstanceName."\" name=\"{$this->InstanceName}\" value=\"{$HtmlValue}\" style=\"display:none\" />";
												$Html .= "<input type=\"hidden\" id=\"".$this->InstanceName."___Config\" value=\"".$this->GetConfigFieldString( )."\" style=\"display:none\" />";
												$Html .= "<iframe id=\"".$this->InstanceName."___Frame\" src=\"{$Link}\" width=\"{$this->Width}\" height=\"{$this->Height}\" frameborder=\"0\" scrolling=\"no\"></iframe>";
												return $Html;
								}
								if ( strpos( $this->Width, "%" ) === FALSE )
								{
												$WidthCSS = $this->Width."px";
								}
								else
								{
												$WidthCSS = $this->Width;
								}
								if ( strpos( $this->Height, "%" ) === FALSE )
								{
												$HeightCSS = $this->Height."px";
								}
								else
								{
												$HeightCSS = $this->Height;
								}
								$Html .= "<textarea name=\"".$this->InstanceName."\" rows=\"4\" cols=\"40\" style=\"width: {$WidthCSS}; height: {$HeightCSS}\">{$HtmlValue}</textarea>";
								return $Html;
				}

				public function IsCompatible( )
				{
								return fckeditor_iscompatiblebrowser( );
				}

				public function GetConfigFieldString( )
				{
								$sParams = "";
								$bFirst = TRUE;
								foreach ( $this->Config as $sKey => $sValue )
								{
												if ( $bFirst )
												{
																$sParams .= "&amp;";
												}
												else
												{
																$bFirst = FALSE;
												}
												if ( $sValue === TRUE )
												{
																$sParams .= $this->EncodeConfig( $sKey )."=true";
												}
												else if ( $sValue === FALSE )
												{
																$sParams .= $this->EncodeConfig( $sKey )."=false";
												}
												else
												{
																$sParams .= $this->EncodeConfig( $sKey )."=".$this->EncodeConfig( $sValue );
												}
								}
								return $sParams;
				}

				public function EncodeConfig( $valueToEncode )
				{
								$chars = array( "&" => "%26", "=" => "%3D", "\"" => "%22" );
								return strtr( $valueToEncode, $chars );
				}

}

function FCKeditor_IsCompatibleBrowser( )
{
				if ( isset( $_SERVER ) )
				{
								$sAgent = $_SERVER['HTTP_USER_AGENT'];
								global $HTTP_SERVER_VARS;
				}
				else if ( isset( $HTTP_SERVER_VARS ) )
				{
								$sAgent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
				}
				else
				{
								global $HTTP_USER_AGENT;
								$sAgent = $HTTP_USER_AGENT;
				}
				if ( strpos( $sAgent, "MSIE" ) !== FALSE && strpos( $sAgent, "mac" ) === FALSE && strpos( $sAgent, "Opera" ) === FALSE )
				{
								$iVersion = ( double );
								return 5.5 <= $iVersion;
				}
				if ( strpos( $sAgent, "Gecko/" ) !== FALSE )
				{
								$iVersion = ( integer );
								return 20030210 <= $iVersion;
				}
				if ( strpos( $sAgent, "Opera/" ) !== FALSE )
				{
								$fVersion = ( double );
								return 9.5 <= $fVersion;
				}
				if ( preg_match( "|AppleWebKit/(\\d+)|i", $sAgent, $matches ) )
				{
								$iVersion = $matches[1];
								return 522 <= $matches[1];
				}
				return FALSE;
}

?>
