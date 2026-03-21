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
                      style="display: flex !important; background: #121416 !important; border: 1px solid #222828 !important; padding: 0 !important;">
                    <input type="search" name="s" value="<?php echo get_search_query(); ?>" placeholder="SEARCH FOR HELMETS, BOOTS, OR JACKETS..." 
                        style="flex-grow: 1 !important; background: transparent !important; border: none !important; color: #fff !important; padding: 25px 30px !important; font-family: 'Space Grotesk', sans-serif !important; text-transform: uppercase !important; font-size: 14px !important; outline: none !important;" />
                    <input type="hidden" name="post_type" value="product" />
                    <button type="submit" class="rd-btn" style="padding: 0 40px !important; height: auto !important;">SEARCH</button>
                </form>
                <div class="mt-6 flex justify-center gap-6 text-[10px] text-gray-600 tracking-[0.3em] uppercase">
                    <span>Popular: Alpinestars</span><span>•</span><span>KYT Racing</span><span>•</span><span>Rynox Gear</span>
                </div>
            </div>
        </div>
    </section>

    <section id="featured-gear" class="py-24 px-6" style="background: #0c0e10;">
        <div class="rd-chassis-max">
            <header class="mb-12 border-b border-[#222828] pb-6">
                <h2 style="font-family: 'Barlow Condensed', sans-serif; font-size: 2.5rem; color: #fff; font-weight: 800; text-transform: uppercase;">
                    FEATURED <span style="color: #76d6d5;">EQUIPMENT</span>
                </h2>
                <p class="text-gray-600 uppercase tracking-[0.3em] text-[10px] font-semibold mt-2">Selected Gear for the Roadies / 2026 Collection</p>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php
                $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 4,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'stock_status'   => 'instock' // Only show gear ready for the armory
                );
                
                $loop = new WP_Query( $args );
                
                if ( $loop->have_posts() ) :
                    while ( $loop->have_posts() ) : $loop->the_post(); 
                        global $product; 
                        ?>
                        <div class="rd-panel group flex flex-col hover:border-[#76d6d5] bg-[#0c0e10] border border-[#222828] transition-all duration-300">
                            <div class="p-8 bg-[#121416] border-b border-[#222828] aspect-square flex items-center justify-center overflow-hidden">
                                <a href="<?php the_permalink(); ?>" class="w-full h-full flex items-center justify-center">
                                    <?php 
                                    if ( has_post_thumbnail() ) {
                                        echo get_the_post_thumbnail( get_the_ID(), 'woocommerce_thumbnail', array(
                                            'class' => 'max-w-full h-auto transition-transform duration-500 group-hover:scale-110 object-contain'
                                        )); 
                                    }
                                    ?>
                                </a>
                            </div>

                            <div class="p-8 flex flex-col flex-grow">
                                <h3 class="text-gray-200 font-['Inter'] text-xs font-bold mb-3 uppercase tracking-wider min-h-[3rem] line-clamp-2">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-[#76d6d5] transition-colors"><?php the_title(); ?></a>
                                </h3>
                                
                                <div class="text-[#76d6d5] font-black text-xl mb-8">
                                    <?php echo $product->get_price_html(); ?>
                                </div>

                                <div class="mt-auto">
                                    <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" 
                                       class="rd-btn w-full text-center text-[10px] py-4 no-underline block tracking-widest">
                                       EQUIP GEAR
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php 
                    endwhile; 
                else :
                    echo '<p class="text-gray-500 uppercase tracking-widest text-xs">No equipment found in the armory.</p>';
                endif; 
                wp_reset_postdata(); 
                ?>
            </div>
        </div>
    </section>
</div>

<style>
    /* Ensure clean image rendering on dark bg */
    .rd-panel img {
        filter: brightness(0.9) contrast(1.1);
    }
    .rd-panel:hover img {
        filter: brightness(1) contrast(1);
    }
    /* Simple line clamp for titles to keep grid symmetric */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
</style>

<?php get_footer(); ?>