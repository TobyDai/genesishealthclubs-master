<?php

if ( ! function_exists( 'ghc_get_locations' ) ) {
	function ghc_get_locations( $args = array() ) {
		$location = new GHCPostTypeLocation;
		$locations = $location->get_locations( $args );
		return $locations;
	}
}

if ( ! function_exists( 'ghc_get_locations_by_market' ) ) {
	function ghc_get_locations_by_market( $market ) {
		return ghc_get_locations(array(
			'tax_query'	=> array(
				array(
					'taxonomy'	=> 'ghc_location_market',
					'field'		=> 'slug',
					'terms'		=> $market
				)
			)
		));
	}
}

if ( ! function_exists( 'ghc_get_locations_by_market_as_key_value' ) ) {
	function ghc_get_locations_by_market_as_key_value( $market ) {
		$locations = ghc_get_locations_by_market( $market );
		$return = array();
		foreach ( $locations as $location )  {
			$return[(int)$location->ID] =  esc_attr( $location->post_title );
		}
		return $return;
	}
}

if ( ! function_exists( 'ghc_get_location_market_term' ) ) {
    function ghc_get_location_market_term( $location_id ) {
        $terms = get_the_terms( $location_id, 'ghc_location_market' );
        return $terms[0];
    }
}



if ( ! function_exists( 'ghc_get_markets' ) ) {
	function ghc_get_markets() {
		return get_terms(array(
			'taxonomy'	=> 'ghc_location_market',
			'orderby'	=> 'name',
			'order'		=> 'DESC'
		));
	}
}

if ( ! function_exists( 'ghc_get_market_short_description' ) ) {
	function ghc_get_market_short_description( $term_id ) {
		return get_term_meta( $term_id, 'ghc_location_market_short_description', true );
	}
}
if ( ! function_exists( 'ghc_get_market_description' ) ) {
	function ghc_get_market_description( $term_id ) {
		return apply_filters( 'the_content', term_description( $term_id, 'ghc_location_market' ) );
	}
}
if ( ! function_exists( 'ghc_get_market_excerpt' ) ) {
	function ghc_get_market_excerpt( $term_id ) {
		return get_term_meta( $term_id, 'ghc_location_market_excerpt', true );
	}
}

if ( ! function_exists( 'ghc_get_market_image_url' ) ) {
	function ghc_get_market_image_url( $term_id, $size = 'large' ) {
		$image_id = get_term_meta( $term_id, 'ghc_location_market_image_id', true );
		return wp_get_attachment_image_url( $image_id, $size );
	}
}

if ( ! function_exists( 'ghc_get_location_hours_today' ) ) {
	function ghc_get_location_hours_today( $post_id ) {
		$location = new GHCPostTypeLocation;
        $hour_sets = $location->get_hours( $post_id, false, true );
        foreach ( $hour_sets[0]['days'] as $day ) {
            if ( $day['label'] === date('D') ) {
                if ( preg_match( '/^open/i', $day['value'] ) ) {
                    return $day['value'] . ' ' . __('today', 'ghc');
                }
                return __('Open', 'ghc') . ' ' . $day['value'] . ' ' . __('today', 'ghc');
            }
        }
	}
}
