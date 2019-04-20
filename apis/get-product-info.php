<?php
$product_id = isset( $_POST[ "product_id" ] ) && !empty( $_POST[ "product_id" ] ) ? intval( $_POST[ "product_id" ] ) : 0;
$response = false;

if ( $product_id > 0 ) {
	$config_file_path = dirname( __FILE__ ) ."/../config.php";
	if ( file_exists( $config_file_path ) ) {
		include $config_file_path;

		$framework_path = $project_dir ."/framework.php";

		if ( file_exists( $framework_path ) ) {
			include $framework_path;

			$connection_ = new mysqli( $servername, $username, $password, $db_name );

			if ( $connection_->connect_error ) {
				die( "Oops... Something went wrong: " . $connection_->connect_error );
			} else {
				$response = array();
				$_STORE = new STORE();

				$products_table = $db_prefix ."products";
				$sql_ = "SELECT * FROM $products_table WHERE id=$product_id LIMIT 1";
				$results_ = $connection_->query( $sql_ );
				if ( $results_->num_rows > 0 ) {
					while ( $row = $results_->fetch_assoc() ) {
						$item_ = new stdClass;
						$item_->id = $row[ "id" ];
						$item_->product_name = $row[ "product_name" ];
						$item_->date_created = $row[ "date_created" ];
						$item_->price_info = $_STORE->get_item_price_info( $item_->id );
						$response = $item_;
					}
				}
			}
		}
	}
}

echo json_encode( $response );
die( "" );
?>
