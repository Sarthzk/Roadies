<?php
/**
 * The Template for displaying product archives (Main Shop Page)
 */
get_header(); ?>

<div class="rd-chassis-max py-20 px-6">
    <header class="mb-16 border-b border-[#222828] pb-10">
        <h1 class="rd-hero-title text-6xl">THE <span class="text-teal">ARMORY</span></h1>
        <p class="text-gray-500 uppercase tracking-[0.4em] text-xs mt-4">Professional Grade Gear / The Rider's HUB</p>
    </header>

    <main>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    global $product;
                    ?>
                    
                    <div class="rd-panel group flex flex-col p-0 transition-all duration-300 hover:border-[#76d6d5] bg-[#0c0e10]">
                        <a href="<?php the_permalink(); ?>" class="no-underline">
                            <div class="bg-[#121416] p-10 overflow-hidden aspect-square flex items-center justify-center border-b border-[#222828]">
                                <?php echo woocommerce_get_product_thumbnail('woocommerce_thumbnail', array(
                                    'class' => 'max-w-full h-auto mix-blend-lighten transition-transform duration-700 group-hover:scale-110'
                                )); ?>
                            </div>

                            <div class="p-8">
                                <h3 class="text-gray-200 font-['Inter'] text-sm font-bold mb-3 uppercase tracking-tight">
                                    <?php the_title(); ?>
                                </h3>
                                <div class="text-[#76d6d5] font-['Space_Grotesk'] font-black text-2xl">
                                    <?php echo $product->get_price_html(); ?>
                                </div>
                            </div>
                        </a>

                        <div class="mt-auto p-8 pt-0">
                            <a href="#" 
                               class="rd-btn w-full text-center text-xs py-5 no-underline ajax_add_to_cart add_to_cart_button"
                               data-product_id="<?php echo get_the_ID(); ?>"
                               data-quantity="1">
                                EQUIP GEAR
                            </a>
                        </div>
                    </div>

                <?php endwhile;
            else :
                echo '<p class="text-gray-500 text-center col-span-full py-20 font-["Space_Grotesk"] uppercase tracking-widest">No gear currently in stock.</p>';
            endif; ?>
        </div>
    </main>
</div>

<?php get_footer(); ?>
