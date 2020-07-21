<?php


if ( ! function_exists( 'ghc_the_slide_item' ) ) {
    function ghc_the_slide_item( $slide_id ) {
        if ( $slide_id ) : ?>
            <div class="slider__item">
                <a href="<?php ghc_get_slide_url( $slide_id ); ?>">
                    <picture>
                        <source srcset="<?php echo ghc_get_slide_image_url_wide( $slide_id ); ?>" media="(min-width: 48em)">
                        <img src="<?php echo ghc_get_slide_image_url_narrow( $slide_id ); ?>">
                    </picture>
                    <div class="slider__item__text">
                        <h3><?php echo ghc_get_slide_headline( $slide_id ); ?></h3>
                        <p><?php echo ghc_get_slide_subtitle( $slide_id ); ?></p>
                    </div>
                </a>
            </div>
        <?php endif;
    }
}
