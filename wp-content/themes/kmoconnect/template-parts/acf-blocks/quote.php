<?php

if ( get_row_layout() == "quote" ) {

	$block = [
		"id"              => "",
		"post_id"         => get_queried_object_id(),
		"name"            => "quote",
		"section_class"   => [ "layout__block", "layout__block--quote" ],
		"class"           => [ "quote" ],
		"wrapper_class"   => [],
		"container_class" => "container",
		"data"            => [
			"aos"           => "fade-in",
			"aos-delay"     => 250,
			"enable_slider" => 0,
			"arrows"        => 0,
			"bullets"       => 0,
			"scrollbar"     => 0,
			"autoplay"      => 0,
			"autoplayspeed" => 0,
			"speed"         => 0,
		],
		"quotes"          => [],
	];

	$block["title"] = get_sub_field( "quote_title", $block["post_id"] ) ?? "";

	$css = get_sub_field( "layout", $block["post_id"] );
	if ( get_sub_field( "show_arrows", $block["post_id"] ) ) {
		$block["data"]["arrows"] = 1;
	}

	if ( get_sub_field( "enable_slider", $block["post_id"] ) ) {
		$block["data"]["enable_slider"] = 1;

		if ( $autoplay = get_sub_field( "autoplayspeed", $block["post_id"] ) ) {
			$block["data"]["autoplayspeed"] = $autoplay;
		}

		if ( $speed = get_sub_field( "speed", $block["post_id"] ) ) {
			$block["data"]["speed"] = $speed;
		}

		if ( get_sub_field( "pagination", $block["post_id"] ) !== "none" ) {
			$key                   = get_sub_field( "pagination" );
			$block["data"][ $key ] = 1;
		}
	}

	if ( ! empty( get_sub_field( "class", $block["post_id"] ) ) ) {
		$block["section_class"][] = esc_attr( get_sub_field( "class", $block["post_id"] ) );
	}

	// basic data
	if ( have_rows( "quotes", $block["post_id"] ) ) {
		while ( have_rows( "quotes", $block["post_id"] ) ) {
			the_row();

			if ( get_row_layout() !== "quote" ) {
				return;
			}

			$quote = [
				"desc"             => get_sub_field( "desc" ) ?? "",
				"profile_name"     => get_sub_field( "profile_name" ) ?? "",
				"profile_function" => get_sub_field( "profile_function" ) ?? "",
				"profile_img"      => get_sub_field( "profile_img" ) ?? "",
				"img"              => get_sub_field( "img" ) ?? "",
			];

			if ( ! empty( $quote["img"] ) && ! in_array( $css, $block["class"] ) ) {
				$block["class"][] = esc_attr( $css );
			}

			$block["quotes"][] = $quote;
		}
	}

	// hook before render block
	do_action( "stw_layout_block_before", "{$block["name"]}-{$block["id"]}" );

	// load component
	do_action( "stw_get_template", "template-parts/components/blocks/{$block["name"]}", $block );

	// hook after render block
	do_action( "stw_layout_block_after", "{$block["name"]}-{$block["id"]}" );

}
