<?php

namespace Kmoconnect\Hooks;

defined( "ABSPATH" ) || exit;

/**
 * Register custom post types
 */
function register_custom_post_types() {

	// services
	do_action(
		"stw_register_cpt",
		"services",
		[
			"cpt"      => "services",
			"plural"   => _x( "Services", "Post Type General Name", "kmoconnect" ),
			"singular" => _x( "Service", "Post Type Singular Name", "kmoconnect" ),
			"slug"     => class_exists( "\\SitePress" ) ? "services" : _x( "services", "post type slug", "kmoconnect" ),
		],
		[
			"menu_position" => 21,
			"menu_icon"     => "dashicons-portfolio",
			"supports"      => [ "thumbnail", "title" ],
		]
	);

	// tax: categories - CPT services
	do_action(
		"stw_register_tax",
		"categories",
		[
			"cpt"      => "services",
			"plural"   => _x( ucfirst( "categories" ), "Post Type General Name", "kmoconnect" ),
			"singular" => _x( ucfirst( "categories" ), "Post Type Singular Name", "kmoconnect" ),
			"slug"     => class_exists( "\\SitePress" ) ? "services" : _x(
				"services",
				"post type slug",
				"kmoconnect"
			),

		],
		[
			"hierarchical"      => true,
			"public"            => true,
			"show_ui"           => true,
			"show_admin_column" => true,
			"query_var"         => true,
			"with_front"        => true,
			"rewrite"           => [
				"hierarchical" => true,
				"slug"         => "services"
			]
		]
	);

	// projects
	do_action(
		"stw_register_cpt",
		"projects",
		[
			"cpt"      => "projects",
			"plural"   => _x( "Projects", "Post Type General Name", "kmoconnect" ),
			"singular" => _x( "Project", "Post Type Singular Name", "kmoconnect" ),
			"slug"     => class_exists( "\\SitePress" ) ? "projects" : _x( "projects", "post type slug", "kmoconnect" ),
		],
		[
			"menu_position" => 22,
			"menu_icon"     => "dashicons-format-gallery",
			"supports"      => [ "thumbnail", "title" ],
		]
	);
}

\add_action( "init", __NAMESPACE__ . "\\register_custom_post_types" );
