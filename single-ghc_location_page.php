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

        $the_location = get_post( get_post_meta( get_the_ID(), 'ghc_location_page_location_id', true ) );
    ?>

    <?php ghc_the_location_nav( $the_location->ID ); ?>

    <?php //ghc_the_location_banner( $the_location->ID ); ?>

    <header class="page-header page-header--has-image">
        <p class="page-header__pretitle">
            <a href="<?php echo get_permalink( $the_location->ID ); ?>"><?php echo get_the_title( $the_location->ID ); ?></a>
        </p>
        <h1 class="page-header__title"><?php the_title(); ?></h1>
        <?php if ( $post->post_excerpt != '' ) : ?>
            <p class="page-header__desc"><?php echo $post->post_excerpt; ?></p>
        <?php endif; ?>
        <figure class="page-header__image">
            <?php the_post_thumbnail( 'large' ); ?>
        </figure>
    </header>

    <div class="page-content">

        <main style="position: relative;">
            <article <?php post_class( 'single-location-page blockcontent' ); ?>>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        </main>


        <?php /*
        <div class="site-main__content">

            <main class="site-main__content__main">
                <article <?php post_class( 'single-location_page' ); ?>>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
            </main>

            <aside class="site-main__content__aside">

                <?php $location_pages = ghc_get_location_pages( $the_location->ID ); ?>
                <?php if ( $location_pages ) : ?>
                    <nav class="list-nav off-stage enter-stage">
                        <h2><a href="<?php echo get_permalink( $the_location->ID ); ?>" title="<?php _e( 'Gym Overview', 'ghc' ); ?>"><?php echo get_the_title( $the_location->ID ); ?></a></h2>
                        <ul>
                            <li><a href="<?php echo get_permalink( $the_location->ID ); ?>" title="<?php _e( 'Gym Overview', 'ghc' ); ?>"><?php _e( 'Gym Overview', 'ghc' ); ?></a></li>
                            <?php foreach ( $location_pages as $location_page ) : ?>
                                <li<?php echo ( $location_page->ID == get_the_ID() ) ? ' class="current-menu-item" ' : ''; ?>><a href="<?php echo get_permalink( $location_page->ID ); ?>" title="<?php echo esc_attr( get_the_title( $location_page->ID ) ); ?>"><?php echo get_the_title( $location_page->ID ); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
                <!--
                <div class="single-location__info__meta off-stage enter-stage">
                    <?php ghc_location_contact_list( $the_location->ID ); ?>

                    <h3>Gym Hours</h3>
                    <ul class="list-hours">
                        <li><label>Sun</label> <span>Opens at 7 am</span></li>
                        <li class="is-active"><label>Mon - Thurs</label> <span>Open 24 hours</span></li>
                        <li><label>Fri</label> <span>Open until 9 pm</span></li>
                        <li><label>Sat</label> <span>7 am - 9 pm</span></li>
                    </ul>
                    <h3>Kid's Club Hours</h3>
                    <ul class="list-hours">
                        <li><label>Sun</label> <span>Opens at 7 am</span></li>
                        <li class="is-active"><label>Mon - Thurs</label> <span>Open 24 hours</span></li>
                        <li><label>Fri</label> <span>Open until 9 pm</span></li>
                        <li><label>Sat</label> <span>7 am - 9 pm</span></li>
                    </ul>
                </div>
                -->

            </aside>

            <?php $location_pages = ghc_get_location_pages( $the_location->ID ); ?>
            <?php if ( $location_pages ) : ?>
                <nav class="single-location__nav off-stage enter-stage">
                    <h3><?php  echo get_the_title( $the_location->ID ) . ' ' . __( 'Programming', 'ghc' ); ?></h3>

                    <ul>
                        <?php foreach ( $location_pages as $location_page ) : ?>
                            <li><a href="<?php echo get_permalink( $location_page->ID ); ?>" title="<?php echo esc_attr( get_the_title( $location_page->ID ) ); ?>"><?php echo get_the_title( $location_page->ID ); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            <?php endif; ?>

        </div>
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
