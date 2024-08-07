<?php

if ( get_row_layout() == "block_name" ) {

	$block = [
		"id"              => "",
		"post_id"         => get_queried_object_id(),
		"name"            => "block-name",
		"section_class"   => [ "layout__block", "layout__block--block-name" ],
		"class"           => [ "block-name" ],
		"container_class" => "container",
		"data"            => [ "aos" => "fade-in" ],
		"items"           => [],
		"buttons"         => [],
	];

	// basic data
	$block["title"] = get_sub_field( "lead_title", $block["post_id"] ) ?? "";

	// hook before render block
	do_action( "stw_layout_block_before", "{$block["name"]}-{$block["id"]}" );

	// load component
	do_action( "stw_get_template", "template-parts/components/blocks/{$block["name"]}", $block );

	// hook after render block
	do_action( "stw_layout_block_after", "{$block["name"]}-{$block["id"]}" );

}
