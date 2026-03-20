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
        #roadies-side-cart * { border-radius: 0 !important; font-family: 'Inter', sans-serif !important; }
        #roadies-side-cart .mini_cart_item { border-bottom: 1px solid #222828 !important; color: #fff; padding: 15px 0 !important; }
        #roadies-side-cart .buttons a.checkout { background: #76d6d5 !important; color: #000 !important; font-weight: 800; text-transform: uppercase; }
        #roadies-side-cart .total { border-top: 2px solid #76d6d5 !important; padding-top: 15px; color: #fff; text-transform: uppercase; }
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