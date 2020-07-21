<?php


if ( ! function_exists( 'ghc_the_location_banner' ) ) {
    function ghc_the_location_banner( $location_id ) {
        $banner = ghc_get_banners_by_location( get_the_ID() ); $banner = $banner[0];
        if ( $banner ) : ?>
            <aside class="page-banner">
                <picture>
                    <source srcset="<?php echo ghc_get_banner_image_url_wide( $banner->ID ); ?>" media="(min-width: 48em)">
                    <img src="<?php echo ghc_get_banner_image_url_narrow( $banner->ID ); ?>">
                </picture>
                <div class="page-banner__text">
                    <h3><?php echo ghc_get_banner_headline( $banner->ID ); ?></h3>
                    <p><?php echo ghc_get_banner_subtitle( $banner->ID ); ?></p>
                </div>
            </aside>
        <?php endif;
    }
}
