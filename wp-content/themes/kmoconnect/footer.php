<?php
$columns = \Kmoconnect\Helpers\theme()->getWidgets( "footer" );
?>
</main>
<?php do_action( "stw_footer_before" ); ?>
<footer class="footer">
    <div class="footer__inner">
        <div class="container">
            <div class="footer__wrapper footer__wrapper--<?php echo $columns; ?>">
				<?php for ( $i = 1; $i <= $columns; $i ++ ) : if ( ! is_active_sidebar( "footer_{$i}" ) ) {
					continue;
				} ?>
                    <div class="footer__col">
						<?php dynamic_sidebar( "footer_{$i}" ); ?>
                    </div>
				<?php endfor; ?>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="container">
                <div class="footer__bottom-wrap">
                    <div class="row justify-content-center">
                        <div class="col-12 footer__bottom-col-1 text-center">
							<?php wp_nav_menu( [
								'theme_location' => 'legal',
								'menu_id'        => 'legal-menu',
								'items_wrap'     => '<ul id="%1$s" class="legal-nav %2$s">%3$s</ul>',
								'depth'          => 2,
								'container'      => 'div',
								'fallback_cb'    => '__return_false',
							] ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div id="scrollTop" class="scrolltop">
    <span class="scrolltop__icon"><i class="fa-solid fa-angle-up"></i></span>
</div>
<?php do_action( "stw_footer_after" ); ?>
<?php wp_footer(); ?>
</body>

</html>
