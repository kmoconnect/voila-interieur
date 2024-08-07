<?php

namespace Kmoconnect\Helpers;

use Kmoconnect\Classess\Theme;

defined( 'ABSPATH' ) || exit;

function theme(): Theme {
	return Theme::instance();
}

function output_svg( $image = "" ): false|string {

	// image has ID?
	if ( ! filter_var( $image, FILTER_VALIDATE_URL ) && is_numeric( $image ) ) {
		$image = wp_get_attachment_url( $image );
	}

	// check for svg ext
	if ( pathinfo( $image, PATHINFO_EXTENSION ) !== "svg" || empty( $image ) ) {
		return false;
	}

	return file_get_contents( $image );
}

function convert_to_tel_link( $phone_number ): string {
	$phone_number = preg_replace( '/[^0-9]/', '', $phone_number );

	return 'tel:' . $phone_number;
}

/**
 * Returns ID of the page, null if page ID is not found
 *
 * @param $slug
 * @param string $post_type
 *
 * @return mixed|null
 */
function wpml_lang_url( $slug, $post_type = "page" ): mixed {
	$page = \get_page_by_path( $slug );
	if ( $page ) {
		$id = $page->ID;

		return \apply_filters( "wpml_object_id", $id, $post_type, true );
	}

	return null;
}

/**
 * Check if WooCommerce is activated
 */
function is_woocommerce_activated(): bool {
	if ( class_exists( "woocommerce" ) ) {
		return true;
	} else {
		return false;
	}
}