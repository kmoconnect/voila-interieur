<?php
add_action( 'init', function () {
	add_rewrite_rule( 'playground', 'index.php?playground=1', 'top' );
} );

add_filter( 'query_vars', function ( $query_vars ) {
	$query_vars[] = 'playground';

	return $query_vars;
} );

add_action( 'template_include', function ( $template ) {

	if ( get_query_var( 'playground' ) == '' ) {
		return $template;
	}

	$post_id = 2;
	$post    = get_post( $post_id );

// Haal ACF veldgegevens op voor deze pagina
	$acf_data = get_fields( $post_id );

// Voeg pagina- en ACF veldgegevens toe aan export array
	$export_data = [
		'ID'           => $post_id,
		'post_title'   => $post->post_title,
		'post_content' => $post->post_content,
		'acf_data'     => $acf_data
	];

// Genereer JSON-bestand
	$json_data = json_encode( $export_data );

// Stuur JSON-bestand naar browser om te downloaden
	header( 'Content-Type: application/json' );
	header( 'Content-Disposition: attachment; filename="page_export.json"' );
	echo $json_data;
	exit;
} );

