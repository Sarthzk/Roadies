<?php
/**
 * Template Name: Roadies Custom Home
 */
get_header(); ?>

<div class="rd-chassis-max">
    <section class="py-32 px-6 text-center border-b border-[#222828] bg-[#0a0a0a]">
    <div class="rd-chassis-max">
        <h1 class="mb-4" style="color: #f0f0f0 !important; font-family: 'Barlow Condensed', sans-serif !important; font-size: 6rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; line-height: 1;">
            EQUIP FOR <span style="color: #76d6d5 !important;">THE APEX</span>
        </h1>
        
        <p class="text-gray-500 font-['Inter'] text-lg max-w-2xl mx-auto mb-12 uppercase tracking-widest">
            The Rider's HUB / Tehalia's Automobiles
        </p>

        <div class="max-w-3xl mx-auto">
            <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" 
                  style="display: flex !important; background: #121416 !important; border: 1px solid #222828 !important; padding: 0 !important; margin: 0 !important; box-shadow: none !important;">
                
                <input type="search" 
                    name="s"
                    value="<?php echo get_search_query(); ?>"
                    placeholder="SEARCH FOR HELMETS, BOOTS, OR JACKETS..." 
                    style="flex-grow: 1 !important; background: transparent !important; border: none !important; color: #fff !important; padding: 25px 30px !important; font-family: 'Space Grotesk', sans-serif !important; text-transform: uppercase !important; font-size: 14px !important; letter-spacing: 2px !important; outline: none !important; box-shadow: none !important; -webkit-appearance: none !important;" />
                
                <input type="hidden" name="post_type" value="product" />
                
                <button type="submit" 
                        style="background: #76d6d5 !important; color: #000 !important; border: none !important; padding: 0 40px !important; font-family: 'Space Grotesk', sans-serif !important; font-weight: 900 !important; font-size: 14px !important; cursor: pointer !important; text-transform: uppercase !important; height: auto !important;">
                    SEARCH
                </button>
            </form>
            
            <div class="mt-6 flex justify-center gap-6 text-[10px] text-gray-600 tracking-[0.3em] uppercase">
                <span>Popular: Alpinestars</span>
                <span>•</span>
                <span>KYT Racing</span>
                <span>•</span>
                <span>Rynox Gear</span>
            </div>
        </div>
    </div>
</section>
    

    <section id="featured-gear" class="py-24 px-6">
    <div class="rd-chassis-max">
        <header class="mb-12 border-b border-[#222828] pb-6">
            <h2 style="font-family: 'Barlow Condensed', sans-serif; font-size: 2.5rem; color: #fff; font-weight: 800; text-transform: uppercase; letter-spacing: 2px;">
                FEATURED <span style="color: #76d6d5;">EQUIPMENT</span>
            </h2>
            <p class="text-gray-600 uppercase tracking-[0.3em] text-[10px] font-semibold mt-2">Selected Gear for the Roadies / 2026 Collection</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php
            // Locked to 4 products only
            $loop = new WP_Query( array(
                'post_type' => 'product', 
                'posts_per_page' => 4,
                'orderby' => 'date',
                'order' => 'DESC'
            ) );

            while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
                
                <div class="rd-panel group flex flex-col transition-all duration-300 hover:border-[#76d6d5] bg-[#0c0e10]" style="height: 100%; display: flex; flex-direction: column;">
                    
                    <div class="p-8 bg-[#121416] border-b border-[#222828] aspect-square flex items-center justify-center overflow-hidden">
                        <?php echo woocommerce_get_product_thumbnail('woocommerce_thumbnail', array(
                            'class' => 'max-w-full h-auto mix-blend-lighten transition-transform duration-500 group-hover:scale-110'
                        )); ?>
                    </div>

                    <div class="p-8 flex flex-col flex-grow">
                        <h3 class="text-gray-200 font-['Inter'] text-sm font-bold mb-2 uppercase tracking-tight min-h-[40px]">
                            <?php the_title(); ?>
                        </h3>
                        
                        <div class="text-[#76d6d5] font-black text-2xl mb-8">
                            <?php echo $product->get_price_html(); ?>
                        </div>

                        <div class="mt-auto">
                            <a href="#" 
                               class="rd-btn w-full text-center text-xs py-5 no-underline ajax_add_to_cart add_to_cart_button"
                               data-product_id="<?php echo get_the_ID(); ?>"
                               data-quantity="1">
                                EQUIP GEAR
                            </a>
                        </div>
                    </div>
                </div>

            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
</div>
<?php get_footer(); ?>
