<?php

namespace Kmoconnect\Hooks;

defined( 'ABSPATH' ) || exit;

/**
 * Actions
 */
function display_pagination( $params = [] ) {
	$attrs = wp_parse_args( $params, [
		"class" => []
	] );

	$attrs["class"][] = "pagination";

	global $wp_query;
	if ( $wp_query->max_num_pages <= 1 ) {
		return;
	}
	?>
    <nav class="<?php echo esc_attr( implode( " ", $attrs["class"] ) ); ?>">
		<?php echo paginate_links( [
			"current"   => max( 1, get_query_var( "paged" ) ),
			"total"     => $wp_query->max_num_pages,
			"prev_text" => '<i class="fa-solid fa-chevron-left"></i>',
			"next_text" => '<i class="fa-solid fa-chevron-right"></i>',
		] ); ?>
    </nav>
	<?php
}

\add_action( "stw_pagination", __NAMESPACE__ . "\\display_pagination" );

/**
 * Render single template
 * CPT: Project
 */
function render_project_single_template() {
	if ( ! is_singular( [ "projects" ] ) ) {
		return;
	}

	echo '<div class="layout">';

	\do_action( "stw_get_template", "template-parts/components/blocks/text-block", [
		"description"   => get_field( "project_desc" ) ?? "",
		"section_class" => [ "layout__block", "layout__block--project-desc" ],
	] );

	$main_image = get_field( "project_main_img" ) ?? [];
	$images     = ( ! empty( get_field( "project_images" ) ) ) ? get_field( "project_images" ) : [];
	$gallery    = array_merge( [ $main_image ], $images );

	\do_action( "stw_get_template", "template-parts/components/blocks/photo-gallery", [
		"images"        => $gallery,
		"section_class" => [ "layout__block", "layout__block--project-gallery" ],
		"data"          => [ "aos" => "fade-in", "lightbox" => 1, "columns" => "auto" ],
	] );

	echo '</div>';

}

//\add_action( "stw_layout_blocks", __NAMESPACE__ . "\\render_project_single_template" );