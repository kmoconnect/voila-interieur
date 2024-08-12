<?php
/**
 * Block: usps
 */
$block_id = apply_filters( "wpml_object_id", 391 );
$block    = [
	"post_id"       => $block_id,
	"name"          => "usps",
	"section_class" => [ "layout__block", "layout__block--usps" ],
	"class"         => [ "usps" ],
	"data"          => [ "aos" => "fade-in" ],
	"items"         => [],
];

if ( ! have_rows( "usps", $block_id ) ) {
	return;
}

while ( have_rows( "usps", $block_id ) ) {
	the_row();
	$block["items"][] = [
		"icon"       => get_sub_field( "usp_icon" ),
		"title"      => get_sub_field( "usp_title" ),
		"short_desc" => get_sub_field( "usp_short_desc" ),
	];
}

// load component
do_action( "stw_get_template", "template-parts/components/blocks/{$block["name"]}", $block );