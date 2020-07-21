<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Genesis Health Clubs
 */

?>
		</div>
	</div><!-- #site-content -->

	<footer class="site-footer">
		<div class="container">
			<div class="site-footer__widgets">
				<?php for ( $i = 0; $i < 4; $i++ ) : $n = $i+1; ?>
					<?php if ( is_active_sidebar( 'footer-' . $n ) ) : ?>
						<div class="site-footer__widgets__item">
							<?php dynamic_sidebar( 'footer-' . $n ); ?>
						</div>
					<?php endif; ?>
				<?php endfor; ?>
			</div>
			<div class="site-footer__credits">
				<span>
					<?php printf( esc_html__( 'Copyright %s', 'ghc' ), get_bloginfo('name') ); ?>
				</span>

				<span><?php printf( esc_html__( 'Site by %1$s', 'ghc' ), '<a href="https://rsmconnect.com" title="RSM Marketing" target="_blank" rel="nofollow">RSM Marketing</a>' ); ?></span>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
