<?php
/*
Plugin Name: Products limit for Woocommerce
Plugin URI: http://iacopocutino.it/products-limit-for-woocommerce/
Description: Allow to set minimum and maximum quantity of products in Woocommerce and display a warning banner in the cart or checkout page.
Author: Iacopo Cutino
Version: 1.0.5
Domain Path: /languages
Author URI: www.iacopocutino.it
License: GPL2

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (! defined('ABSPATH')) {
	exit();
}

/**
 * Languages support
 **/
function products_lfw_language() {
	load_plugin_textdomain('products-limit', false, dirname( plugin_basename( __FILE__ )) . '/languages/');
}
add_action('init','products_lfw_language');


/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

include 'settings.php';



if (get_option('min_auto_insert') == 'yes')   {

// Function for min product in  check out or cart

add_action( 'woocommerce_check_cart_items', 'products_lfw_set_min_num_products' );
function products_lfw_set_min_num_products() {
	// Only run in the Cart or Checkout pages
	if( is_cart() || is_checkout() ) {
		global $woocommerce, $post;

		
		$minimum_num_products = get_option( 'number_field' );

		
		$cart_num_products = WC()->cart->cart_contents_count;

		//variable that contain the shop permalink for the button in the warning banner
	    $return_to  = get_permalink(woocommerce_get_page_id('shop'));
		

	    // Compare values and add an error is Cart's total number of products
	    // happens to be less than the minimum required before checking out.

		if( $cart_num_products < $minimum_num_products ) {
			
			// If the checkbox for button is enabled add the shop button to the warning message in chart or checkout page
			// Display our error message

			if(get_option('button_auto_insert') == 'yes') {

	        wc_add_notice( sprintf(__( 'A Minimum of %s products is required before checking out. Current number of items in the cart: %s. <a href="%s" class="button wc-forwards">Continue Shopping</a>', 'products-limit'),
	        	$minimum_num_products,
	        	$cart_num_products, $return_to ),
	        'error' );

	    } else {

	    	wc_add_notice( sprintf(__( 'A Minimum of %s products is required before checking out. Current number of items in the cart: %s.', 'products-limit'),
	        	$minimum_num_products,
	        	$cart_num_products ),
	        'error' );	

	    }

	    }


		}

	}
}





if (get_option('max_auto_insert') == 'yes')   {

// Function for max products in  check out or cart

add_action( 'woocommerce_check_cart_items', 'products_lfw_set_max_num_products' );
function products_lfw_set_max_num_products() { 

if( is_cart() || is_checkout() ) {
		global $woocommerce, $post;

		//variable that contain the shop permalink for the button in the warning banner
		$return_to  = get_permalink(woocommerce_get_page_id('shop'));

		$max_num_products = get_option( 'number_field2' );

		$cart_num_products = WC()->cart->cart_contents_count;

		//if items exceed the maximum number set in the admin panel 

		if( $cart_num_products > $max_num_products ) {

			// If the checkbox for button is enabled add the shop button to the warning message in chart or checkout page
			// Display our error message

			if(get_option('button_auto_insert') == 'yes') {

	        wc_add_notice( sprintf(__( '<strong>A Maximum of %s products is allowed before checking out.</strong> Current number of items in the cart: %s. <a href="%s" class="button wc-forwards">Continue Shopping</a>', 'products-limit'),
	        	$max_num_products,
	        	$cart_num_products, $return_to ),
	        'error' );
	    
	    } else {

	    	wc_add_notice( sprintf(__( '<strong>A Maximum of %s products is allowed before checking out.</strong> Current number of items in the cart: %s.', 'products-limit'),
	        	$max_num_products,
	        	$cart_num_products ),
	        'error' );
	    
	    }

		}

	}
}

}

}