<?php

use function Kmoconnect\Helpers\theme;

defined( 'ABSPATH' ) || exit;

/**
 * Init theme
 */
$theme = theme();

/**
 * Own support functions
 */
$theme->addSupport( "navbar", [ "responsive" => "offcanvas" ] );

/**
 * Add supports
 */
$theme->addSupport( "title-tag" )
      ->addSupport( "custom-logo" )
      ->addSupport( "post-thumbnails" )
      ->addSupport( "appearance-tools" )
      ->addSupport( "customize-selective-refresh-widgets" )
      ->addSupport(
	      "html5",
	      [
		      "search-form",
		      "gallery",
		      "caption",
	      ]
      );

/**
 * Register nav menus
 */
$theme->addNavMenus( [
	"primary" => "Primary",
	"legal"   => "Legal - footer",
] );

/**
 * Register widgets
 */
$theme->addWidget( "footer", 4 )
      ->addWidget( "Copyright footer", 1 )
      ->addWidget( "contact", 2 )
      ->addWidget( "Topbar Left", 1 )
      ->addWidget( "Topbar Right", 1 );


if ( wp_get_environment_type() === 'development' ) {
	$theme->addScript( "vite", "http://localhost:5173/assets/src/js/main.js", [], false, true );
	require_once get_theme_file_path( "playground.php" );
} else {
	$theme->addStyle( "theme-style", get_theme_file_uri() . "/assets/dist/main.css" );
	$theme->addScript( "theme-script", get_theme_file_uri() . "/assets/dist/main.js", [], true );
}

$theme->addAjaxScript(
	"theme-script",
	"ajax_object",
	[
		"url"         => admin_url( "admin-ajax.php" ),
		"_ajax_nonce" => wp_create_nonce( "_ajax_nonce" ),
	]
);
