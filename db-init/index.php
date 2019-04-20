<?php
/*
*	Quick DB Init through this simple script.
*/

$config_file_path = dirname( __FILE__ ) ."/../config.php";

if ( file_exists( $config_file_path ) ) {
	require_once $config_file_path;

	$connection_ = new mysqli( $servername, $username, $password, $db_name );

	if ( $connection_->connect_error ) {
	    die( "Oops... Something went wrong: " . $connection_->connect_error );
	} else {
		// Create Products Table if needed
		$products_table = $db_prefix ."products";

		$sql_ = "SHOW TABLES LIKE '$products_table'";
		$results_ = $connection_->query( $sql_ );

		if ( $results_->num_rows == 0 ) {
			$sql_ = "
			CREATE TABLE $products_table (
				id INT NOT NULL AUTO_INCREMENT,
				product_name VARCHAR(255),
				date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (id)
			)
			";
			$result_ = $connection_->query( $sql_ );
			if ( $result_ == true ) {
				$sql_ = "CREATE INDEX product_name ON $products_table (product_name);";
				$result_ = $connection_->query( $sql_ );

				$sql_ = "CREATE INDEX date_created ON $products_table (date_created);";
				$connection_->query( $sql_ );
			}
		}

		// Create Products Prices Table if needed
		$products_prices_table = $db_prefix ."products_prices";

		$sql_ = "SHOW TABLES LIKE '$products_prices_table'";
		$results_ = $connection_->query( $sql_ );

		if ( $results_->num_rows == 0 ) {
			$sql_ = "
			CREATE TABLE $products_prices_table (
				id INT NOT NULL AUTO_INCREMENT,
				product_id INT,
				product_price DECIMAL(11,2),
				PRIMARY KEY (id)
			)
			";
			$result_ = $connection_->query( $sql_ );
			if ( $result_ == true ) {
				$sql_ = "CREATE INDEX product_id ON $products_prices_table (product_id);";
				$result_ = $connection_->query( $sql_ );

				$sql_ = "CREATE INDEX product_price ON $products_prices_table (product_price);";
				$connection_->query( $sql_ );
			}
		}

		// Create Products Discounts Table if needed
		$products_discounts_table = $db_prefix ."products_discounts";

		$sql_ = "SHOW TABLES LIKE '$products_discounts_table'";
		$results_ = $connection_->query( $sql_ );

		if ( $results_->num_rows == 0 ) {
			$sql_ = "
			CREATE TABLE $products_discounts_table (
				id INT NOT NULL AUTO_INCREMENT,
				product_id INT,
				quantity INT,
				product_price DECIMAL(11,2),
				PRIMARY KEY (id)
			)
			";
			$result_ = $connection_->query( $sql_ );
			if ( $result_ == true ) {
				$sql_ = "CREATE INDEX product_id ON $products_discounts_table (product_id);";
				$result_ = $connection_->query( $sql_ );

				$sql_ = "CREATE INDEX product_price ON $products_discounts_table (product_price);";
				$connection_->query( $sql_ );
			}
		}

		// Create Sales Table if needed
		$sales = $db_prefix ."product_sales";

		$sql_ = "SHOW TABLES LIKE '$sales'";
		$results_ = $connection_->query( $sql_ );

		if ( $results_->num_rows == 0 ) {
			$sql_ = "
			CREATE TABLE $sales (
				id INT NOT NULL AUTO_INCREMENT,
				product_id INT,
				quantity INT,
				product_price DECIMAL(11,2),
				quantity_discount INT,
				quantity_discount_price DECIMAL(11,2),
				total DECIMAL(11,2),
				date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (id)
			)
			";
			$result_ = $connection_->query( $sql_ );
			if ( $result_ == true ) {
				$sql_ = "CREATE INDEX product_id ON $products_discounts_table (product_id);";
				$result_ = $connection_->query( $sql_ );

				$sql_ = "CREATE INDEX product_price ON $products_discounts_table (product_price);";
				$connection_->query( $sql_ );
			}
		}
	}
} else {
	die( "Create config.php in the root first!" );
}
?>
