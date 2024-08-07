<?php

namespace Kmoconnect\Woocommerce\Base;

defined( 'ABSPATH' ) || exit();

/**
 * Unregister woocommerce actions
 */
\remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
\remove_action( "woocommerce_before_checkout_form", "woocommerce_checkout_coupon_form" );
\remove_action( 'wp_head', 'wc_gallery_noscript' );

/**
 * Disable default Woocommerce CSS
 */
\add_filter( "woocommerce_enqueue_styles", "__return_false" );

function disable_mobile_messaging( $mailer ) {
	\remove_action( "woocommerce_email_footer", [ $mailer->emails["WC_Email_New_Order"], "mobile_messaging" ], 9 );
}

\add_action( "woocommerce_email", __NAMESPACE__ . "\\disable_mobile_messaging" );

/**
 * Update options
 */
function woo_update_options() {
	$options = [
		"thumbnail"  => "woocommerce_thumbnail_image_width",
		"single_img" => "woocommerce_single_image_width"
	];

	if ( ! \get_option( $options["thumbnail"] ) ) {
		update_option( $options["thumbnail"], 600 );
	}

	if ( ! \get_option( $options["single_img"] ) ) {
		update_option( $options["single_img"], 600 );
	}
}

\add_action( "init", __NAMESPACE__ . "\\woo_update_options" );

function woocommerce_body_class( $classes ) {
	if ( \is_shop() ) {
		$classes[] = 'woocommerce-shop';
	}

	if ( \is_product_category() ) {
		$classes[] = 'woocommerce-category';
	}

	if ( \is_product() ) {
		$classes[] = 'woocommerce-single-product';
	}

	if ( \is_woocommerce() ) {
		$classes[] = 'woocommerce';
		$classes[] = 'woocommerce-page';
	} elseif ( \is_checkout() ) {
		$classes[] = 'woocommerce-checkout';
		$classes[] = 'woocommerce-page';
	} elseif ( \is_cart() ) {
		$classes[] = 'woocommerce-cart';
		$classes[] = 'woocommerce-page';
	} elseif ( \is_account_page() ) {
		$classes[] = 'woocommerce-account';
		$classes[] = 'woocommerce-page';
	}

	return $classes;
}

\add_filter( "body_class", __NAMESPACE__ . "\\woocommerce_body_class" );

// change class postcode, city
function custom_woocommerce_default_address_fields( $fields ) {
	$fields['address_1']['class'][0]    = 'form-row-first';
	$fields['address_1']['placeholder'] = '';
	$fields['address_2']['class'][0]    = 'form-row form-row-last';
	$fields['address_2']['label_class'] = '';
	$fields['address_2']['placeholder'] = '';

	$fields['postcode']['class'][0] = 'form-row-first';
	$fields['city']['class'][0]     = 'form-row-last';

	return $fields;
}

\add_filter( "woocommerce_default_address_fields", __NAMESPACE__ . "\\custom_woocommerce_default_address_fields", 11, 1 );

function checkout_fields( $fields ) {
	// change priority
	$fields['billing']['billing_phone']['priority']   = 30;
	$fields['billing']['billing_email']['priority']   = 40;
	$fields['billing']['billing_country']['priority'] = 80;

	// change class
	$fields['billing']['billing_phone']['class'] = [ 'form-row-first' ];
	$fields['billing']['billing_email']['class'] = [ 'form-row-last' ];

	return $fields;
}

\add_filter( "woocommerce_checkout_fields", __NAMESPACE__ . "\\checkout_fields", 11, 1 );

/**
 * Shop navbar
 */
function shop_navbar() {
	\get_template_part( "template-parts/woocommerce/lay-out/shop-bar" );
}

\add_action( "stw_navbar_end", __NAMESPACE__ . "\\shop_navbar" );

/**
 * Start div wrapper woocommerce main
 */
function start_wrap_main_content() {
	$class  = \apply_filters( "stw_shop_css_class", [] );
	$markup = '<div class="' . esc_attr( implode( " ", array_merge( [ "shop" ], $class ) ) ) . '">';
	$markup .= '<div class="container">';
	$markup .= '<div class="shop__wrapper">';
	echo $markup;
}

\add_action( "woocommerce_before_main_content", __NAMESPACE__ . "\\start_wrap_main_content", 1 );

/**
 * Start div wrapper woocommerce main
 */
function end_wrap_main_content() {
	$markup = '</div>';
	$markup .= '</div>';
	$markup .= '</div>';
	echo $markup;
}

\add_action( "woocommerce_after_main_content", __NAMESPACE__ . "\\end_wrap_main_content", 20 );

function woocommerce_sidebar() {
	if ( is_product() ) {
		return;
	}

	get_sidebar( "shop" );
}

\remove_action( "woocommerce_sidebar", "woocommerce_get_sidebar", 10 );
\add_action( "woocommerce_before_main_content", __NAMESPACE__ . "\\woocommerce_sidebar", 1 );

/**
 * Extra CSS class on shop div
 * Styling main shop with sidebar
 */
\add_filter( "stw_shop_css_class", function ( array $class ) {
	if ( is_active_sidebar( "shop_sidebar_1" ) ) {
		return $class = [ "shop--sidebar" ];
	}

	return $class;
} );

\add_action( "woocommerce_before_quantity_input_field", function () {
	get_template_part( "template-parts/woocommerce/lay-out/quantity-minus" );
} );

\add_action( "woocommerce_after_quantity_input_field", function () {
	get_template_part( "template-parts/woocommerce/lay-out/quantity-plus" );
} );

/**
 * Hide title tabs
 * Description, Additional information
 */
\add_filter( "woocommerce_product_additional_information_heading", "__return_false" );
\add_filter( "woocommerce_product_description_heading", "__return_false" );

/**
 * Order by translations
 */
function customize_orderby( array $options ) {
	$options["popularity"] = __( "Popularity", "kmoconnect" );
	$options["date"]       = __( "Latest", "kmoconnect" );
	$options["price"]      = __( "Price low - high", "kmoconnect" );
	$options["price-desc"] = __( "Price high - low", "kmoconnect" );
	$options["rating"]     = __( "Average rating", "kmoconnect" );

	return $options;
}

\add_filter( "woocommerce_catalog_orderby", __NAMESPACE__ . "\\customize_orderby" );

function add_grouped_thumbnail( $product ) {
	$image_size    = [ 120, 120 ];
	$attachment_id = get_post_meta( $product->get_id(), '_thumbnail_id', true );
	$link          = get_the_permalink( $product->get_id() );
	?>
    <td class="label">
        <a href="<?php echo $link; ?>"> <?php echo wp_get_attachment_image( $attachment_id, $image_size ); ?> </a>
    </td>
	<?php
}

\add_action( "woocommerce_grouped_product_list_before_quantity", __NAMESPACE__ . "\\add_grouped_thumbnail" );
