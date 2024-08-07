<?php
function wp_install_defaults( $user_id ) {
	global $wpdb, $wp_rewrite, $table_prefix;

	// Default category.
	$cat_name = __( 'Uncategorized' );
	/* translators: Default category slug. */
	$cat_slug = sanitize_title( _x( 'Uncategorized', 'Default category slug' ) );

	$cat_id = 1;

	$wpdb->insert(
		$wpdb->terms,
		array(
			'term_id'    => $cat_id,
			'name'       => $cat_name,
			'slug'       => $cat_slug,
			'term_group' => 0,
		)
	);
	$wpdb->insert(
		$wpdb->term_taxonomy,
		array(
			'term_id'     => $cat_id,
			'taxonomy'    => 'category',
			'description' => '',
			'parent'      => 0,
			'count'       => 1,
		)
	);
	$cat_tt_id = $wpdb->insert_id;

	$now             = current_time( 'mysql' );
	$now_gmt         = current_time( 'mysql', 1 );
	$first_post_guid = get_option( 'home' ) . '/?p=1';

	if ( is_multisite() ) {
		update_posts_count();
	}

	$wpdb->insert(
		$wpdb->term_relationships,
		array(
			'term_taxonomy_id' => $cat_tt_id,
			'object_id'        => 1,
		)
	);

	// First page.
	if ( is_multisite() ) {
		$first_page = get_site_option( 'first_page' );
	}

	if ( empty( $first_page ) ) {
		$first_page = "<!-- wp:paragraph -->\n<p>";
		/* translators: First page content. */
		$first_page .= __( "This is an example page. It's different from a blog post because it will stay in one place and will show up in your site navigation (in most themes). Most people start with an About page that introduces them to potential site visitors. It might say something like this:" );
		$first_page .= "</p>\n<!-- /wp:paragraph -->\n\n";

		$first_page .= "<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>";
		/* translators: First page content. */
		$first_page .= __( "Hi there! I'm a bike messenger by day, aspiring actor by night, and this is my website. I live in Los Angeles, have a great dog named Jack, and I like pi&#241;a coladas. (And gettin' caught in the rain.)" );
		$first_page .= "</p></blockquote>\n<!-- /wp:quote -->\n\n";

		$first_page .= "<!-- wp:paragraph -->\n<p>";
		/* translators: First page content. */
		$first_page .= __( '...or something like this:' );
		$first_page .= "</p>\n<!-- /wp:paragraph -->\n\n";

		$first_page .= "<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p>";
		/* translators: First page content. */
		$first_page .= __( 'The XYZ Doohickey Company was founded in 1971, and has been providing quality doohickeys to the public ever since. Located in Gotham City, XYZ employs over 2,000 people and does all kinds of awesome things for the Gotham community.' );
		$first_page .= "</p></blockquote>\n<!-- /wp:quote -->\n\n";

		$first_page .= "<!-- wp:paragraph -->\n<p>";
		$first_page .= sprintf(
		/* translators: First page content. %s: Site admin URL. */
			__( 'As a new WordPress user, you should go to <a href="%s">your dashboard</a> to delete this page and create new pages for your content. Have fun!' ),
			admin_url()
		);
		$first_page .= "</p>\n<!-- /wp:paragraph -->";
	}

	$first_post_guid = get_option( 'home' ) . '/?page_id=2';
	$wpdb->insert(
		$wpdb->posts,
		array(
			'post_author'           => $user_id,
			'post_date'             => $now,
			'post_date_gmt'         => $now_gmt,
			'post_content'          => 'Lorem ipsum',
			'post_excerpt'          => '',
			'comment_status'        => 'closed',
			'post_title'            => __( 'Home' ),
			/* translators: Default page slug. */
			'post_name'             => __( 'home' ),
			'post_modified'         => $now,
			'post_modified_gmt'     => $now_gmt,
			'guid'                  => $first_post_guid,
			'post_type'             => 'page',
			'to_ping'               => '',
			'pinged'                => '',
			'post_content_filtered' => '',
		)
	);
	$wpdb->insert(
		$wpdb->postmeta,
		array(
			'post_id'    => 2,
			'meta_key'   => '_wp_page_template',
			'meta_value' => 'default',
		)
	);

	// Privacy Policy page.
	if ( is_multisite() ) {
		// Disable by default unless the suggested content is provided.
		$privacy_policy_content = get_site_option( 'default_privacy_policy_content' );
	} else {
		if ( ! class_exists( 'WP_Privacy_Policy_Content' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-privacy-policy-content.php';
		}

		$privacy_policy_content = WP_Privacy_Policy_Content::get_default_content();
	}

	if ( ! empty( $privacy_policy_content ) ) {
		$privacy_policy_guid = get_option( 'home' ) . '/?page_id=3';

		$wpdb->insert(
			$wpdb->posts,
			array(
				'post_author'           => $user_id,
				'post_date'             => $now,
				'post_date_gmt'         => $now_gmt,
				'post_content'          => $privacy_policy_content,
				'post_excerpt'          => '',
				'comment_status'        => 'closed',
				'post_title'            => __( 'Privacy Policy' ),
				/* translators: Privacy Policy page slug. */
				'post_name'             => __( 'privacy-policy' ),
				'post_modified'         => $now,
				'post_modified_gmt'     => $now_gmt,
				'guid'                  => $privacy_policy_guid,
				'post_type'             => 'page',
				'post_status'           => 'draft',
				'to_ping'               => '',
				'pinged'                => '',
				'post_content_filtered' => '',
			)
		);
		$wpdb->insert(
			$wpdb->postmeta,
			array(
				'post_id'    => 3,
				'meta_key'   => '_wp_page_template',
				'meta_value' => 'default',
			)
		);
		update_option( 'wp_page_for_privacy_policy', 3 );
	}

	if ( ! is_multisite() ) {
		update_user_meta( $user_id, 'show_welcome_panel', 0 );
	} elseif ( ! is_super_admin( $user_id ) && ! metadata_exists( 'user', $user_id, 'show_welcome_panel' ) ) {
		update_user_meta( $user_id, 'show_welcome_panel', 2 );
	}

	if ( is_multisite() ) {
		// Flush rules to pick up the new page.
		$wp_rewrite->init();
		$wp_rewrite->flush_rules();

		$user = new WP_User( $user_id );
		$wpdb->update( $wpdb->options, array( 'option_value' => $user->user_email ), array( 'option_name' => 'admin_email' ) );

		// Remove all perms except for the login user.
		$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->usermeta WHERE user_id != %d AND meta_key = %s", $user_id, $table_prefix . 'user_level' ) );
		$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->usermeta WHERE user_id != %d AND meta_key = %s", $user_id, $table_prefix . 'capabilities' ) );

		/*
		 * Delete any caps that snuck into the previously active blog. (Hardcoded to blog 1 for now.)
		 * TODO: Get previous_blog_id.
		 */
		if ( ! is_super_admin( $user_id ) && 1 != $user_id ) {
			$wpdb->delete(
				$wpdb->usermeta,
				array(
					'user_id'  => $user_id,
					'meta_key' => $wpdb->base_prefix . '1_capabilities',
				)
			);
		}
	}

    /**
     * Modifications
     */
	// Set Timezone
	$timezone = "Europe/Brussels";
	update_option( 'timezone_string', $timezone );

	// Start of the Week
	update_option( 'start_of_week', 1 );

	// Disable Smilies
	update_option( 'use_smilies', 0 );

    // default page as frontpage
    $homepage = get_page_by_title('home');
	update_option( 'page_on_front', $homepage->ID );
	update_option( 'show_on_front', 'page' );

    // permalink
    update_option( 'permalink_structure', '/%postname%/' );

}