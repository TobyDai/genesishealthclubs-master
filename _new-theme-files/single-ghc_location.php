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
        $the_market = ghc_get_location_market_term( get_the_ID() );
    ?>

    <?php ghc_the_location_nav( get_the_ID() ); ?>

    <?php ghc_the_location_banner( get_the_ID() ); ?>

    <header class="page-header page-header--location page-header--has-image">
        <p class="page-header__pretitle">
            <a href="<?php echo get_term_link( $the_market, 'ghc_location_market' ); ?>"><?php echo $the_market->name; ?></a>
        </p>
        <h1 class="page-header__title"><?php the_title(); ?></h1>
        <p class="page-header__desc"><?php ghc_the_location_short_description( get_the_ID() ); ?></p>

        <figure class="page-header__image">
            <?php the_post_thumbnail( 'large' ); ?>
        </figure>
        <div class="page-header__meta">
            <?php ghc_location_contact_list( get_the_ID(), array( 'class'   => 'location-meta__address' ) ); ?>
            <p><?php echo ghc_get_location_hours_today(get_the_ID()); ?></p>
        </div>
    </header>
    <div class="page-content">

        <?php $featured_blocks = ghc_get_featured_location_pages( get_the_ID() ); ?>

        <div class="card-list card-list--markets">
            <?php foreach ( $featured_blocks as $post ) : setup_postdata( $post ); ?>
                <div class="card-list__item">
                    <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
                        <div class="card-list__item__content">
                            <div class="card-list__item__content__details">
                                <h2 class="card-list__item__title"><?php the_title(); ?></h2>
                                <?php the_excerpt(); ?>
                                <span><?php _e( 'Learn more', 'ghc' ); ?></span>
                            </div>
                            <div class="card-list__item__content__media" style="background-image: url(<?php echo get_the_post_thumbnail_url( get_the_ID(), 'medium'); ?>);">
                                <?php echo the_post_thumbnail( get_the_ID(), 'medium' ); ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; wp_reset_postdata(); ?>
        </div>

        <div class="location-intro">
            <div class="location-intro__meta">
                <?php ghc_location_hours_list( get_the_ID() ); ?>
                <?php ghc_location_social_list( get_the_ID(), array( 'class'   => 'location-meta__social' ) ); ?>
            </div>
            <div class="location-intro__content">

            </div>
        </div>


        <?php /*
                <?php $class_instances = ghc_get_location_classes_today( get_the_ID() ); ?>

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
        						</dl>
        					</a>
        				</li>
        			<?php endforeach; ?>
        		</ol>
        */ ?>

        <?php /*
        <main style="position: relative;">

            <article <?php post_class( 'single-location' ); ?>>

                <?php //ghc_location_notice( get_the_ID() ); ?>

                <?php $location_pages = ghc_get_location_pages( get_the_ID() ); ?>
                <?php if ( $location_pages ) : ?>
                    <nav class="location-nav single-location__nav off-stage enter-stage">
                        <h3><?php _e( 'Programming', 'ghc' ); ?></h3>

                        <ul>
                            <?php foreach ( $location_pages as $location_page ) : ?>
                                <li><a href="<?php echo get_permalink( $location_page->ID ); ?>" title="<?php echo esc_attr( get_the_title( $location_page->ID ) ); ?>"><?php echo get_the_title( $location_page->ID ); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                <?php endif; ?>

                <?php ghc_location_amenities_list( get_the_ID(), array( 'class' => 'location-amenities' ) ); ?>

                <section class="location-events single-location__events off-stage enter-stage">
                    <h3>Upcoming Events</h3>
                    <div class="events off-stage">
                        <?php for ( $i=0; $i<9; $i++ ) : ?>
                            <article class="events__item enter-stage">
                                <a href="#!">
                                    <div class="events__item__date"><span>Jul</span> <b><?php echo 9 + $i; ?></b></div>
                                    <figure>
                                        <?php echo wp_get_attachment_image(96, 'medium', false, array('class'=>'off-stage enter-stage')); ?>
                                    </figure>
                                    <div>
                                        <h2>The Event Name</h2>
                                        <p>7:00 pm - 9:00 pm</p>
                                    </div>
                                </a>
                            </article>
                        <?php endfor; ?>
                    </div>
                </section>

                <?php $featured_blocks = ghc_get_featured_location_pages( get_the_ID() ); ?>

                <section class="location-programs single-location__blocks">
                    <?php foreach ( $featured_blocks as $post ) : setup_postdata( $post ); ?>
                        <article class="single-location__blocks__item">
                            <figure class="off-stage enter-stage" style="background-image: url(<?php echo get_the_post_thumbnail_url( get_the_ID(), 'large'); ?>);">
                                <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
                                    <?php echo the_post_thumbnail( get_the_ID(), 'large' ); ?>
                                    <figcaption class="off-stage enter-stage"><?php the_title(); ?></figcaption>
                                </a>
                            </figure>
                            <div class="off-stage enter-stage">
                                <h2><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a></h2>
                                <p><?php the_excerpt(); ?></p>
                                <a class="bold-link" href="<?php the_permalink(); ?>"><?php _e( 'Learn More', 'ghc' ); ?></a>
                            </div>
                        </article>
                    <?php endforeach; wp_reset_postdata(); ?>
                </section>


                <section class="location-classes">
                    <h3><?php echo apply_filters( 'the_title', __( 'Today\'s Classes', 'ghc' ) ); ?></h3>
                    <div class="location-classes__content">
                        <ul class="class-instance-list">
                            <?php foreach ( $class_instances as $class_instance ) : ?>
                                <li class="class-instance-list__item">
                                    <p><a href="<?php echo get_permalink( get_post_meta( $class_instance->ID, 'ghc_class_instance_class_id', true ) ); ?>"><?php echo get_the_title( get_post_meta( $class_instance->ID, 'ghc_class_instance_class_id', true ) ); ?></a> <small><?php echo ghc_get_class_instance_studio_name( $class_instance->ID ); ?></small></p>
                                    <time><?php echo ghc_get_class_instance_display_hours_start( $class_instance->ID ); ?></time>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </section>

            </article>

        </main>
        */ ?>

        <?php
        ghc_offer_form( get_the_ID(), true );
        ?>
    </div>
    <?php
    endwhile;
    ?>


<?php
get_footer();
