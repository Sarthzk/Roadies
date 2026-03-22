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

    // Kinetic Framework Fonts (Space Grotesk, Inter, and IBM Plex Sans for Numbers)
    wp_enqueue_style( 'rd-fonts', 'https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@800&family=Space+Grotesk:wght@300..900&family=Inter:wght@400..700&family=IBM+Plex+Sans:wght@400;700&display=swap', false );
    
    // Tailwind Engine
    wp_enqueue_script( 'rd-tailwind', 'https://cdn.tailwindcss.com', array(), null, false );

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
            font-variant-numeric: tabular-nums !important; 
            letter-spacing: -0.02em !important;
        }

        /* 4. WOOCOMMERCE UI CLEANUP */
        .woocommerce-Price-currencySymbol {
            margin-right: 4px;
            font-weight: 400; 
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

// Change Checkout Button Text
add_filter( 'woocommerce_order_button_text', function() {
    return __( 'CONFIRM GEAR — DEPART', 'hello-elementor-child' );
}, 99);

/* ---------------------------------------------------------------
 * 3. RIDER DASHBOARD: INITIALIZE PROFILE (SIMPLIFIED)
 * --------------------------------------------------------------- */

// Wipe the default dashboard content hook
remove_action( 'woocommerce_account_dashboard', 'woocommerce_account_dashboard' );

// Inject the custom Roadies Dashboard
add_action( 'woocommerce_account_dashboard', 'rd_kinetic_dashboard_greeting' );

function rd_kinetic_dashboard_greeting() {
    $current_user = wp_get_current_user();
    $first_name = !empty($current_user->user_firstname) ? $current_user->user_firstname : $current_user->display_name;
    
    ?>
    <div class="rd-profile-initialization">
        <div class="rd-spec-box" style="margin-bottom: 30px; border-color: #76d6d5; background: rgba(118, 214, 213, 0.02);">
            <span class="rd-spec-label">SYSTEM_STATUS: ONLINE // SESSION: ACTIVE</span>
            <h2 style="font-family: 'Space Grotesk', sans-serif; font-weight: 900; color: #fff; text-transform: uppercase; letter-spacing: 2px; margin: 10px 0; font-size: 24px;">
                RIDER PROFILE: <span class="text-teal"><?php echo esc_html( $first_name ); ?></span>
            </h2>
            <p style="font-family: 'Inter', sans-serif; color: #555; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; margin: 0;">
                Verified Hub: <span class="text-teal">Pimpri_HQ</span> // Accessing your gear and history...
            </p>
        </div>

        <div class="rd-panel" style="padding: 35px; background: #121416; border: 1px solid #222828;">
            <p style="margin: 0; font-size: 14px; line-height: 1.8; color: #999; font-family: 'Inter', sans-serif;">
                From your dashboard, you can track your 
                <a href="<?php echo esc_url( wc_get_endpoint_url( 'orders' ) ); ?>" class="text-teal" style="font-weight: 800; text-decoration: none; border-bottom: 1px solid #222828;">Recent Orders</a>, 
                manage your 
                <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address' ) ); ?>" class="text-teal" style="font-weight: 800; text-decoration: none; border-bottom: 1px solid #222828;">Shipping & Billing Addresses</a>, 
                and update your 
                <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ) ); ?>" class="text-teal" style="font-weight: 800; text-decoration: none; border-bottom: 1px solid #222828;">Account Settings</a>.
            </p>
        </div>
    </div>
    <?php
}

/* ---------------------------------------------------------------
 * 4. SVG & MEDIA SUPPORT
 * --------------------------------------------------------------- */
add_filter( 'upload_mimes', function( $mimes ) {
    if ( current_user_can( 'manage_options' ) ) {
        $mimes['svg']  = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';
    }
    return $mimes;
});

/* ---------------------------------------------------------------
 * 5. MODULE LOADER (The Engine)
 * --------------------------------------------------------------- */
require_once get_stylesheet_directory() . '/inc/riding-taxonomy.php';
require_once get_stylesheet_directory() . '/inc/ajax-cart.php';

/* ---------------------------------------------------------------
 * 6. WOOCOMMERCE THEME SUPPORT
 * --------------------------------------------------------------- */
add_action( 'after_setup_theme', function() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
});

/**
 * Auto-hide WooCommerce system notices after 4 seconds
 */
add_action('wp_footer', 'roadies_autohide_system_notices');
function roadies_autohide_system_notices() {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Wait 4 seconds (4000ms), then execute fade out
            setTimeout(function() {
                const notices = document.querySelectorAll('.woocommerce-message, .woocommerce-error, .woocommerce-info');
                
                notices.forEach(notice => {
                    // Apply smooth CSS transitions
                    notice.style.transition = 'opacity 0.6s ease, max-height 0.6s ease, margin 0.6s ease, padding 0.6s ease';
                    
                    // Collapse the element
                    notice.style.opacity = '0';
                    notice.style.maxHeight = '0px';
                    notice.style.margin = '0px';
                    notice.style.padding = '0px';
                    notice.style.border = 'none';
                    
                    // Completely remove from DOM after the animation finishes
                    setTimeout(() => notice.remove(), 600); 
                });
            }, 4000); // Change this number to adjust how long the notification stays on screen
        });
    </script>
    <?php
}

/**
 * ARMORY UI ENGINE V3
 * Bypasses Elementor to force Title, simple Size text, and +/- Buttons
 */
add_action('wp_footer', 'roadies_armory_ui_engine_v3');
function roadies_armory_ui_engine_v3() {
    if ( is_product() ) {
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                
                /* --- 1. THE AGGRESSIVE TITLE INJECTOR --- */
                if (!document.querySelector('h1.product_title')) {
                    // Grab the raw title from the browser tab
                    let rawTitle = document.title.split('-')[0].trim(); 
                    
                    // Find the main right-hand column container
                    const summaryContainer = document.querySelector('.summary.entry-summary') || document.querySelector('.summary');
                    
                    if (summaryContainer) {
                        const titleHtml = `<h1 class="product_title" style="font-family: 'Space Grotesk', sans-serif !important; font-size: 42px !important; font-weight: 900 !important; text-transform: uppercase; line-height: 1.1; margin-top: 0; margin-bottom: 20px !important; display: block; width: 100%;">${rawTitle}</h1>`;
						
                        // Inject the title at the very top of the right column
                        summaryContainer.insertAdjacentHTML('afterbegin', titleHtml);
                    }
                }

                /* --- 2. THE "SIMPLE TEXT" VARIATION FIX --- */
                const variationRows = document.querySelectorAll('table.variations tr');
                variationRows.forEach(function(row) {
                    const labelTd = row.querySelector('td.label');
                    const valueTd = row.querySelector('td.value');
                    
                    if (labelTd && valueTd && !valueTd.querySelector('.rd-simple-text')) {
                        // Grab the text (e.g. "Size")
                        const labelText = labelTd.innerText.trim();
                        
                        // NUKE the stubborn Elementor box completely
                        labelTd.style.display = 'none'; 
                        
                        // Create a simple, floating text element
                        const simpleText = document.createElement('span');
                        simpleText.className = 'rd-simple-text';
                        simpleText.innerText = labelText;
                        simpleText.style.cssText = "color: #888; font-family: 'Space Grotesk', sans-serif; text-transform: uppercase; font-size: 14px; font-weight: 700; letter-spacing: 2px; margin-right: 20px; white-space: nowrap;";
                        
                        // Turn the dropdown container into a perfectly aligned flex row
                        valueTd.style.cssText = "display: flex !important; align-items: center !important; background: transparent !important; border: none !important; padding: 0 !important; margin-bottom: 25px;";
                        
                        // Ensure the select dropdown fills the remaining space
                        const selectBox = valueTd.querySelector('select');
                        if (selectBox) {
                            selectBox.style.flexGrow = '1';
                            selectBox.style.margin = '0';
                        }

                        // Inject the simple text right before the dropdown
                        valueTd.insertBefore(simpleText, valueTd.firstChild);
                    }
                });

                /* --- 3. QUANTITY +/- INJECTOR --- */
                const qtyInputs = document.querySelectorAll('input.qty');
                qtyInputs.forEach(function(input) {
                    if (input.parentElement.classList.contains('rd-qty-wrap')) return;

                    const wrapper = document.createElement('div');
                    wrapper.className = 'rd-qty-wrap';
                    
                    const minusBtn = document.createElement('button');
                    minusBtn.type = 'button';
                    minusBtn.className = 'rd-qty-btn minus';
                    minusBtn.innerText = '-';

                    const plusBtn = document.createElement('button');
                    plusBtn.type = 'button';
                    plusBtn.className = 'rd-qty-btn plus';
                    plusBtn.innerText = '+';

                    input.parentNode.insertBefore(wrapper, input);
                    wrapper.appendChild(minusBtn);
                    wrapper.appendChild(input);
                    wrapper.appendChild(plusBtn);

                    minusBtn.addEventListener('click', function() {
                        let val = parseFloat(input.value) || 0;
                        let min = parseFloat(input.min) || 1;
                        let step = parseFloat(input.step) || 1;
                        if (val > min) {
                            input.value = val - step;
                            input.dispatchEvent(new Event('change', { bubbles: true })); 
                        }
                    });

                    plusBtn.addEventListener('click', function() {
                        let val = parseFloat(input.value) || 0;
                        let max = parseFloat(input.max) || 9999;
                        let step = parseFloat(input.step) || 1;
                        if (val < max) {
                            input.value = val + step;
                            input.dispatchEvent(new Event('change', { bubbles: true })); 
                        }
                    });
                });
                
            });
        </script>
        <?php
    }
}

/**
 * ARMORY THEME TOGGLE ENGINE
 * Injects a floating HUD button and handles Light/Dark LocalStorage logic.
 */
add_action('wp_footer', 'roadies_theme_toggle_engine');
function roadies_theme_toggle_engine() {
    ?>
    <button id="rd-theme-toggle" class="rd-theme-toggle" aria-label="Toggle Theme">
        <span class="theme-icon">🌙</span>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('rd-theme-toggle');
            const body = document.body;
            const icon = toggleBtn.querySelector('.theme-icon');

            // 1. Check user's previous preference on page load
            const currentTheme = localStorage.getItem('roadies_theme');
            
            if (currentTheme === 'light') {
                body.setAttribute('data-theme', 'light');
                icon.innerText = '☀️';
            } else {
                body.setAttribute('data-theme', 'dark'); // Default state
                icon.innerText = '🌙';
            }

            // 2. Listen for clicks and swap states
            toggleBtn.addEventListener('click', function() {
                if (body.getAttribute('data-theme') === 'light') {
                    // Switch to Dark
                    body.setAttribute('data-theme', 'dark');
                    localStorage.setItem('roadies_theme', 'dark');
                    icon.innerText = '🌙';
                } else {
                    // Switch to Light
                    body.setAttribute('data-theme', 'light');
                    localStorage.setItem('roadies_theme', 'light');
                    icon.innerText = '☀️';
                }
            });
        });
    </script>
    <?php
}