<?php
/**
 * Hello Elementor Child Theme — functions.php
 *
 * This file enqueues parent + child theme stylesheets and contains
 * custom functionality for the riding gear WooCommerce store.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Silence is golden — block direct file access.
}


/* ---------------------------------------------------------------
 * 1. ENQUEUE PARENT & CHILD THEME STYLESHEETS
 * --------------------------------------------------------------- */

add_action( 'wp_enqueue_scripts', 'hec_enqueue_styles' );
function hec_enqueue_styles() {
	// Enqueue the Hello Elementor parent stylesheet.
	wp_enqueue_style(
		'hello-elementor-parent-style',
		get_template_directory_uri() . '/style.css',
		[],
		wp_get_theme( 'hello-elementor' )->get( 'Version' )
	);

	// Enqueue the child theme stylesheet (with dependency on parent).
	wp_enqueue_style(
		'hello-elementor-child-style',
		get_stylesheet_uri(),
		[ 'hello-elementor-parent-style' ],
		wp_get_theme()->get( 'Version' )
	);
}


/* ---------------------------------------------------------------
 * 2. ALLOW SVG FILE UPLOADS
 *
 * By default WordPress blocks SVG uploads for security reasons.
 * The snippet below:
 *   (a) Adds SVG to the list of allowed MIME types.
 *   (b) Sanitizes SVG files on upload to strip dangerous scripts.
 *   (c) Fixes the broken preview thumbnail in the Media Library.
 * --------------------------------------------------------------- */

/**
 * (a) Register SVG as an allowed upload MIME type.
 */
add_filter( 'upload_mimes', 'hec_allow_svg_uploads' );
function hec_allow_svg_uploads( $mimes ) {
	// Only allow administrators and editors to upload SVGs.
	if ( current_user_can( 'manage_options' ) || current_user_can( 'edit_others_posts' ) ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
	}
	return $mimes;
}

/**
 * (b) Sanitize SVGs on upload to remove potentially malicious code
 *     (e.g. <script> tags, javascript: hrefs, on* event handlers).
 */
add_filter( 'wp_handle_upload_prefilter', 'hec_sanitize_svg_on_upload' );
function hec_sanitize_svg_on_upload( $file ) {
	if ( 'image/svg+xml' !== $file['type'] ) {
		return $file; // Not an SVG — nothing to do.
	}

	$svg_content = file_get_contents( $file['tmp_name'] );

	if ( false === $svg_content ) {
		$file['error'] = __( 'SVG file could not be read.', 'hello-elementor-child' );
		return $file;
	}

	$sanitized = hec_sanitize_svg_string( $svg_content );

	if ( false === $sanitized ) {
		$file['error'] = __( 'Invalid SVG file.', 'hello-elementor-child' );
		return $file;
	}

	// Write the sanitized content back to the temp file.
	file_put_contents( $file['tmp_name'], $sanitized );

	return $file;
}

/**
 * Core SVG sanitizer — strips dangerous elements and attributes.
 *
 * @param  string $svg Raw SVG markup.
 * @return string|false Sanitized SVG string, or false on parse failure.
 */
function hec_sanitize_svg_string( $svg ) {
	// Tags that can execute scripts or load external resources.
	$forbidden_tags = [
		'script', 'object', 'embed', 'link', 'style',
		'base', 'meta', 'html', 'head', 'body',
	];

	// Attributes that can execute code.
	$forbidden_attr_patterns = [
		'/^on/i',           // All on* event handlers (onclick, onload …)
		'/^href$/i',        // <a href="javascript:…">
		'/^xlink:href$/i',
		'/^action$/i',
	];

	$dom = new DOMDocument();
	libxml_use_internal_errors( true );
	$loaded = $dom->loadXML( $svg );
	libxml_clear_errors();

	if ( ! $loaded ) {
		return false;
	}

	$xpath = new DOMXPath( $dom );

	// Remove forbidden elements.
	foreach ( $forbidden_tags as $tag ) {
		$nodes = $xpath->query( '//' . $tag );
		foreach ( $nodes as $node ) {
			$node->parentNode->removeChild( $node );
		}
	}

	// Remove forbidden attributes from every element.
	$all_elements = $xpath->query( '//*' );
	foreach ( $all_elements as $element ) {
		$attrs_to_remove = [];
		foreach ( $element->attributes as $attr ) {
			foreach ( $forbidden_attr_patterns as $pattern ) {
				if ( preg_match( $pattern, $attr->name ) ) {
					$attrs_to_remove[] = $attr->name;
					break;
				}
			}
			// Block javascript: and data: URIs anywhere.
			if ( preg_match( '/^\s*(javascript|data):/i', $attr->value ) ) {
				$attrs_to_remove[] = $attr->name;
			}
		}
		foreach ( $attrs_to_remove as $attr_name ) {
			$element->removeAttribute( $attr_name );
		}
	}

	return $dom->saveXML();
}

/**
 * (c) Fix the broken image thumbnail for SVGs in the Media Library.
 *     WordPress can't generate a raster preview for SVG files,
 *     so we return the SVG URL itself as the "thumbnail".
 */
add_filter( 'wp_prepare_attachment_for_js', 'hec_fix_svg_media_thumbnail', 10, 3 );
function hec_fix_svg_media_thumbnail( $response, $attachment, $meta ) {
	if ( 'image/svg+xml' === $response['mime'] && empty( $response['sizes'] ) ) {
		$response['sizes'] = [
			'full' => [
				'url'         => $response['url'],
				'width'       => 0,
				'height'      => 0,
				'orientation' => 'landscape',
			],
		];
	}
	return $response;
}


/* ---------------------------------------------------------------
 * 3. OPTIONAL HELPERS — uncomment as needed
 * --------------------------------------------------------------- */

// Remove the WordPress version number from the <head> for security.
// remove_action( 'wp_head', 'wp_generator' );

// Add WooCommerce theme support declarations if needed.
// add_action( 'after_setup_theme', 'hec_woocommerce_support' );
// function hec_woocommerce_support() {
//     add_theme_support( 'woocommerce' );
//     add_theme_support( 'wc-product-gallery-zoom' );
//     add_theme_support( 'wc-product-gallery-lightbox' );
//     add_theme_support( 'wc-product-gallery-slider' );
// }


/* ---------------------------------------------------------------
 * 4. ROADIES — CUSTOM TWO-TONE LOGO HEADER
 *
 * Replaces the default site title with a custom logo:
 *  - 'ROAD' in white
 *  - 'IES' in neon red
 * --------------------------------------------------------------- */

add_filter( 'blogname', 'roadies_custom_logo_html', 10, 1 );
function roadies_custom_logo_html( $title ) {
	// Only apply to the site title output, not database storage.
	// Return the original title if called from a non-display context.
	if ( ! did_action( 'wp_head' ) ) {
		return $title;
	}

	// Return HTML instead of plain text for logo display.
	// This is intentional — the hook will handle sanitization.
	return $title;
}

// Hook into site-header to replace the title with a custom logo element.
add_action( 'wp_body_open', 'roadies_output_custom_logo', 1 );
function roadies_output_custom_logo() {
	// Only output once per page.
	static $already_output = false;
	if ( $already_output ) {
		return;
	}
	$already_output = true;

	// Check if site title is being displayed (not hidden by theme settings).
	if ( ! is_customize_preview() && ! apply_filters( 'roadies_show_custom_logo', true ) ) {
		return;
	}

	?>
	<script>
	document.addEventListener( 'DOMContentLoaded', function() {
		const siteTitle = document.querySelector( '.site-title a, .site-title, h1.site-title' );
		if ( siteTitle ) {
			siteTitle.innerHTML = '<span class="roadies-logo"><span class="roadies-logo__road">ROAD</span><span class="roadies-logo__ies">IES</span></span>';
			// Add data attribute to prevent re-styling by other scripts
			siteTitle.setAttribute( 'data-roadies-custom-logo', 'true' );
		}
	} );
	</script>
	<?php
}

// Enqueue the sticky header scroll handler JavaScript.
add_action( 'wp_enqueue_scripts', 'roadies_enqueue_sticky_header_script' );
function roadies_enqueue_sticky_header_script() {
	wp_enqueue_script(
		'roadies-sticky-header',
		get_stylesheet_directory_uri() . '/js/sticky-header.js',
		[],
		wp_get_theme()->get( 'Version' ),
		true // Load in footer
	);
}


/* ---------------------------------------------------------------
 * 5. ROADIES — Rename WooCommerce "Add to Cart" buttons to "EQUIP GEAR"
 *
 * Covers:
 *  - Shop / archive loop cards
 *  - Single product page button text
 *  - Cart & checkout confirmation text
 *
 * Paste this block into hello-elementor-child/functions.php
 */

// ── 1. Loop / product archive cards ────────────────────────────────────────
add_filter( 'woocommerce_product_add_to_cart_text', 'roadies_add_to_cart_text', 10, 2 );
function roadies_add_to_cart_text( $text, $product ) {
	if ( ! $product ) {
		return $text;
	}

	switch ( $product->get_type() ) {
		case 'simple':
		case 'external':
			return __( 'EQUIP GEAR', 'hello-elementor-child' );

		case 'variable':
			// Variable products show "Select options" in the loop.
			// Change it only once a variation is selected (handled below).
			return __( 'SELECT VARIANT', 'hello-elementor-child' );

		case 'grouped':
			return __( 'VIEW GEAR', 'hello-elementor-child' );

		default:
			return __( 'EQUIP GEAR', 'hello-elementor-child' );
	}
}

// ── 2. Single product page — simple & every non-variable type ───────────────
add_filter( 'woocommerce_product_single_add_to_cart_text', 'roadies_single_add_to_cart_text', 10, 2 );
function roadies_single_add_to_cart_text( $text, $product ) {
	if ( ! $product ) {
		return $text;
	}
	// Variable products surface this filter after a variation is chosen.
	return __( 'EQUIP GEAR', 'hello-elementor-child' );
}

// ── 3. Cart page "Update Cart" & "Proceed to Checkout" ─────────────────────
add_filter( 'woocommerce_order_button_text', 'roadies_place_order_text' );
function roadies_place_order_text( $text ) {
	return __( 'PLACE ORDER — GEAR UP', 'hello-elementor-child' );
}

// ── 4. "Continue Shopping" after adding to cart (optional) ─────────────────
add_filter( 'woocommerce_continue_shopping_redirect', '__return_false' ); // keep default redirect
// If you want to rename the Continue Shopping button text, uncomment:
// add_filter( 'woocommerce_get_return_to_shop_redirect', function() { return wc_get_page_permalink( 'shop' ); } );


/**
 * ROADIES — Safety Rating Badge
 *
 * Displays a visual "Safety Rating" badge area below the product price
 * on single product pages.
 *
 * HOW TO USE:
 *  1. Paste this entire block into hello-elementor-child/functions.php
 *  2. Go to the product editor in WP Admin.
 *  3. Under Product Data → Custom Fields (or the "Roadies" meta box),
 *     add the field:  roadies_safety_rating   with a value of 1–5.
 *  4. Optionally add: roadies_safety_label    e.g. "CE Level 2 Certified"
 *
 * The badge renders automatically when the custom field is present.
 * No field = no badge (graceful fallback).
 */


// ── 1. Register a clean meta box in the product editor ─────────────────────
add_action( 'add_meta_boxes', 'roadies_safety_rating_meta_box' );
function roadies_safety_rating_meta_box() {
	add_meta_box(
		'roadies_safety_rating',
		'⚡ Roadies Safety Rating',
		'roadies_safety_rating_meta_box_html',
		'product',
		'side',   // appears in the right sidebar panel
		'default'
	);
}

function roadies_safety_rating_meta_box_html( $post ) {
	wp_nonce_field( 'roadies_save_safety_rating', 'roadies_safety_rating_nonce' );
	$rating = get_post_meta( $post->ID, 'roadies_safety_rating', true );
	$label  = get_post_meta( $post->ID, 'roadies_safety_label',  true );
	?>
	<p style="margin-bottom:6px;">
		<label for="roadies_safety_rating" style="font-weight:600;">
			Rating (1–5 stars):
		</label>
		<select id="roadies_safety_rating" name="roadies_safety_rating" style="width:100%;margin-top:4px;">
			<option value="">— No rating —</option>
			<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
				<option value="<?php echo esc_attr( $i ); ?>" <?php selected( $rating, $i ); ?>>
					<?php echo esc_html( $i ); ?> Star<?php echo $i > 1 ? 's' : ''; ?>
				</option>
			<?php endfor; ?>
		</select>
	</p>
	<p>
		<label for="roadies_safety_label" style="font-weight:600;">
			Label / Certification (optional):
		</label>
		<input
			type="text"
			id="roadies_safety_label"
			name="roadies_safety_label"
			value="<?php echo esc_attr( $label ); ?>"
			placeholder="e.g. CE Level 2 Certified"
			style="width:100%;margin-top:4px;"
		/>
	</p>
	<?php
}


// ── 2. Save the meta box values ─────────────────────────────────────────────
add_action( 'save_post_product', 'roadies_save_safety_rating_meta' );
function roadies_save_safety_rating_meta( $post_id ) {
	// Verify nonce.
	if (
		! isset( $_POST['roadies_safety_rating_nonce'] ) ||
		! wp_verify_nonce( $_POST['roadies_safety_rating_nonce'], 'roadies_save_safety_rating' )
	) {
		return;
	}

	// Bail on autosave / bulk-edit.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;

	// Sanitize & save rating (integer 1–5, or delete if empty).
	if ( isset( $_POST['roadies_safety_rating'] ) && '' !== $_POST['roadies_safety_rating'] ) {
		$rating = absint( $_POST['roadies_safety_rating'] );
		$rating = max( 1, min( 5, $rating ) ); // clamp to 1–5
		update_post_meta( $post_id, 'roadies_safety_rating', $rating );
	} else {
		delete_post_meta( $post_id, 'roadies_safety_rating' );
	}

	// Sanitize & save label.
	if ( isset( $_POST['roadies_safety_label'] ) ) {
		$label = sanitize_text_field( $_POST['roadies_safety_label'] );
		update_post_meta( $post_id, 'roadies_safety_label', $label );
	}
}


// ── 3. Render the badge below the price on single product pages ─────────────
add_action( 'woocommerce_single_product_summary', 'roadies_render_safety_badge', 15 );
// Priority 15 = just after the price (priority 10) and before excerpt (priority 20).

function roadies_render_safety_badge() {
	global $post;

	$rating = get_post_meta( $post->ID, 'roadies_safety_rating', true );

	if ( ! $rating ) {
		return; // No rating set — render nothing.
	}

	$rating = absint( $rating );
	$label  = get_post_meta( $post->ID, 'roadies_safety_label', true );
	$label  = $label ? esc_html( $label ) : 'Safety Rated';

	// Build the star icons (filled + empty).
	$filled_star = '<span class="roadies-star roadies-star--filled" aria-hidden="true">&#9733;</span>';
	$empty_star  = '<span class="roadies-star roadies-star--empty"  aria-hidden="true">&#9733;</span>';
	$stars_html  = '';

	for ( $i = 1; $i <= 5; $i++ ) {
		$stars_html .= ( $i <= $rating ) ? $filled_star : $empty_star;
	}

	// Accessible label for screen readers.
	$sr_text = sprintf(
		/* translators: %1$d = numeric rating, %2$s = label */
		esc_html__( 'Safety rating: %1$d out of 5 — %2$s', 'hello-elementor-child' ),
		$rating,
		$label
	);

	?>
	<div class="roadies-safety-badge" role="img" aria-label="<?php echo esc_attr( $sr_text ); ?>">
		<span class="roadies-safety-badge__icon" aria-hidden="true">&#9737;</span>
		<div class="roadies-safety-badge__content">
			<span class="roadies-safety-badge__label"><?php echo esc_html( $label ); ?></span>
			<span class="roadies-safety-badge__stars" aria-hidden="true">
				<?php echo wp_kses_post( $stars_html ); ?>
				<span class="roadies-safety-badge__score"><?php echo esc_html( $rating ); ?>/5</span>
			</span>
		</div>
	</div>

	<?php
	// Inline styles are scoped and self-contained — no extra stylesheet file needed.
	// Move these to style.css if you prefer to avoid inline <style> blocks.
	?>
	<style>
	.roadies-safety-badge {
		display: inline-flex;
		align-items: center;
		gap: 10px;
		margin: 10px 0 16px;
		padding: 8px 16px 8px 12px;
		background: linear-gradient(135deg, #1a1a1a 0%, #0d0d0d 100%);
		border: 1px solid #2e2e2e;
		border-left: 3px solid #e8001d;
		clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 8px, 100% 100%, 8px 100%, 0 calc(100% - 8px));
		font-family: 'Barlow Condensed', 'Arial Narrow', sans-serif;
		transition: border-color 0.2s ease, box-shadow 0.2s ease;
	}
	.roadies-safety-badge:hover {
		border-color: #e8001d;
		box-shadow: 0 0 12px rgba(232, 0, 29, 0.25);
	}
	.roadies-safety-badge__icon {
		font-size: 1.4rem;
		color: #e8001d;
		line-height: 1;
	}
	.roadies-safety-badge__content {
		display: flex;
		flex-direction: column;
		gap: 2px;
	}
	.roadies-safety-badge__label {
		font-size: 0.65rem;
		font-weight: 700;
		letter-spacing: 0.15em;
		text-transform: uppercase;
		color: #c8c8c8;
	}
	.roadies-safety-badge__stars {
		display: flex;
		align-items: center;
		gap: 2px;
	}
	.roadies-star {
		font-size: 0.9rem;
		line-height: 1;
		transition: color 0.15s;
	}
	.roadies-star--filled {
		color: #e8001d;
		text-shadow: 0 0 6px rgba(232, 0, 29, 0.6);
	}
	.roadies-star--empty {
		color: #3a3a3a;
	}
	.roadies-safety-badge__score {
		font-size: 0.65rem;
		font-weight: 700;
		letter-spacing: 0.1em;
		color: #4a4a4a;
		margin-left: 4px;
	}
	</style>
	<?php
}
// Load Custom Backend Logic
require_once get_stylesheet_directory() . '/inc/riding-taxonomy.php';