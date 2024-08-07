<?php
$block = [
	"icon_class"      => "fa-solid fa-arrow-left-long",
	"desc"            => __( "Back to overview", "studiowebvision" ),
	"link"            => get_post_type_archive_link( get_post_type() ),
	"container_class" => [ "container" ]
];

if ( isset( $args ) ) {
	$block = wp_parse_args( $args, $block );
}
?>
<section class="back-link">
    <div class="<?php echo esc_attr( implode( " ", $block["container_class"] ) ) ?>">
        <a href="<?php echo $block["link"]; ?>" class="back-link__btn">
			<span class="back-link__icon">
			<?php echo "<i class=\"{$block["icon_class"]}\"></i>"; ?>
			</span>
            <span class="back-link__desc">
			<?php echo $block["desc"]; ?>
			</span>
        </a>
    </div>
</section>
