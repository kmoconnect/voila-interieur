<?php

use function Kmoconnect\Helpers\is_woocommerce_activated;

defined( 'ABSPATH' ) || exit;

require __DIR__ . '/vendor/autoload.php';

require_once get_theme_file_path() . "/app/Helpers/functions.php";

$includes = [
	/**
	 * Setup
	 */
	"Setup/theme",
	"Setup/base",

	/**
	 * Hooks
	 */
	"Hooks/actions",
	"Hooks/filters",
	"Hooks/ajax",
	"Hooks/custom-post-types",
	"Hooks/shortcodes",
];

if ( is_woocommerce_activated() ) {
	$includes[] = "Woocommerce/base";
	$includes[] = "Woocommerce/theme";
	$includes[] = "Woocommerce/filters";
	// frontend specific
	$includes[] = "Woocommerce/Frontend/shop";
	$includes[] = "Woocommerce/Frontend/cart";
	$includes[] = "Woocommerce/Frontend/checkout";
	$includes[] = "Woocommerce/Frontend/product";
	$includes[] = "Woocommerce/Frontend/account";
	$includes[] = "Woocommerce/Frontend/thankyou";
	// admin specific
	$includes[] = "Woocommerce/Admin/product";
}

foreach ( $includes as $include ) {
	require_once get_theme_file_path() . "/app/{$include}.php";
}
