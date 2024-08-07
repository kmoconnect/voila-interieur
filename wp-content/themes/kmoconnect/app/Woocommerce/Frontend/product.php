<?php

namespace Kmoconnect\Woocommerce\Frontend\Product;

defined( 'ABSPATH' ) || exit();

/**
 * Single Product
 * Hooks and filters
 */
//\remove_action( "woocommerce_single_product_summary", "woocommerce_template_single_meta", 40 );

/**
 * Single product - meta
 */
//\add_action( "woocommerce_single_product_summary", "woocommerce_template_single_meta", 6 );

/**
 * Previous button to shop page
 */
function single_product_previous_link_to_shop_page() {
	$args = [
		"desc"            => __( "Back to shop", "kmoconnect" ),
		"container_class" => []
	];

	\get_template_part( "template-parts/components/lay-out/back-link", null, $args );
}
\add_filter( "woocommerce_before_single_product", __NAMESPACE__ . '\\single_product_previous_link_to_shop_page' );

/**
 * Single product - gallery thumbnail size
 */
function gallery_thumbnail_size( array $sizes ) {
	return [ 300, 300 ];
}

\add_filter( 'woocommerce_gallery_thumbnail_size', __NAMESPACE__ . '\\gallery_thumbnail_size' );

/**
 * Single product
 * USP's on page
 */
function single_product_usps() {
	\get_template_part( "template-parts/lay-out/usp-product-page-462" );
}

\add_action( "woocommerce_single_product_summary", __NAMESPACE__ . "\\single_product_usps", 50 );

/**
 * Single product
 * Tabs, accordion
 */
function single_product_tabs() {
	$supports = get_theme_support( 'stw-wc-single-product' );
	$defaults = [
		"accordions" => false,
		"tabs"       => true
	];

	if ( is_array( $supports ) ) {
		$defaults = wp_parse_args( $supports[0], $defaults );
	}

	foreach ( array_keys( array_filter( $defaults ) ) as $key ) {
		get_template_part( "template-parts/woocommerce/single-product/{$key}" );
	}
}

\remove_action( "woocommerce_after_single_product_summary", "woocommerce_output_product_data_tabs", 10 );
\add_action( "woocommerce_single_product_summary", __NAMESPACE__ . "\\single_product_tabs", 60 );

/**
 * Rename product tab title: "Description"
 * Dutch is translating: "Beschrijving"
 * Is better: "Omschrijving"
 */
function customize_tab_title_description( $title ) {
	return __( "Description", "kmoconnect" );
}

\add_filter( "woocommerce_product_description_tab_title", __NAMESPACE__ . "\\customize_tab_title_description" );

/**
 * Rename product tab title: "Description"
 * Dutch is translating: "Beschrijving"
 * Is better: "Omschrijving"
 */
function customize_tab_title_extra_information( $title ) {
	return __( "Product details", "kmoconnect" );
}

\add_filter( "woocommerce_product_additional_information_tab_title", __NAMESPACE__ . "\\customize_tab_title_extra_information" );

/**
 * Product gallery thumbnail sizes
 */
function gallery_thumbnail_sizes( array $dimensions ) {

	$dimensions[0] = 150;
	$dimensions[1] = 150;

	return $dimensions;
}

//\add_filter( "woocommerce_gallery_thumbnail_size", __NAMESPACE__ . "\\gallery_thumbnail_sizes" );

/**
 * Open external new tab
 * Single external product
 */
function woocommerce_external_add_to_cart(): void {
	global $product;
	if ( ! $product->add_to_cart_url() ) {
		return;
	}
	echo '<p><a href="' . $product->add_to_cart_url() . '" class="single_add_to_cart_button button alt" target="_blank">' . $product->single_add_to_cart_text() . '</a></p>';
}

\remove_action( "woocommerce_external_add_to_cart", "woocommerce_external_add_to_cart", 30 ); // re-hook
\add_action( "woocommerce_external_add_to_cart", __NAMESPACE__ . "\\woocommerce_external_add_to_cart", 30 );

/**
 * Start wrapper single product: row
 */
function start_wrapper_single_product_row() {
	echo '<div class="product__row">';
}

\add_action(
	'woocommerce_before_single_product_summary',
	__NAMESPACE__ . '\\start_wrapper_single_product_row',
	1
);

/**
 * Start wrapper single product: left column
 */
function start_wrapper_single_product_left() {
	echo '<div class="product__left">';
}

\add_action(
	'woocommerce_before_single_product_summary',
	__NAMESPACE__ . '\\start_wrapper_single_product_left',
	8
);

/**
 * End wrapper single product: left column
 */
function end_wrapper_single_product_left() {
	echo '</div>';
}

\add_action(
	'woocommerce_before_single_product_summary',
	__NAMESPACE__ . "\\end_wrapper_single_product_left",
	30
);

/**
 * Start wrapper single product: right column
 */
function start_wrapper_single_product_right() {
	echo '<div class="product__right">';
}

\add_action(
	'woocommerce_before_single_product_summary',
	__NAMESPACE__ . '\\start_wrapper_single_product_right',
	31
);

/**
 * End wrapper single product: right column
 */
function end_wrapper_single_product_right() {
	echo '</div>';
}

\add_action(
	'woocommerce_after_single_product_summary',
	__NAMESPACE__ . "\\end_wrapper_single_product_right",
	11
);

/**
 * End wrapper single product: row
 */
function end_wrapper_single_product_row() {
	echo '</div>';
}

\add_action(
	'woocommerce_after_single_product_summary',
	__NAMESPACE__ . "\\end_wrapper_single_product_row",
	12
);

/**
 * Start wrap add_to_cart
 */
function start_wrap_before_add_to_cart() {
	echo '<div class="product__add-to-cart">';
}

\add_action(
	'woocommerce_before_add_to_cart_button',
	__NAMESPACE__ . '\\start_wrap_before_add_to_cart'
);

function end_wrap_before_add_to_cart() {
	echo '</div>';
}

\add_action(
	'woocommerce_after_add_to_cart_button',
	__NAMESPACE__ . "\\end_wrap_before_add_to_cart"
);

/**
 * Single product CSS class
 */
function woocommerce_post_class( array $classes, $product ) {
	if ( $product->get_gallery_image_ids() ) {
		$classes[] = 'woocommerce-have-thumbnails';
	}

	return $classes;
}
\add_filter( "woocommerce_post_class", __NAMESPACE__ . "\\woocommerce_post_class", 10, 2 );