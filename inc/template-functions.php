<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Genesis Health Clubs
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ghc_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	$classes[] = 'theme-ghc';

	return $classes;
}
add_filter( 'body_class', 'ghc_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function ghc_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'ghc_pingback_header' );

if ( ! function_exists( 'ghc_strip_white_space' ) ) {
    function ghc_strip_white_space( $content ) {
		return preg_replace( '/<(\w+)\b(?:\s+[\w\-.:]+(?:\s*=\s*(?:"[^"]*"|"[^"]*"|[\w\-.:]+))?)*\s*\/?>\s*<\/\1\s*>/', '', preg_replace( '/>&nbsp;</', '><', $content ) );
    }
}
//add_filter( 'the_content', 'ghc_strip_white_space' );


if ( ! function_exists( 'ghc_get_current_uri_swap_parameter' ) ) {
	function ghc_get_current_uri_swap_parameter( $key, $value ) {
		$current_url = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);

		$parts = parse_url($current_url);
		parse_str($parts['query'], $query);
		$query[ $key ] = $value;
		$querystring = http_build_query( $query );

		return $uri_parts[0] . '?' . $querystring;

	}
}
