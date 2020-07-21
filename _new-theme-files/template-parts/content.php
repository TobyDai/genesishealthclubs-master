<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Genesis Health Clubs
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				ghc_posted_on();
				ghc_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php ghc_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		if ( is_singular() ) {
			the_content();
		}
		else {
			the_excerpt();
			?>
			<a class="label-link label-link--light" href="<?php echo get_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php _e( 'Continue reading', 'copas' ); ?></a>
			<?php
		}
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
