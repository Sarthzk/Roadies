<?php
/**
 * Template Name: Roadies Custom Home
 * Integrated with Wishlist Engine, Glitch HUD, Live Store Status & Direct Maps
 */
get_header(); 

// LIVE STORE STATUS LOGIC (Asia/Kolkata Time)
date_default_timezone_set('Asia/Kolkata');
$current_hour = date('H.i'); 
$current_day = date('l');
$is_open = false;

// Store Hours: Tue-Sun (10:30 to 21:00), Monday Closed
if ($current_day !== 'Monday') {
    if ($current_hour >= 10.30 && $current_hour <= 21.00) {
        $is_open = true;
    }
}
?>

<div class="rd-chassis-max">
    <section class="py-32 px-6 text-center border-b border-[#222828] bg-[#0c0e10]">
        <div class="rd-chassis-max">
            <h1 class="rd-hero-title rd-glitch mb-4" data-text="EQUIP FOR THE APEX">
                EQUIP FOR THE APEX
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
            </div>
        </div>
    </section>

    <section id="featured-gear" class="py-24 px-6" style="background: #0c0e10;">
        <div class="rd-chassis-max">
            <header class="mb-12 border-b border-[#222828] pb-6">
                <h2 style="font-family: 'Space Grotesk', sans-serif; font-size: 2.5rem; color: #fff; font-weight: 800; text-transform: uppercase;">
                    FEATURED <span class="text-teal">EQUIPMENT</span>
                </h2>
                <p class="text-gray-600 uppercase tracking-[0.3em] text-[10px] font-semibold mt-2">Selected Gear for the Roadies / 2026 Collection</p>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php
                $args = array('post_type' => 'product', 'posts_per_page' => 8, 'stock_status' => 'instock');
                $loop = new WP_Query( $args );
                if ( $loop->have_posts() ) :
                    while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
                        <div class="rd-panel group flex flex-col bg-[#0c0e10] border border-[#222828] transition-all duration-300">
                            <div class="p-8 bg-[#121416] border-b border-[#222828] aspect-square flex items-center justify-center overflow-hidden relative">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('woocommerce_thumbnail', ['class' => 'max-w-full h-auto transition-transform duration-500 group-hover:scale-110 object-contain']); ?>
                                </a>
                                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
                                    <?php if (shortcode_exists('ti_wishlists_add_button')) echo do_shortcode('[ti_wishlists_add_button]'); ?>
                                </div>
                            </div>
                            <div class="p-8 flex flex-col flex-grow">
                                <h3 class="text-gray-200 font-['Inter'] text-xs font-bold mb-3 uppercase tracking-wider min-h-[3rem] line-clamp-2">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-teal"><?php the_title(); ?></a>
                                </h3>
                                <div class="text-teal font-black text-xl mb-8"><?php echo $product->get_price_html(); ?></div>
                                <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="rd-btn w-full text-center text-[10px] py-4 tracking-widest no-underline">EQUIP GEAR</a>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
        </div>
    </section>

    <section id="physical-store" class="py-24 px-6 border-t border-[#222828]" style="background: #0e1113;">
        <div class="rd-chassis-max flex flex-col md:flex-row items-stretch gap-12">
            
            <div class="md:w-1/2">
                <header class="mb-8">
                    <h2 class="rd-glitch" data-text="BASE OF OPERATIONS" style="font-family: 'Space Grotesk', sans-serif; font-size: 2.5rem; color: #fff; font-weight: 800; text-transform: uppercase;">
                        BASE OF <span class="text-teal">OPERATIONS</span>
                    </h2>
                    <div class="flex items-center gap-3 mt-2">
                        <div class="flex items-center gap-2 px-3 py-1 border border-[#222828] bg-[#0c0e10]">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full <?php echo $is_open ? 'bg-[#76d6d5]' : 'bg-red-500'; ?> opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 <?php echo $is_open ? 'bg-[#76d6d5]' : 'bg-red-500'; ?>"></span>
                            </span>
                            <span class="text-[9px] uppercase tracking-[0.2em] font-bold <?php echo $is_open ? 'text-[#76d6d5]' : 'text-red-500'; ?>">
                                System Status: <?php echo $is_open ? 'Live & Operational' : 'Offline / Standby'; ?>
                            </span>
                        </div>
                    </div>
                </header>

                <div class="rd-spec-box">
                    <span class="rd-spec-label">Coordinates / Address</span>
                    <p class="text-gray-300 font-['Inter'] text-sm leading-relaxed">
                        Shop No.7, LIC Building, Station Rd, near SHAKTI SPORTS,<br>
                        MIDC, Pimpri Colony, Pune, Maharashtra 411018
                    </p>
                </div>

                <div class="rd-spec-box">
                    <span class="rd-spec-label">Armory Access Hours</span>
                    <p class="text-gray-400 font-['Inter'] text-xs uppercase tracking-widest">
                        Tue — Sun // 10:30 AM — 09:00 PM<br>
                        <span class="text-red-800">Monday // Lockdown (Closed)</span>
                    </p>
                </div>

                <div class="flex flex-wrap gap-4 mt-8">
                    <a href="https://maps.google.com/?q=Roadies+The+Riders+Hub+Garage+Pimpri" target="_blank" class="rd-btn no-underline inline-block">
                        INITIATE NAVIGATION
                    </a>

                    <?php if ($is_open) : ?>
                        <a href="tel:+918888888888" class="rd-btn no-underline inline-block" style="background: transparent; border: 1px solid #76d6d5; color: #76d6d5;">
                            ESTABLISH COMMS LINK
                        </a>
                    <?php else : ?>
                        <a href="mailto:contact@roadies.local" class="rd-btn no-underline inline-block opacity-50" style="background: #1a1d20; color: #444; cursor: not-allowed; border: 1px solid #222828;">
                            COMMS ENCRYPTED (OFFLINE)
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="md:w-1/2 w-full border border-[#222828] p-2 bg-[#0c0e10] relative overflow-hidden group">
                <div class="h-full min-h-[300px] bg-[#121416] flex items-center justify-center border border-[#222828] relative overflow-hidden">
                    <span class="text-gray-800 font-['Space Grotesk'] font-black text-6xl tracking-tighter uppercase opacity-10">PUNE HQ</span>
                    
                    <div class="absolute top-4 left-4 w-6 h-6 border-t border-l border-teal/40"></div>
                    <div class="absolute bottom-4 right-4 w-6 h-6 border-b border-r border-teal/40"></div>
                    <div class="absolute inset-0 pointer-events-none bg-gradient-to-b from-transparent via-teal/5 to-transparent h-1/2 w-full animate-scan"></div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .rd-panel .tinv-wraper { position: static !important; }
    
    @keyframes scan {
        0% { transform: translateY(-100%); }
        100% { transform: translateY(200%); }
    }
    .animate-scan { animation: scan 3s linear infinite; }
</style>

<?php get_footer(); ?>