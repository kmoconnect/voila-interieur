<?php
/**
 * Registration box left side from login form
 * Only visible when option woocommerce_enable_myaccount_registration is disabled
 */
?>
<div class="woocommerce-registration">
    <h3>
		<?php _e( "Register", "kmoconnect" ); ?>
    </h3>
    <p><?php _e( "Are you not yet known to us? Then create a new account first.", "kmoconnect" ); ?></p>
    <a href="/register" class="btn btn-sm btn-primary"><?php _e( "Create account", "kmoconnect" ); ?></a>
</div>