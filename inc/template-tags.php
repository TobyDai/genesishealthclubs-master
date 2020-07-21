<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Genesis Health Clubs
 */


if ( ! function_exists( 'ghc_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function ghc_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'ghc' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'ghc_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function ghc_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'ghc' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'ghc_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function ghc_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'ghc' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'ghc' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'ghc' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'ghc' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'ghc' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'ghc' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'ghc_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function ghc_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;


if ( ! function_exists('ghc_get_option') ) {
	function ghc_get_option( $key ) {
		return get_option($key) != '' ? get_option($key) : false;
	}
}


if ( ! function_exists('ghc_get_woocommerce_address' ) ) {
	function ghc_get_woocommerce_address() {
		$street_address = ghc_get_option('woocommerce_store_address');
		$street_address_2 = ghc_get_option('woocommerce_store_address_2');
		$city = ghc_get_option('woocommerce_store_city');
		$state_country = explode(':', ghc_get_option('woocommerce_default_country'));
		$state = is_array($state_country) && isset($state_country[1]) ? $state_country[1] : false;
		$postcode = ghc_get_option('woocommerce_store_postcode');



		$html = $street_address . ' ';
		if ( $street_address_2 != '' ) {

			if ( $html != '' )
				$html .= '<br>';

			$html .= $street_address_2 . ' ';
		}
		if ( $city ) {
			if ( $html != '' )
				$html .= '<br>';

			$html .= $city;
		}
		if ( $state ) {

			if ( $city )
				$html .= ',';
			$html .= ' ' . $state;
		}
		if ( $postcode ) {
			$html .= ' ' . $postcode;
		}
		return $html;
	}
}
if ( ! function_exists('ghc_get_woocommerce_phone' ) ) {
	function ghc_get_woocommerce_phone() {
		return ghc_get_option('woocommerce_store_phone');
	}
}

if ( ! function_exists('ghc_get_woocommerce_email' ) ) {
	function ghc_get_woocommerce_email() {
		return ghc_get_option('woocommerce_store_email');
	}
}

if ( ! function_exists( 'ghc_list_shop_contact' ) ) :
	function ghc_list_shop_contact() {
		ob_start();
		?>
		<ul class="shop-contact-info">
			<li class="shop-contact-info__address"><?php echo ghc_get_woocommerce_address(); ?></li>
			<li class="shop-contact-info__phone"><?php echo ghc_get_woocommerce_phone(); ?></li>
			<li class="shop-contact-info__email"><?php echo ghc_get_woocommerce_email(); ?></li>
		</ul>
		<?php
		return ob_get_clean();
	}

endif;

add_shortcode( 'list_shop_contact', 'ghc_list_shop_contact' );


if ( ! function_exists( 'ghc_list_faq' ) ) :
	function ghc_list_faq() {
		$faqs = get_posts(array(
			'post_type'			=> 'ghc_faq',
			'posts_per_page'	=> '-1',
			'order'				=> 'asc',
			'orderby'			=> 'menu_order'
		));
		ob_start();
		foreach ( $faqs as $faq ) :
		?>
			<details id="<?php echo $faq->post_name; ?>">
				<summary>
					<h3><?php echo get_the_title( $faq->ID ); ?></h3>
				</summary>
				<div>
					<?php echo apply_filters( 'the_content', $faq->post_content ); ?>
				</div>
			</details>
		<?php
		endforeach;
		return ob_get_clean();
	}

endif;

add_shortcode( 'list_faq', 'ghc_list_faq' );

if ( ! function_exists( 'ghc_the_location_short_description' ) ) {
	function ghc_the_location_short_description( $location_id ) {
		echo get_post_meta( $location_id, 'ghc_location_short_description', true );
		return;
	}
}


if ( ! function_exists( 'ghc_location_contact_details' ) ) :
	function ghc_location_contact_details( $location_id, $args = array() ) {
		?>
		<dl<?php echo isset( $args['class'] ) ? ' class="' . $args['class'] . '"' :
		''; ?>>
			<dt class="screen-reader-text"><?php _e( 'Address', 'ghc' ); ?></dt>
			<dd><?php
				echo get_post_meta( $location_id, 'ghc_location_street_address', true );
				echo '<br>';
				echo get_post_meta( $location_id, 'ghc_location_address_locality', true ) . ', ';
				echo get_post_meta( $location_id, 'ghc_location_postal_code', true );
			?></dd>
			<dt class="screen-reader-text"><?php _e( 'Phone', 'ghc' ); ?></dt>
			<dd><?php echo get_post_meta( $location_id, 'ghc_location_telephone', true ); ?></dd>
		</dl>
		<?php
	}

endif;

if ( ! function_exists( 'ghc_location_contact_list' ) ) :
	function ghc_location_contact_list( $location_id, $args = array() ) {
		?>
		<dl<?php echo isset( $args['class'] ) ? ' class="' . $args['class'] . '"' :
		''; ?>>
			<dt class="screen-reader-text"><?php _e( 'Address', 'ghc' ); ?></dt>
			<dd><?php echo get_post_meta( $location_id, 'ghc_location_street_address', true ); ?></dd>
			<dd><?php
				echo get_post_meta( $location_id, 'ghc_location_address_locality', true ) . ', ';
				echo get_post_meta( $location_id, 'ghc_location_address_region', true ) . ' ';
				echo get_post_meta( $location_id, 'ghc_location_postal_code', true );
			?></dd>
			<dd><a href=""><?php echo get_post_meta( $location_id, 'ghc_location_telephone', true ); ?></a></dd>
		</dl>
		<?php
	}

endif;

if ( ! function_exists( 'ghc_location_amenities_list' ) ) :
	function ghc_location_amenities_list( $location_id, $args = array() ) {
		$amenities = get_the_terms( $location_id, 'ghc_location_amenity' );
		if ( is_array( $amenities ) && count( $amenities ) > 0 ) :
			?>
			<dl<?php echo isset( $args['class'] ) ? ' class="' . $args['class'] . '"' :
			''; ?>>
				<dt><?php _e( 'Gym Highlights', 'ghc' ); ?></dt>
				<?php foreach ( $amenities as $amenity ) : ?>
					<dd><?php echo $amenity->name; ?></dd>
				<?php endforeach; ?>
			</dl>
			<?php
		endif;
	}

endif;

if ( ! function_exists( 'ghc_location_social_list' ) ) :
	function ghc_location_social_list( $location_id, $args = array() ) {
		?>
		<dl class="social-links<?php echo isset( $args['class'] ) ? ' ' . $args['class'] . '' :
		''; ?>">
			<dt class="screen-reader-text"><?php _e('Social', 'ghc' ); ?></dt>
			<?php if ( get_post_meta( $location_id, 'ghc_location_facebook_url', true ) != '' ) : ?>
				<dd><a href="<?php echo esc_attr( get_post_meta( $location_id, 'ghc_location_facebook_url', true ) ); ?>" title="<?php _e( 'Facebook', 'ghc' ); ?>" target="_blank"><?php _e( 'Facebook', 'ghc' ); ?></a></dd>
			<?php endif; ?>
			<?php if ( get_post_meta( $location_id, 'ghc_location_twitter_username', true ) != '' ) : ?>
				<dd><a href="https://twitter.com/<?php echo esc_attr( get_post_meta( $location_id, 'ghc_location_twitter_username', true ) ); ?>" title="<?php _e( 'Twitter', 'ghc' ); ?>" target="_blank"><?php _e( 'Twitter', 'ghc' ); ?></a></dd>
			<?php endif; ?>
			<?php if ( get_post_meta( $location_id, 'ghc_location_instagram_username', true ) != '' ) : ?>
				<dd><a href="https://instagram.com/<?php echo esc_attr( get_post_meta( $location_id, 'ghc_location_instagram_username', true ) ); ?>" title="<?php _e( 'Instagram', 'ghc' ); ?>" target="_blank"><?php _e( 'Instagram', 'ghc' ); ?></a></dd>
			<?php endif; ?>
		</dl>
		<?php
	}

endif;

if ( ! function_exists( 'ghc_location_notice' ) ) :
	function ghc_location_notice( $location_id, $args = array() ) {
		?>
		<aside class="location-notice<?php echo isset( $args['class'] ) ? ' ' . $args['class'] . '' :
		''; ?>">
			<div class="location-notice__content container">
				<h2>First Month Free!</h2>
				<a class="button">Join for 33 cents!</a>
			</div>
		</aside>
		<?php
	}

endif;

if ( ! function_exists( 'ghc_get_markets' ) ) :
	function ghc_get_markets( $args = array() ) {
		return get_terms( array(
			'taxonomy'	=> 'ghc_location_market'
		) );
	}
endif;

if ( ! function_exists( 'ghc_market_dropdown' ) ) :
	function ghc_market_dropdown( $args = array() ) {
		$markets = ghc_get_markets();
		?>
		<details class="is-dropdown<?php echo isset( $args['class'] ) ? ' ' . $args['class'] . '' :
		''; ?>">
			<summary><?php _e( 'All Markets', 'ghc' ); ?></summary>
			<nav>
				<ul>
					<?php foreach ( $markets as $market ) : ?>
						<li><a href=""><?php echo $market->name; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</nav>
		</details>
		<?php
	}

endif;


function ghc_get_the_form_title($form_id) {
  $forminfo = RGFormsModel::get_form($form_id);
  $form_title = $forminfo->title;
  return $form_title;
}

if ( ! function_exists( 'ghc_offer_form' ) ) :
	function ghc_offer_form( $post_id, $inline = false ) {
		$the_post = get_post( $post_id );
		$form_id = get_post_meta( $post_id, $the_post->post_type . '_offer_form', true );
		if ( $the_post->post_type == 'ghc_class' ) {
			$form_id = 3;
		}
		if ( $form_id ) :
		?>
			<?php if ( $inline ) : ?>
				<div class="offer-form-inline">
					<?php gravity_form( $form_id, true, true, false, '', false ); ?>
				</div>
			<?php else : ?>
		        <input id="the-offer-form-control" class="offer-form-toggle hidden-input" type="checkbox">
		        <label class="offer-form__toggle" for="the-offer-form-control"><span></span></label>
		        <label class="offer enter-stage" for="the-offer-form-control">
		            <span class="off-stage enter-stage"><?php echo ghc_get_the_form_title( $form_id ); ?></span>
		        </label>
		        <span class="offer-shadow enter-stage"><span><?php echo ghc_get_the_form_title( $form_id ); ?></span></span>
		        <aside class="offer-form">
		            <label class="offer-form__toggle" for="the-offer-form-control"><span></span></label>
		            <div class="offer-form__content">
						<?php gravity_form( $form_id, false, false, false, '', false ); ?>
		            </div>
		        </aside>
			<?php endif; ?>
		<?php
		endif;
	}
endif;

if ( ! function_exists( 'ghc_location_hours_list' ) ) {
	function ghc_location_hours_list( $post_id, $args = array() ) {
		$location = new GHCPostTypeLocation;
		echo $location->get_hours_list( $post_id, $args );
	}
}
