<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Genesis Health Clubs
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<!-- https://gist.github.com/stephansmith/0a12493293f670f31b12bf8fa6defd0a -->
	<script>document.getElementsByTagName( 'html' )[0].className = document.getElementsByTagName( 'html' )[0].className.replace( /no-js/, 'js' );</script>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ghc' ); ?></a>

	<input class="is-hidden" id="site-nav-toggle-control" type="checkbox" name="site-nav-toggle-control">
	<input class="is-hidden" id="primary-menu-item-submenu-control-null" name="primary-menu-item-submenu-control-depth-0" type="radio">

	<header class="site-header">
		<div class="site-header__content container">
			<?php
			if ( is_front_page() ) :
				?>
				<h1 class="site-header__logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-header__logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			?>
			<label class="site-header__nav-toggle" for="site-nav-toggle-control"><span></span></label>

			<nav class="site-header__nav">
				<?php
				wp_nav_menu( array(
					'theme_location'	=> 'primary-menu',
					'menu_id'			=> '',
					'menu_class'		=> '',
					'items_wrap'		=> '<ul class="site-header__nav__menu">%3$s</ul>',
					'container'			=> false,
					'walker'			=> new GHC_Walker_Nav_Menu_Radio
				) );
				?>
				<?php
				wp_nav_menu( array(
					'theme_location'	=> 'secondary-menu',
					'menu_id'			=> '',
					'menu_class'		=> '',
					'items_wrap'		=> '<ul class="site-header__nav__secondary">%3$s</ul>',
					'container'			=> false,
					'walker'			=> new GHC_Walker_Nav_Menu_Radio
				) );
				?>
				<?php if ( function_exists( 'ghc_woocommerce_header_cart' ) ) : ?>
					<?php ghc_woocommerce_header_cart(); ?>
				<?php endif; ?>
			</nav>
		</div>

	</header><!-- #masthead -->

	<div id="content" class="site-main">
		<div class="container">
