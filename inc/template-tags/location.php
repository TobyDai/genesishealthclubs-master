<?php

if ( ! function_exists( 'ghc_the_location_nav' ) ) {
    function ghc_the_location_nav( $location_id ) {
        $location_pages = ghc_get_location_pages( $location_id );
        if ( $location_pages ) : ?>
            <nav class="page-nav">
                <div class="container">
                    <a href="<?php echo get_permalink( $location_id ); ?>"><?php echo get_the_title( $location_id ); ?> </a>
                    <?php foreach ( $location_pages as $location_page ) : ?>
                        <a href="<?php echo get_permalink( $location_page->ID ); ?>" title="<?php echo esc_attr( get_the_title( $location_page->ID ) ); ?>"><?php echo get_the_title( $location_page->ID ); ?></a>
                    <?php endforeach; ?>
                </div>
            </nav>
        <?php endif;
    }
}
