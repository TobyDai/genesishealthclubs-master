<?php
/**
 * Genesis Health Clubsfunctions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Genesis Health Clubs
 */

if ( ! function_exists( 'ghc_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ghc_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Genesis Health Clubs, use a find and replace
		 * to change 'ghc' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ghc', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary-menu' => esc_html__( 'Primary', 'ghc' ),
			'secondary-menu' => esc_html__( 'Secondary', 'ghc' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Excerpt support for pages
		add_post_type_support( 'page', 'excerpt' );

		/*
		 * Gutenberg support
		**/

		add_theme_support( 'editor-styles' );

		add_theme_support('responsive-embeds');

		add_theme_support('align-wide');

		add_theme_support('disable-custom-font-sizes');

		add_theme_support('disable-custom-colors');
		/*
		add_theme_support('editor-color-palette', array(
			array(
				'name'  => __('Blue', 'ghc'),
				'slug'  => 'blue',
				'color' => '#007ac2'
			),
			array(
				'name'  => __('Gray', 'ghc'),
				'slug'  => 'gray',
				'color' => '#939598'
			),
			array(
				'name'  => __('Light Gray', 'ghc'),
				'slug'  => 'light-gray',
				'color' => '#eaeff1'
			),
			array(
				'name'  => __('White', 'ghc'),
				'slug'  => 'white',
				'color' => '#ffffff'
			),

		));
		*/



		add_editor_style( 'styles/editor.css' );
		add_editor_style( 'styles/common.css' );
	}
endif;
add_action( 'after_setup_theme', 'ghc_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ghc_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'ghc_content_width', 640 );
}
add_action( 'after_setup_theme', 'ghc_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ghc_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column One', 'ghc' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here.', 'ghc' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column Two', 'ghc' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here.', 'ghc' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column Three', 'ghc' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here.', 'ghc' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column Four', 'ghc' ),
		'id'            => 'footer-4',
		'description'   => esc_html__( 'Add widgets here.', 'ghc' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	/*register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ghc' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ghc' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );*/
}
add_action( 'widgets_init', 'ghc_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ghc_scripts() {

	$cache = current_user_can('manage_options') ? date('U') : '43432480';
	$cache = date('U');

	wp_enqueue_style( 'ghc-fonts', 'https://use.typekit.net/njo8yuv.css' );

	wp_enqueue_style( 'ghc-style', get_stylesheet_uri(), array(), $cache );
	wp_enqueue_style( 'ghc-common', get_template_directory_uri() . '/styles/common.css', array(), $cache );

	if ( is_front_page() ) {
		wp_enqueue_style( 'ghc-style-front-page', get_template_directory_uri() . '/styles/front-page.css', array('ghc-style'), $cache );
	}
	else if (
		is_singular() &&
		(
			get_post_type( get_queried_object_id() ) === 'ghc_location'
		 	||
			get_post_type( get_queried_object_id() ) === 'ghc_location_page'
			||
			get_post_type( get_queried_object_id() ) === 'ghc_class'
		)
		||
		is_post_type_archive( 'ghc_location' )
	) {
		wp_enqueue_style( 'ghc-style-front-page', get_template_directory_uri() . '/styles/location.css', array('ghc-style'), $cache );
			wp_enqueue_style( 'ghc-style-front-page', get_template_directory_uri() . '/styles/class.css', array('ghc-style'), $cache );
	}

	if (
		is_singular() &&
		(
			get_post_type( get_queried_object_id() ) === 'ghc_class'
			||
			get_post_type( get_queried_object_id() ) === 'ghc_location'
		)
		||
		is_post_type_archive( 'ghc_class' )
	) {
		wp_enqueue_style( 'ghc-style-class', get_template_directory_uri() . '/styles/class.css', array('ghc-style'), $cache );
	}

	wp_enqueue_script( 'ghc-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'ghc-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'copas-modernizr', get_template_directory_uri() . '/js/modernizr.min.js', array(), '20151213', true );

	wp_enqueue_script( 'copas-cedar', get_template_directory_uri() . '/js/cedar.min.js', array(), '20151214', true );

	wp_enqueue_script( 'copas-main', get_template_directory_uri() . '/js/main.js', array(), $cache, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ghc_scripts' );

function ghc_admin_scripts() {
	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_register_style('jquery-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');
	wp_enqueue_style( 'jquery-ui' );
	wp_enqueue_style( 'ghc-style-admin', get_template_directory_uri() . '/styles/admin.css', array(), date('U') );

	wp_enqueue_script( 'ghc-js-admin', get_template_directory_uri() . '/js/admin.js', array('jquery'), date('U'), true );
}
add_action( 'admin_enqueue_scripts', 'ghc_admin_scripts' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Walker Nav Menu
 */
require get_template_directory() . '/inc/walker-nav-menu.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom Post Types.
 */
require get_template_directory() . '/inc/post-types/_base.php';
require get_template_directory() . '/inc/post-types/alert.php';
require get_template_directory() . '/inc/post-types/banner.php';
require get_template_directory() . '/inc/post-types/class.php';
require get_template_directory() . '/inc/post-types/employee.php';
require get_template_directory() . '/inc/post-types/location.php';
require get_template_directory() . '/inc/post-types/location-page.php'; /* Must be registered after Location post type */

/**
 * Custom Template Functions.
 */
require get_template_directory() . '/inc/template-functions/class.php';
require get_template_directory() . '/inc/template-functions/banner.php';
require get_template_directory() . '/inc/template-functions/location.php';

/**
 * Custom Template Tags.
 */
require get_template_directory() . '/inc/template-tags/banner.php';
require get_template_directory() . '/inc/template-tags/location.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}


function pumpimagestore_admin_menu_customizations() {
    if ( get_current_user_id() != 1 ) {
        //remove_menu_page('jetpack');
        //remove_menu_page( 'edit.php' );
        //remove_menu_page('plugins.php');
        //remove_menu_page('tools.php');
        //remove_menu_page( 'themes.php' );
        //remove_submenu_page('plugins.php', 'plugin-editor.php');
        //remove_submenu_page('options-general.php', 'options-writing.php');
        //remove_submenu_page('options-general.php', 'options-reading.php');
        //remove_submenu_page('options-general.php', 'options-media.php');
        //remove_submenu_page('options-general.php', 'options-permalink.php');
    }
}
add_action( 'admin_menu', 'pumpimagestore_admin_menu_customizations',9999 );

function customize_admin_bar( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'wp-logo' );
	$wp_admin_bar->remove_node( 'search' );
    //$wp_admin_bar->remove_node( 'customize' );
    $wp_admin_bar->remove_node( 'stats' );
    $wp_admin_bar->remove_node( 'notes' );
}
add_action( 'admin_bar_menu', 'customize_admin_bar', 999 );
