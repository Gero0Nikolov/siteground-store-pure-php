var loader = "<span id='loader' class='loader'>Loading...</span>";

jQuery( document ).ready( function(){
	if ( jQuery( "#main-screen" ).length > 0 ) {
		jQuery( "#main-screen #actions .button" ).each( function(){
			jQuery( this ).on( "click", function(){
				screen = jQuery( this ).attr( "id" ).split( "-side" )[ 0 ];
				jQuery( "#main-screen" ).addClass( "hidden" );
				jQuery( "#"+ screen +"-screen" ).removeClass( "hidden" );
			} );
		} );
	}

	if ( jQuery( "#admin-screen" ).length > 0 ) {
		jQuery( "#admin-screen #back-button" ).on( "click", function(){
			jQuery( "#admin-screen" ).addClass( "hidden" );
			screen = jQuery( this ).attr( "screen" );
			jQuery( "#"+ screen +"-screen" ).removeClass( "hidden" );
		} );

		// Add Item Action
		jQuery( "#admin-screen #actions #add-item" ).on( "click", function(){
			open_composer();
		} );

		// Get Store List
		get_store_items( "#admin-screen #items-list", function( response ){
			if ( response !== undefined ) {
				result_ = JSON.parse( response );
				if ( result_.length > 0 ) {
					jQuery( "#admin-screen #items-list #loader" ).remove();

					for ( key in result_ ) {
						product = result_[ key ];

						view_ = "\
						<div id='product-"+ product.id +"' class='product-row'>\
							<div class='row'>\
								<div class='col name'>"+ product.product_name +"</div>\
								<div class='col actions'>\
									<button id='edit-"+ product.id +"' class='button edit'>Edit</button>\
									<button id='remove-"+ product.id +"' class='button close'>Remove</button>\
								</div>\
							</div>\
							<div class='row'>\
								<div class='col price'>Price: "+ product.price_info.price +"</div>\
								<div class='col date'>Created on: "+ product.date_created +"</div>\
							</div>\
							<div class='row'>\
								<div class='col quantity'>Quantity: "+ product.price_info.quantity +"</div>\
								<div class='col quantity-discount'>Quantity discount: "+ product.price_info.quantity_price +"</div>\
							</div>\
						</div>\
						";
						jQuery( "#admin-screen #items-list" ).append( view_ );

						// Remove Action
						jQuery( "#product-"+ product.id +" #remove-"+ product.id ).on( "click", function(){
							product_id = jQuery( this ).attr( "id" ).split( "remove-" )[ 1 ];

							jQuery.ajax( {
								url : site_url +"apis/remove-store-item.php",
								type : "POST",
								data : {
									product_id : product_id
								},
								success : function( response ) {
									if ( response !== undefined ) {
										result_ = JSON.parse( response );
										if ( result_ != false ) {
											jQuery( "#admin-screen #product-"+ result_ ).remove();
										}
									}
								},
								error : function( response ) {
									console.log( response );
								}
							} );
						} );

						// Edit Action
						jQuery( "#product-"+ product.id +" #edit-"+ product.id ).on( "click", function(){
							product_id = jQuery( this ).attr( "id" ).split( "edit-" )[ 1 ];
							open_composer( product_id );
						} );
					}
				} else {
					view = "<h3 class='empty-message'>You don\'t have any items at the moment :(</h3><button id='add-item' class='button add'>Add new</button>";
					jQuery( "#admin-screen #items-list" ).html( view );

					jQuery( "#admin-screen #items-list #add-item" ).on( "click", function(){
						jQuery( "#admin-screen #actions #add-item" ).trigger( "click" );
					} );
				}
			}
		}, function( response ){
			console.log( response );
		} );
	}

	if ( jQuery( "#user-screen" ).length > 0 ) {
		jQuery( "#user-screen #back-button" ).on( "click", function(){
			jQuery( "#user-screen" ).addClass( "hidden" );
			screen = jQuery( this ).attr( "screen" );
			jQuery( "#"+ screen +"-screen" ).removeClass( "hidden" );
		} );

		// Get Store List
		get_store_items( "#user-screen #items-list", function( response ){
			if ( response !== undefined ) {
				result_ = JSON.parse( response );

				if ( result_.length > 0 ) {
					jQuery( "#user-screen #items-list #loader" ).remove();

					for ( key in result_ ) {
						product = result_[ key ];
						product.price_info.price = parseFloat( product.price_info.price );
						product.price_info.quantity = product.price_info.quantity != false ? parseInt( product.price_info.quantity ) : false;
						product.price_info.quantity_price = product.price_info.quantity_price != false ? parseFloat( product.price_info.quantity_price ) : false;

						items[ product.id ] = product;

						view_ = "\
						<div id='product-"+ product.id +"' class='product-row'>\
							<div class='row'>\
								<div class='col name'>"+ product.product_name +"</div>\
								<div class='col actions'>\
									<button id='add-"+ product.id +"' class='button add'>Add to cart</button>\
								</div>\
							</div>\
							<div class='row'>\
								<div class='col price'>Price: "+ product.price_info.price +"</div>\
							</div>\
							<div class='row'>\
								<div class='col quantity'>Quantity: "+ product.price_info.quantity +"</div>\
								<div class='col quantity-discount'>Quantity discount: "+ product.price_info.quantity_price +"</div>\
							</div>\
						</div>\
						";
						jQuery( "#user-screen #items-list" ).append( view_ );

						jQuery( "#product-"+ product.id +" #add-"+ product.id ).on( "click", function(){
							product_id = jQuery( this ).attr( "id" ).split( "add-" )[ 1 ];

							// Add to Cart
							if ( typeof( cart[ product_id ] ) === "undefined" ) {
								cart[ product_id ] = {
									cost : 0,
									times : 1
								};
							} else {
								cart[ product_id ].times += 1;
							}

							// Create view
							view_ = "\
							<div id='product-"+ product_id +"' class='cart-item'>\
								<div class='name'>"+ items[ product_id ].product_name +"</div>\
								<button id='remove-"+ product_id +"'class='button close'>Remove</button>\
							</div>\
							";

							jQuery( "#user-screen #cart #list" ).append( view_ );

							// Recalculate Total
							total = 0;
							for ( item_id in cart ) {
								cart[ item_id ].cost = 0;
								times_item_in_cart_difference = cart[ item_id ].times;
								for ( count_times = 0; count_times < cart[ item_id ].times; count_times++ ) {
									if (
										items[ item_id ].price_info.quantity != false &&
										items[ item_id ].price_info.quantity_price != false &&
										times_item_in_cart_difference >= items[ item_id ].price_info.quantity
									) {
										cart[ item_id ].cost += items[ item_id ].price_info.quantity_price;
										times_item_in_cart_difference -= items[ item_id ].price_info.quantity;
									} else {
										if ( times_item_in_cart_difference > 0 ) {
											cart[ item_id ].cost += items[ item_id ].price_info.price;
											times_item_in_cart_difference -= 1;
										}
									}
								}
							}


							for ( item_id in cart ) {
								total += cart[ item_id ].cost;
							}
							jQuery( "#cart #total #amount" ).html( total );
						} );
					}
				} else {
					view = "<h3 class='empty-message'>You don\'t have any items at the moment :(</h3>";
					jQuery( "#user-screen #items-list" ).html( view );
				}
			}
		}, function( response ){
			console.log( response );
		} );

		// Buy Button
		jQuery( "#user-screen #cart #buy-button" ).on( "click", function(){
			jQuery.ajax( {
				url : site_url +"apis/create-sale.php",
				type : "POST",
				data : {
					cart : cart
				},
				success : function( response ){
					console.log( response );
					if ( response !== undefined ) {
						result_ = JSON.parse( response );
						if ( result_ == true ) {
							alert( "Thanks for your purchase!" );
							window.location.reload( true );
						} else { console.log( result_ ); }
					}
				},
				error : function( response ){
					console.log( response );
				}
			} );
		} );
	}
} );

function get_store_items( container, onSuccess, onError ) {
	jQuery( container ).html( loader );

	jQuery.ajax( {
		url : site_url +"apis/get-store-items.php",
		type : "POST",
		success : function( response ) {
			onSuccess( response );
		},
		error : function( response ) {
			onError( response );
		}
	} );
}

function open_composer( product_id = 0 ) {
	// Pull Data if needed
	if ( product_id > 0 ) {
		jQuery.ajax( {
			url : site_url +"apis/get-product-info.php",
			type : "POST",
			data : {
				product_id : product_id
			},
			success : function( response ){
				if ( response !== undefined ) {
					result_ = JSON.parse( response );
					if ( result_ != false ) {
						console.log( result_ );
						jQuery( "#popup #product-name" ).val( result_.product_name );
						jQuery( "#popup #product-price" ).val( result_.price_info.price );
						jQuery( "#popup #quantity" ).val( result_.price_info.quantity );
						jQuery( "#popup #quantity-discount" ).val( result_.price_info.quantity_price );
					}
				}
			},
			error : function( response ){
				console.log( response );
			}
		} );
	}

	view = "\
	<div id='popup' class='popup' product_id='"+ product_id +"'>\
		<div id='popup-inner' class='popup-inner'>\
			<button id='close-popup' class='button close'>Close</button>\
			<div id='product-info'>\
				<input id='product-name' type='text' placeholder='Product Name'>\
				<input id='product-price' type='number' placeholder='Product Price'>\
				<input id='quantity' type='number' placeholder='Quantity'>\
				<input id='quantity-discount' type='number' placeholder='Quantity Discount'>\
			</div>\
			<button id='save-product' class='button add'>Save</button>\
		</div>\
	</div>\
	";
	jQuery( "body" ).append( view );

	jQuery( "#popup" ).on( "click", function( e ) {
		if ( e.target == this ) {
			jQuery( this ).remove();
		}
	} );

	jQuery( "#popup #close-popup" ).on( "click", function() {
		jQuery( "#popup" ).remove();
	} );

	//Save Action
	jQuery( "#popup #save-product" ).on( "click", function(){
		if ( jQuery( this ).find( "#loader" ).length == 0 ) {
			jQuery( this ).append( loader );

			args = {
				product_id : jQuery( "#popup" ).attr( "product_id" ),
				name : jQuery( "#popup #product-name" ).val(),
				price : jQuery( "#popup #product-price" ).val(),
				quantity : jQuery( "#popup #quantity" ).val(),
				quantity_discount : jQuery( "#popup #quantity-discount" ).val()
			};

			jQuery.ajax( {
				url : site_url +"apis/save-store-item.php",
				type : "POST",
				data : args,
				success : function( response ){
					jQuery( "#popup #save-product #loader" ).remove();
					if ( response !== undefined ) {
						result_ = JSON.parse( response );
						if ( result_ == true ) {
							alert( "Product is saved!" );
							window.location.reload( true );
						} else {
							alert( result_ );
						}
					}
				},
				error : function( response ){
					console.log( response );
				}
			} );
		}
	} );
}
