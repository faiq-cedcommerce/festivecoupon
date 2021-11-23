/* global woocommerce_admin */
( function( $, woocommerce_admin ) {
	$( function() {
		if ( 'undefined' === typeof woocommerce_admin ) {
			return;
		}
		$( '#festive_price' ).on( 'change', function() {
			var sale_price_value 		= parseInt($('#_sale_price' ).val());
			var regular_price_value 	= parseInt($('#_regular_price' ).val());
			var festive_price_value		= $('#festive_price').val();
			
			if(festive_price_value >= sale_price_value ){
				alert("Festive Price is not Greator and Equal to Sale Price Value");
				$('#festive_price').val("");
				$('#festive_price').focus();
			}
			if(festive_price_value >= regular_price_value ){
				alert("Festive Price is not Greator and Equal to Regular Price Value");
				$('#festive_price').val("");
				$('#festive_price').focus();
			}
			if(festive_price_value <=0 ){
				alert("Festive Price Cannot less than or equal to Zero");
				$('#festive_price').val("");
				$('#festive_price').focus();
			}
		} );	
	
	});

})( jQuery, woocommerce_admin );
