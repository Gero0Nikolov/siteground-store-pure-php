<?php
/*
*	Config File for DB details:
*	Servername, User, Password, Database
*
*	Project Config:
*	Change the PROJECT_DIR with your local setup.
*/

$protocol = isset( $_SERVER[ "HTTPS" ] ) && !empty( $_SERVER[ "HTTPS" ] ) ? "https://" : "http://";
$host = $_SERVER[ "HTTP_HOST" ] == "localhost" ? $_SERVER[ "HTTP_HOST" ] . $_SERVER[ "REQUEST_URI" ] : $_SERVER[ "HTTP_HOST" ];
$GLOBALS[ "site_url" ] = $protocol . $host;
$project_dir = $_SERVER[ "DOCUMENT_ROOT" ] ."/Projects/SiteGround-Store-PureStack";
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "site-ground-store-db";
$db_prefix = "str_";
?>
