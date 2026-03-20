<?php
/**
 * The custom Roadies Header
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="roadies-site-header" style="background: #0a0a0a; border-bottom: 2px solid #008080; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 999;">
    
    <div class="roadies-logo">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #f0f0f0; font-family: 'Barlow Condensed', sans-serif; font-size: 2rem; font-weight: 800; text-decoration: none; text-transform: uppercase; letter-spacing: 2px;">
            ROAD<span style="color: #008080;">IES</span>
        </a>
    </div>

    <nav class="roadies-main-nav">
        <ul style="list-style: none; display: flex; gap: 30px; margin: 0; padding: 0;">
            <li><a href="<?php echo esc_url( home_url( '/product-category/helmets/' ) ); ?>" style="color: #c8c8c8; text-decoration: none; text-transform: uppercase; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.95rem; letter-spacing: 1px; transition: color 0.3s;">Helmets</a></li>
            <li><a href="<?php echo esc_url( home_url( '/product-category/boots/' ) ); ?>" style="color: #c8c8c8; text-decoration: none; text-transform: uppercase; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.95rem; letter-spacing: 1px; transition: color 0.3s;">Boots</a></li>
            <li><a href="<?php echo esc_url( home_url( '/product-category/jackets/' ) ); ?>" style="color: #c8c8c8; text-decoration: none; text-transform: uppercase; font-family: 'Inter', sans-serif; font-weight: 600; font-size: 0.95rem; letter-spacing: 1px; transition: color 0.3s;">Jackets</a></li>
        </ul>
    </nav>

    <div class="roadies-cart-trigger">
        <a href="#" id="roadies-cart-toggle" style="color: #008080; font-family: 'Inter', sans-serif; font-weight: bold; text-decoration: none; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 8px;">
            Garage
            <span class="cart-count" style="background: #1a1a1a; color: #fff; padding: 2px 8px; border-radius: 4px; border: 1px solid #333; font-size: 0.8rem;">
                <?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : '0'; ?>
            </span>
        </a>
    </div>

</header>

<div id="page" class="site-content"> ```

