<?php
/**
 * Template Name: Roadies Account Page
 * Layout: Symmetric Center Stack
 */
get_header(); ?>

<div id="roadies-armory-gate" class="rd-chassis-max" style="padding: 80px 20px; min-height: 80vh; background: #0c0e10; display: flex; flex-direction: column; align-items: center;">
    
    <div style="margin-bottom: 60px; border-left: 4px solid #76d6d5; padding-left: 20px; align-self: flex-start; max-width: 800px; margin-left: auto; margin-right: auto; width: 100%;">
        <h1 style="font-family: 'Space Grotesk', sans-serif; font-weight: 900; color: #fff; text-transform: uppercase; font-size: 3.5rem; margin: 0; letter-spacing: -2px; line-height: 1;">ACCESS_THE_ARMORY</h1>
        <p style="color: #666; font-family: 'Inter', sans-serif; letter-spacing: 3px; font-size: 11px; margin-top: 10px; font-weight: 600;">SECURE_AUTH_GATEWAY // PROCEED_WITH_CREDENTIALS</p>
    </div>

    <div class="roadies-login-wrapper">
        <?php while ( have_posts() ) : the_post(); the_content(); endwhile; ?>
    </div>
</div>

<style>
    /* 1. SYMMETRIC STACKING */
    #roadies-armory-gate .u-columns.col2-set {
        display: flex !important;
        flex-direction: column !important; /* Stacked one after the other */
        align-items: center !important;
        gap: 40px !important;
        width: 100% !important;
        max-width: 600px !important; /* Professional narrow width for symmetry */
        margin: 0 auto !important;
    }

    /* 2. PANEL UNIFORMITY */
    #roadies-armory-gate .u-column1, 
    #roadies-armory-gate .u-column2 {
        background: #111416 !important;
        border: 1px solid #222828 !important;
        padding: 50px !important;
        width: 100% !important;
        float: none !important;
        box-sizing: border-box !important;
    }

    /* 3. CENTERED HEADINGS & TITLES */
    #roadies-armory-gate h2 {
        font-family: 'Space Grotesk', sans-serif !important;
        color: #76d6d5 !important;
        text-transform: uppercase !important;
        font-size: 1.5rem !important;
        font-weight: 900 !important;
        margin-bottom: 30px !important;
        text-align: center !important;
        border-bottom: 1px solid #222828 !important;
        padding-bottom: 20px !important;
    }

    /* 4. FORM FIELD SYMMETRY */
    #roadies-armory-gate label {
        color: #888 !important;
        font-family: 'Inter', sans-serif !important;
        text-transform: uppercase !important;
        font-size: 10px !important;
        letter-spacing: 2px !important;
        text-align: center !important;
        display: block !important;
        margin-bottom: 10px !important;
    }

    #roadies-armory-gate input.input-text {
        background: #0c0e10 !important;
        border: 1px solid #333 !important;
        color: #fff !important;
        padding: 15px !important;
        border-radius: 0 !important;
        width: 100% !important;
        text-align: center !important; /* Centers the text inside input */
        margin-bottom: 20px !important;
    }

    /* 5. ACTION BUTTONS */
    #roadies-armory-gate .button {
        background: #76d6d5 !important;
        color: #000 !important;
        font-family: 'Space Grotesk', sans-serif !important;
        font-weight: 900 !important;
        text-transform: uppercase !important;
        padding: 20px !important;
        width: 100% !important;
        border: none !important;
        cursor: pointer;
        transition: 0.3s;
    }

    #roadies-armory-gate .button:hover { background: #fff !important; }

    /* REMOVE CHECKBOX WEIRDNESS */
    .woocommerce-form__label-for-checkbox {
        justify-content: center !important;
        margin-top: 10px !important;
        color: #555 !important;
    }
</style>

<?php get_footer(); ?>