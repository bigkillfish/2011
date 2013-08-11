<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include_once( "./auth.php" );
$query = "SHOW VARIABLES like 'datadir'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$DATA_BASE_DIR = $ROW['Value'];
}
if ( $DATA_BASE_DIR == "" )
{
				$DATA_BASE_DIR = "D:/MYOA/data5/";
}
$query = "select PARA_VALUE from SYS_PARA where PARA_NAME='BACKUP_DATABASES'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$BACKUP_DATABASES = $ROW[0];
}
if ( substr( $BACKUP_DATABASES, strlen( $BACKUP_DATABASES ) - 1, 1 ) == "," )
{
				$BACKUP_DATABASES = substr( $BACKUP_DATABASES, 0, -1 );
}
$BACKUP_DATABASES_ARRAY = explode( ",", $BACKUP_DATABASES );
foreach ( $BACKUP_DATABASES_ARRAY as $DB_NAME )
{
				$DATA_DIR = $DATA_BASE_DIR.$DB_NAME;
				$handle = opendir( $DATA_DIR );
				if ( $handle )
				{
								echo sprintf( _( "不能打开数据库目录（%s）" ), $DATA_DIR );
								exit( );
				}
				$FILE_COUNT = 0;
				$FILE_ARRAY = array( );
				while ( FALSE !== ( $FILE_NAME = readdir( $handle ) ) )
				{
								if ( $FILE_NAME == "." || $FILE_NAME == ".." )
								{
								}
								else
								{
												continue;
								}
								$EXT_NAME = strtolower( substr( $FILE_NAME, -4 ) );
								if ( $EXT_NAME != ".frm" && $EXT_NAME != ".myd" && $EXT_NAME != ".myi" )
								{
												$FILE_ARRAY[$FILE_COUNT++] = $FILE_NAME;
								}
				}
				closedir( $handle );
				if ( $FILE_COUNT == 0 )
				{
								$BACKUP_DIR_SINGLE = str_replace( "//", "/", $BACKUP_PATH );
								if ( ( !file_exists( $BACKUP_DIR_SINGLE ) || !is_dir( $BACKUP_DIR_SINGLE ) ) && !mkdir( $BACKUP_DIR_SINGLE ) )
								{
												echo sprintf( _( "创建备份目录（%s）失败" ), $BACKUP_DIR_SINGLE );
												exit( );
								}
								$BACKUP_DIR_SINGLE .= "/".$DB_NAME.date( "YmdHis", time( ) );
								$BACKUP_DIR_SINGLE = str_replace( "//", "/", $BACKUP_DIR_SINGLE );
								if ( ( !file_exists( $BACKUP_DIR_SINGLE ) || !is_dir( $BACKUP_DIR_SINGLE ) ) && !mkdir( $BACKUP_DIR_SINGLE ) )
								{
												echo sprintf( _( "创建备份目录（%s）失败" ), $BACKUP_DIR_SINGLE );
								}
								else
								{
												$query = "FLUSH TABLES WITH READ LOCK ";
												exequery( $connection, $query );
												$I = 0;
												for ( ;	$I < count( $FILE_ARRAY );	++$I	)
												{
																if ( copy( $DATA_DIR."/".$FILE_ARRAY[$I], $BACKUP_DIR_SINGLE."/".$FILE_ARRAY[$I] ) )
																{
																				$FAIL_FILE .= $FILE_ARRAY[$I].",";
																				--$FILE_COUNT;
																}
												}
												if ( $FILE_COUNT != count( $FILE_ARRAY ) )
												{
																echo sprintf( _( "数据库（%s）中，以下文件备份失败：" ), $DB_NAME ).substr( $FAIL_FILE, 0, -1 )."\n";
												}
												$query = "UNLOCK TABLES";
												exequery( $connection, $query );
								}
				}
}
$query = "update OFFICE_TASK set LAST_EXEC='".date( "Y-m-d" )."' where TASK_CODE='db_backup'";
exequery( $connection, $query );
echo "+OK";
?>
