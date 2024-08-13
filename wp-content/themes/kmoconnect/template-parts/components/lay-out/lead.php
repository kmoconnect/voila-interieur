<?php

$block = [
	"title"           => "",
	"description"     => "",
	"id"              => "",
	"img"             => "",
	"buttons"         => [],
	"section_class"   => [ "lead-section" ],
	"class"           => [],
	"container_class" => "container",
	"data"            => [],
];

if ( isset( $args ) ) {
	$block = wp_parse_args( $args, $block );
}

$block["class"][] = "lead";
?>
<section class="<?php echo esc_attr( implode( " ", $block["section_class"] ) ); ?>">
    <div class="<?php echo esc_attr( implode( " ", $block["class"] ) ); ?>"<?php do_action( "output_data_attributes",
		$block["data"] ); ?>>
        <div class="lead__wrapper">
            <div class="<?php echo $block["container_class"]; ?>">
                <div class="lead__inner">
                    <div class="lead__inner-container">
                        <div class="lead__content">
                            <header class="heading lead__header">
                                <h1 class="lead__title heading__title">
									<?php do_action( "stw_replace_curly", $block["title"] ); ?>
                                </h1>
                            </header>
                            <div class="lead__desc">
								<?php do_action( "stw_replace_curly", $block["description"] ); ?>
                            </div>
							<?php if ( count( $block["buttons"] ) > 0 ): ?>
                                <div class="lead__cta">
									<?php foreach ( $block["buttons"] as $button ): ?>
                                        <a href="<?php echo $button["url"]; ?>"
                                           class="lead__btn <?php echo implode( " ", $button["class"] ); ?>"
                                           target="<?php echo $button["target"]; ?>">
											<?php echo $button["title"]; ?>
                                        </a>
									<?php endforeach; ?>
                                </div>
							<?php endif; ?>
                        </div>
                    </div>
					<?php if ( ! empty( $block["img"] ) ): ?>
                        <div class="lead__img-wrapper">
							<?php echo wp_get_attachment_image( $block["img"], "full", false,
								[ "class" => "lead__img" ] ); ?>
                        </div>
					<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>