<?php
/**
 * Genesis Health ClubsTheme Customizer
 *
 * @package Genesis Health Clubs
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ghc_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'ghc_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'ghc_customize_partial_blogdescription',
		) );
	}

	$wp_customize->add_setting( 'ghc_woocommerce_products_per_line' );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ghc_woocommerce_products_per_line', array(
		'label'			=> __( 'Products Per Line', 'kera' ),
		'description'	=> null,
		'section'		=> 'woocommerce_product_catalog',
		'settings'		=> 'ghc_woocommerce_products_per_line',
		'type'			=> 'range',
		'input_attrs'	=> array(
			'min'		=> 1,
			'max'		=> 6
		),
	) ) );

	$wp_customize->add_setting( 'ghc_woocommerce_show_variable_form' );

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ghc_woocommerce_show_variable_form', array(
		'label'			=> __( 'Show Variable Form', 'kera' ),
		'description'	=> 'Show the product variable form on shop archive pages.',
		'section'		=> 'woocommerce_product_catalog',
		'settings'		=> 'ghc_woocommerce_show_variable_form',
		'type'			=> 'checkbox',
	) ) );


}
add_action( 'customize_register', 'ghc_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function ghc_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function ghc_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function ghc_customize_preview_js() {
	wp_enqueue_script( 'ghc-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'ghc_customize_preview_js' );
