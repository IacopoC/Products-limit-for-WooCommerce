<?php

if (! defined('ABSPATH')) {
	exit();
}

/**
 * Create the section beneath the products tab
 **/
add_filter( 'woocommerce_get_sections_products', 'products_lfw_number_field_add_section' );
function products_lfw_number_field_add_section( $sections ) {
	
	$sections['number_field'] = __( 'Min/max products limit', 'products-limit' );
	return $sections;
	
}

/**
 * Add settings to the specific section we created before
 */
add_filter( 'woocommerce_get_settings_products', 'products_lfw_number_field_all_settings', 10, 2 );
function products_lfw_number_field_all_settings( $settings, $current_section ) {
	/**
	 * Check the current section is what we want
	 **/
	if ( $current_section == 'number_field' ) {
		$settings_limit = array();
		// Add Title to the Settings
		$settings_limit[] = array( 'name' => __( 'Products limit', 'products-limit' ), 'type' => 'title', 'desc' => __( 'Setting to set minimum and maximum products quantity', 'products-limit' ), 'id' => 'number_field' );
		
		// Add number field option with minimun number limit
		$settings_limit[] = array(
			'name'     => __( 'Min products', 'products-limit' ),
			'desc_tip' => __( 'Add minimum limit', 'products-limit' ),
			'id'       => 'number_field',
			'type'     => 'number',
			'css'      => 'width:100px;',
			'desc'     => __( 'Add minimum limit of products', 'products-limit' ),
			'custom_attributes' => array(
				'step' 	=> '1',
				'min'	=> '1'
			) 
		);

		// Add checkbox option for minimum limit
		$settings_limit[] = array(
			'name'     => __( 'Enable/disable minimum', 'products-limit' ),
			'desc_tip' => __( 'Check to enable minimum', 'products-limit' ),
			'id'       => 'min_auto_insert',
			'type'     => 'checkbox',
			'desc'     => __( 'Min product option', 'products-limit' ),
		);


		// Add number field option with max number limit
		$settings_limit[] = array(
			'name'     => __( 'Max products', 'products-limit' ),
			'desc_tip' => __( 'Add maximum limit', 'products-limit' ),
			'id'       => 'number_field2',
			'type'     => 'number',
			'css'      => 'width:100px;',
			'desc'     => __( 'Add maximum limit of products', 'products-limit' ),
			'custom_attributes' => array(
				'step' 	=> '1',
				'min' =>'1',
				'max'	=> '100'
			) 
		);


		// Add checkbox option for maximum limit
		$settings_limit[] = array(
			'name'     => __( 'Enable/disable maximum', 'products-limit' ),
			'desc_tip' => __( 'Check to enable maximum', 'products-limit' ),
			'id'       => 'max_auto_insert',
			'type'     => 'checkbox',
			'desc'     => __( 'Max product option', 'products-limit' ),
		);


		// Add checkbox option for custom button "Continue Shopping"
		$settings_limit[] = array(
			'name'     => __( 'Enable/disable custom button', 'products-limit' ),
			'desc_tip' => __( 'Check to enable custom button', 'products-limit' ),
			'id'       => 'button_auto_insert',
			'type'     => 'checkbox',
			'desc'     => __( '"Continue Shopping" button in warning banner', 'products-limit' )
		);


		
		$settings_limit[] = array( 'type' => 'sectionend', 'id' => 'number_field' );
		return $settings_limit;
	
	/**
	 * If not, return the standard settings
	 **/
	} else {
		return $settings;
	}
}
