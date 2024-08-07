<?php
defined( 'ABSPATH' ) || exit;

get_header();
/**
 * The template for displaying taxonomy pages
 */
$taxonomy = get_queried_object();
$query_id = get_queried_object_id();

do_action( "stw_lead" );
if ( $taxonomy->parent > 0 ) {
	get_template_part( "template-parts/taxonomy-child", $taxonomy->taxonomy );
} else {
	get_template_part( "template-parts/taxonomy", $taxonomy->taxonomy );
}
get_footer();
