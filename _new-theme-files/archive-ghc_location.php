<?php
/**
 * The template for displaying archive locations
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Genesis Health Clubs
 */

get_header();
?>

	<?php if ( have_posts() ) : ?>

		<?php $locations = ghc_get_locations(); ?>



		<header class="page-header">
			<h1 class="page-header__title"><?php echo count($locations) . ' gym' . (count($locations) != 1 ? 's' : ''); ?></h1>

			<form class="page-header__search">
				<div class="icon-locate"><span></span></div>
				<input type="text" placeholder="Search by ZIP code..." pattern="\d*" />
			</form>
		</header>

		<main class="page-content">
			<div class="card-list card-list--markets">
				<?php $markets = ghc_get_markets(); ?>
				<?php foreach ( $markets as $market ) : ?>
					<?php $locations_in_market = ghc_get_locations_by_market( $market->slug ); ?>
					<div class="card-list__item">
						<a href="<?php echo get_term_link( $market, 'ghc_location_market' ); ?>" title="<?php echo $market->name; ?>">
							<div class="card-list__item__content">
								<div class="card-list__item__content__details">
									<h2 class="card-list__item__title"><?php echo $market->name; ?></h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea com.</p>
									<span><?php
										echo (
											count( $locations_in_market ) != 1
											?
											'View all ' . count( $locations_in_market ) . ' gyms'
											:
											'View one gym'
										);
									?></span>
								</div>
								<div class="card-list__item__content__media" style="background-image: url(https://genesishealthclubs.ictideas.com/wp-content/uploads/2019/06/P1133290_Edit01-2.jpg);">
									<img src="https://genesishealthclubs.ictideas.com/wp-content/uploads/2019/06/P1133290_Edit01-2.jpg" alt="" />
								</div>
							</div>
						</a>
					</div>
				<?php endforeach; ?>
			</div>


			<?php /* $markets = get_terms( array( 'taxonomy' => 'ghc_location_market' ) ); ?>
			<?php foreach ( $markets as $market ) : ?>
				<details class="collapsible">
					<summary>
						<h2><?php echo $market->name; ?></h2>
					</summary>
					<div class="locations">
					<?php
					// Start the Loop
					while ( have_posts() ) :
						the_post();
						if ( ! has_term( $market->term_id, 'ghc_location_market' ) ) {
							continue;
						}
					?>
						<article class="locations__item">
							<h2><?php the_title(); ?></h2>
							<?php ghc_location_contact_list( get_the_ID() ); ?>
			                <?php ghc_location_hours_list( get_the_ID(), array( 'show_title' => false, 'limit' => 1 ) ); ?>
							<nav>
								<a class="button" href="<?php the_permalink(); ?>"><?php _e( 'View Gym Page', 'ghc' ); ?></a>
							</nav>
						</article>
					<?php
					endwhile;
					?>
					</div>
				</details>
			<?php endforeach; */ ?>
			<aside>
				<?php ghc_offer_form( 0, true ); ?>
			</aside>
		</main>
		<?php
		the_posts_navigation();

	else :

		get_template_part( 'template-parts/content', 'none' );

	endif;
	?>

	<?php ghc_offer_form( get_the_ID() ); ?>

<?php
get_footer();
