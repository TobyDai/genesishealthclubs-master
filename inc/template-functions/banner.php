<?php

if ( ! function_exists( 'ghc_get_banners' ) ) {
	function ghc_get_banners( $args = array() ) {
		$controller = new GHCPostTypeBanner;
		$banners = $controller->get_banners( $args );
		return $banners;
	}
}

if ( ! function_exists( 'ghc_get_banners_by_location' ) ) {
	function ghc_get_banners_by_location( $location_id ) {
		return ghc_get_banners(array(
			'meta_query'	=> array(
				array(
					'key'	=> 'ghc_banner_locations_' . $location_id,
					'value'=> 1,
				)
			)
		));
	}
}

if ( ! function_exists( 'ghc_get_banner_image' ) ) {
	function ghc_get_banner_image_url( $banner_id, $size ) {
		$image_id = get_post_meta( $banner_id, 'ghc_banner_image_' . $size, true );
		if ( $image_id != '' ) {
			$image_src = wp_get_attachment_image_src( $image_id, 'full' );
			return $image_src[0];
		}
		return;
	}
}

if ( ! function_exists( 'ghc_get_banner_image_narrow' ) ) {
	function ghc_get_banner_image_url_narrow( $banner_id ) {
		return ghc_get_banner_image_url( $banner_id, 'narrow' );
	}
}
if ( ! function_exists( 'ghc_get_banner_image_wide' ) ) {
	function ghc_get_banner_image_url_wide( $banner_id ) {
		return ghc_get_banner_image_url( $banner_id, 'wide' );
	}
}

if ( ! function_exists( 'ghc_get_banner_headline' ) ) {
	function ghc_get_banner_headline( $banner_id ) {
		return get_post_meta( $banner_id, 'ghc_banner_headline', true );
	}
}

if ( ! function_exists( 'ghc_get_banner_subtitle' ) ) {
	function ghc_get_banner_subtitle( $banner_id ) {
		return get_post_meta( $banner_id, 'ghc_banner_subtitle', true );
	}
}
