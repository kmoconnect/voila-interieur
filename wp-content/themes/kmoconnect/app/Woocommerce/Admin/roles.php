<?php

namespace Kmoconnect\Woocommerce\Admin;

defined( 'ABSPATH' ) || exit();

/**
 * Give "editor" role caps
 * Manage products, coupons and orders
 */
function caps() {
	$capabilities['core'] = [
		'view_woocommerce_reports',
	];

	$capability_types = [ 'product', 'shop_order', 'shop_coupon' ];

	foreach ( $capability_types as $capability_type ) {

		$capabilities[ $capability_type ] = [
			// Post type.
			"edit_{$capability_type}",
			"read_{$capability_type}",
			"delete_{$capability_type}",
			"edit_{$capability_type}s",
			"edit_others_{$capability_type}s",
			"publish_{$capability_type}s",
			"read_private_{$capability_type}s",
			"delete_{$capability_type}s",
			"delete_private_{$capability_type}s",
			"delete_published_{$capability_type}s",
			"delete_others_{$capability_type}s",
			"edit_private_{$capability_type}s",
			"edit_published_{$capability_type}s",

			// Terms.
			"manage_{$capability_type}_terms",
			"edit_{$capability_type}_terms",
			"delete_{$capability_type}_terms",
			"assign_{$capability_type}_terms",
		];
	}

	return $capabilities;
}

function modify_editor_role() {
	$role = get_role( 'editor' );

	$capabilities = caps();
	foreach ( $capabilities as $cap_group ) {
		foreach ( $cap_group as $cap ) {
			$role->add_cap( $cap );
		}
	}
}

\add_action( 'admin_init', __NAMESPACE__ . '\\modify_editor_role' );

function remove_admin_menu() {
	$user = wp_get_current_user();

	if ( in_array( "editor", $user->roles ) ) {
		\remove_menu_page( 'woocommerce-marketing' );
		\remove_submenu_page( 'woocommerce', 'wc-addons' );
	}
}

\add_action( "admin_menu", __NAMESPACE__ . '\\remove_admin_menu', 99 );