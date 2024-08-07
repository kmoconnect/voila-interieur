<?php

namespace Kmoconnect\Woocommerce\Frontend\Cart;

defined( 'ABSPATH' ) || exit();

/**
 * Cart
 * Hooks and filters
 */

/**
 * Start wrapper cart
 */
function start_wrapper_cart_page() {
	echo '<div class="woocommerce-cart__wrapper">';
}

\add_action( 'woocommerce_before_cart', __NAMESPACE__ . '\\start_wrapper_cart_page' );

/**
 * End wrapper cart
 */
function end_wrapper_cart_page() {
	echo '</div>';
}

\add_action( 'woocommerce_after_cart', __NAMESPACE__ . "\\end_wrapper_cart_page" );

/**
 * Cart coupon code before proceed checkout button
 */
function coupon_code_before_process_checkout() {
	if ( wc_coupons_enabled() ) { ?>
        <div class="cart-coupon">
            <label for="coupon_code"
                   class="screen-reader-text"><?php esc_html_e( 'Discount code:', 'kmoconnect' ); ?></label>
            <input type="text" name="coupon_code" class="input-text cart-coupon__input" id="coupon_code" value=""
                   placeholder="<?php esc_attr_e( 'Add discount code', 'kmoconnect' ); ?>"/>
            <button type="submit"
                    class="button cart-coupon__btn<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"
                    name="apply_coupon"
                    value="<?php esc_attr_e( 'Apply', 'kmoconnect' ); ?>"><?php esc_html_e( 'Apply', 'kmoconnect' ); ?></button>
			<?php do_action( 'woocommerce_cart_coupon' ); ?>
        </div>
	<?php }
}
\add_action( "woocommerce_proceed_to_checkout", __NAMESPACE__ . "\\coupon_code_before_process_checkout" );
