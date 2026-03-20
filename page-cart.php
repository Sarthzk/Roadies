<?php
/**
 * Template Name: Kinetic Cart Page
 */
get_header(); ?>

<div class="rd-chassis-max py-20 px-6">
    <header class="mb-12 border-b border-[#222828] pb-8">
        <h1 class="rd-hero-title text-5xl">Your <span class="text-teal">Garage</span></h1>
        <p class="text-gray-500 uppercase tracking-widest text-xs mt-2">The Rider's HUB / Secure Checkout</p>
    </header>

    <div class="rd-panel p-8 bg-[#0c0e10]">
        <?php echo do_shortcode('[woocommerce_cart]'); ?>
    </div>
</div>

<style>
    /* Force Cart Table to Dark Mode */
    .woocommerce-cart-form, .cart-collaterals { background: transparent !important; color: #fff !important; }
    .shop_table { border: 1px solid #222828 !important; background: #0e1113 !important; }
    .shop_table th { background: #121416 !important; color: #76d6d5 !important; text-transform: uppercase; letter-spacing: 1px; padding: 20px !important; }
    .cart_item { border-bottom: 1px solid #222828 !important; }
    .product-name a { color: #fff !important; font-weight: 700 !important; text-decoration: none !important; }
    .product-price, .product-subtotal { color: #76d6d5 !important; font-family: 'Space Grotesk', sans-serif; }
    
    /* Buttons */
    .button[name="update_cart"] { background: transparent !important; border: 1px solid #222828 !important; color: #666 !important; text-transform: uppercase; }
    .checkout-button { background: #76d6d5 !important; color: #000 !important; font-weight: 900 !important; text-transform: uppercase; padding: 20px !important; width: 100% !important; display: block !important; text-align: center !important; }
    
    /* Inputs */
    .quantity input { background: #000 !important; border: 1px solid #222828 !important; color: #fff !important; padding: 10px !important; }
</style>

<?php get_footer(); ?>