<?php
/**
 * Hello Elementor Child Theme — functions.php
 * ROADIES KINETIC FRAMEWORK — v3.1.0
 * Unified Branding & AJAX Engine
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ---------------------------------------------------------------
 * 1. CORE ENQUEUES & KINETIC UI OVERRIDE
 * --------------------------------------------------------------- */
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

    wp_enqueue_style( 'rd-fonts', 'https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@800&family=Space+Grotesk:wght@300..900&family=Inter:wght@400..700&family=IBM+Plex+Sans:wght@400;700&display=swap', false );
    
    wp_enqueue_script( 'rd-tailwind', 'https://cdn.tailwindcss.com', array(), null, false );

    wp_enqueue_style( 'hello-elementor-child-style', get_stylesheet_uri(), ['parent-style'], '3.1.0' );

    if ( is_front_page() || is_product_category() ) {
        wp_enqueue_script( 'wc-add-to-cart' );
    }
}, 99 );

// Force the baseline Dark Mode colors sitewide
add_action( 'wp_head', function() {
    echo '<style>
        /* Only apply dark defaults when NOT in light mode */
        body:not([data-theme="light"]) {
            background: #0c0e10 !important; 
            color: #ffffff !important; 
        }
        
        html { 
            margin: 0 !important; 
            padding: 0 !important; 
            overflow-x: hidden; 
        }

        .entry-title, .page-header, .archive-title { display: none !important; }
        #content { padding: 0 !important; margin: 0 !important; }
        
        .rd-chassis-max { max-width: 1400px; margin: 0 auto; width: 100%; }
        .text-teal { color: #76d6d5 !important; }
        .bg-teal { background-color: #76d6d5 !important; }

        .amount, .price, .quantity, .total .amount, 
        .roadies-safety-badge__score, .cart-contents-count { 
            font-family: "IBM Plex Sans", sans-serif !important; 
            font-weight: 700 !important; 
            font-variant-numeric: tabular-nums !important; 
            letter-spacing: -0.02em !important;
        }

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
add_filter( 'woocommerce_product_add_to_cart_text', 'rd_custom_btn_text', 10, 2 );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'rd_custom_btn_text', 10, 2 );
function rd_custom_btn_text( $text, $product ) {
    return __( 'EQUIP GEAR', 'hello-elementor-child' );
}

add_filter( 'woocommerce_order_button_text', function() {
    return __( 'CONFIRM GEAR — DEPART', 'hello-elementor-child' );
}, 99);

/* ---------------------------------------------------------------
 * 3. RIDER DASHBOARD
 * --------------------------------------------------------------- */
remove_action( 'woocommerce_account_dashboard', 'woocommerce_account_dashboard' );
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
 * 5. MODULE LOADER
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

/* ---------------------------------------------------------------
 * 7. AUTO-HIDE WOOCOMMERCE NOTICES
 * --------------------------------------------------------------- */
add_action('wp_footer', 'roadies_autohide_system_notices');
function roadies_autohide_system_notices() {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const notices = document.querySelectorAll('.woocommerce-message, .woocommerce-error, .woocommerce-info');
                notices.forEach(notice => {
                    notice.style.transition = 'opacity 0.6s ease, max-height 0.6s ease, margin 0.6s ease, padding 0.6s ease';
                    notice.style.opacity = '0';
                    notice.style.maxHeight = '0px';
                    notice.style.margin = '0px';
                    notice.style.padding = '0px';
                    notice.style.border = 'none';
                    setTimeout(() => notice.remove(), 600);
                });
            }, 4000);
        });
    </script>
    <?php
}

/* ---------------------------------------------------------------
 * 8. ARMORY UI ENGINE V3 (Product Page)
 * --------------------------------------------------------------- */
add_action('wp_footer', 'roadies_armory_ui_engine_v3');
function roadies_armory_ui_engine_v3() {
    if ( is_product() ) {
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                
                /* --- 1. TITLE INJECTOR --- */
                if (!document.querySelector('h1.product_title')) {
                    let rawTitle = document.title.split('-')[0].trim(); 
                    const summaryContainer = document.querySelector('.summary.entry-summary') || document.querySelector('.summary');
                    if (summaryContainer) {
                        const titleHtml = `<h1 class="product_title" style="font-family: 'Space Grotesk', sans-serif !important; font-size: 42px !important; font-weight: 900 !important; text-transform: uppercase; line-height: 1.1; margin-top: 0; margin-bottom: 20px !important; display: block; width: 100%;">${rawTitle}</h1>`;
                        summaryContainer.insertAdjacentHTML('afterbegin', titleHtml);
                    }
                }

                /* --- 2. VARIATION TEXT FIX --- */
                const variationRows = document.querySelectorAll('table.variations tr');
                variationRows.forEach(function(row) {
                    const labelTd = row.querySelector('td.label');
                    const valueTd = row.querySelector('td.value');
                    if (labelTd && valueTd && !valueTd.querySelector('.rd-simple-text')) {
                        const labelText = labelTd.innerText.trim();
                        labelTd.style.display = 'none'; 
                        const simpleText = document.createElement('span');
                        simpleText.className = 'rd-simple-text';
                        simpleText.innerText = labelText;
                        simpleText.style.cssText = "color: #888; font-family: 'Space Grotesk', sans-serif; text-transform: uppercase; font-size: 14px; font-weight: 700; letter-spacing: 2px; margin-right: 20px; white-space: nowrap;";
                        valueTd.style.cssText = "display: flex !important; align-items: center !important; background: transparent !important; border: none !important; padding: 0 !important; margin-bottom: 25px;";
                        const selectBox = valueTd.querySelector('select');
                        if (selectBox) { selectBox.style.flexGrow = '1'; selectBox.style.margin = '0'; }
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
                        if (val > min) { input.value = val - step; input.dispatchEvent(new Event('change', { bubbles: true })); }
                    });
                    plusBtn.addEventListener('click', function() {
                        let val = parseFloat(input.value) || 0;
                        let max = parseFloat(input.max) || 9999;
                        let step = parseFloat(input.step) || 1;
                        if (val < max) { input.value = val + step; input.dispatchEvent(new Event('change', { bubbles: true })); }
                    });
                });
            });
        </script>
        <?php
    }
}

/* ---------------------------------------------------------------
 * 9. THEME TOGGLE ENGINE (FIXED)
 * — Strips Elementor inline styles on light mode
 * — Restores them via reload on dark mode
 * --------------------------------------------------------------- */
add_action('wp_footer', 'roadies_theme_toggle_engine');
function roadies_theme_toggle_engine() {
    ?>
    <button id="rd-theme-toggle" class="rd-theme-toggle" aria-label="Toggle Theme">
        <span class="theme-icon">🌙</span>
    </button>

    <script>
        (function() {
            const toggleBtn = document.getElementById('rd-theme-toggle');
            const body      = document.body;
            const icon      = toggleBtn.querySelector('.theme-icon');

            // Elementor containers that carry hardcoded inline background styles
            const EL_SELECTORS = [
                '.elementor-section',
                '.elementor-column',
                '.elementor-widget-wrap',
                '.elementor-widget-container',
                '.e-con',
                '.e-con-inner',
                '.e-child'
            ];

            function stripElementorBg() {
                EL_SELECTORS.forEach(function(sel) {
                    document.querySelectorAll(sel).forEach(function(el) {
                        el.style.removeProperty('background-color');
                        el.style.removeProperty('background');
                        el.style.removeProperty('color');
                    });
                });
            }

            function applyLight() {
                body.setAttribute('data-theme', 'light');
                icon.innerText = '☀️';
                stripElementorBg();
            }

            function applyDark() {
                body.setAttribute('data-theme', 'dark');
                icon.innerText = '🌙';
                // Reload restores all Elementor inline styles naturally
                location.reload();
            }

            // On page load — apply saved preference immediately
            // Run BEFORE DOMContentLoaded so there's no flash of wrong theme
            var saved = localStorage.getItem('roadies_theme') || 'dark';

            if (saved === 'light') {
                body.setAttribute('data-theme', 'light');
                icon.innerText = '☀️';
                // Strip after DOM is ready
                document.addEventListener('DOMContentLoaded', function() {
                    stripElementorBg();
                });
            } else {
                body.setAttribute('data-theme', 'dark');
                icon.innerText = '🌙';
            }

            // Toggle click handler
            toggleBtn.addEventListener('click', function() {
                var current = body.getAttribute('data-theme');
                if (current === 'light') {
                    localStorage.setItem('roadies_theme', 'dark');
                    applyDark();
                } else {
                    localStorage.setItem('roadies_theme', 'light');
                    applyLight();
                }
            });
        })();
    </script>
    <?php
}