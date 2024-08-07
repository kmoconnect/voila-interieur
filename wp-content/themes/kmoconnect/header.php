<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( "charset" ); ?>">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php wp_body_open(); ?>
<?php do_action( "stw_header_before" ); ?>
<header class="<?php echo esc_attr( implode( " ", apply_filters( "stw_header_class", [ "header" ] ) ) ); ?>">
	<?php
	do_action( "stw_header_wrapper_before" );
	do_action( "stw_header_wrapper" );
	do_action( "stw_header_wrapper_after" );
	?>
</header>
<?php do_action( "stw_header_after" ); ?>
<main class="site" id="site">
