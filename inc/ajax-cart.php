<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Build the HTML for the Slide-Out Cart Panel
add_action('wp_footer', function() {
    if ( is_cart() || is_checkout() ) return; // Don't show on checkout pages
    ?>
    <div id="roadies-side-cart" style="position:fixed; top:0; right:-450px; width:400px; max-width:100%; height:100vh; background:#1a1a1a; color:#f0f0f0; z-index:9999; transition: right 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); border-left: 2px solid #008080; padding: 25px; box-shadow: -10px 0 30px rgba(0,0,0,0.8);">
        
        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #333; padding-bottom:15px; margin-bottom:20px;">
            <h3 style="margin:0; font-family:'Barlow Condensed', sans-serif; text-transform:uppercase; letter-spacing:2px; color:#fff;">Garage (Cart)</h3>
            <button id="close-side-cart" style="background:none; border:none; color:#f0f0f0; font-size:28px; cursor:pointer; padding:0; line-height:1;">&times;</button>
        </div>

        <div class="widget_shopping_cart_content" style="height: calc(100vh - 100px); overflow-y: auto;">
            </div>

    </div>

    <div id="roadies-cart-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100vh; background:rgba(0,0,0,0.6); backdrop-filter: blur(3px); z-index:9998;"></div>
    <?php
});

// 2. The JavaScript AJAX Interceptor
add_action('wp_footer', function() {
    if ( is_cart() || is_checkout() ) return;
    ?>
    <script>
    jQuery(document).ready(function($) {
        
        // UI Functions
        function openRoadiesCart() {
            $('#roadies-side-cart').css('right', '0');
            $('#roadies-cart-overlay').fadeIn(200);
        }

        function closeRoadiesCart() {
            $('#roadies-side-cart').css('right', '-450px');
            $('#roadies-cart-overlay').fadeOut(200);
        }

        $('#close-side-cart, #roadies-cart-overlay').on('click', closeRoadiesCart);

        // Listen for normal Woo events (Shop Page clicks)
        $(document.body).on('added_to_cart', function() {
            openRoadiesCart();
        });

        // HIJACK THE SINGLE PRODUCT PAGE FORM
        $('form.cart').on('submit', function(e) {
            e.preventDefault(); // Stop the page reload!
            
            var $form = $(this),
                $button = $form.find('button[type="submit"]');

            if ($button.hasClass('disabled')) return;

            // Gather product data
            var formData = new FormData($form[0]);
            formData.append('add-to-cart', $button.val());

            // Visual feedback
            $button.text('EQUIPPING...').css('opacity', '0.7');

            // Send the AJAX request
            $.ajax({
                url: wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'),
                data: formData,
                type: 'POST',
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.error && response.product_url) {
                        window.location = response.product_url; // Redirect if variation error
                        return;
                    }
                    
                    // Tell WooCommerce to update the cart HTML, which triggers our open event
                    $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $button]);
                    
                    // Reset button
                    $button.text('EQUIP GEAR').css('opacity', '1');
                }
            });
        });
    });
    </script>
    <?php
}, 100);