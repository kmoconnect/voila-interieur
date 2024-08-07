<?php

$card = [
	"title" => "",
	"desc"  => "",
	"img"   => "",
	"link"  => [ "url" => "#", "target" => "self", "title" => "" ],
	"class" => [],
	"data"  => [],
];

if ( isset( $args ) ) {
	$card = wp_parse_args( $args, $card );
}

if ( isset( $card["link"]["url"] ) && $card["link"]["url"] !== "#" ) {
	$card["data"]["src"] = $card["link"]["url"];
}

$card["class"][] = "primary-card";
?>
<div class="<?php echo esc_attr( implode( " ", $card["class"] ) ); ?>" <?php do_action( "output_data_attributes", $card["data"] ); ?>>
	<?php if ( $card["img"] ) : ?>
        <div class="primary-card__img-wrapper">
			<?php echo wp_get_attachment_image( $card["img"], "large", null, [ "class" => "primary-card__img" ] ); ?>
        </div>
	<?php endif; ?>
    <div class="primary-card__content">
        <h3 class="primary-card__title">
			<?php echo $card["title"]; ?>
        </h3>
		<?php if ( ! empty( $card["desc"] ) ): ?>
            <div class="primary-card__desc">
				<?php echo $card["desc"]; ?>
            </div>
		<?php endif; ?>
		<?php if ( isset( $card["link"]["url"] ) && $card["link"]["url"] !== "#" ) : ?>
            <div class="primary-card__cta">
                <a href="<?php echo $card["link"]["url"]; ?>" class="primary-card__btn"
                   target="<?php echo $card["link"]["target"] ?? "_self"; ?>">
					<?php echo $card["link"]["title"]; ?>
                </a>
            </div>
		<?php endif; ?>
    </div>
</div>