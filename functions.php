<?php
/**
 * Hello Elementor Child Theme — functions.php
 * ROADIES KINETIC FRAMEWORK — v3.1.0
 * Unified Branding & AJAX Engine
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // block direct file access.
}

/* ---------------------------------------------------------------
 * 1. CORE ENQUEUES & KINETIC UI OVERRIDE
 * --------------------------------------------------------------- */
add_action( 'wp_enqueue_scripts', function() {
    // Parent Theme Styles
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

    // Kinetic Framework Fonts & Tailwind
    wp_enqueue_style( 'rd-fonts', 'https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..900&family=Inter:wght@400..700&display=swap', false );
    wp_enqueue_script( 'rd-tailwind', 'https://cdn.tailwindcss.com', array(), null, false );
	wp_enqueue_style( 'rd-fonts', 'https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@800&family=Space+Grotesk:wght@300..900&family=Inter:wght@400..700&family=IBM+Plex+Sans:wght@400;700&display=swap', false );

    // Child Theme Styles
    wp_enqueue_style( 'hello-elementor-child-style', get_stylesheet_uri(), ['parent-style'], '3.1.0' );

    // Force WooCommerce AJAX engine on the Front Page
    if ( is_front_page() || is_product_category() ) {
        wp_enqueue_script( 'wc-add-to-cart' );
    }
}, 99 );

// Force the baseline Dark Mode colors sitewide
add_action( 'wp_head', function() {
    echo '<style>
        /* 1. GLOBAL RESET & BASE COLORS */
        html, body { 
            background: #0c0e10 !important; 
            color: #ffffff !important; 
            margin: 0 !important; 
            padding: 0 !important; 
            overflow-x: hidden; 
        }
        
        .entry-title, .page-header, .archive-title { display: none !important; }
        #content { padding: 0 !important; margin: 0 !important; }
        
        /* 2. LAYOUT & ACCENTS */
        .rd-chassis-max { max-width: 1400px; margin: 0 auto; width: 100%; }
        .text-teal { color: #76d6d5 !important; }
        .bg-teal { background-color: #76d6d5 !important; }

        /* 3. IBM PLEX SANS FOR NUMERICAL DATA (Prices & Quantities) */
        .amount, 
        .price, 
        .quantity, 
        .total .amount, 
        .roadies-safety-badge__score,
        .cart-contents-count { 
            font-family: "IBM Plex Sans", sans-serif !important; 
            font-weight: 700 !important; 
            font-variant-numeric: tabular-nums !important; /* Forces numbers to align in columns */
            letter-spacing: -0.02em !important;
        }

        /* 4. WOOCOMMERCE UI CLEANUP */
        .woocommerce-Price-currencySymbol {
            margin-right: 4px;
            font-weight: 400; /* Slightly thinner symbol makes the numbers pop */
            color: #76d6d5;
        }
    </style>';
});

/* ---------------------------------------------------------------
 * 2. ROADIES — UI REWRITES (EQUIP GEAR)
 * --------------------------------------------------------------- */

// Change "Add to Cart" to "EQUIP GEAR" across the board
add_filter( 'woocommerce_product_add_to_cart_text', 'rd_custom_btn_text', 10, 2 );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'rd_custom_btn_text', 10, 2 );
function rd_custom_btn_text( $text, $product ) {
    return __( 'EQUIP GEAR', 'hello-elementor-child' );
}


// Change Checkout Button Text (Force Priority 99)
add_filter( 'woocommerce_order_button_text', function() {
    return __( 'CONFIRM GEAR — DEPART', 'hello-elementor-child' );
}, 99);

/* ---------------------------------------------------------------
 * 3. SVG & MEDIA SUPPORT
 * --------------------------------------------------------------- */
add_filter( 'upload_mimes', function( $mimes ) {
    if ( current_user_can( 'manage_options' ) ) {
        $mimes['svg']  = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';
    }
    return $mimes;
});

/* ---------------------------------------------------------------
 * 4. MODULE LOADER (The Engine)
 * --------------------------------------------------------------- */

// Custom taxonomy for Riding Styles (Track, Street, Adventure)
require_once get_stylesheet_directory() . '/inc/riding-taxonomy.php';

// AJAX slide-out cart functionality (The Garage)
require_once get_stylesheet_directory() . '/inc/ajax-cart.php';

/* ---------------------------------------------------------------
 * 5. WOOCOMMERCE THEME SUPPORT
 * --------------------------------------------------------------- */
add_action( 'after_setup_theme', function() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
});
