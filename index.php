<?php
/*
*	Project Info:
*	Title: Online Store Implementation
*	Description:
*	- Create new products
*		- Product Name
*		- Product Price
*		- Product Discount Price a.k.a Get N for $Y
*	- Simple UI from which the user can pick products and live calculation will be presented
*
*	NOTE: Detailed Documentation can be found in the README.md document or in the GitHub repository of the project:
*/

$framework_path = dirname( __FILE__ ) ."/framework.php";
if ( file_exists( $framework_path ) ) {
	require_once $framework_path;

	$_STORE = new STORE();
	$_STORE->get_header();
	$_STORE->get_site();
	$_STORE->get_footer();
} else {
	die( "Oops... Looks like the Framework.php file is missing, which is not good." );
}
?>
