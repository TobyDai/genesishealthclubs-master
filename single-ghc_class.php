<?php
/**
 * The template for displaying all locations
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Genesis Health Clubs
 */

get_header();
?>

    <?php
    while ( have_posts() ) :
        the_post();
    ?>

    <main <?php post_class( 'page-content single-class' ); ?>>

        <article>
            <figure class="single-class__figure img-filter">
                <?php the_post_thumbnail('large'); ?>
            </figure>

            <div class="single-class__intro off-stage enter-stage">
                <header>
                    <?php the_title( '<h1 class="entry-title off-stage enter-stage">', '</h1>' ); ?>
                </header>
                <?php echo apply_filters( 'the_content', get_post_meta( get_the_ID(), 'ghc_class_short_description', true ) ); ?>
            </div>
            <?php if ( get_post_meta( get_the_ID(), 'ghc_class_video', true ) != '' ) : ?>
                <figure class="single-class__video">
                    <div class="single-class__video__content">
                        <?php echo wp_oembed_get(get_post_meta( get_the_ID(), 'ghc_class_video', true )); ?>
                    </div>
                </figure>
            <?php endif; ?>
        </article>

		<?php
        $markets = get_terms( array( 'taxonomy' => 'ghc_location_market' ) );
        $locations = ghc_get_locations();
        $is_open = false;
        ?>
		<?php foreach ( $markets as $market ) : ?>
            <?php foreach ( $locations as $location ) : ?>
                <?php
                if ( ! has_term( $market->term_id, 'ghc_location_market', $location->ID ) ) {
					continue;
                }
                $class_instances = ghc_get_class_instances(
                    get_the_ID(),
                    array( 'location' => $location->ID )
                );

                if ( is_array( $class_instances ) && count( $class_instances ) > 0 ) :
                    $current_market = $market->term_id;
                    if ( $current_market != $previous_market ) :
                        if ( $previous_market ) : ?>
                            <?php $is_open = false; ?>
                            </div>
                        </details>
                        <?php endif; ?>
                        <?php $is_open = true; ?>
    					<details class="collapsible">
    						<summary><h2><?php echo $market->name; ?></h2></summary>
                            <div class="locations">
                    <?php endif; ?>
                    <article class="locations__item">
						<h2><?php echo get_the_title( $location->ID); ?></h2>
                        <?php echo ghc_get_class_instance_session_list( $class_instances ); ?>
						<nav>
							<a class="button" href="<?php echo get_the_permalink( $location->ID ); ?>"><?php _e( 'View Gym Page', 'ghc' ); ?></a>
						</nav>
					</article>
                    <?php $previous_market = $market->term_id; ?>
                <?php endif; ?>
            <?php endforeach; ?>
		<?php endforeach; ?>
        <?php if ( $is_open ) : ?>
                </div>
            </details>
        <?php endif; ?>

        <?php ghc_offer_form( get_the_ID(), true ); ?>

    </main>

    <?php
    endwhile;
    ?>


<?php
get_footer();
