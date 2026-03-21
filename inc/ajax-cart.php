<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action('wp_footer', function() {
    if ( is_cart() || is_checkout() ) return; ?>
    <div id="roadies-side-cart" class="rd-panel" style="position:fixed; top:0; right:-500px; width:450px; max-width:100%; height:100vh; z-index:9999; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); border-left: 1px solid #222828; background: #0c0e10; display: flex; flex-direction: column;">
        <div class="p-8 border-b border-[#222828] flex justify-between items-center bg-[#0e1113]">
            <div>
                <h3 style="color:#76d6d5; font-family:'Space Grotesk', sans-serif; font-weight:900; text-transform:uppercase; margin:0;">Your Garage</h3>
                <p style="font-family:'Inter', sans-serif; font-size:10px; color:#666; letter-spacing:2px; text-transform:uppercase;">The Rider's HUB</p>
            </div>
            <button id="close-side-cart" style="background:none; border:none; color:#76d6d5; font-size:32px; cursor:pointer;">&times;</button>
        </div>
        <div class="widget_shopping_cart_content p-8 overflow-y-auto flex-grow">
            <?php woocommerce_mini_cart(); ?>
        </div>
    </div>
    <div id="roadies-cart-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100vh; background:rgba(0,0,0,0.85); backdrop-filter: blur(10px); z-index:9998;"></div>
    <style>
    /* 1. MASTER PANEL ARCHITECTURE */
    #roadies-side-cart {
        display: flex !important;
        flex-direction: column !important;
        background: #0c0e10 !important; /* Kinetic Dark */
        box-shadow: -20px 0 50px rgba(0,0,0,0.95) !important;
        border-left: 1px solid #222828 !important;
    }

    #roadies-side-cart * {
        border-radius: 0 !important; /* The CNC Rule: No rounding */
        font-family: 'Inter', sans-serif !important;
        box-sizing: border-box;
    }

    /* 2. DYNAMIC CONTENT AREA */
    #roadies-side-cart .widget_shopping_cart_content {
        display: flex !important;
        flex-direction: column !important;
        height: 100% !important;
        padding: 0 30px 30px 30px !important;
    }

    /* This pushes the subtotal and buttons to the absolute bottom */
    #roadies-side-cart .cart_list {
        flex-grow: 1 !important;
        overflow-y: auto !important;
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* 3. PRODUCT ITEM STYLING */
    #roadies-side-cart .mini_cart_item {
        display: flex !important;
        align-items: center;
        gap: 20px;
        padding: 25px 0 !important;
        border-bottom: 1px solid #1a1d1f !important;
        position: relative;
    }

    #roadies-side-cart .mini_cart_item img {
        width: 80px !important;
        height: 80px !important;
        object-fit: contain;
        background: #121416;
        border: 1px solid #222828;
        padding: 10px;
        mix-blend-mode: lighten;
    }

    #roadies-side-cart .mini_cart_item a:not(.remove) {
        color: #ffffff !important;
        font-family: 'Space Grotesk', sans-serif !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        font-size: 13px !important;
        text-decoration: none !important;
        line-height: 1.3;
    }

    #roadies-side-cart .quantity {
        display: block;
        margin-top: 5px;
        color: #76d6d5 !important; /* Kinetic Teal */
        font-family: 'Space Grotesk', sans-serif !important;
        font-weight: 700;
        font-size: 14px !important;
    }

    /* 4. FOOTER: SUBTOTAL & POSITIONING */
    #roadies-side-cart .total {
        margin-top: auto !important;
        padding: 30px 0 20px 0 !important;
        border-top: 2px solid #76d6d5 !important; /* Teal Accent Line */
        display: flex !important;
        justify-content: space-between !important;
        align-items: baseline !important;
        background: #0c0e10;
    }

    #roadies-side-cart .total strong {
        color: #666;
        font-family: 'Space Grotesk', sans-serif !important;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 2px;
    }

    #roadies-side-cart .total .amount {
        color: #ffffff !important;
        font-size: 26px !important;
        font-weight: 900 !important;
        font-family: 'Space Grotesk', sans-serif !important;
    }

    /* 5. ACTION BUTTONS */
    #roadies-side-cart .buttons {
        display: flex !important;
        flex-direction: column !important;
        gap: 12px !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    #roadies-side-cart .buttons a {
        display: block !important;
        width: 100% !important;
        padding: 22px !important;
        text-align: center !important;
        font-family: 'Space Grotesk', sans-serif !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        letter-spacing: 2px !important;
        font-size: 12px !important;
        text-decoration: none !important;
        transition: all 0.3s ease !important;
    }

    /* View Cart Button */
    #roadies-side-cart .buttons a.wc-forward:not(.checkout) {
        background: transparent !important;
        border: 1px solid #222828 !important;
        color: #888 !important;
    }

    #roadies-side-cart .buttons a.wc-forward:hover {
        border-color: #76d6d5 !important;
        color: #fff !important;
    }

    /* Checkout Button */
    #roadies-side-cart .buttons a.checkout {
        background: #76d6d5 !important; /* Teal */
        color: #000 !important;
    }

    #roadies-side-cart .buttons a.checkout:hover {
        background: #ffffff !important;
        box-shadow: 0 0 20px rgba(118, 214, 213, 0.5);
    }

    /* 6. UTILITY: REMOVE BUTTON */
    #roadies-side-cart .remove_from_cart_button {
        color: #444 !important;
        font-size: 20px !important;
        background: transparent !important;
        transition: color 0.2s;
    }

    #roadies-side-cart .remove_from_cart_button:hover {
        color: #ff4444 !important;
    }

</style>
    

    <script>
    jQuery(document).ready(function($) {
        function openCart() { $('#roadies-side-cart').css('right', '0'); $('#roadies-cart-overlay').fadeIn(300); }
        function closeCart() { $('#roadies-side-cart').css('right', '-500px'); $('#roadies-cart-overlay').fadeOut(300); }
        $(document).on('click', '#roadies-cart-toggle, #close-side-cart, #roadies-cart-overlay', function(e) {
            e.preventDefault(); (this.id === 'roadies-cart-toggle') ? openCart() : closeCart();
        });
        $(document.body).on('added_to_cart', function() { openCart(); });
    });
    </script>
<?php }, 100);
