<?php
/*
Plugin Name: Yubinbango for WP-Members
Plugin URI: https://github.com/ko31/yubinbango-for-wp-members
Description: This is a plugin for WP-Members, to convert an address from a zip code.
Author: Ko Takagi
Version: 0.9
Author URI: https://go-sign.info
*/

register_activation_hook( __FILE__, function() {
	if ( ! defined( 'WPMEM_VERSION' ) ) {
		deactivate_plugins( __FILE__ );
		exit( __( 'Sorry, WP-Members is not installed.', 'yb4wpmem' ) );
	}
} );

add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_script( 'yubinbango', plugin_dir_url( __FILE__ ) . 'js/yubinbango.js' );
} );

add_filter( 'wpmem_register_form_rows', function ( $rows, $tag ) {
	if ( 'new' == $tag ) {
		$rows['user_zip']['field'] = str_replace(
			"textbox",
			"textbox p-postal-code",
			$rows['user_zip']['field']
		);
		$rows['user_address']['field'] = str_replace(
			"textbox",
			"textbox p-region p-locality p-street-address p-extended-address",
			$rows['user_address']['field']
		);
	}

	return $rows;
} , 10, 2 );


add_filter( 'wpmem_register_form', function ( $form, $toggle, $rows, $hidden ) {

	if ( 'new' == $toggle ) {
		$form = str_replace(
			'class="form"',
			'class="form h-adr"',
			$form
		);
		$form = str_replace(
			'</form>',
			'<span class="p-country-name" style="display:none;">Japan</span></form>',
			$form
		);
	}

	return $form;
} , 10, 4 );
