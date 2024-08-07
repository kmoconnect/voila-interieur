<?php

namespace Kmoconnect\Woocommerce\Frontend\Thankyou;

defined( 'ABSPATH' ) || exit();

/**
 * Thank you
 * Hooks and filters
 */

function start_wrap_view_order() {
	echo '<div class="woocommerce-order-details__wrapper">';
}

\add_action( "woocommerce_thankyou", __NAMESPACE__ . "\\start_wrap_view_order", 9 );

function end_wrap_view_order() {
	echo '</div>';
}

\add_action( "woocommerce_thankyou", __NAMESPACE__ . "\\end_wrap_view_order", 11 );