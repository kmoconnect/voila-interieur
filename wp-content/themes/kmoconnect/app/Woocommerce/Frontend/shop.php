<?php

namespace Kmoconnect\Woocommerce\Frontend\Shop;

defined( 'ABSPATH' ) || exit();

/**
 * Shop
 * Hooks and filters
 */
\remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Start shop toolbar wrapper
 * results, orderby and search
 */
function start_wrapper_shop_loop_toolbar() {
	ob_start();
	echo $html = '<div class="woocommerce-toolbar">';
	do_action( "stw_woo_toolbar" );
	echo ob_get_clean();
}

\add_action(
	'woocommerce_before_shop_loop',
	__NAMESPACE__ . '\\start_wrapper_shop_loop_toolbar',
	11
);

/**
 * End shop toolbar wrapper
 */
function end_wrapper_shop_loop_toolbar() {
	echo '</div>';
}

\add_action(
	'woocommerce_before_shop_loop',
	__NAMESPACE__ . "\\end_wrapper_shop_loop_toolbar",
	33
);

function shop_filter_button() {
	\get_template_part( "template-parts/woocommerce/lay-out/shop-filter-button" );
}

\add_action( "stw_woo_toolbar", __NAMESPACE__ . "\\shop_filter_button" );

/**
 * Start wrapper select orderby
 */
function start_wrapper_label_orderby() {
	$html = '<div class="woocommerce-sort">';
	$html .= sprintf( '<p class="woocommerce-sort-label">%s</p>', __( "Order by:", "kmoconnect" ) );

	echo $html;
}

\add_action( "woocommerce_before_shop_loop", __NAMESPACE__ . "\\start_wrapper_label_orderby", 29 );

/**
 * End wrapper select orderby
 */
function end_wrapper_label_orderby() {
	echo '</div>';
}

\add_action( "woocommerce_before_shop_loop", __NAMESPACE__ . "\\end_wrapper_label_orderby", 31 );

function start_wrapper_product_loop_img() {
	$html = '<div class="woocommerce-loop-product__img-wrap">';
	echo $html;
}

\add_action( 'woocommerce_before_shop_loop_item_title', __NAMESPACE__ . '\\start_wrapper_product_loop_img', 9 );

function end_wrapper_product_loop_img() {
	$html = '</div>';
	echo $html;
}

\add_action( 'woocommerce_before_shop_loop_item_title', __NAMESPACE__ . "\\end_wrapper_product_loop_img", 10 );

/**
 * Start wrapper product title en markup plus
 */
function start_wrap_product_loop_details() {
	echo '<div class="woocommerce-loop-product__details">';
}

\add_action(
	'woocommerce_shop_loop_item_title',
	__NAMESPACE__ . '\\start_wrap_product_loop_details',
	7
);

/**
 * Start wrapper product title en markup plus
 */
function end_wrap_product_loop_details() {
	echo '</div>';
}

\add_action(
	'woocommerce_after_shop_loop_item_title',
	__NAMESPACE__ . "\\end_wrap_product_loop_details",
	15
);