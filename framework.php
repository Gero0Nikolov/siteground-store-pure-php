<?php

class STORE {
	private $project_dir;
	private $project_url;

	function __construct() {
		if ( file_exists( dirname( __FILE__ ) ."/config.php" ) ) {
			include dirname( __FILE__ ) ."/config.php";
			$this->project_dir = $project_dir;
			$this->project_url = $GLOBALS[ "site_url" ];
		}
	}

	/*
	*	Function Name: get_header
	*	Function Arguments: NONE
	*	Function Purpose: Initialize the Header of the UI.
	*/
	function get_header() {
		if ( file_exists( $this->project_dir ."/header.php" ) ) { require_once $this->project_dir ."/header.php"; }
	}

	/*
	*	Function Name: get_site
	*	Function Arguments: NONE
	*	Function Purpose: Initialize the Page View of the UI.
	*/
	function get_site() {
		if ( file_exists( $this->project_dir ."/site.php" ) ) { require_once $this->project_dir ."/site.php"; }
	}

	/*
	*	Function Name: get_footer
	*	Function Arguments: NONE
	*	Function Purpose: Initialize the Footer of the UI.
	*/
	function get_footer() {
		if ( file_exists( $this->project_dir ."/footer.php" ) ) { require_once $this->project_dir ."/footer.php"; }
	}

	/*
	*	Function Name: get_item_price_info
	*	Function Arguments: $item_id [INT] (required)
	*	Function Purpose: This function will return price and quantity discount information for the given $item_id
	*/
	function get_item_price_info( $item_id ) {
		$item_id = intval( $item_id );
		if ( $item_id > 0 ) {
			if ( file_exists( $this->project_dir ."/config.php" ) ) {
				include $this->project_dir ."/config.php";

				$connection_ = new mysqli( $servername, $username, $password, $db_name );

				if ( $connection_->connect_error ) {
					die( "Oops... Something went wrong: " . $connection_->connect_error );
				} else {
					$products_prices_table = $db_prefix ."products_prices";
					$products_discounts_table = $db_prefix ."products_discounts";

					$product_price_info = new stdClass;

					// Get Product Price
					$sql_ = "SELECT product_price FROM $products_prices_table WHERE product_id=$item_id LIMIT 1";
					$result_ = $connection_->query( $sql_ );
					if ( $result_->num_rows > 0 ) {
						while ( $row = $result_->fetch_assoc() ) {
							$product_price_info->price = $row[ "product_price" ];
						}
					} else { $product_price_info->price = false; }

					// Get Product Discount
					$sql_ = "SELECT quantity, product_price FROM $products_discounts_table WHERE product_id=$item_id LIMIT 1";
					$result_ = $connection_->query( $sql_ );
					if ( $result_->num_rows > 0 ) {
						while ( $row = $result_->fetch_assoc() ) {
							$product_price_info->quantity = $row[ "quantity" ];
							$product_price_info->quantity_price = $row[ "product_price" ];
						}
					} else {
						$product_price_info->quantity = false;
						$product_price_info->quantity_price = false;
					}

					return $product_price_info;
				}
			} else { return false; }
		} else { return false; }
	}
}
?>
