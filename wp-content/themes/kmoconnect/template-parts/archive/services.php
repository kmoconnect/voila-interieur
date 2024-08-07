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
    <section class="layout__block layout__block--group-cards">
        <div class="container">
			<?php if ( have_posts() ) : ?>
                <div class="row">
                    <div class="col-12">
						<?php while ( have_posts() ) : the_post(); ?>
                            <div class="archive-services__item row row-cols-md-2 mb-30 align-items-center"
                                 data-aos="fade-in" data-aos-delay="100">
                                <div class="col-12">
                                    <a href="<?php the_permalink(); ?>" class="archive-services__img">
										<?php echo wp_get_attachment_image( get_post_thumbnail_id(), "large", false, [ "class" => "aspect-1x1 object-fit-cover" ] ); ?>
                                    </a>
                                </div>
                                <div class="col-12">
                                    <div class="archive-services__content px-30">
                                        <h3 class="archive-service__title text-uppercase">
											<?php echo get_the_title(); ?>
                                        </h3>
                                        <div class="archive-services__desc mb-6">
											<?php echo get_the_excerpt(); ?>
                                        </div>
                                        <a href="<?php the_permalink(); ?>"
                                           class="archive-services__cta btn btn-primary">
											<?php _e( "Read more", "kmoconnect" ); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
						<?php endwhile; ?>
                    </div>
                </div>
				<?php do_action( "stw_pagination" ); ?>
			<?php endif; ?>
        </div>
    </section>
</div>
