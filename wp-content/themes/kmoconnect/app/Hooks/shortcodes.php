<?php

namespace Kmoconnect\Hooks;

defined( 'ABSPATH' ) || exit;

/**
 * Init shortcodes
 */
function init_shortcodes() {
	\add_shortcode( "stw_current_year", __NAMESPACE__ . "\\current_year" );
	\add_shortcode( "convert_to_tel_format", __NAMESPACE__ . "\\convert_to_tel_format" );
	\add_shortcode( "stw_logo_footer", __NAMESPACE__ . "\\logo_footer" );
	\add_shortcode( "stw_site_url", __NAMESPACE__ . "\\stw_get_site_url" );
}
\add_action( "init", __NAMESPACE__ . "\\init_shortcodes" );

/**
 * Shortcodes
 */
function convert_to_tel_format( $atts ) {
	return preg_replace( '/[^\d]/', '', $atts['telefoon'] );
}

/**
 * Current year
 * @return string
 */
function current_year() {
	return \date_i18n( "Y" );
}

/**
 * Output logo
 */
function logo_footer() {
	return \get_custom_logo();
}

/**
 * Site URL
 */
function stw_get_site_url() {
	return \get_site_url();
}