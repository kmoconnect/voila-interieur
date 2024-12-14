<?php

$block = [
	"section_class"   => [],
	"class"           => [],
	"container_class" => "container",
	"buttons"         => [],
	"data"            => [],
	"items"           => [],
	"title"           => "",
	"desc"            => "",
	"id"              => "",
	"img"             => "",
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
            <div class="usps__wrapper">
                <div class="row row-cols-md-3 g-15">
					<?php foreach ( $block["items"] as $item ) : ?>
                        <div class="col-12">
                            <div class="usps__item d-flex gap-4">
                                <div class="usps__item-icon bg-primary rounded-circle max-h-12 p-4 d-flex flex-column align-items-center">
									<?php echo $item["icon"]; ?>
                                </div>
                                <div class="usps__item-content">
                                    <h5 class="usps__item-title fw-normal lt-space-1 mb-0">
										<?php echo $item["title"]; ?>
                                    </h5>
                                    <div class="usps__item-desc">
										<?php echo $item["short_desc"]; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
					<?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>