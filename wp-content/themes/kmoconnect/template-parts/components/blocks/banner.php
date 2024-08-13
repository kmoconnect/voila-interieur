<?php

$block = [
	"section_class"   => [],
	"class"           => [],
	"container_class" => "container",
	"buttons"         => [],
	"data"            => [],
	"title"           => "",
	"desc"            => "",
	"id"              => "",
	"img"             => "",
	"subtitle"        => "",
];

if ( isset( $args ) ) {
	$block = wp_parse_args( $args, $block );
}

$block["class"] = wp_parse_args( [], $block["class"] )
?>
<section class="<?php echo esc_attr( implode( " ", $block["section_class"] ) ); ?>">
    <div class="<?php echo esc_attr( implode( " ", $block["class"] ) ); ?>"<?php do_action( "output_data_attributes",
		$block["data"] ); ?>>
        <div class="banner__wrapper position-relative py-50">
            <div class="banner__bg position-absolute top-0 start-0 w-100 h-100">
				<?php echo wp_get_attachment_image( $block["img"], 'full', false,
					[ "class" => "banner__img !h-100 object-fit-cover" ] ); ?>
                <div class="banner__overlay position-absolute top-0 start-0 w-100 h-100 opacity-50 bg-black"
                     aria-hidden="true"></div>
            </div>
            <div class="banner__inner position-relative">
                <div class="<?php echo $block["container_class"]; ?>">
                    <div class="banner__content max-w-200 mx-auto d-flex flex-column align-items-center">
                        <div class="banner__subtitle text-white text-uppercase mb-3">
							<?php do_action( "stw_replace_curly", $block["subtitle"] ); ?>
                        </div>
                        <h2 class="banner__title text-white h1 mb-4">
							<?php do_action( "stw_replace_curly", $block["title"] ); ?>
                        </h2>
                        <div class="banner__desc text-white mb-4">
							<?php do_action( "stw_replace_curly", $block["desc"] ); ?>
                        </div>
                        <div class="banner__cta">
							<?php get_template_part( "template-parts/components/lay-out/btn-group", null, [
								"buttons" => $block["buttons"],
								"class"   => [ "btn-group--center" ]
							] ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>