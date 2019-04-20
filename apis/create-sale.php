<?php
$cart = isset( $_POST[ "cart" ] ) && !empty( $_POST[ "cart" ] ) ? $_POST[ "cart" ] : array();
$response = false;

if ( !empty( $cart ) ) {
	$config_file_path = dirname( __FILE__ ) ."/../config.php";
	if ( file_exists( $config_file_path ) ) {
		include $config_file_path;

		$framework_path = $project_dir ."/framework.php";

		if ( file_exists( $framework_path ) ) {
			include $framework_path;

			$connection_ = new mysqli( $servername, $username, $password, $db_name );
			$_STORE = new STORE();

			if ( $connection_->connect_error ) {
				die( "Oops... Something went wrong: " . $connection_->connect_error );
			} else {
				$product_sales_table = $db_prefix ."product_sales";

				foreach ( $cart as $product_id => $sale_info ) {
					$sale_ = new stdClass;
					$sale_->product_id = $product_id;
					$sale_->quantity = $sale_info[ "times" ];
					$sale_->total = $sale_info[ "cost" ];
					$sale_->price_info = $_STORE->get_item_price_info( $product_id );
					$sale_->price_info->quantity = $sale_->price_info->quantity == false ? 0 : $sale_->price_info->quantity;
					$sale_->price_info->quantity_price = $sale_->price_info->quantity_price == false ? 0 : $sale_->price_info->quantity_price;

					// Store to Sales Table
					$sql_ = "
					INSERT INTO $product_sales_table (product_id, quantity, product_price, quantity_discount, quantity_discount_price, total)
					VALUES (". $sale_->product_id .", ". $sale_->quantity .", ". $sale_->price_info->price .", ". $sale_->price_info->quantity .", ". $sale_->price_info->quantity_price .", ". $sale_->total .")
					";
					$result_ = $connection_->query( $sql_ );
					if ( $result_ == true ) {
						$response = true;
					} else { $response == $connection_->error; }
				}
			}
		}
	}
}

echo json_encode( $response );
die( "" );
?>
