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
    <ul class="nav mb-3" id="pills-tab" role="tablist">
		<?php foreach ( $product_tabs as $key => $product_tab ): $tabId = esc_attr( $key ); ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo $i === 0 ? "active" : null; ?>"
                        id="<?php echo $tabId = esc_attr( $key ); ?>-tab" data-bs-toggle="pill"
                        data-bs-target="#<?php echo $tabId = esc_attr( $key ); ?>"
                        type="button" role="tab" aria-controls="<?php echo $tabId = esc_attr( $key ); ?>"
                        aria-selected="true">
					<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
                </button>
            </li>
			<?php $i ++; endforeach; ?>
    </ul>
    <div class="tab-content" id="pills-tabContent">
		<?php foreach ( $product_tabs as $key => $product_tab ): $tabId = esc_attr( $key ); ?>
            <div class="tab-pane fade <?php echo $iContent === 0 ? "active show" : null; ?>"
                 id="<?php echo $tabId = esc_attr( $key ); ?>" role="tabpanel"
                 aria-labelledby="<?php echo $tabId = esc_attr( $key ); ?>-tab"
                 tabindex="0">
				<?php if ( isset( $product_tab['callback'] ) ) {
					call_user_func( $product_tab['callback'], $key, $product_tab );
				} ?>
            </div>
			<?php $iContent ++; endforeach; ?>
    </div>
</div>