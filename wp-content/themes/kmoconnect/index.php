<?php
defined( 'ABSPATH' ) || exit;

get_header();

// studiowebvision plugin hooks
do_action( "stw_hero" );
do_action( "stw_lead" );

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
	}
}

// studiowebvision plugin hooks
do_action( "stw_layout_blocks" );
get_footer();