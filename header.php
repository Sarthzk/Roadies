<?php
/**
 * The custom Roadies Header - Kinetic Framework Integration
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
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

<header class="roadies-site-header" style="background: #0a0a0a; border-bottom: 2px solid #222828; padding: 15px 40px; position: sticky; top: 0; z-index: 999;">
    <div class="rd-chassis-max" style="display: flex; justify-content: space-between; align-items: center; max-width: 1600px; margin: 0 auto;">
        
        <div class="roadies-logo-group">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="text-decoration: none; display: flex; flex-direction: column;">
                <span style="color: #76d6d5; font-family: 'Space Grotesk', sans-serif; font-size: 2.2rem; font-weight: 900; line-height: 0.9; text-transform: uppercase; letter-spacing: -1px;">ROADIES</span>
                <span style="color: #666; font-family: 'Inter', sans-serif; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 3px; margin-top: 4px;">THE RIDER'S HUB</span>
                <span style="color: #444; font-family: 'Inter', sans-serif; font-size: 8px; font-weight: 500; text-transform: uppercase; letter-spacing: 1px;">TEHALIA'S AUTOMOBILES</span>
            </a>
        </div>

        <nav class="roadies-main-nav">
            <ul style="list-style: none; display: flex; gap: 40px; margin: 0; padding: 0;">
                <li><a href="<?php echo esc_url( home_url( '/product-category/helmets/' ) ); ?>" style="color: #888; text-decoration: none; text-transform: uppercase; font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 0.8rem; letter-spacing: 2px;">HELMETS</a></li>
                <li><a href="<?php echo esc_url( home_url( '/product-category/boots/' ) ); ?>" style="color: #888; text-decoration: none; text-transform: uppercase; font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 0.8rem; letter-spacing: 2px;">BOOTS</a></li>
                <li><a href="<?php echo esc_url( home_url( '/product-category/jackets/' ) ); ?>" style="color: #888; text-decoration: none; text-transform: uppercase; font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 0.8rem; letter-spacing: 2px;">JACKETS</a></li>
            </ul>
        </nav>

        <div class="roadies-cart-trigger">
            <a href="#" id="roadies-cart-toggle" style="background: #76d6d5; color: #000; font-family: 'Space Grotesk', sans-serif; font-weight: 800; text-transform: uppercase; padding: 12px 25px; text-decoration: none; font-size: 0.75rem; display: flex; align-items: center; gap: 10px;">
                CART <span style="background: #000; color: #76d6d5; padding: 2px 8px; font-size: 10px;"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
            </a>
        </div>
    </div>
</header>
<div id="page" class="site-content">