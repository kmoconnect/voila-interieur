<?php
/**
 * Lay-out block: Afrekenen
 */
$block_id = 1028;
$block    = [
	"ID"   => $block_id,
	"post" => get_post( $block_id ),
];

$parsed_blocks = parse_blocks( $block["post"]->post_content );

if ( $parsed_blocks ) {
	foreach ( $parsed_blocks as $block ) {
		echo apply_filters( 'the_content', render_block( $block ) );
	}
}
