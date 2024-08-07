<?php

use function Kmoconnect\Helpers\theme;

$theme = theme();
$theme->addSupport( "woocommerce" )
      ->addSupport( "wc-product-gallery-lightbox" )
      ->addSupport( "wc-product-gallery-slider" );

// own woocommerce support functions
$theme->addSupport( "stw-wc-single-product", [ "accordions" => true, "tabs" => false ] );

// register widgets
$theme->addWidget( "Shop bar", 1 );
$theme->addWidget( "Shop sidebar", 1 );
$theme->addWidget( "Shop offcanvas", 1 );