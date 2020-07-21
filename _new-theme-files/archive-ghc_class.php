<?php
/**
 * The template for displaying archive classes
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Genesis Health Clubs
 */

get_header();
?>
	<?php $markets = ghc_get_markets(); ?>

	<header class="page-header">
		<h1 class="page-header__title">Group Fitness</h1>
		<form method="get" class="class-search-form">
			<select name="market" data-action="replace-select" data-action-target="class-search-location">
				<option value="">Select a market</option>
				<?php foreach ( $markets as $market ) : ?>
					<option
						value="<?php echo $market->slug; ?>"
						data-select-replace='<?php echo json_encode( ghc_get_locations_by_market_as_key_value( $market ) ); ?>'
						<?php echo ( isset($_GET['market']) && $_GET['market'] == $market->slug ? ' selected ' : '' ); ?>
					><?php echo $market->name; ?></option>
				<?php endforeach; ?>
			</select>
			<select id="class-search-location" name="location" data-placeholder="Select a location">
				<?php if ( isset( $_GET['market'] ) && $_GET['market'] != '' ) : ?>
					<?php $market_locations = ghc_get_locations_by_market( $_GET['market'] ); ?>
					<option value="">Select a location</option>
					<?php foreach ( $market_locations as $market_location ) : ?>
						<option
							value="<?php echo $market_location->ID; ?>"
							<?php echo ( isset($_GET['location']) && $_GET['location'] == $market_location->ID ? ' selected ' : '' ); ?>
						><?php echo $market_location->post_title; ?></option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
			<button class="button button--outline">Find classes</button>
		</form>

	</header>

	<?php if ( isset( $_GET['location'] )  && $_GET['location'] != '' ) : ?>
		<?php
			$class_instances = ( ! isset( $_GET['date'] ) ? ghc_get_location_classes_today( $_GET['location'] ) : ghc_get_location_classes_by_date( $_GET['location'], $_GET['date'] ) );
		?>

		<main id="page-content" class="page-content page-content--medium">

			<ol class="class-list-days">
				<?php
				$day = date('w');
				$week_start = date('Y-m-d', strtotime('-'.$day.' days'));
				 ?>
				<?php for ( $i = 1; $i < 8; $i++ ) : ?>
					<?php $the_date = strtotime( $week_start . ' +' . $i . ' days' ); ?>
					<li>
						<a
							<?php if ( ! isset( $_GET['date'] ) && $i == 1 || $_GET['date'] == date('Y-m-d', $the_date ) ) echo ' class="is-active" '; ?>
							href="<?php echo ghc_get_current_uri_swap_parameter( 'date', date('Y-m-d', $the_date ) ); ?>#page-content"
						>
							<b><?php echo substr( date('D', $the_date ), 0, 1 ); ?></b>
							<strong><?php echo date('D', $the_date ); ?></strong>
							<?php /*<small><?php echo date('M j', $the_date ); ?></small>*/ ?>
						</a>
					</li>
				<?php endfor; ?>
			</ol>

			<ol class="class-list">
				<?php foreach ( $class_instances as $class_instance ) : ?>
					<li class="class-list__item">
						<a href="<?php echo get_permalink( ghc_get_class_instance_class_id( $class_instance->ID ) ); ?>">
							<h3 class="class-list__item__title"><?php echo ghc_get_class_instance_class_title( $class_instance->ID ); ?></h3>
							<dl>
								<dt class="screen-reader-text">Time</dt>
								<dd><?php echo ghc_get_class_instance_display_hours( $class_instance->ID ); ?></dd>
								<dt class="screen-reader-text">Studio</dt>
								<dd><?php echo ghc_get_class_instance_studio_name( $class_instance->ID ); ?></dd>
								<?php /*<dt class="screen-reader-text">Instructor</dt>
								<dd><?php echo ghc_get_class_instance_instructor( $class_instance->ID ); ?></dd>*/ ?>
							</dl>
						</a>
					</li>
				<?php endforeach; ?>
			</ol>

		</main>

	<?php elseif ( have_posts() ) : ?>

		<main class="page-content">
			<h2 class="section-title">Featured Classes</h2>
			<div class="card-list card-list--classes">
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="card-list__item">
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
							<div class="card-list__item__content">
								<div class="card-list__item__content__media" style="background-image: url(<?php echo get_the_post_thumbnail_url( get_the_ID(), 'large'); ?>);">
									<?php the_post_thumbnail('large'); ?>
								</div>
								<div class="card-list__item__content__details">
									<h2 class="card-list__item__title"><?php the_title(); ?></h2>
									<?php echo apply_filters('the_content', get_post_meta( get_the_ID(), 'ghc_class_short_description', true ) ); ?>
									<span><?php _e( 'Find a session', 'ghc' ); ?></span>
								</div>
							</div>
						</a>
					</div>
				<?php endwhile; ?>
			</div>
			<?php /*
			<div class="classes">
				<?php
				while ( have_posts() ) :
					the_post();
				?>
					<article class="classes__item">
	                    <a class="classes__item__link" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
	                        <figure class="classes__item__media img-filter"><?php the_post_thumbnail('large'); ?></figure>
	                        <h2 class="classes__item__title"><?php the_title(); ?></h2>
	                    </a>
	                    <details class="classes__item__details">
	                        <summary><?php _e( 'Details', 'ghc' ); ?></summary>
	                        <div class="classes__item__content">
	                            <?php echo apply_filters('the_content', get_post_meta( get_the_ID(), 'ghc_class_short_description', true ) ); ?>
	                        </div>
	                    </details>
						<nav>
							<a class="bold-link" href="<?php the_permalink(); ?>"><?php _e( 'Find a Session', 'ghc' ); ?></a>
						</nav>
					</article>
				<?php
			endwhile;
				?>
			</div>
			*/ ?>
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
