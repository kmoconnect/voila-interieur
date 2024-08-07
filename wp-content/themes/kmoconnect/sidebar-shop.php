<?php
/**
 * Bail if empty widgets
 */
if ( ! is_active_sidebar( "shop_sidebar_1" ) ) {
	return;
}
?>
<aside id="sidebar-shop" class="sidebar-shop">
	<?php dynamic_sidebar( "shop_sidebar_1" ); ?>
</aside>