<?php

namespace Kmoconnect\Woocommerce\Admin;

defined( 'ABSPATH' ) || exit();

/**
 * Add custom tabs
 * description and short description
 */
function custom_product_tabs( $tabs ) {
	$tabs["post_content"] = [
		'label'    => __( 'Description', 'kmoconnect' ),
		'target'   => 'post_content_tab',
		'class'    => [],
		"priority" => 21
	];

	$tabs["excerpt"] = [
		'label'    => __( 'Short description', 'kmoconnect' ),
		'target'   => 'excerpt_tab',
		'class'    => [],
		"priority" => 22
	];

	return $tabs;
}

\add_filter( 'woocommerce_product_data_tabs', __NAMESPACE__ . '\\custom_product_tabs' );

function custom_product_tabs_content() {
	global $post;
	?>
    <div id="post_content_tab" class="panel woocommerce_options_panel">
        <div style="padding:1rem;">
			<?php wp_editor( $post->post_content, 'content', [
				'textarea_name' => 'content',
				'textarea_rows' => 10,
				'editor_height' => '300',
				'media_buttons' => false,
				'quicktags'     => false
			] ); ?>
        </div>
    </div>
    <div id="excerpt_tab" class="panel woocommerce_options_panel">
        <div style="padding:1rem;">
			<?php wp_editor( htmlspecialchars_decode( $post->post_excerpt, ENT_QUOTES ), 'excerpt', [
				'textarea_name' => 'excerpt',
				'textarea_rows' => 5,
				'editor_height' => '300',
				'media_buttons' => false,
				'quicktags'     => false
			] ); ?>
        </div>
    </div>
	<?php
}

\add_action( 'woocommerce_product_data_panels', __NAMESPACE__ . '\\custom_product_tabs_content' );

function remove_default_product_tabs() {
	\remove_meta_box( 'postexcerpt', 'product', 'normal' );
	\remove_post_type_support( 'product', 'editor' );
}

\add_action( 'add_meta_boxes', __NAMESPACE__ . '\\remove_default_product_tabs', 99 );
