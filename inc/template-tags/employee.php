<?php

if ( ! function_exists( 'ghc_the_employee_list_item' ) ) {
    function ghc_the_employee_list_item( $employee_id ) {
        if ( $employee_id ) : ?>
            <div class="employee-list__item">
                <a href="<?php echo get_permalink( $employee_id ); ?>" title="<?php echo esc_attr( ghc_get_employee_name( $employee_id ) ); ?>">
                    <?php echo get_the_post_thumbnail( $employee_id, 'medium' ); ?>
                    <h3><?php echo ghc_get_employee_name( $employee_id ); ?></h3>
                    <p><?php echo ghc_get_employee_job_title( $employee_id ); ?></p>
                </a>
            </div>
        <?php endif;
    }
}
