<?php

use Kmoconnect\Classess\Bootstrap_Nav_Walker;

$supports = get_theme_support( "navbar" );
$defaults = [
	"responsive" => "toggle",
];

if ( is_array( $supports ) ) {
	$defaults = wp_parse_args( $supports[0], $defaults );
}
?>
<div class="header__wrapper">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-xl navbar-light" role="navigation">
			<?php do_action( "stw_navbar_start" ); ?>
			<?php the_custom_logo(); ?>
			<?php if ( $defaults["responsive"] == "offcanvas" ) : ?>
                <button
                        class="navbar__toggle navbar-toggler"
                        type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                        aria-expanded="false" aria-label="Toggle navigation"
                >
                    <i class="fa-solid fa-bars navbar__mobile"></i>
                </button>
                <div class="justify-content-center pt-4 pt-lg-0 navbar__offcanvas offcanvas offcanvas-end"
                     tabindex="-1"
                     id="offcanvasNavbar"
                     aria-labelledby="offcanvasNavbarLabel"
                >
                    <div class="offcanvas-header pb-0">
						<?php the_custom_logo(); ?>
                        <button
                                type="button"
                                class="btn-close ms-auto"
                                data-bs-dismiss="offcanvas"
                                aria-label="Close"
                        ></button>
                    </div>
                    <div class="offcanvas-body">
						<?php
						// primary nav
						wp_nav_menu( [
							"theme_location"  => "primary",
							"menu_id"         => "primary-menu",
							"items_wrap"      => '<ul id="%1$s" class="justify-content-end mb-2 mb-md-0 %2$s">%3$s</ul>',
							"depth"           => 2,
							"container"       => "div",
							"container_class" => "primary-nav flex-grow-1 flex-shrink-1",
							"container_id"    => "primary",
							"menu_class"      => "nav navbar-nav",
							"fallback_cb"     => "__return_false",
							"walker"          => new Bootstrap_Nav_Walker(),
						] );
						?>
                    </div>
                </div>
			<?php else: ?>
                <button
                        class="navbar__toggle navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar"
                        aria-expanded="false" aria-label="Toggle navigation"
                >
                    <i class="fa-solid fa-bars navbar__mobile"></i>
                </button>
                <div id="navbar" class="collapse navbar-collapse justify-content-end pt-4 pt-lg-0">
					<?php
					// primary nav
					wp_nav_menu( [
						"theme_location"  => "primary",
						"menu_id"         => "primary-menu",
						"items_wrap"      => '<ul id="%1$s" class="ms-auto mb-2 mb-md-0 %2$s">%3$s</ul>',
						"depth"           => 2,
						"container"       => "div",
						"container_class" => "primary-nav",
						"container_id"    => "primary",
						"menu_class"      => "nav navbar-nav",
						"fallback_cb"     => "__return_false",
						"walker"          => new Bootstrap_Nav_Walker(),
					] );
					?>
                </div>
			<?php endif; ?>
			<?php do_action( "stw_navbar_end" ); ?>
        </nav>
    </div>
</div>