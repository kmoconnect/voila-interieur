<?php

$block = [
	"ID"                 => 402,
	"current_project_id" => get_the_ID(),
	"swiper"             => [
		"slidesPerView" => 3,
		"loop"          => true,
		"autoplay"      => [ "delay" => 5000 ],
		"speed"         => 1000,
		"spaceBetween"  => 30,
		"navigation"    => [ "nextEl" => ".swiper-button-next", "prevEl" => ".swiper-button-prev" ],
		"breakpoints"   => [
			320 => [ "slidesPerView" => 1 ],
			768 => [ "slidesPerView" => 2 ],
			992 => [ "slidesPerView" => 3 ]
		]
	],
];

if ( isset( $args ) ) {
	$block = wp_parse_args( $args, $block );
}

$projects = new WP_Query( [
	"post_type" => "projects"
] );

if ( ! $projects->have_posts() ) {
	return;
}

while ( $projects->have_posts() ) {
	$projects->the_post();

	if ( $block["current_project_id"] == get_the_ID() ) {
		continue;
	}

	$block["projects"][] = [
		"img"   => get_post_thumbnail_id(),
		"title" => get_the_title(),
		"desc"  => get_the_excerpt(),
		"class" => [ "primary-card--vertical" ],
	];
}

wp_reset_postdata();
?>
<section class="recent-projects layout__block">
    <div class="container">
        <div class="recent-projects__wrapper">
            <div class="recent-projects__row">
				<?php if ( $title = get_field( "recent_projects_title", $block["ID"] ) ): ?>
                    <h2 class="recent-projects__title">
						<?php echo $title; ?>
                    </h2>
				<?php endif; ?>
				<?php if ( $projects->post_count > 3 ): ?>
                    <div class="recent-projects__arrows">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
				<?php endif; ?>
            </div>
            <div class="swiper" data-swiper='<?php echo json_encode( $block["swiper"] ); ?>'>
                <div class="swiper-wrapper">
					<?php foreach ( $block["projects"] as $project ): ?>
                        <div class="swiper-slide mb-10">
							<?php do_action( "stw_get_template", "template-parts/components/cards/primary-card",
								$project ); ?>
                        </div>
					<?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
