<?php

namespace Kmoconnect\Hooks;

defined( 'ABSPATH' ) || exit;

/**
 * Ajax
 */

//function example_callback() {
//	if ( ! isset( $_POST['_ajax_nonce'] ) ) {
//		wp_send_json_error( 'Invalid ajax nonce!', 401 );
//		wp_die();
//	}
//
//	/* Verify first the ajax nonce for security */
//	if ( ! wp_verify_nonce( $_POST['_ajax_nonce'], '_ajax_nonce' ) ) {
//		wp_send_json_error( 'Invalid ajax nonce!', 401 );
//		wp_die();
//	}
//
//	wp_die();
//}
//\add_action( "wp_ajax_example_callback", __NAMESPACE__ . "\\example_callback" );
//\add_action( "wp_ajax_nopriv_example_callback", __NAMESPACE__ . "\\example_callback" );
