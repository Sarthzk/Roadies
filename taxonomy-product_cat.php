<?php
/**
 * Master Template for Product Categories (Helmets, Boots, Jackets)
 */
get_header(); 

$current_cat = get_queried_object();
?>

<div class="rd-chassis-max">
    <header class="py-20 px-6 text-center border-b border-[#222828] bg-[#0c0e10]">
        <h1 class="rd-hero-title text-6xl mb-4"><?php echo esc_html( $current_cat->name ); ?></h1>
        <p class="text-gray-400 font-['Inter'] text-lg max-w-2xl mx-auto uppercase tracking-widest">
            High-Performance Equipment / Category: <?php echo esc_html( $current_cat->slug ); ?>
        </p>
    </header>

    <main class="py-16 px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
            <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    global $product;
                    ?>
                    
                    <div class="rd-panel group flex flex-col p-0 transition-all duration-300 hover:border-[#76d6d5]">
                        <a href="<?php the_permalink(); ?>" class="text-decoration-none no-underline">
                            <div class="bg-[#121416] p-8 overflow-hidden aspect-square flex items-center justify-center">
                                <?php echo woocommerce_get_product_thumbnail('woocommerce_thumbnail', array(
                                    'class' => 'max-w-full h-auto mix-blend-lighten transition-transform duration-500 group-hover:scale-110'
                                )); ?>
                            </div>

                            <div class="p-6">
                                <h3 class="text-gray-200 font-['Inter'] text-base font-medium mb-2 tracking-tight">
                                    <?php the_title(); ?>
                                </h3>
                                <div class="text-[#76d6d5] font-['Space_Grotesk'] font-bold text-xl">
                                    <?php echo $product->get_price_html(); ?>
                                </div>
                            </div>
                        </a>

                        <div class="mt-auto p-6 pt-0">
                            <a href="?add-to-cart=<?php echo get_the_ID(); ?>" 
                               class="rd-btn w-full text-center text-xs py-4 no-underline flex items-center justify-center gap-2 ajax_add_to_cart add_to_cart_button"
                               data-product_id="<?php echo get_the_ID(); ?>">
                                EQUIP GEAR
                            </a>
                        </div>
                    </div>

                <?php endwhile;
            else :
                echo '<p class="text-gray-500 text-center col-span-full py-20">No gear currently available in this category.</p>';
            endif; ?>
        </div>
    </main>
</div>

<?php get_footer(); ?>