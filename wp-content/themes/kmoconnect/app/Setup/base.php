<?php

namespace Kmoconnect\Setup;

use function Kmoconnect\Helpers\is_woocommerce_activated;

defined( "ABSPATH" ) || exit;

/**
 * Remove top Admin Menu Bar
 */
function remove_default_post_type_menu_bar( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( "new-post" );
	$wp_admin_bar->remove_node( "comments" );
	$wp_admin_bar->remove_node( "wp-logo" );
	$wp_admin_bar->remove_node( "new-content" );
	$wp_admin_bar->remove_node( "rank-math" );
}

\add_action( "admin_bar_menu", __NAMESPACE__ . "\\remove_default_post_type_menu_bar", 999 );

function remove_dashboard_widgets() {
	global $wp_meta_boxes;
	unset( $wp_meta_boxes['dashboard']['normal']['high']['rank_math_dashboard_widget'] );
}

\add_action( 'wp_dashboard_setup', __NAMESPACE__ . '\\remove_dashboard_widgets' );

/**
 * Hide admin notices
 */
function hide_notices() {
	?>
    <style>
        #rank_math_review_plugin_notice,
        #ewww-image-optimizer-review {
            display: none;
        }
    </style>
	<?php
}

\add_action( "admin_head", __NAMESPACE__ . "\\hide_notices" );

/**
 * Disable admin new user registration
 * Filters whether the admin is notified of a new user registration.
 * @since 6.1.0
 */
\add_filter( "wp_send_new_user_notification_to_admin", "__return_false" );

/**
 * Gravity forms loading spinner
 */
function spinner_url( $image_src, $form ) {
	return 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
}

\add_filter( "gform_ajax_spinner_url", __NAMESPACE__ . '\\spinner_url', 10, 2 );

/**
 * Disable default wyswiyg editor
 */
function init_remove_support() {
	\remove_post_type_support( "page", "editor" );
	\remove_post_type_support( "post", "editor" );
}

\add_action( "init", __NAMESPACE__ . "\\init_remove_support", 100 );

/**
 * Post revisions
 */
function disable_revisions() {
	return 0;
}

\add_filter( "wp_revisions_to_keep", __NAMESPACE__ . "\\disable_revisions" );

/**
 * Display cookiepolicy
 */
function add_post_state( $post_states, $post ) {
	if ( $post->post_name === 'cookiebeleid' ) {
		$post_states[] = 'Cookie policy';
	}

	return $post_states;
}

\add_filter( "display_post_states", __NAMESPACE__ . "\\add_post_state", 10, 2 );

/**
 * Yoast SEO metabox below
 */
function lower_yoast_metabox_priority() {
	return 'core';
}

\add_filter( "wpseo_metabox_prio", __NAMESPACE__ . "\\lower_yoast_metabox_priority" );

/**
 * Yoast SEO extra variables
 */
function yoast_vars_company_city() {
	return \get_field( "gemeente", "options" );
}

function register_custom_yoast_variables() {
	\wpseo_register_var_replacement(
		"%%company_city%%",
		__NAMESPACE__ . "\\yoast_vars_company_city",
		"advanced",
		"some help text"
	);
}

\add_action( "wpseo_register_extra_replacements", __NAMESPACE__ . "\\register_custom_yoast_variables" );

/**
 * RankMath metabox below
 */
function lower_rankmath_metabox_priority() {
	return "low";
}

add_filter( "rank_math/metabox/priority", __NAMESPACE__ . "\\lower_rankmath_metabox_priority" );

/**
 * Rank Math disable meta box in posts columns
 * WP_Posts_List_Table
 */
function customize_posts_columns( array $columns ): array {
	unset( $columns["rank_math_seo_details"] );
	unset( $columns["rank_math_title"] );
	unset( $columns["rank_math_description"] );

	return $columns;
}

/**
 * Loop over all custom post types and disable meta box in posts columns
 */
add_action( "init", function () {
	$post_types = get_post_types();
	foreach ( $post_types as $post_type ) {
		\add_filter( "manage_{$post_type}_posts_columns", __NAMESPACE__ . "\\customize_posts_columns", 12 );
	}
}, 999 );

/**
 * Removes all archive title prefixes
 */
\add_filter( "get_the_archive_title_prefix", "__return_false" );

/**
 * Disable e-mail notifications for password changes
 * https://developer.wordpress.org/reference/functions/wp_password_change_notification/
 */
\remove_action( "after_password_reset", "wp_password_change_notification" );

/**
 * Gravity Forms
 * Multistep Wizard buttons next and prev translations
 */
function translate_next_button( $button ) {
	return str_replace( "Next", __( "Next", "kmoconnect" ), $button );
}

\add_filter( "gform_next_button", __NAMESPACE__ . "\\translate_next_button" );

function translate_prev_button( $button ) {
	return str_replace( "Previous", __( "Previous", "kmoconnect" ), $button );
}

\add_filter( "gform_previous_button", __NAMESPACE__ . "\\translate_prev_button" );

/**
 * Allow shortcodes in nav_menu_item
 */
function shortcode_nav_menu_item( $title ) {

	if ( \is_admin() ) {
		return $title;
	}

	return \apply_shortcodes( $title );
}

\add_filter( "nav_menu_item_title", __NAMESPACE__ . "\\shortcode_nav_menu_item" );

/**
 * Render before navbar
 */
function render_before_navbar() {
	\do_action( "stw_topbanner" );

	if ( has_action( "stw_topbar_left" ) || has_action( "stw_topbar_right" ) ) {
		get_template_part( "template-parts/components/lay-out/topbar" );
	}
}

\add_action( "stw_header_wrapper_before", __NAMESPACE__ . "\\render_before_navbar" );

/**
 * Render topbar left
 */
function widget_topbar_left() {
	if ( is_active_sidebar( "topbar_left_1" ) ) {
		\dynamic_sidebar( 'topbar_left_1' );
	}
}
\add_action( "stw_topbar_left", __NAMESPACE__ . "\\widget_topbar_left" );

/**
 * Render topbar right
 */
function widget_topbar_right() {
	if ( is_active_sidebar( "topbar_right_1" ) ) {
		\dynamic_sidebar( 'topbar_right_1' );
	}
}
\add_action( "stw_topbar_right", __NAMESPACE__ . "\\widget_topbar_right" );

/**
 * Render navbar
 */
function render_navbar() {
	get_template_part( "template-parts/components/lay-out/navbar" );
}

\add_action( "stw_header_wrapper", __NAMESPACE__ . "\\render_navbar" );

/**
 * Render start archive section tag
 */
function render_archive_section_start() {
	if ( ! is_archive() ) {
		return;
	}

	$post_type     = get_query_var( "post_type" );
	$section_class = [ "archive-{$post_type}" ];
	$output        = '<section class="' . esc_attr( implode( " ", $section_class ) ) . '">';
	echo $output;
}

\add_action( "stw_layout_blocks", __NAMESPACE__ . "\\render_archive_section_start", 1 );

/**
 * Render end archive section tag
 */
function render_archive_section_end() {
	if ( ! is_archive() ) {
		return;
	}

	$output = '</section>';
	echo $output;
}

\add_action( "stw_layout_blocks", __NAMESPACE__ . "\\render_archive_section_end", 9999 );

/**
 * Render archive start template
 */
function render_archive_template_start() {
	if ( ! is_archive() ) {
		return;
	}

	$post_type = get_query_var( "post_type" );

	if ( locate_template( "template-parts/archive/{$post_type}.php" ) ) {
		get_template_part( "template-parts/archive/{$post_type}" );
	} else {
		get_template_part( "template-parts/archive/default" );
	}
}

\add_action( "stw_layout_blocks", __NAMESPACE__ . "\\render_archive_template_start", 2 );

/**
 * Customize the lead only for single post
 */
function customize_lead_single_post() {
	// bail no single post
	if ( ! \is_single() ) {
		return;
	}

	$post_type    = \get_post_type();
	$archive_name = \get_field( "lead_title", "{$post_type}-archive-options" );

	$block = [
		"title"       => \get_the_title(),
		"description" => \get_the_content(),
		"img"         => \get_post_thumbnail_id(),
		"buttons"     => [
			[
				"url"    => \get_post_type_archive_link( $post_type ),
				"title"  => $archive_name ?
					sprintf(
						__( "Back to %s", "kmoconnect" ),
						strtolower( $archive_name )
					) : __( "Back to overview", "kmoconnect" ),
				"class"  => [ "prev-link" ],
				"target" => "_self",
			],
		],
	];

	\do_action( "stw_get_template", "template-parts/acf-blocks/lead", $block );
}

\add_action( "stw_lead", __NAMESPACE__ . "\\customize_lead_single_post" );