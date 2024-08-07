<?php

namespace Kmoconnect\Woocommerce\Frontend\Checkout;

defined( 'ABSPATH' ) || exit();

/**
 * Checkout
 * Hooks and filters
 */

/**
 * Start wrap checkout customer details
 */
function start_wrap_checkout_customer_details() {
	echo '<div class="woocommerce-checkout__customer-wrapper">';
}

\add_action( 'woocommerce_checkout_before_customer_details', __NAMESPACE__ . '\\start_wrap_checkout_customer_details' );

function end_wrap_checkout_customer_details() {
	echo '</div>';
}

\add_action( 'woocommerce_checkout_after_customer_details', __NAMESPACE__ . "\\end_wrap_checkout_customer_details" );

/**
 * Start wrap checkout order details
 */
function start_wrap_checkout_order_details() {
	echo '<div class="order_details">';
}

\add_action( 'woocommerce_checkout_before_order_review_heading', __NAMESPACE__ . '\\start_wrap_checkout_order_details', 20 );

function end_wrap_checkout_order_details() {
	echo '</div>';
}

\add_action( 'woocommerce_checkout_after_order_review', __NAMESPACE__ . "\\end_wrap_checkout_order_details", 20 );

/**
 * Start wrap checkout order detail wrapper
 */
function start_wrap_checkout_order_details_wrapper() {
	echo '<div class="woocommerce-checkout__details-wrapper">';
}

\add_action( 'woocommerce_checkout_before_order_review_heading', __NAMESPACE__ . '\\start_wrap_checkout_order_details_wrapper', 10 );

function end_wrap_checkout_order_details_wrapper() {
	echo '</div>';
}

\add_action( 'woocommerce_checkout_after_order_review', __NAMESPACE__ . "\\end_wrap_checkout_order_details_wrapper", 10 );

\remove_action( "woocommerce_checkout_order_review", "woocommerce_checkout_payment", 20 );

\add_action( "woocommerce_checkout_after_customer_details", function () {
	$markup = '<div class="payment-wrapper">';
	$markup .= '<h3 class="payment-title">' . __( "Pay", "kmoconnect" ) . '</h3>';
	echo $markup;
}, 7 );
\add_action( "woocommerce_checkout_after_customer_details", "woocommerce_checkout_payment", 8 );

\add_action( "woocommerce_checkout_after_customer_details", function () {
	$markup = '</div>';
	echo $markup;
}, 9 );