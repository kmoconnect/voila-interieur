<?php
defined( 'ABSPATH' ) || exit;

$post_type      = get_post_type();
$template_files = [ "{$post_type}-card" ];
$data_attrs     = apply_filters( "stw_archive_data_attrs", [
	"columns"   => "auto",
	"direction" => "vertical"
], $post_type );
?>
<div class="layout">
    <section class="layout__block layout__block--group-cards !pt-0">
        <div class="container">
			<?php if ( have_posts() ) : ?>
                <div class="group-cards" <?php do_action( "output_data_attributes", $data_attrs ); ?>>
                    <div class="group-cards__grid">
						<?php while ( have_posts() ) :the_post(); ?>
							<?php

							$card = [
								"title" => get_the_title(),
								"desc"  => get_the_excerpt(),
								"link"  => [
									"url"   => get_permalink(),
									"title" => __( "Discover more", "kmoconnect" ),
								],
								"img"   => get_post_thumbnail_id(),
							];

							$card = apply_filters( "stw_archive_card", $card, $post_type );

							foreach ( $template_files as $template_file ) {
								if ( locate_template( "template-parts/components/cards/$template_file.php" ) ) {
									do_action( "stw_get_template", "template-parts/components/cards/{$template_file}", $card );
									break;
								} else {
									$card["class"] = [ "primary-card--vertical" ];
									do_action( "stw_get_template", "template-parts/components/cards/primary-card", $card );
								}
							}

							?>
						<?php endwhile; ?>
                    </div>
                </div>
				<?php do_action( "stw_pagination" ); ?>
			<?php else : ?>
                <div class="empty-message">
					<?php echo apply_filters( "stw_archive_empty_message", "", $post_type ); ?>
                </div>
			<?php endif; ?>
        </div>
    </section>
</div>