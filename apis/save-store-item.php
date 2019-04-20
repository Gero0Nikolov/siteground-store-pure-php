<?php
$product_id = isset( $_POST[ "product_id" ] ) && !empty( $_POST[ "product_id" ] ) ? intval( $_POST[ "product_id" ] ) : 0;
$name = isset( $_POST[ "name" ] ) && !empty( $_POST[ "name" ] ) ? preg_replace( '/[^A-Za-z0-9_\s]/', "", trim( $_POST[ "name" ] ) ) : "";
$price = isset( $_POST[ "price" ] ) && !empty( $_POST[ "price" ] ) ? floatval( $_POST[ "price" ] ) : 0;
$quantity = isset( $_POST[ "quantity" ] ) && !empty( $_POST[ "quantity" ] ) ? intval( $_POST[ "quantity" ] ) : 0;
$quantity_discount = isset( $_POST[ "quantity_discount" ] ) && !empty( $_POST[ "quantity_discount" ] ) ? floatval( $_POST[ "quantity_discount" ] ) : 0;

$response = false;

if ( !empty( $name ) && strlen( $name ) <= 255 ) {
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

			// Create the product if needed
			if ( $product_id == 0 ) {
				$sql_ = "INSERT INTO $products_table (product_name) VALUES ('$name')";
				$result_ = $connection_->query( $sql_ );

				if ( $result_ == true ) {
					$product_id = $connection_->insert_id;

					// Create the price
					$sql_ = "INSERT INTO $products_prices_table (product_id, product_price) VALUES ($product_id, $price)";
					$result_ = $connection_->query( $sql_ );

					// Create Quantity Discount if needed
					if ( $quantity > 0 && $quantity_discount > 0 ) {
						$sql_ = "INSERT INTO $products_discounts_table (product_id, quantity, product_price) VALUES ($product_id, $quantity, $quantity_discount)";
						$result_ = $connection_->query( $sql_ );
					}

					$response = true;
				} else { $response = $connection_->error; }
			} else { // Update Product Info				
				$sql_ = "UPDATE $products_table SET product_name='$name' WHERE id=$product_id";
				$result_ = $connection_->query( $sql_ );

				$sql_ = "UPDATE $products_prices_table SET product_price=$price WHERE product_id=$product_id";
				$result_ = $connection_->query( $sql_ );

				$sql_ = "UPDATE $products_discounts_table SET quantity=$quantity, product_price=$quantity_discount WHERE product_id=$product_id";
				$result_ = $connection_->query( $sql_ );

				$response = true;
			}
		}
	}
} else { $response = "Give name to this product and make sure it's less than 255 charactes!"; }

echo json_encode( $response );
die( "" );
?>
