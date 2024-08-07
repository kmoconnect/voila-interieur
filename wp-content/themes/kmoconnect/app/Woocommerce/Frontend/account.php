<?php

namespace Kmoconnect\Woocommerce\Frontend\Account;

defined( 'ABSPATH' ) || exit();

/**
 * Account
 * Hooks and filters
 */

function start_wrap_my_account() {
	$markup = '<div class="woocommerce__wrapper">';
	echo $markup;
}

\add_action( "woocommerce_before_account_navigation", __NAMESPACE__ . "\\start_wrap_my_account" );

function end_wrap_my_account() {
	$markup = '</div>';
	echo $markup;
}

\add_action( "woocommerce_account_content", __NAMESPACE__ . "\\end_wrap_my_account" );


/**
 * My account / Login
 */
function start_login_wrap() {
	$class = [ "woocommerce-login__wrapper" ];
	if ( get_option( 'woocommerce_enable_myaccount_registration' ) ) {
		$class[] = "woocommerce-login__wrapper--flex";
	}
	$markup = '<div class="' . esc_attr( implode( " ", $class ) ) . '">';
	echo $markup;
}

\add_action( "woocommerce_before_customer_login_form", __NAMESPACE__ . "\\start_login_wrap" );

function start_login_login_wrap() {
	if ( get_option( 'woocommerce_enable_myaccount_registration' ) ) {
		$markup = '<div class="woocommerce-login__form">';
	}
	echo $markup;
}

\add_action( "woocommerce_before_customer_login_form", __NAMESPACE__ . "\\start_login_login_wrap" );

function end_login_wrap() {
	$markup = '</div>';

	echo $markup;
}

\add_action( "woocommerce_after_customer_login_form", __NAMESPACE__ . "\\end_login_wrap" );

function start_login_registration_wrap() {
	if ( get_option( 'woocommerce_enable_myaccount_registration' ) ) {
		get_template_part( "template-parts/woocommerce/my-account/registration-left" );
	}
}

\add_action( "woocommerce_after_customer_login_form", __NAMESPACE__ . "\\start_login_registration_wrap" );

function end_login_login_wrap() {
	$markup = '</div>';

	echo $markup;
}

\add_action( "woocommerce_after_customer_login_form", __NAMESPACE__ . "\\end_login_login_wrap" );

function customize_my_account_menu_items( array $items ) {
	unset( $items["downloads"] );

	return $items;
}

\add_filter( "woocommerce_account_menu_items", __NAMESPACE__ . "\\customize_my_account_menu_items" );