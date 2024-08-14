<?php

namespace Kmoconnect\Hooks;

use function Kmoconnect\Helpers\output_svg;

defined( 'ABSPATH' ) || exit;

/**
 * Change custom logo html
 */
function customize_logo_html( $html ) {
	// bail if no logo
	$custom_logo_id = get_theme_mod( "custom_logo" );
	if ( ! $custom_logo_id ) {
		return $html;
	}

	// change css class
	$html = str_replace( "custom-logo-link", "navbar-brand", $html );
	$html = str_replace( "custom-logo", "logo", $html );

	// bail if not SVG ext
	if ( empty( output_svg( $custom_logo_id ) ) ) {
		return $html;
	}

	return sprintf(
		'<a href="%1$s" class="navbar-brand" rel="home" itemprop="url">%2$s</a>',
		esc_url( home_url( '/' ) ),
		output_svg( $custom_logo_id )
	);
}

\add_filter( "get_custom_logo", __NAMESPACE__ . "\\customize_logo_html" );

/**
 * Output SVG instead of img tags
 * Using: wp_get_attachment_image()
 */
function customize_img_output( $html, $attachment_id, $size, $icon, $attrs ) {
	$svg_output = output_svg( $attachment_id );

	// bail if not SVG ext
	if ( empty( $svg_output ) ) {
		return $html;
	}

	// If the class attribute exists in $attrs, extract it
	$class_attribute = '';
	if ( ! empty( $attrs['class'] ) ) {
		$class_attribute = ' class="' . esc_attr( $attrs['class'] ) . '"';
	}

	// Add the class to the SVG output
	$svg_output_with_class = preg_replace( '/<svg/', '<svg' . $class_attribute, $svg_output, 1 );

	// remove img tag in html string and replace with modified SVG output
	return preg_replace( '/<img[^>]+>/', $svg_output_with_class, $html );
}

\add_filter( "wp_get_attachment_image", __NAMESPACE__ . "\\customize_img_output", 10, 5 );

/**
 * Add conditional header classes
 */
function header_class( array $class ) {

	if ( ! function_exists( "get_field" ) ) {
		return $class;
	}

	$id = \get_queried_object_id();

	if ( \is_archive() ) {
		$post_type = \get_post_type();
		$id        = "{$post_type}-archive-options";
	}

	$header = \get_field( "header_style", $id );

	if ( ! $header ) {
		return $class;
	}

	$class[] = "header--{$header}";

	return $class;
}
\add_filter( "stw_header_class", __NAMESPACE__ . "\\header_class" );

function space_element_before_navbar() {
	$header_classes = esc_attr( implode( " ", apply_filters( "stw_header_class", [ "header" ] ) ) );
	if ( str_contains( $header_classes, 'header--fixed' ) ) {
		echo '<div class="header__spacer" aria-hidden="true"></div>';
	}
}

\add_action( "stw_header_before", __NAMESPACE__ . "\\space_element_before_navbar" );

function add_acf_page_settings_css_class( $classes ) {

	if ( is_singular( "projects" ) ) {
		$classes[] = "page-small-container";
	}

	// bail ACF not exists
	if ( ! function_exists( "get_field" ) ) {
		return $classes;
	}

	$css = get_field( "css_class" );

	if ( empty( $css ) ) {
		return $classes;
	}

	return array_merge( $classes, explode( " ", $css ) );

}

\add_filter( "body_class", __NAMESPACE__ . "\\add_acf_page_settings_css_class" );

/**
 * Frontend dashboard
 */
function dashboard_post_types( $post_types ) {
	$post_types[] = "services";
	$post_types[] = "projects";
	$post_types[] = "stw_layout_blocks";

	return $post_types;
}
\add_filter( "stw_dashboard_post_types", __NAMESPACE__ . "\\dashboard_post_types" );

function archive_data_attrs( $data, $post_type ) {
	if ( $post_type === "projects" ) {
		$data["columns"] = 2;
	}

	return $data;
}
\add_filter( "stw_archive_data_attrs", __NAMESPACE__ . "\\archive_data_attrs", 10, 2 );

function customize_lead( $block, $post_type ) {
	if ( is_singular( "services" ) ) {
		$block["name"] = "lead-services";
	}

	return $block;
}
\add_filter( "stw_the_lead", __NAMESPACE__ . "\\customize_lead", 10, 2 );