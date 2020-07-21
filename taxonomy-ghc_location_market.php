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

		<?php $the_term = get_term(get_queried_object_id(), 'ghc_location_market'); ?>

		<header class="page-header page-header--has-search">
			<p class="page-header__pretitle"><?php echo $the_term->name; ?></p>
			<h1 class="page-header__title"><?php echo $wp_query->found_posts . ' gym' . ($wp_query->found_posts != 1 ? 's' : ''); ?></h1>

			<form class="page-header__search">
				<div class="icon-locate"><span></span></div>
				<input type="text" placeholder="Search by ZIP code..." pattern="\d*" />
			</form>
			<a class="page-header__back" href="/locations/">View all locations</a>
		</header>

		<main class="page-content">
			<div class="wide-content copy">
				<?php echo ghc_get_market_short_description( $the_term->term_id ); ?>
			</div>

			<div class="card-list card-list--locations">
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="card-list__item">
						<a href="<?php the_permalink( get_the_ID() ); ?>" title="<?php the_title(); ?>">
							<div class="card-list__item__content">
								<div class="card-list__item__content__details">
									<h2 class="card-list__item__title"><?php the_title(); ?></h2>
									<?php ghc_location_contact_details( get_the_ID(), array('class' => 'ghc_address' ) ); ?>
					                <?php //ghc_location_hours_list( get_the_ID(), array( 'show_title' => false, 'limit' => 1 ) ); ?>
									<span>View this gym</span>
								</div>
								<?php
									$image_url = get_the_post_thumbnail_url() != '' ? get_the_post_thumbnail_url() : 'https://genesishealthclubs.ictideas.com/wp-content/uploads/2019/06/P1133290_Edit01-2.jpg';
								?>
								<div class="card-list__item__content__media" style="background-image: url(<?php echo $image_url; ?>);">
									<img src="<?php echo $image_url; ?>" alt="">
								</div>
							</div>
						</a>
					</div>
				<?php endwhile; ?>
			</div>

			<div class="wide-content copy">
				<?php echo ghc_get_market_description( $the_term->term_id ); ?>
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
		</main>

		<aside class="page-form">
			<?php gravity_form( 5, true, true, false, null, true ); ?>
		</aside>
		<?php
		the_posts_navigation();

	else :

		get_template_part( 'template-parts/content', 'none' );

	endif;
	?>

	<?php ghc_offer_form( get_the_ID() ); ?>

<?php
get_footer();
