<?php
$product_id = isset( $_POST[ "product_id" ] ) && !empty( $_POST[ "product_id" ] ) ? intval( $_POST[ "product_id" ] ) : 0;
$response = false;

if ( $product_id > 0 ) {
	$config_file_path = dirname( __FILE__ ) ."/../config.php";
	if ( file_exists( $config_file_path ) ) {
		include $config_file_path;

		$connection_ = new mysqli( $servername, $username, $password, $db_name );

		if ( $connection_->connect_error ) {
			die( "Oops... Something went wrong: " . $connection_->connect_error );
		} else {
			$products_table = $db_prefix ."products";
			$products_prices_table = $db_prefix ."products_prices";
			$products_discounts_table = $db_prefix ."products_discounts";

			// Delete Discounts
			$sql_ = "DELETE FROM $products_discounts_table WHERE product_id=$product_id";
			$result_ = $connection_->query( $sql_ );

			// Delete Prices
			$sql_ = "DELETE FROM $products_prices_table WHERE product_id=$product_id";
			$result_ = $connection_->query( $sql_ );

			// Delete Product
			$sql_ = "DELETE FROM $products_table WHERE id=$product_id";
			$result_ = $connection_->query( $sql_ );

			$response = $product_id;
		}
	}
}

echo json_encode( $response );
die( "" );
?>
