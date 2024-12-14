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
	"items"           => [],
];

if ( isset( $args ) ) {
	$block = wp_parse_args( $args, $block );
}

$block["class"] = wp_parse_args( [], $block["class"] )
?>
<section class="<?php echo esc_attr( implode( " ", $block["section_class"] ) ); ?>">
    <div class="<?php echo esc_attr( implode( " ", $block["class"] ) ); ?>"<?php do_action( "output_data_attributes",
		$block["data"] ); ?>>
        <div class="<?php echo $block["container_class"]; ?>">
            <div class="decoration__collection__wrapper group-cards">
                <div class="decoration-collection__lead mb-10">
                    <div class="row justify-content-between">
                        <div class="col-md-8">
                            <h2 class="decoration-collection__title mb-0">
								<?php do_action( "stw_replace_curly", $block["title"] ); ?>
                            </h2>
                        </div>
                        <div class="col-md-4">
							<?php get_template_part( "template-parts/components/lay-out/btn-group", null, [
								"buttons" => $block["buttons"],
								"class"   => [ "btn-group--end" ]
							] ); ?>
                        </div>
                    </div>
                </div>
                <div class="decoration-collection__items">
                    <div class="row row-cols-md-2 row-cols-lg-3 g-10">
						<?php foreach ( $block["items"] as $item ): ?>
                            <div class="col-12">
								<?php do_action( "stw_get_template", "template-parts/components/cards/primary-card",
									$item ); ?>
                            </div>
						<?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>