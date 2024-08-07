<?php

$block = [
	"id"      => "",
	"icon"    => "",
	"class"   => [],
	"buttons" => [],
	"data"    => [],
];

if ( isset( $args ) ) {
	$block = wp_parse_args( $args, $block );
}

if ( empty( $block["buttons"] ) ) {
	return;
}

$block["class"][] = "btn-group";
?>
    <div class="<?php echo esc_attr( implode( " ", $block["class"] ) ); ?>"<?php do_action( "output_data_attributes", $block["data"] ); ?>>
        <div class="btn-group__wrapper">
			<?php foreach ( $block["buttons"] as $button ): ?>
                <a href="<?php echo $button["url"] ?? "#"; ?>"
                   class="btn-group__btn <?php echo isset( $button["class"] ) && is_array( $button["class"] ) ? esc_attr( implode( " ", $button["class"] ) ) : ""; ?>"
                   target="<?php echo $button["target"] ?? "_self"; ?>">
					<?php if ( ! empty( $button["title"] ) ): ?>
                        <span class="btn-group__text">
                        <?php echo $button["title"]; ?>
	                </span>
					<?php endif; ?>
                </a>
			<?php endforeach; ?>
        </div>
    </div>
<?php
