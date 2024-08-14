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
						<?php echo wp_get_attachment_image( $block["img"], "full", false,
							[ "class" => "lead-services__img aspect-1x1 object-fit-cover w-100" ] ); ?>
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

