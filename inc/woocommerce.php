<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Genesis Health Clubs
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function ghc_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'ghc_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function ghc_woocommerce_scripts() {
	wp_enqueue_style( 'ghc-woocommerce-style', get_template_directory_uri() . '/styles/woocommerce.css', array(), date('U') );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'ghc-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'ghc_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function ghc_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'ghc_woocommerce_active_body_class' );

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function ghc_woocommerce_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'ghc_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function ghc_woocommerce_thumbnail_columns() {
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'ghc_woocommerce_thumbnail_columns' );

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function ghc_woocommerce_loop_columns() {

	return get_theme_mod( 'ghc_woocommerce_products_per_line' ) != '' ? get_theme_mod( 'ghc_woocommerce_products_per_line' ) : 4;
}
add_filter( 'loop_shop_columns', 'ghc_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function ghc_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 4,
		'columns'        => 4,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'ghc_woocommerce_related_products_args' );
/*
if ( ! function_exists( 'ghc_woocommerce_product_columns_wrapper' ) ) {

	function ghc_woocommerce_product_columns_wrapper() {
		$columns = ghc_woocommerce_loop_columns();
		echo '<div class="columns-' . absint( $columns ) . '">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'ghc_woocommerce_product_columns_wrapper', 40 );

if ( ! function_exists( 'ghc_woocommerce_product_columns_wrapper_close' ) ) {

	function ghc_woocommerce_product_columns_wrapper_close() {
		echo '</div>';
	}
}
add_action( 'woocommerce_after_shop_loop', 'ghc_woocommerce_product_columns_wrapper_close', 40 );
*/

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'ghc_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function ghc_woocommerce_wrapper_before() {
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
			<?php
	}
}
add_action( 'woocommerce_before_main_content', 'ghc_woocommerce_wrapper_before' );

if ( ! function_exists( 'ghc_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function ghc_woocommerce_wrapper_after() {
			?>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'ghc_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'ghc_woocommerce_header_cart' ) ) {
			ghc_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'ghc_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function ghc_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		ghc_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'ghc_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'ghc_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function ghc_woocommerce_cart_link() {
		?>
		<a class="cart-contents <?php echo ( WC()->cart->get_cart_contents_count() > 0 ? 'has-contents' : '' ); ?>" href="<?php echo esc_url( wc_get_checkout_url() ); ?>" title="<?php esc_attr_e( 'Checkout', 'ghc' ); ?>"><?php _e( 'Checkout', 'ghc' ); ?></a>
		<?php
	}
}

if ( ! function_exists( 'ghc_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function ghc_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<nav class="site-header__shop">
			<ul>
				<?php if ( get_option( 'woocommerce_myaccount_page_id' ) ) : ?>
					<li>
						<a href="<?php echo esc_attr( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" title="<?php echo is_user_logged_in() ? __( 'Account', 'ghc' ) : __( 'Login', 'ghc' ); ?>"><?php echo is_user_logged_in() ? __( 'Account', 'ghc' ) : __( 'Login', 'ghc' ); ?></a>
					</li>
				<?php endif; ?>
				<li class="<?php echo esc_attr( $class ); ?>">
					<?php ghc_woocommerce_cart_link(); ?>
				</li>
			</ul>
		</nav>
		<?php
	}
}


/**
 * Additional store contact info added to WooCommerce > Settings > General.
 *
 * @return void
 */
function ghc_general_settings_add_contacts( $settings ) {
   $key = 0;

   foreach( $settings as $values ){
	   $new_settings[$key] = $values;
	   $key++;

	   // Inserting array just after the post code in "Store Address" section
	   if ( $values['id'] == 'woocommerce_store_postcode' ){
		   $new_settings[$key] = array(
			   'title'    => __( 'Phone Number' ),
			   'desc'     => __( 'Optional phone number of your business office' ),
			   'id'       => 'woocommerce_store_phone', // <= The field ID (important)
			   'default'  => '',
			   'type'     => 'text',
			   'desc_tip' => true, // or false
		   );
		   $key++;

		   $new_settings[$key] = array(
			   'title'    => __( 'Email' ),
			   'desc'     => __( 'Optional email of your business office' ),
			   'id'       => 'woocommerce_store_email', // <= The field ID (important)
			   'default'  => '',
			   'type'     => 'email',
			   'desc_tip' => true, // or false
		   );
		   $key++;
	   }
   }
   return $new_settings;
}
add_filter( 'woocommerce_general_settings', 'ghc_general_settings_add_contacts' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/*
// remove Order Notes from checkout field in Woocommerce
if ( ! function_exists( 'ghc_mod_woocommerce_checkout_fields' ) ) {
	function ghc_mod_woocommerce_checkout_fields( $fields ) {
		unset($fields['order']['order_comments']);
		unset($fields['billing']['billing_company']);
		unset($fields['shipping']['shipping_company']);
		return $fields;
	}
}
add_filter( 'woocommerce_checkout_fields' , 'ghc_mod_woocommerce_checkout_fields' );
*/
add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );

add_filter( 'woocommerce_product_description_heading', '__return_false' );
add_filter( 'woocommerce_product_additional_information_heading', '__return_false' );

add_filter( 'woocommerce_reset_variations_link', '__return_empty_string' );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 7 );
if ( ! function_exists( 'ghc_woocommerce_maybe_add_shop_loop_price' ) ) {
	function ghc_woocommerce_maybe_add_shop_loop_price() {
		global $product;
		if ( ! $product->is_type( 'variable' ) ) {
			add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 7 );
		}
		else {
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 7 );
		}
	}
}
add_action( 'woocommerce_after_shop_loop_item', 'ghc_woocommerce_maybe_add_shop_loop_price', 1);

//remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
//remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 1 );


remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// COMBINE THE CART AND CHECKOUT PAGES
add_action( 'woocommerce_before_checkout_form', function () {
  if ( is_wc_endpoint_url( 'order-received' ) ) return;
      echo do_shortcode('[woocommerce_cart]');
}, 5 );
// SKIP THE CART PAGE WHEN ADDING TO CART
add_filter('woocommerce_add_to_cart_redirect', function () {
	if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 1 ) {
		global $woocommerce;
		$checkout_url = wc_get_checkout_url();
		return $checkout_url;
	}
});

if ( ! function_exists( 'ghc_add_cart_title' ) ) {
	function ghc_add_cart_title() {
		echo '<h3>' . __( 'Cart', 'ghc' ) . '</h3>';
	}
}
add_action( 'woocommerce_before_cart_table', 'ghc_add_cart_title' );


/**
 * Remove selectWoo
 */
if ( ! function_exists( 'ghc_disable_selectwoo' ) ) {
	function ghc_disable_selectwoo() {
		wp_dequeue_style( 'selectWoo' );
		wp_deregister_style( 'selectWoo' );

		wp_dequeue_script( 'selectWoo');
		wp_deregister_script('selectWoo');
	}
}
add_action( 'wp_enqueue_scripts', 'ghc_disable_selectwoo', 100 );


if ( ! function_exists( 'ghc_modify_loop_add_to_cart_link' ) ) {
	function ghc_modify_loop_add_to_cart_link($button, $product) {

	    if ( get_theme_mod( 'ghc_woocommerce_show_variable_form' ) == 1 && $product->is_type('variable') ) {
	        ob_start();
	        woocommerce_variable_add_to_cart();
	        $button = ob_get_clean();
	        $replacement = sprintf('data-product_id="%d" data-quantity="1" $1 ajax_add_to_cart add_to_cart_button product_type_simple ', $product->get_id());
	        $button = preg_replace('/(class="single_add_to_cart_button)/', $replacement, $button);
	        //$button = preg_replace( '/Add to cart/', 'Add', $button );
	    }
		/*
	    else if ( ! $product->is_type('grouped') && ! $product->is_type('external') && ! has_term( 'events', 'product_cat', $product->get_id() ) ) {
	        // only if can be purchased
	        if ( $product->is_purchasable() ) {
	            // show qty +/- with button
	            ob_start();
	            woocommerce_simple_add_to_cart();
	            $button = ob_get_clean();
	            // modify button so that AJAX add-to-cart script finds it
	            $replacement = sprintf('data-product_id="%d" data-quantity="1" $1 ajax_add_to_cart add_to_cart_button product_type_simple ', $product->get_id());
	            $button = preg_replace('/(class="single_add_to_cart_button)/', $replacement, $button);
	            $button = preg_replace( '/Add to cart/', 'Add', $button );
	        }
	    }
		*/
	    return $button;
	}
}
add_filter('woocommerce_loop_add_to_cart_link', 'ghc_modify_loop_add_to_cart_link', 10, 2);
