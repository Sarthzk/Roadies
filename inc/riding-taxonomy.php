<?php
/**
 * Plugin Name: Roadies – Riding Style Taxonomy
 * Description: Registers a hierarchical "Riding Style" taxonomy for WooCommerce products
 *              and seeds it with four default terms on activation.
 * Version:     1.0.0
 */

defined( 'ABSPATH' ) || exit;

// ─────────────────────────────────────────────────────────────────
// 1. REGISTER THE TAXONOMY
// ─────────────────────────────────────────────────────────────────

add_action( 'init', 'roadies_register_riding_style_taxonomy' );

function roadies_register_riding_style_taxonomy() {

    $labels = array(
        'name'              => _x( 'Riding Styles', 'taxonomy general name',  'roadies' ),
        'singular_name'     => _x( 'Riding Style',  'taxonomy singular name', 'roadies' ),
        'search_items'      => __( 'Search Riding Styles',   'roadies' ),
        'all_items'         => __( 'All Riding Styles',      'roadies' ),
        'parent_item'       => __( 'Parent Riding Style',    'roadies' ),
        'parent_item_colon' => __( 'Parent Riding Style:',   'roadies' ),
        'edit_item'         => __( 'Edit Riding Style',      'roadies' ),
        'update_item'       => __( 'Update Riding Style',    'roadies' ),
        'add_new_item'      => __( 'Add New Riding Style',   'roadies' ),
        'new_item_name'     => __( 'New Riding Style Name',  'roadies' ),
        'menu_name'         => __( 'Riding Styles',          'roadies' ),
        'not_found'         => __( 'No riding styles found', 'roadies' ),
        'back_to_items'     => __( '← Back to Riding Styles', 'roadies' ),
    );

    $args = array(
        'labels'             => $labels,
        'hierarchical'       => true,           // behaves like categories, not tags
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,           // appears in the WP admin sidebar
        'show_in_nav_menus'  => true,
        'show_in_rest'       => true,           // enables Gutenberg / block-editor support
        'show_admin_column'  => true,           // shows column on the Products list table
        'query_var'          => true,
        'rewrite'            => array(
            'slug'         => 'riding-style',
            'with_front'   => false,
            'hierarchical' => true,
        ),
        // Tie into WooCommerce's product-attribute meta box
        'meta_box_cb'        => false,          // false = let WooCommerce render its own UI
    );

    register_taxonomy( 'riding_style', array( 'product' ), $args );
}

// ─────────────────────────────────────────────────────────────────
// 2. SHOW INSIDE THE WOOCOMMERCE PRODUCT EDITOR
//    WooCommerce auto-discovers hierarchical taxonomies attached to
//    'product', but the filter below makes that explicit and lets
//    you control the order / position in the editor sidebar.
// ─────────────────────────────────────────────────────────────────

add_filter( 'woocommerce_product_data_tabs', 'roadies_add_riding_style_to_wc_editor' );

function roadies_add_riding_style_to_wc_editor( $tabs ) {
    // Nothing extra needed for hierarchical taxonomies – WooCommerce renders
    // them automatically in the right-hand "Product categories"-style box.
    // This filter is left here as an extension point if you later need a
    // dedicated custom tab.
    return $tabs;
}

// ─────────────────────────────────────────────────────────────────
// 3. SEED DEFAULT TERMS
//    Runs once on plugin/theme activation, or safely on every request
//    because wp_insert_term() quietly skips existing terms.
// ─────────────────────────────────────────────────────────────────

add_action( 'init', 'roadies_seed_riding_style_terms', 20 );

function roadies_seed_riding_style_terms() {

    // Only seed when the taxonomy exists (i.e. after hook priority 10 above).
    if ( ! taxonomy_exists( 'riding_style' ) ) {
        return;
    }

    $default_terms = array(
        'Sport/Track'       => 'sport-track',
        'Adventure/Touring' => 'adventure-touring',
        'Urban/Commute'     => 'urban-commute',
        'Cruiser'           => 'cruiser',
    );

    foreach ( $default_terms as $term_name => $term_slug ) {
        if ( ! term_exists( $term_name, 'riding_style' ) ) {
            wp_insert_term(
                $term_name,
                'riding_style',
                array( 'slug' => $term_slug )
            );
        }
    }
}

// ─────────────────────────────────────────────────────────────────
// 4. FLUSH REWRITE RULES ON ACTIVATION
//    Drop this into your main plugin file, or call it from your
//    theme's after_switch_theme hook if you're adding this to a theme.
// ─────────────────────────────────────────────────────────────────

register_activation_hook( __FILE__, 'roadies_flush_rewrite_rules' );

function roadies_flush_rewrite_rules() {
    roadies_register_riding_style_taxonomy();
    roadies_seed_riding_style_terms();
    flush_rewrite_rules();
}