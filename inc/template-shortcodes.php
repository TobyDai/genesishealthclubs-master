<?php


if ( ! function_exists( 'ghc_shortcode_details' ) ) {
    function ghc_shortcode_details( $atts, $content = '' ) {
        $atts = shortcode_atts( array(
            'summary' => '',
        ), $atts, 'details' );
        ob_start();
        ?>
        <details>
            <summary><?php echo $atts['summary']; ?></summary>
            <?php echo apply_filters( 'the_content', $content ); ?>
        </details>
        <?php
        return ob_get_clean();
    }
}
add_shortcode( 'details', 'ghc_shortcode_details' );
