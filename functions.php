<?php
/**
 * ROADIES KINETIC FRAMEWORK — functions.php
 * v3.0.3 - High-Contrast White Text Override
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'rd-fonts', 'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@400;500;600&display=swap', false );
    wp_enqueue_script( 'rd-tailwind', 'https://cdn.tailwindcss.com', array(), null, false );
    wp_enqueue_style( 'rd-style', get_stylesheet_uri(), array(), '3.0.3' );
});

// Force the baseline colors
add_action( 'wp_head', function() {
    echo '<style>
        html, body { background: #121416 !important; color: #ffffff !important; margin: 0 !important; padding: 0 !important; }
        .entry-title, .page-header, .archive-title { display: none !important; }
        #content { padding: 0 !important; margin: 0 !important; }
    </style>';
});