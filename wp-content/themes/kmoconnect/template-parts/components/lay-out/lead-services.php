<?php
$block = [
	"title"           => "",
	"description"     => "",
	"id"              => "",
	"img"             => "",
	"images"          => [],
	"buttons"         => [],
	"section_class"   => [ "lead-section" ],
	"class"           => [],
	"container_class" => "container",
	"data"            => [],
	"swiper"          => [
		"slidesPerView" => 1,
		"loop"          => true,
//		"autoplay"      => [ "delay" => 3250, "pauseOnMouseEnter" => false ],
		"speed"         => 1000,
		"spaceBetween"  => 0,
		"effect"        => "slide",
		"navigation"    => [ "nextEl" => ".swiper-button-next", "prevEl" => ".swiper-button-prev" ],
		"pagination"    => [ "el" => ".swiper-pagination", "type" => "bullets", "clickable" => true ]
	]
];

if ( isset( $args ) ) {
	$block = wp_parse_args( $args, $block );
}

$block["buttons"] = [
	[
		"url"   => get_the_permalink( 13 ),
		"title" => __( "Book your appointment", "kmoconnect" ),
		"class" => [ "btn", "btn-primary" ]
	]
];
?>
<section class="lead-services pt-10 pb-layout">
    <div class="lead-services__back-link mb-6">
		<?php get_template_part( "template-parts/components/lay-out/back-link" ); ?>
    </div>
    <div class="container">
        <div class="lead-services__wrapper">
            <div class="row gx-20">
                <div class="col-md-5">
                    <div class="lead-services__img-wrapper pt-3">
                        <div class="swiper" data-swiper='<?php echo json_encode( $block["swiper"] ); ?>'>
                            <div class="swiper-wrapper">
								<?php foreach ( $block["images"] as $image ):

									$img = wp_get_attachment_image_src( $image, 'full' );
									?>
                                    <div class="swiper-slide cursor-pointer" data-lightbox="1">
                                        <a class="block" data-pswp-src="<?php echo $img[0]; ?>"
                                           data-pswp-width="<?php echo $img[1]; ?>"
                                           data-pswp-height="<?php echo $img[2]; ?>">
											<?php echo wp_get_attachment_image( $image, "full", false,
												[ "class" => "lead-services__img aspect-1x1 object-fit-cover w-100" ] ); ?>
                                        </a>
                                    </div>
								<?php endforeach; ?>
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="lead-services__content max-w-160">
                        <h1 class="lead-services__title h2 mb-4 title-underline">
							<?php do_action( "stw_replace_curly", $block["title"] ); ?>
                        </h1>
                        <div class="lead-services__desc">
							<?php do_action( "stw_replace_curly", $block["description"] ); ?>
                        </div>
                        <div class="lead-services__cta">
							<?php get_template_part( "template-parts/components/lay-out/btn-group", null, [
								"buttons" => $block["buttons"],
								"class"   => [ "mt-8" ]
							] ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

