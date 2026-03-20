<?php
/**
 * Template Name: Roadies Custom Home
 */
get_header(); ?>

<div class="rd-chassis-max">
    <section class="py-24 px-6 text-center border-b border-[#222828]">
        <h1 class="rd-hero-title">Equip For <span class="text-teal">The Apex</span></h1>
        <p class="text-gray-400 font-['Inter'] text-lg max-w-2xl mx-auto mb-10">Professional-grade racing gear for The Rider's HUB.</p>
        <a href="#featured-gear" class="rd-btn">Enter The Garage</a>
    </section>

    <section id="featured-gear" class="py-20 px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php
            $loop = new WP_Query( array('post_type' => 'product', 'posts_per_page' => 8) );
            while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
                <div class="rd-panel p-6 flex flex-col group transition duration-300 hover:border-[#76d6d5]">
                    <div class="mb-6 text-center overflow-hidden">
                        <?php echo woocommerce_get_product_thumbnail(); ?>
                    </div>
                    <h3 class="text-gray-200 font-['Inter'] text-lg font-semibold mb-2"><?php the_title(); ?></h3>
                    <span class="text-teal font-bold text-xl mb-6 block"><?php echo $product->get_price_html(); ?></span>
                    <a href="#" class="rd-btn ajax_add_to_cart add_to_cart_button" data-product_id="<?php echo get_the_ID(); ?>" data-quantity="1">EQUIP GEAR</a>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </section>
</div>
<?php get_footer(); ?>