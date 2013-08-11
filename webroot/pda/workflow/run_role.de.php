<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function getMyDept( $LOWER = 0 )
{
				global $LOGIN_DEPT_ID;
				global $SYS_DEPARTMENT;
				foreach ( $SYS_DEPARTMENT as $DEPT_ID => $DEPT )
				{
								do
								{
												if ( isset( $FLAG ) && $DEPT['DEPT_LEVEL'] <= $FLAG )
												{
																break;
												}
												else if ( $DEPT_ID != $LOGIN_DEPT_ID && !isset( $FLAG ) )
												{
												}
												else if ( !( $DEPT_ID == $LOGIN_DEPT_ID ) )
												{
																break;
												}
												else
												{
																$FLAG = $DEPT['DEPT_LEVEL'];
												}
												if ( $LOWER == 1 )
												{
												}
								} while ( 0 );
								$MY_DEPT_STR .= $DEPT_ID.",";
				}
				if ( $MY_DEPT_STR != "" )
				{
								$MY_DEPT_STR = substr( $MY_DEPT_STR, 0, -1 );
				}
				else
				{
								$MY_DEPT_STR = 0;
				}
				reset( &$SYS_DEPARTMENT );
				return $MY_DEPT_STR;
}

function run_role( $RUN_ID, $PRCS_ID )
{
				global $connection;
				global $LOGIN_USER_ID;
				global $LOGIN_USER_PRIV;
				global $LOGIN_DEPT_ID;
				$RUN_ROLE = "";
				$query = "SELECT * from FLOW_RUN where RUN_ID='".$RUN_ID."'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$FLOW_ID = $ROW['FLOW_ID'];
				}
				else
				{
								return $RUN_ROLE;
				}
				$query_str = " and RUN_ID='".$RUN_ID."'";
				if ( $PRCS_ID != "0" && $PRCS_ID != "" )
				{
								$query_str .= " and PRCS_ID='".$PRCS_ID."'";
				}
				if ( $LOGIN_USER_PRIV == "1" )
				{
								$RUN_ROLE .= "1,";
				}
				$query = "SELECT * from FLOW_RUN_PRCS where USER_ID='".$LOGIN_USER_ID."' AND OP_FLAG=1".$query_str;
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$RUN_ROLE .= "2,";
				}
				$query = "SELECT DEPT_ID from FLOW_RUN,USER where FLOW_RUN.BEGIN_USER=USER.USER_ID and RUN_ID='".$RUN_ID."'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$BEGIN_DEPT = $ROW['DEPT_ID'];
				}
				$MY_DEPT_STR = getmydept( );
				$query = "SELECT MANAGE_USER,MANAGE_USER_DEPT,QUERY_USER,QUERY_USER_DEPT from FLOW_TYPE where FLOW_ID='".$FLOW_ID."'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								foreach ( $ROW as $PRIV_NAME => $PRIV_STR )
								{
												$PRIV_ARRAY = explode( "|", $PRIV_STR );
												$PRIV_USER = $PRIV_ARRAY[0];
												$PRIV_DEPT = $PRIV_ARRAY[1];
												$PRIV_ROLE = $PRIV_ARRAY[2];
												if ( !( !find_id( $PRIV_USER, $LOGIN_USER_ID ) && !find_id( $PRIV_ROLE, $LOGIN_USER_PRIV ) && !find_id( $PRIV_ROLE, $LOGIN_USER_PRIV_OTHER ) && !find_id( $PRIV_DEPT, $LOGIN_DEPT_ID ) && !find_id( $PRIV_DEPT, $LOGIN_DEPT_ID_OTHER ) && !( $PRIV_DEPT == "ALL_DEPT" ) ) )
												{
																continue;
												}
												else if ( $PRIV_NAME == "MANAGE_USER" || find_id( $MY_DEPT_STR, $BEGIN_DEPT ) && $PRIV_NAME == "MANAGE_USER_DEPT" )
												{
																$RUN_ROLE .= "3,";
												}
												else if ( !( $PRIV_NAME == "QUERY_USER" ) && ( !find_id( $MY_DEPT_STR, $BEGIN_DEPT ) || !( $PRIV_NAME == "QUERY_USER_DEPT" ) ) )
												{
																$RUN_ROLE .= "5,";
												}
								}
				}
				$query = "SELECT * from FLOW_RUN_PRCS where USER_ID='".$LOGIN_USER_ID."'".$query_str;
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$RUN_ROLE .= "4,";
				}
				$query = "SELECT 1 from FLOW_RUN_PRCS where OTHER_USER='".$LOGIN_USER_ID."'".$query_str;
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$RUN_ROLE .= "6,";
				}
				return $RUN_ROLE;
}

function get_prcs_user( $FLOW_ID, $PRCS_ID )
{
				global $connection;
				$USER_ARR = array( "OP" => array( ), "OTHER" => array( ) );
				$query = "SELECT * from FLOW_PROCESS where FLOW_ID='".$FLOW_ID."' and PRCS_ID = '{$PRCS_ID}'";
				$cursor = exequery( $connection, $query );
				if ( $ROW = mysql_fetch_array( $cursor ) )
				{
								$PRCS_USER = $ROW['PRCS_USER'];
								$PRCS_DEPT = $ROW['PRCS_DEPT'];
								$PRCS_PRIV = $ROW['PRCS_PRIV'];
								$AUTO_TYPE = $ROW['AUTO_TYPE'];
								$AUTO_USER_OP = $ROW['AUTO_USER_OP'];
								$AUTO_USER = $ROW['AUTO_USER'];
								do
								{
												if ( $AUTO_TYPE == 3 )
												{
																if ( $AUTO_USER != "" )
																{
																				$query1 = "SELECT USER_ID,DEPT_ID,USER_PRIV,USER_NAME,USER_PRIV_OTHER from USER where USER_ID='".$AUTO_USER_OP."' limit 1";
																				$cursor1 = exequery( $connection, $query1 );
																				if ( $ROW = mysql_fetch_array( $cursor1 ) )
																				{
																								$USER_ID = $ROW['USER_ID'];
																								$DEPT_ID = $ROW['DEPT_ID'];
																								$USER_PRIV = $ROW['USER_PRIV'];
																								$USER_NAME = $ROW['USER_NAME'];
																								$USER_PRIV_OTHER = $ROW['USER_PRIV_OTHER'];
																								if ( $PRCS_DEPT == "ALL_DEPT" || find_id( $PRCS_USER, $USER_ID ) || find_id( $PRCS_DEPT, $DEPT_ID ) || find_id( $PRCS_PRIV, $USER_PRIV ) || priv_other( $PRCS_PRIV, $USER_PRIV_OTHER ) )
																								{
																												$USER_ARR['OP'][$USER_ID] = $USER_NAME;
																								}
																				}
																				$query3 = "SELECT USER_ID,DEPT_ID,USER_PRIV,USER_NAME,USER_PRIV_OTHER from USER where find_in_set(USER_ID,'".$AUTO_USER."')";
																				$cursor3 = exequery( $connection, $query3 );
																				do
																				{
																								if ( $ROW = mysql_fetch_array( $cursor3 ) )
																								{
																												$USER_ID = $ROW['USER_ID'];
																												$DEPT_ID = $ROW['DEPT_ID'];
																												$USER_PRIV = $ROW['USER_PRIV'];
																												$USER_NAME = $ROW['USER_NAME'];
																												$USER_PRIV_OTHER = $ROW['USER_PRIV_OTHER'];
																												if ( !( $PRCS_DEPT == "ALL_DEPT" ) && !find_id( $PRCS_USER, $USER_ID ) && !find_id( $PRCS_DEPT, $DEPT_ID ) && !find_id( $PRCS_PRIV, $USER_PRIV ) && !priv_other( $PRCS_PRIV, $USER_PRIV_OTHER ) )
																												{
																																$USER_ARR['OTHER'][$USER_ID] = $USER_NAME;
																												}
																								}
																				} while ( 1 );
																}
												}
												$query = "SELECT USER_ID,USER_NAME FROM USER WHERE 1=1";
												if ( $PRCS_DEPT != "ALL_DEPT" )
												{
																$query .= " and (find_in_set(USER_ID,'".$PRCS_USER."') OR (find_in_set(DEPT_ID,'{$PRCS_DEPT}')) OR (find_in_set(USER_PRIV,'{$PRCS_PRIV}')))";
												}
												$cursor = exequery( $connection, $query );
								} while ( 0 );
								while ( $ROW = mysql_fetch_array( $cursor ) )
								{
												$USER_ARR['OP'][$ROW[0]] = $ROW[1];
												$USER_ARR['OTHER'][$ROW[0]] = $ROW[1];
												break;
												break;
								}
				}
				return $USER_ARR;
}

include_once( "../auth.php" );
include_once( "inc/utility_all.php" );
include_once( "inc/utility_org.php" );
include_once( "general/workflow/list/turn/condition.php" );
?>
