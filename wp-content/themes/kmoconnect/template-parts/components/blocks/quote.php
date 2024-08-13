<?php

$block = [
	"id"              => "",
	"section_class"   => [],
	"class"           => [ "quote" ],
	"wrapper_class"   => [],
	"container_class" => "container",
	"quotes"          => [],
	"type"            => "",
	"title"           => "",
	"data"            => [
		"aos"           => "fade-in",
		"aos-delay"     => 250,
		"arrows"        => 0,
		"bullets"       => 0,
		"scrollbar"     => 0,
		"autoplay"      => 0,
		"autoplayspeed" => 0,
	],
	"swiper"          => [
		"slidesPerView" => 1,
		"breakpoints"   => [
			772 => [
				"slidesPerView" => 3,
			]
		],
		"autoplay"      => [ "delay" => 6000, "pauseOnMouseEnter" => true ],
		"speed"         => 1000,
		"spaceBetween"  => 30,
		"navigation"    => [ "nextEl" => ".swiper-button-next", "prevEl" => ".swiper-button-prev" ],
		"pagination"    => [ "el" => ".swiper-pagination", "type" => "bullets", "clickable" => true ],
		"scrollbar"     => [ "el" => ".swiper-scrollbar", "draggable" => true ],
	],
];

if ( isset( $args ) ) {
	$block = wp_parse_args( $args, $block );
}

if ( $block["data"]["arrows"] == 0 ) {
	$block["swiper"]["navigation"] = false;
}

if ( $block["data"]["bullets"] == 0 ) {
	$block["swiper"]["pagination"] = false;
}

if ( $block["data"]["scrollbar"] == 0 ) {
	$block["swiper"]["scrollbar"] = false;
}

if ( $block["data"]["autoplay"] == 0 ) {
	$block["swiper"]["autoplay"] = $block["data"]["autoplay"];
}

// autoplay delay
if ( $block["data"]["autoplay"] !== 0 && $block["data"]["autoplayspeed"] > 0 ) {
	$block["swiper"]["autoplay"]["delay"] = $block["data"]["autoplayspeed"];
}

if ( $block["data"]["autoplay"] !== 0 && $block["data"]["speed"] > 0 ) {
	$block["swiper"]["speed"] = $block["data"]["speed"];
}

$block["wrapper_class"] = wp_parse_args( [
	"quote__wrapper",
], $block["wrapper_class"] );
?>
<section class="<?php echo esc_attr( implode( " ", $block["section_class"] ) ); ?>">
    <div class="<?php echo esc_attr( implode( " ", $block["class"] ) ); ?>"<?php do_action( "output_data_attributes",
		$block["data"] ); ?>>
        <div class="<?php echo esc_attr( $block["container_class"] ); ?>">
            <div class="<?php echo esc_attr( implode( " ", $block["wrapper_class"] ) ); ?>">
                <div class="quote__lead mx-auto text-center mb-10">
                    <h2 class="quote__title mb-0">
						<?php do_action( "stw_replace_curly", $block["title"] ); ?>
                    </h2>
                </div>
				<?php if ( $block["data"]["enable_slider"] ): ?>
                    <div class="swiper" data-swiper='<?php echo json_encode( $block["swiper"] ); ?>'>
                        <div class="swiper-wrapper">
							<?php foreach ( $block["quotes"] as $quote ): ?>
                                <div class="swiper-slide">
                                    <div class="quote__wrap">
										<?php if ( $quote["img"] ): ?>
                                            <div class="quote__bg" aria-hidden="true">
                                                <div class="quote__main-img-wrap">
													<?php echo wp_get_attachment_image( $quote["img"], "large", false,
														[ "class" => "quote__main-img" ] ); ?>
                                                </div>
                                            </div>
										<?php endif; ?>
                                        <blockquote class="quote__block d-flex flex-column align-items-center">
                                            <div class="quote__icon fs-3 text-secondary">
                                                <i class="fa-solid fa-quote-left"></i>
                                            </div>
                                            <h5 class="quote__desc text-center">
												<?php do_action( "stw_replace_curly", $quote["desc"] ); ?>
                                            </h5>
                                            <div class="quote__profile d-flex flex-column align-items-center">
												<?php if ( ! empty( $quote["profile_img"] ) ): ?>
                                                    <div class="quote__profile-img-wrap mb-2">
														<?php echo wp_get_attachment_image( $quote["profile_img"],
															"medium", false, [ "class" => "quote__profile-img" ] ); ?>
                                                    </div>
												<?php endif; ?>
												<?php if ( ! empty( $quote["profile_name"] ) ): ?>
                                                    <div class="quote__profile-name">
                                                        <span><?php do_action( "stw_replace_curly",
		                                                        $quote["profile_name"] ); ?></span>
                                                    </div>
												<?php endif; ?>
												<?php if ( ! empty( $quote["profile_function"] ) ): ?>
                                                    <div class="quote__profile-function">
                                                        <span><?php do_action( "stw_replace_curly",
		                                                        $quote["profile_function"] ); ?></span>
                                                    </div>
												<?php endif; ?>
                                            </div>
                                        </blockquote>
                                    </div>
                                </div>
							<?php endforeach; ?>
                        </div>
						<?php if ( $block["swiper"]["navigation"] ): ?>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
						<?php endif; ?>
						<?php if ( $block["swiper"]["pagination"] ): ?>
                            <div class="swiper-pagination"></div>
						<?php endif; ?>
						<?php if ( $block["swiper"]["scrollbar"] ): ?>
                            <div class="swiper-scrollbar"></div>
						<?php endif; ?>
                    </div>
				<?php else: ?>
					<?php foreach ( $block["quotes"] as $quote ): ?>
                        <div class="quote__wrap">
							<?php if ( $quote["img"] ): ?>
                                <div class="quote__bg" aria-hidden="true">
                                    <div class="quote__main-img-wrap">
										<?php echo wp_get_attachment_image( $quote["img"], "large", false,
											[ "class" => "quote__main-img" ] ); ?>
                                    </div>
                                </div>
							<?php endif; ?>
                            <blockquote class="quote__block">
                                <h3 class="quote__desc">
									<?php do_action( "stw_replace_curly", $quote["desc"] ); ?>
                                </h3>
                                <div class="quote__profile">
									<?php if ( ! empty( $quote["profile_img"] ) ): ?>
                                        <div class="quote__profile-img-wrap">
											<?php echo wp_get_attachment_image( $quote["profile_img"], "medium", false,
												[ "class" => "quote__profile-img" ] ); ?>
                                        </div>
									<?php endif; ?>
									<?php if ( ! empty( $quote["profile_name"] ) ): ?>
                                        <div class="quote__profile-name">
                                            <span><?php do_action( "stw_replace_curly",
		                                            $quote["profile_name"] ); ?></span>
                                        </div>
									<?php endif; ?>
									<?php if ( ! empty( $quote["profile_function"] ) ): ?>
                                        <div class="quote__profile-function">
                                            <span><?php do_action( "stw_replace_curly",
		                                            $quote["profile_function"] ); ?></span>
                                        </div>
									<?php endif; ?>
                                </div>
                            </blockquote>
                        </div>
					<?php endforeach; ?>
				<?php endif; ?>
            </div>
        </div>
    </div>
</section>
