<?php

if ( get_row_layout() == "window_decoration_collection" ) {

	$block = [
		"id"              => "",
		"post_id"         => get_queried_object_id(),
		"name"            => "window_decoration_collection",
		"section_class"   => [ "layout__block", "layout__block--window-decoration-collection", ],
		"class"           => [ "decoration-collection" ],
		"container_class" => "container",
		"data"            => [ "aos" => "fade-in" ],
		"items"           => []
	];

	// basic data
	$block["title"]   = get_sub_field( "lead_title", $block["post_id"] ) ?? "";
	$block["buttons"] = apply_filters( "stw_formatted_buttons", [] );

	$decoration_collections = new WP_Query( [
		"post_type" => "services",
	] );

	if ( ! $decoration_collections->have_posts() ) {
		return;
	}

	while ( $decoration_collections->have_posts() ) {
		$decoration_collections->the_post();
		$block["items"][] = [
			"title" => get_the_title(),
			"img"   => get_post_thumbnail_id(),
			"link"  => [ "url" => get_permalink(), "title" => __( "Read more", "kmoconnect" ) ],
		];
	}

	wp_reset_postdata();

	// hook before render block
	do_action( "stw_layout_block_before", "{$block["name"]}-{$block["id"]}" );

	// load component
	do_action( "stw_get_template", "template-parts/components/blocks/{$block["name"]}", $block );

	// hook after render block
	do_action( "stw_layout_block_after", "{$block["name"]}-{$block["id"]}" );

}
