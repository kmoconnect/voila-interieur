<?php

if ( get_row_layout() == "banner" ) {

	$block = [
		"id"              => "",
		"post_id"         => get_queried_object_id(),
		"name"            => "banner",
		"section_class"   => [ "layout__block", "layout__block--banner", ],
		"class"           => [ "banner" ],
		"container_class" => "container",
		"data"            => [ "aos" => "fade-in" ],
	];

	// basic data
	$block["title"]    = get_sub_field( "banner_title", $block["post_id"] ) ?? "";
	$block["subtitle"] = get_sub_field( "banner_subtitle", $block["post_id"] ) ?? "";
	$block["desc"]     = get_sub_field( "banner_desc", $block["post_id"] ) ?? "";
	$block["img"]      = get_sub_field( "banner_img", $block["post_id"] ) ?? "";
	$block["buttons"]  = apply_filters( "stw_formatted_buttons", [] );

	// hook before render block
	do_action( "stw_layout_block_before", "{$block["name"]}-{$block["id"]}" );

	// load component
	do_action( "stw_get_template", "template-parts/components/blocks/{$block["name"]}", $block );

	// hook after render block
	do_action( "stw_layout_block_after", "{$block["name"]}-{$block["id"]}" );

}
