<?php

if ( ! function_exists( 'ghc_get_slides' ) ) {
	function ghc_get_slides( $args = array() ) {
		$controller = new GHCPostTypeSlide;
		$items = $controller->get_slides( $args );
		return $items;
	}
}

if ( ! function_exists( 'ghc_get_slide_url') ) {
    function ghc_get_slide_url( $slide_id ) {
        return get_post_meta( $slide_id, 'ghc_slide_url', true);
    }
}

if ( ! function_exists( 'ghc_get_slide_image' ) ) {
	function ghc_get_slide_image_url( $slide_id, $size ) {
		$image_id = get_post_meta( $slide_id, 'ghc_slide_image_' . $size, true );
		if ( $image_id != '' ) {
			$image_src = wp_get_attachment_image_src( $image_id, 'full' );
			return $image_src[0];
		}
		return;
	}
}

if ( ! function_exists( 'ghc_get_slide_image_narrow' ) ) {
	function ghc_get_slide_image_url_narrow( $slide_id ) {
		return ghc_get_slide_image_url( $slide_id, 'narrow' );
	}
}
if ( ! function_exists( 'ghc_get_slide_image_wide' ) ) {
	function ghc_get_slide_image_url_wide( $slide_id ) {
		return ghc_get_slide_image_url( $slide_id, 'wide' );
	}
}

if ( ! function_exists( 'ghc_get_slide_headline' ) ) {
	function ghc_get_slide_headline( $slide_id ) {
		return get_post_meta( $slide_id, 'ghc_slide_headline', true );
	}
}

if ( ! function_exists( 'ghc_get_slide_subtitle' ) ) {
	function ghc_get_slide_subtitle( $slide_id ) {
		return get_post_meta( $slide_id, 'ghc_slide_subtitle', true );
	}
}
