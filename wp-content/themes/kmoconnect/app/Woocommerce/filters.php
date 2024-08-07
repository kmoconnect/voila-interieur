<?php

namespace Kmoconnect\Woocommerce\Filters;

// functions.php
function block_wrapper( $block_content, $block ) {

	if ( $block['blockName'] === 'woocommerce/customer-account' ) {
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 448 512"><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg>';

		return preg_replace( '/(<svg .*?\/svg\>)/s', $svg, $block_content );

	}

	if ( $block['blockName'] === 'core/search' ) {
		$svg = '<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>';

		return preg_replace( '/(<svg .*?\/svg\>)/s', $svg, $block_content );

	}

	if ( $block['blockName'] === 'woocommerce/mini-cart-shopping-button-block' ) {
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 256 256"><g fill="none" stroke-width="16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="m 64,80 h 128 c 16,0 29.33333,16 32,32 l 16,96 c 2.66807,16.00842 -16,32 -32,32 H 48 C 32,240 13.33193,224.00842 16,208 L 32,112 C 34.666667,96 48,80 64,80 Z"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M 80,112 V 63.814079"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="m 176,64 v 48"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M 19.090159,191.31828 H 236.90984"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M 176,64 C 176,48 166.70076,30.94703 151.90703,22.405869 137.1133,13.86471 118.88668,13.86471 104.09296,22.40587 89.299233,30.947031 80.000002,48 80,64"/><rect width="80" height="16" x="16" y="240"/></g></svg>';

		return preg_replace( '/(<svg .*?\/svg\>)/s', $svg, $block_content );
	}

	return $block_content;
}

\add_filter( 'render_block', __NAMESPACE__ . '\\block_wrapper', 10, 2 );

function add_cart_product_image( $product_name, $cart_item, $cart_item_key ) {
	$image = '';
	if ( is_checkout() && ! is_wc_endpoint_url( 'order-received' ) ) {

		// Get product object.
		$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

		// Get product thumbnail.
		$thumbnail = $_product->get_image();

		// Add wrapper to image and add some css.
		$image = '<div class="cart-item__img">' . $thumbnail . ' </div>';
	}

	return '<div class="cart-item__wrap"> ' . $image . ' <div class="cart-item__name">' . $product_name . '</div></div>';
}

\add_filter( "woocommerce_cart_item_name", __NAMESPACE__ . "\\add_cart_product_image", 10, 3 );

function customize_msg_order_received( $text ) {
	return __( "Thank you for your order!", "kmoconnect" );
}

\add_filter( "woocommerce_thankyou_order_received_text", __NAMESPACE__ . "\\customize_msg_order_received" );

/**
 * E-mails
 */
function email_footer_text( $text ) {
	return "";
}

\add_filter( "woocommerce_email_footer_text", __NAMESPACE__ . "\\email_footer_text" );
\add_filter( "woocommerce_email_additional_content_new_order", __NAMESPACE__ . "\\email_footer_text" );

/**
 * E-mail default settings
 */
function email_settings( array $settings ) {
//	foreach ( $settings as $setting ) {
//		if ( $setting["id"] === "woocommerce_email_background_color" ) {
//			$setting["default"] = get_option( "webvision-theme--colors" )["primary-color"];
//		}
//	}

	return $settings;
}

\add_filter( "woocommerce_email_settings", __NAMESPACE__ . "\\email_settings" );

function relate_products_heading( $title ) {
	return __( "You might also like this...", "kmoconnect" );
}

\add_filter( "woocommerce_product_related_products_heading", __NAMESPACE__ . "\\relate_products_heading" );

\add_filter( "woocommerce_single_product_carousel_options", function ( $options ) {
	$options['sync'] = "carousel";

	return $options;
} );

\add_filter( "wpc_brand_filter_entities", function ( array $tax ) {
	$tax[] = "stw_woo_brands";

	return $tax;
} );


\add_filter( 'wpc_filters_label_term_html', function ( $html, $link_attributes, $term, $filter ) {
	if ( $filter["e_name"] !== "stw_woo_brands" ) {
		return $html;
	}

	$attachment_id    = get_term_meta( $term->term_id, 'thumbnail_id', true );
	$attachment_props = wp_get_attachment_image_src( $attachment_id, 'medium' );
	$src              = isset( $attachment_props[0] ) ? $attachment_props[0] : false;

	if ( $src ) {
		$img       = '<span class="wpc-term-image-wrapper"><span class="wpc-term-image-container" style="background-image: url(' . $src . ')"></span></span>';
		$term_name = '<span class="wpc-term-name">' . $term->name . '</span>';
		$html      = '<a ' . $link_attributes . '>' . $img . ' ' . $term_name . '</a>';
	}

	return $html;
}, 10, 4 );

/**
 * Change the breadcrumb separator
 */
function wcc_change_breadcrumb_delimiter( $defaults ) {
	$defaults['delimiter'] = '<span class="woocommerce-breadcrumb__seperator"><i class="fa-solid fa-chevron-right"></i></span>';
	$defaults['home']      = __( 'Shop', 'kmoconnect' );

	return $defaults;
}
\add_filter( 'woocommerce_breadcrumb_defaults', __NAMESPACE__ . '\\wcc_change_breadcrumb_delimiter' );

function woo_custom_breadrumb_home_url() {
	return get_permalink( wc_get_page_id( 'shop' ) );
}
\add_filter( 'woocommerce_breadcrumb_home_url', __NAMESPACE__ . '\\woo_custom_breadrumb_home_url' );