<?php
/*
Template Name: Contact
*/
get_header();
do_action( "stw_lead" );
$columns = \Kmoconnect\Helpers\theme()->getWidgets( "contact" );
?>
    <section class="contact">
        <div class="contact__wrapper">
            <div class="container">
                <div class="contact__inner grid gap-x-2 grid-cols-lg-<?php echo $columns + 1; ?>">
					<?php for ( $i = 1; $i <= $columns; $i ++ ): ?>
                        <div class="contact__col-<?php echo $i; ?> <?php echo ( $i == 2 ) ? 'col-span-lg-2' : 'col-span-lg-1' ?>">
							<?php dynamic_sidebar( "contact_{$i}" ); ?>
                        </div>
					<?php endfor; ?>
                </div>
            </div>
        </div>
    </section>
<?php
do_action( "stw_google_maps" );
get_footer();
