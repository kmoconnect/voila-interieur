<?php
/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( "woocommerce_product_tabs", [] );
if ( empty( $product_tabs ) ) {
	return;
}
$i        = 0;
$iContent = 0;
?>
<div class="product__tabs">
    <div class="accordion accordion-flush" id="accordionProduct">
		<?php foreach ( $product_tabs as $key => $product_tab ): $tabId = esc_attr( $key ); ?>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#<?php echo $tabId = esc_attr( $key ); ?>" aria-expanded="false"
                            aria-controls="<?php echo $tabId = esc_attr( $key ); ?>">
						<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
                    </button>
                </h2>
                <div id="<?php echo $tabId = esc_attr( $key ); ?>" class="accordion-collapse collapse"
                     data-bs-parent="#<?php echo $tabId = esc_attr( $key ); ?>">
                    <div class="accordion-body">
						<?php if ( isset( $product_tab['callback'] ) ) {
							call_user_func( $product_tab['callback'], $key, $product_tab );
						} ?>
                    </div>
                </div>
            </div>
			<?php $iContent ++; endforeach; ?>
    </div>
</div>