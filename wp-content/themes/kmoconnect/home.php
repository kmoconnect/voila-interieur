<?php
defined( 'ABSPATH' ) || exit;

get_header();
/**
 * Studiowebvision plugin hook
 */
do_action( "stw_hero" );
do_action( "stw_lead" );
?>
	<section class="blog blog--listing">
		<div class="container">
			<div class="row row-cols-1 g-5">
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						?>
					<div class="col">
						<?php get_template_part( "template-parts/loops/" . get_post_type() ); ?>
					</div>
				<?php endwhile; ?>
				<?php else : ?>
					<div class="col">
						<div class="text-center">
							<p><?php _e( 'There are currently no items', 'kmoconnect' ); ?></p>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php
/**
 * Studiowebvision plugin hook
 */
do_action( "stw_layout_blocks" );
get_footer();
