<?php
/**
 * Template Name: Roadies Checkout Page
 * Layout: Kinetic Armory Form
 */
get_header(); ?>

<div id="roadies-checkout-gate" class="rd-chassis-max" style="padding: 80px 20px; min-height: 80vh; background: #0c0e10; display: flex; flex-direction: column; align-items: center;">
    
    <div style="margin-bottom: 60px; border-left: 4px solid #76d6d5; padding-left: 20px; align-self: flex-start; max-width: 1200px; width: 100%; margin-left: auto; margin-right: auto;">
        <h1 style="font-family: 'Space Grotesk', sans-serif; font-weight: 900; color: #fff; text-transform: uppercase; margin: 0; font-size: 42px;">
            Secure Checkout
        </h1>
        <p style="color: #666; font-family: 'Inter', sans-serif; letter-spacing: 3px; font-size: 11px; margin-top: 10px; text-transform: uppercase;">
            Encrypted Gateway // Fast Dispatch
        </p>
    </div>

    <div class="roadies-checkout-wrapper" style="width: 100%; max-width: 1200px;">
        <?php echo do_shortcode('[woocommerce_checkout]'); ?>
    </div>

</div>

<style>
    /* 1. Rigid CSS Grid Layout (Fixes the wrapping issue) */
    #roadies-checkout-gate form.woocommerce-checkout {
        display: grid !important;
        grid-template-columns: 55% 40% !important;
        justify-content: space-between !important;
        align-items: start !important;
    }

    #roadies-checkout-gate #customer_details {
        grid-column: 1 !important;
        grid-row: 1 / 3 !important; /* Spans multiple rows on the left */
        width: 100% !important;
        max-width: 100% !important;
    }

    #roadies-checkout-gate #order_review_heading {
        grid-column: 2 !important;
        grid-row: 1 !important;
        margin-bottom: 0 !important;
    }

    #roadies-checkout-gate #order_review {
        grid-column: 2 !important;
        grid-row: 2 !important;
        width: 100% !important;
    }

    /* Headings */
    #roadies-checkout-gate .woocommerce-checkout h3 {
        font-family: 'Space Grotesk', sans-serif !important;
        color: #76d6d5 !important;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 24px;
        border-bottom: 2px solid #222828;
        padding-bottom: 15px;
        margin-bottom: 30px;
        margin-top: 0;
    }

    /* Form Labels */
    #roadies-checkout-gate .woocommerce-checkout label {
        color: #888 !important;
        font-family: 'Inter', sans-serif;
        text-transform: uppercase;
        font-size: 10px;
        letter-spacing: 2px;
        font-weight: 700;
        display: block;
        margin-bottom: 8px;
    }

    /* Standard Input Fields */
    #roadies-checkout-gate .woocommerce-checkout input[type="text"],
    #roadies-checkout-gate .woocommerce-checkout input[type="email"],
    #roadies-checkout-gate .woocommerce-checkout input[type="tel"],
    #roadies-checkout-gate .woocommerce-checkout textarea {
        background-color: #121416 !important;
        border: 1px solid #222828 !important;
        color: #fff !important;
        padding: 16px !important;
        border-radius: 0 !important;
        font-family: 'IBM Plex Sans', sans-serif;
        width: 100%;
        transition: all 0.3s ease;
    }

    /* Fix the Select2 Dropdowns (Country/State) */
    .select2-container--default .select2-selection--single {
        background-color: #121416 !important;
        border: 1px solid #222828 !important;
        border-radius: 0 !important;
        height: 52px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #fff !important;
        line-height: 52px !important;
        padding-left: 16px !important;
        font-family: 'IBM Plex Sans', sans-serif;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 52px !important;
    }
    /* Dropdown Options Box */
    .select2-dropdown {
        background-color: #0e1113 !important;
        border: 1px solid #76d6d5 !important;
        color: #fff !important;
    }
    .select2-container--default .select2-results__option[aria-selected=true],
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #76d6d5 !important;
        color: #000 !important;
    }

    /* Order Summary Table */
    #roadies-checkout-gate .woocommerce-checkout table.shop_table {
        border: 1px solid #222828;
        border-radius: 0;
        background: #0e1113;
        width: 100%;
        margin-bottom: 20px;
    }

    #roadies-checkout-gate .woocommerce-checkout table.shop_table th,
    #roadies-checkout-gate .woocommerce-checkout table.shop_table td {
        border-top: 1px solid #222828;
        color: #ccc;
        font-family: 'IBM Plex Sans', sans-serif;
        padding: 15px;
        background: transparent !important;
    }

    #roadies-checkout-gate .woocommerce-checkout table.shop_table th {
        font-family: 'Space Grotesk', sans-serif;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 12px;
        color: #888;
    }

    /* Place Order Button */
    #roadies-checkout-gate #place_order {
        background-color: #76d6d5 !important;
        color: #000 !important;
        font-family: 'Space Grotesk', sans-serif !important;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 900;
        padding: 20px !important;
        border-radius: 0 !important;
        width: 100%;
        transition: all 0.3s ease !important;
        border: none !important;
        cursor: pointer;
        margin-top: 20px;
    }

    #roadies-checkout-gate #place_order:hover {
        background-color: #fff !important;
        box-shadow: 0 0 20px rgba(118, 214, 213, 0.4) !important;
    }

    /* Payment Methods Box */
    #roadies-checkout-gate #payment {
        background: #0e1113 !important;
        border: 1px solid #222828 !important;
        border-radius: 0 !important;
        padding: 20px;
    }

    #roadies-checkout-gate #payment div.payment_box {
        background-color: #121416 !important;
        color: #888 !important;
        font-family: 'Inter', sans-serif;
        font-size: 13px;
    }
    
    #roadies-checkout-gate #payment div.payment_box::before {
        border-bottom-color: #121416 !important;
    }

    /* Fix the White Alert/Coupon Boxes */
    .woocommerce-info, .woocommerce-error, .woocommerce-message {
        background-color: #0e1113 !important;
        color: #fff !important;
        border-top: 3px solid #76d6d5 !important;
        border-left: 1px solid #222828 !important;
        border-right: 1px solid #222828 !important;
        border-bottom: 1px solid #222828 !important;
        font-family: 'Inter', sans-serif;
    }
    .woocommerce-error {
        border-top-color: #ff4d4d !important;
    }
    .woocommerce-error::before {
        color: #ff4d4d !important;
    }
    
    /* Responsive stacking for mobile */
    @media (max-width: 768px) {
        #roadies-checkout-gate form.woocommerce-checkout {
            grid-template-columns: 1fr !important;
        }
        #roadies-checkout-gate #customer_details,
        #roadies-checkout-gate #order_review_heading,
        #roadies-checkout-gate #order_review {
            grid-column: 1 !important;
            grid-row: auto !important;
        }
    }
</style>

<?php get_footer(); ?>