<?php
/*
 * Genesis Health ClubsCustom Post Type Foundation
 */
class GHCPostType {

    public function format_bool( $string ) {
        $bool = false;
        if ( $string == 'true' || $string == true || $string == '1' || $string == 1 ) {
            $bool = true;
        }
        return $bool;
    }

    public function get_array_value( $key, $array, $format_bool = true ) {
        if ( is_array( $array ) && array_key_exists( $key, $array ) ) {
            $value = $array[ $key ];
            if ( $value == 'true' || $value == 'false' ) {
                $value = $this->format_bool( $value );
            }
            return $value;
        }
        return '';
    }

    public function get_field_key($slug, $field) {
        $field_key = $field['key_override'] ? $field['key_override'] : $this->slug . '_' . $field['name'];
        return esc_attr( $field_key );
    }

    public function get_formatted_telephone( $value ) {

    }

    public function value_format_time( $value ) {
        return date('H:i', strtotime( $value ) );
    }

    public function value_format_date( $value ) {
        return date('Y-m-d', strtotime( $value ) );
    }

    public function format_hours( $string ) {
        if ( preg_match( '/:30/', $string ) ) {
            $string = date('g:i a', strtotime( $string ) );
        }
        else {
            $string = date('g a', strtotime( $string ) );
        }
        return $string;
    }

    public function admin_remove_date_filter() {
        global $typenow;
        if ( $typenow == $this->slug ) {
            add_filter('months_dropdown_results', '__return_empty_array');
        }
    }

    function enqueue_base_scripts() {
        wp_enqueue_style( 'jquery-ui-datepicker' );
    }

	public function init_metabox() {

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes'  )        );
		add_action( 'save_post',      array( $this, 'save_meta_boxes' ), 10, 2 );



	}

	public function add_meta_boxes() {

        $meta_boxes = $this->meta_boxes;
        $slug = $this->slug;

        foreach ( $meta_boxes as $meta_box ) {

            /*
             * https://developer.wordpress.org/reference/functions/add_meta_box/
             */
            $callback_args = array(
                'context'   => $meta_box['context'],
                'fields'    => $meta_box['fields'],
                //'__back_compat_meta_box'    => true
            );
            add_meta_box(
                $slug . '_' . $meta_box['slug'],    // $id
                __( $meta_box['name'], 'ghc' ), // $title
                array( $this, 'render_meta_box' ),  // $callback
                $slug,                              // $screen
                $meta_box['context'],               // $context
                $meta_box['priority'],              // $priority
                $callback_args                      // $callback_args
            );
        }

    }

    public function render_meta_box( $post, $callback_args ) {

        /*
         * Add nonce for security and authentication.
         * Validated in save_meta_boxes
         */
        wp_nonce_field( $callback_args['id'] . '_nonce_action', $callback_args['id'] . '_nonce' );

        $args = $callback_args['args'];

        $fields = $args['fields'];

        $days = array(
          'mon'	=> 'Monday',
          'tue'	=> 'Tuesday',
          'wed'	=> 'Wednesday',
          'thu'	=> 'Thursday',
          'fri'	=> 'Friday',
          'sat'	=> 'Saturday',
          'sun'	=> 'Sunday'
        );

        ?>

        <?php if ( $args['context'] == 'normal' ) : ?>
            <div class="ghc-controls">
        <?php endif; ?>
            <?php foreach ( $fields as $field ) : ?>
                <?php $field_key = $this->get_field_key($this->slug, $field); ?>
                <?php $field_value = get_post_meta($post->ID, $field_key, true ); ?>
                <?php if ( $args['context'] == 'normal' ) : ?>
                    <div class="ghc-control ghc-control--<?php echo $field['width']; ?> ghc-control--<?php echo $field['type']; ?>">
                        <?php if ( $field['label'] && $field['type'] != 'boolean' && $field['type'] != 'multiselect-posts' ) : ?>
                            <label for="<?php echo $field_key; ?>"><?php echo $field['label']; ?></label>
                        <?php endif; ?>
                <?php else : ?>
                    <?php if ( $field['label'] ) : ?>
                        <p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="<?php echo $field_key; ?>"><?php echo $field['label']; ?></label></p>
                    <?php endif; ?>
                <?php endif; ?>
                    <?php if ( $field['type'] == 'image' ) : ?>
                        <?php
                        $upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );
                        $current_id = $field_value;
                        $current_src = wp_get_attachment_image_src( $current_id, 'full' );

                        // For convenience, see if the array is valid
                        $current_image = is_array( $current_src );
                        ?>

                        <div class="custom-image-controls">
                            <!-- Your image container, which can be manipulated with js -->
                            <div class="custom-img-container">
                                <?php if ( $current_image ) : ?>
                                    <img src="<?php echo $current_src[0] ?>" alt="" style="max-width:100%;" />
                                <?php endif; ?>
                            </div>

                            <!-- Your add & remove image links -->
                            <p class="hide-if-no-js">
                                <a class="upload-custom-img <?php if ( $current_image  ) { echo 'hidden'; } ?>"
                                   href="<?php echo $upload_link ?>">
                                    <?php _e('Set wide image') ?>
                                </a>
                                <a class="delete-custom-img <?php if ( ! $current_image  ) { echo 'hidden'; } ?>"
                                  href="#">
                                    <?php _e('Remove this image') ?>
                                </a>
                            </p>

                            <!-- A hidden input to set and post the chosen image id -->
                            <input class="custom-img-id" name="<?php echo $field['name']; ?>" type="hidden" value="<?php echo esc_attr( $current_id ); ?>" />
                        </div>
                    <?php elseif ( $field['type'] == 'page' ) : ?>
                        <?php
                            wp_dropdown_pages(array(
                                'selected'          => $field_value,
                                'show_option_none'  => '...',
                                'option_none_value' => '',
                                'name'              => $field['name']
                            ));
                        ?>
                    <?php elseif ( $field['type'] == 'post_select' ) : ?>
                        <?php $this->display_post_type_select( $field, $post->ID ); ?>

                    <?php elseif ( $field['type'] == 'sortable' ) : ?>
                        <?php
                        $all_items = array();
                        if ( isset( $field['post_type'] ) ) {
                            $query_args = array(
                                'post_type'         => $field['post_type'],
                                'posts_per_page'    => '-1',
                            );
                            if ( isset( $field['meta'] ) ) {
                                $query_args['meta_query'] = array();
                                foreach ( $field['meta'] as $meta ) {
                                    $meta_value = $meta['value'] == 'post_id' ? $post->ID : $meta['value'];
                                    $meta_compare = isset( $meta['compare'] ) ? $meta['compare'] : '=';
                                    $query_args['meta_query'][] = array(
                                        'key'   => $meta['key'],
                                        'value' => $meta_value,
                                        'compare'   => $meta_compare
                                    );
                                }
                            }
                            $all_items = get_posts($query_args);
                        }
                        $current_items = is_array( $field_value ) ? $field_value : array();
                        ?>
                        <ul class="sortable-list">
                            <?php foreach ( $current_items as $current_item ) : ?>
                                <li>
                                    <?php echo get_the_title( $current_item ); ?>
                                    <input type="hidden" name="<?php echo esc_attr( $field['name'] ); ?>[]" value="<?php echo $current_item; ?>">
                                </li>
                            <?php endforeach; ?>
                            <?php foreach ( $all_items as $item ) : ?>
                                <?php if ( ! in_array( $item->ID, $current_items ) ) : ?>
                                    <li>
                                        <?php echo $item->post_title; ?>
                                        <input type="hidden" name="<?php echo esc_attr( $field['name'] ); ?>[]" value="<?php echo $item->ID; ?>">
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php elseif ( $field['type'] == 'multiselect-posts' ) : ?>
                        <?php
                        $all_items = array();
                        if ( isset( $field['post_type'] ) ) {
                            $query_args = array(
                                'post_type'         => $field['post_type'],
                                'posts_per_page'    => '-1',
                                'orderby'           => 'post_title',
                                'order'             => 'ASC'
                            );
                            if ( isset( $field['meta'] ) ) {
                                $query_args['meta_query'] = array();
                                foreach ( $field['meta'] as $meta ) {
                                    $meta_value = $meta['value'] == 'post_id' ? $post->ID : $meta['value'];
                                    $meta_compare = isset( $meta['compare'] ) ? $meta['compare'] : '=';
                                    $query_args['meta_query'][] = array(
                                        'key'   => $meta['key'],
                                        'value' => $meta_value,
                                        'compare'   => $meta_compare
                                    );
                                }
                            }
                            $all_items = get_posts($query_args);
                        }
                        //$current_items = is_array( $field_value ) ? $field_value : array();
                        ?>
                        <span class="label label--with-options">
                            <?php echo $field['label']; ?>
                            <a href="#!" data-check-all="<?php echo $field['name']; ?>">Check All</a>
                            <a href="#!" data-uncheck-all="<?php echo $field['name']; ?>">Uncheck All</a>
                        </span>
                        <div>
                            <?php foreach ( $all_items as $item ) : ?>
                                <?php $item_value = get_post_meta( $post->ID, $field_key . '_' . $item->ID, true); ?>
                                <label>
                                    <input data-name="<?php echo $field['name']; ?>" type="checkbox" name="<?php echo $field['name'] . '_' . $item->ID; ?>" value="1" <?php echo (  $item_value == 1 ? ' checked ' : '' ); ?>>
                                    <span><?php echo $item->post_title; ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php elseif ( $field['type'] == 'radio' ) : ?>
                        <?php foreach ( $field['choices'] as $key => $value ) : ?>
                            <label style="display: block; margin-bottom: 0.25em;">
                                <input name="<?php echo $field['name']; ?>" type="radio" value="<?php echo $key ; ?>"<?php if ( $field_value === $key ) echo ' checked'; ?>><?php echo $value; ?>
                            </label>
                        <?php endforeach; ?>
                    <?php elseif ( $field['type'] == 'select' ) : ?>
                        <select name="<?php echo $field['name']; ?>">
                            <?php foreach ( $field['choices'] as $key => $value ) : ?>
                                <option value="<?php echo $key ; ?>"<?php if ( $field_value === $key ) echo ' selected'; ?>><?php echo $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php elseif ( $field['type'] == 'boolean' ) : ?>
                        <label class="ghc-inline-label">
                            <input id="<?php echo $field_key; ?>" name="<?php echo $field['name']; ?>" type="checkbox" value="1"<?php if ( $field_value === '1' ) echo ' checked'; ?>>
                            <?php echo $field['label']; ?>
                        </label>
                    <?php elseif ( $field['type'] == 'textarea' ) : ?>
                        <textarea id="<?php echo $field_key; ?>" type="<?php echo $field['type']; ?>" name="<?php echo $field['name']; ?>" <?php
                            echo ( isset( $field['maxlength'] ) && $field['maxlength'] != '' ) ? ' maxlength="' . $field['maxlength'] . '" ' : '';
                        ?>><?php echo $field_value != '' ? $field_value : ''; ?></textarea>
                    <?php elseif ( $field['type'] == 'wysiwyg' ) : ?>
                        <?php
                        wp_editor(
                            $field_value,
                            $field['name'],
                            array(
                                'media_buttons' => false,
                                'textarea_rows' => 10,
                                'quicktags'     => false,
                                'teeny'         => true,
                                'tinymce'       => array(
                                    'toolbar1'  => 'bold,italic,link,undo,redo'
                                )
                            )
                        );
                        ?>
                    <?php elseif ( $field['type'] == 'gravityform' ) : ?>
                        <?php if ( class_exists( 'RGFormsModel' ) ) : ?>
                            <select id="<?php echo $field_key; ?>" name="<?php echo $field['name']; ?>">
                                <option value="">...</option>
                                <?php $forms = RGFormsModel::get_forms( null, 'title' ); ?>
                                <?php foreach( $forms as $form ) : ?>
                                    <option value="<?php echo $form->id; ?>"<?php
                                        if ( $form->id == $field_value )  {
                                            echo ' selected';
                                        }
                                    ?>><?php echo $form->title; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    <?php elseif ( $field['type'] == 'hours' ) : ?>
                        <?php var_dump($field_value); ?>
                        <div id="ghc-hour-groups" class="ghc-hour-groups">
                            <?php if ( is_array( $field_value ) ) : $n = 0; ?>
                                <?php foreach ( $field_value as $hour_set ) : ?>
                                    <?php $this->display_hour_set( $field['name'], $hour_set, $n ); ?>

                                <?php $n += 1; endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <button class="ghc-hour-group-add button" type="button">Add Hour Set</button>
                        <?php
                            ob_start();
                            $field_prefix = $field['name'];
                            $this->display_hour_set( $field['name'] );
                            $output = preg_replace( '/\'/', "\'", ob_get_clean() );
                        ?>
                        <script>
                            jQuery(document).ready(function(){
                                jQuery( '.ghc-hour-group-add' ).on( 'click', function () {

                                    var current_hour_count = jQuery( '.ghc-hour-group' ).length,
                                    template = '<?php echo preg_replace( "/[\n\r]/","", $output ); ?>';

                                    template = template.replace( /\[\]/g, '[' + current_hour_count + ']');

                                    jQuery( '#ghc-hour-groups' ).append(

                                        jQuery( template )
                                    );
                                });

                                jQuery( '#ghc-hour-groups' ).on( 'click', '.ghc-hour-group-remove', function () {
                                    jQuery( this ).closest( '.ghc-hour-group' ).remove();
                                });

                                jQuery( '#ghc-hour-groups' ).on( 'change', '.ghc-hour-split', function () {
                                    if ( jQuery( this ).is(':checked') ) {
                                        jQuery( this ).closest( '.ghc-hour-controls' ).find( '.ghc-hour-controls__secondary' ).show();
                                    }
                                    else {
                                        jQuery( this ).closest( '.ghc-hour-controls' ).find( '.ghc-hour-controls__secondary' ).hide();
                                    }
                                })
                            });
                        </script>
                    <?php else : ?>
                        <input id="<?php echo $field_key; ?>" type="<?php echo $field['type']; ?>" name="<?php echo $field['name']; ?>" value="<?php
                            echo $field_value != '' ? $field_value : '';
                        ?>"<?php
                            echo ( isset( $field['maxlength'] ) && $field['maxlength'] != '' ) ? ' maxlength="' . $field['maxlength'] . '" ' : '';
                        ?><?php
                            //echo ( $field['type'] == 'date' ) ? ' class="date-picker hasDatepicker" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" ' : '';
                        ?>>
                    <?php endif; ?>
                    <?php if ( isset( $field['hint'] ) && $field['hint'] != '' ) : ?>
                        <p class="howto"><?php echo $field['hint']; ?></p>
                    <?php endif; ?>
                <?php if ( $args['context'] == 'normal' ) : ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php if ( $args['context'] == 'normal' ) : ?>
            </div>
        <?php endif; ?>


        <?php
    }

    public function save_meta_boxes( $post_id, $post ) {

        // Check if the user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return;

        // Check if it's not an autosave.
        if ( wp_is_post_autosave( $post_id ) )
            return;

        // Check if it's not a revision.
        if ( wp_is_post_revision( $post_id ) )
            return;

        $meta_boxes = $this->meta_boxes;

        foreach ( $meta_boxes as $meta_box ) {

            // Add nonce for security and authentication.
            $nonce_name   = $_POST[ $this->slug . '_' . $meta_box['slug'] . '_nonce'];
            $nonce_action = $this->slug . '_' . $meta_box['slug'] . '_nonce_action';

            // Check if a nonce is set.
            if ( ! isset( $nonce_name ) )
                continue;

            // Check if a nonce is valid.
            if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
                continue;

            foreach ( $meta_box['fields'] as $field ) {

                $field_key = $this->get_field_key($this->slug, $field);

                if ( $field['type'] === 'multiselect-posts') {
                    foreach ( $_POST as $key => $value ) {
                        if ( preg_match( '/^' . $field['name'] . '_/', $key ) ) {
                            $multiselect_value = $_POST[ $key ] || 0;
                            update_post_meta( $post_id, $this->slug . '_' . $key, $multiselect_value );
                        }
                    }
                }
                else if ( isset( $_POST[ $field['name'] ] ) && $_POST[ $field['name'] ] != '' ) {
                    if ( $field['type'] == 'date' ) {
                        update_post_meta($post_id, $field_key, date('Y-m-d', strtotime($_POST[ $field['name'] ] )));
                        update_post_meta($post_id, $field_key . '_sort', date('U', strtotime($_POST[ $field['name'] ] )));
                        continue;
                    }
                    update_post_meta($post_id, $field_key, $_POST[ $field['name'] ] );
                }
                else {
                    // clear if not set
                    update_post_meta($post_id, $field_key, '' );
                }

            }
        }
    }

    public function display_weekday_select( $field, $post_id ) {

        $field_key = $this->get_field_key($this->slug, $field);
        $field_value = get_post_meta($post_id, $field_key, true );
        ?>
        <select id="<?php echo $field_key; ?>" name="<?php echo esc_attr( $field['name'] ); ?><?php echo ( $field['multiple'] ? '[]' : '' ); ?>"<?php echo ( $field['multiple'] ? ' multiple ' : '' ); ?>>
            <option value="">...</option>
            <?php for ( $i = 1; $i < 8; $i++ ) : ?>

                <option value="<?php echo $i; ?>"<?php
                    if ( $field['multiple'] && is_array( $field_value ) && in_array( $i, $field_value ) ) {
                        echo ' selected ';
                    }
                    else if ( $field_value == $i ) {
                        echo ' selected ';
                    }
                ?>><?php echo date('D', strtotime("Sunday +{$i} days")); ?></option>
            <?php endfor; ?>
        </select>
        <?php
    }

    public function display_taxonomy_select( $field, $post_id ) {

        $field_key = $this->get_field_key($this->slug, $field);
        $field_value = get_post_meta($post_id, $field_key, true );;

        $choices = get_terms(array(
            'taxonomy'       => $field['taxonomy'],
            'hide_empty'    => false,
        ));
        ?>
        <select id="<?php echo $field_key; ?>" name="<?php echo esc_attr( $field['name'] ); ?><?php echo ( $field['multiple'] ? '[]' : '' ); ?>"<?php echo ( $field['multiple'] ? ' multiple ' : '' ); ?>>
            <option value="">...</option>
            <?php foreach ( $choices as $choice ) : ?>
                <option value="<?php echo $choice->term_id; ?>"<?php
                    if ( $field['multiple'] && is_array( $field_value ) && in_array( $choice->term_id, $field_value ) ) {
                        echo ' selected ';
                    }
                    else if ( $field_value == $choice->term_id ) {
                        echo ' selected ';
                    }
                ?>><?php echo $choice->name ?></option>
            <?php endforeach; ?>
        </select>
        <?php
    }

    public function display_post_type_select( $field, $post_id ) {

        $field_key = $this->get_field_key($this->slug, $field);
        $field_value = get_post_meta($post_id, $field_key, true );

        $choices = get_posts(array(
            'post_type'         => $field['post_type'],
            'order'             => 'ASC',
            'orderby'           => 'title',
            'posts_per_page'    => '-1'
        ));
        ?>
        <select id="<?php echo $field_key; ?>" name="<?php echo esc_attr( $field['name'] ); ?><?php echo ( $field['multiple'] ? '[]' : '' ); ?>"<?php echo ( $field['multiple'] ? ' multiple ' : '' ); ?>>
            <option value="">...</option>
            <?php foreach ( $choices as $choice ) : ?>
                <option value="<?php echo $choice->ID; ?>"<?php
                    if ( $field['multiple'] && is_array( $field_value ) && in_array( $choice->ID, $field_value ) ) {
                        echo ' selected ';
                    }
                    else if ( $field_value == $choice->ID ) {
                        echo ' selected ';
                    }
                ?>><?php echo get_the_title($choice->ID); ?></option>
            <?php endforeach; ?>
        </select>
        <?php
    }

    /*
    public function display_hour_set( $name, $hour_set = array(), $n = '' ) {
        $days = array(
          'mon'	=> 'Monday',
          'tue'	=> 'Tuesday',
          'wed'	=> 'Wednesday',
          'thu'	=> 'Thursday',
          'fri'	=> 'Friday',
          'sat'	=> 'Saturday',
          'sun'	=> 'Sunday'
        );
        ?>
        <div class="ghc-hour-group">
            <div class="ghc-control">
                <input name="<?php echo $name . '[' . $n . '][title][label]'; ?>" value="<?php echo esc_attr( $this->get_array_value( 'label', $hour_set['title'] ) ); ?>" placeholder="Hour set title">
                <!--<label style="margin-left: 1em;">
                    Hide Title
                    <input type="checkbox" name="<?php echo $name; ?>[<?php echo $n; ?>][title][hide]" value="true" <?php
                        if ( is_array( $hour_set['title'] ) && array_key_exists( 'hide', $hour_set['title'] ) && $hour_set['title']['hide'] == 'true' ) {
                            echo ' checked="checked"';
                        }
                    ?>>
                </label>-->
            </div>
            <?php foreach ( $days as $key => $value ) : ?>
                <?php $field_name = $name . '[' . $n . '][' . $key . ']'; ?>
                <?php $is_split = $this->get_array_value( 'split', $hour_set[ $key ] ); ?>
                <div class="ghc-hour-control">
                    <label for="<?php echo $field_name; ?>"><?php _e( $value, 'ghc' ); ?></label>
                    <div class="ghc-hour-controls">
                        <div class="ghc-hour-controls__primary">
                            <div class="ghc-hour-controls__hour">
                                <label><?php _e( 'Open', 'ghc' ); ?></label>
                                <select name="<?php echo $field_name; ?>[open]">
                                    <option value=""></option>
                                    <?php for ( $i=0; $i < 24; $i++ ) : ?>
                                        <?php $hour_string = date( 'H:i', strtotime( "$i:00" ) ); ?>
                                        <?php $half_string  = date( 'H:i', strtotime( "$i:30" ) ) ; ?>
                                        <option value="<?php echo $hour_string; ?>" <?php echo ( $hour_set[ $key ]['open'] == $hour_string ? ' selected ' : '' ); ?>><?php echo date( 'h:i A', strtotime( "$i:00" ) ); ?></option>
                                        <option value="<?php echo $half_string; ?>" <?php echo ( $hour_set[ $key ]['open'] == $half_string ? ' selected ' : '' ); ?>><?php echo date( 'h:i A', strtotime( "$i:30" ) ); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="ghc-hour-controls__hour">
                                <label><?php _e( 'Close', 'ghc' ); ?></label>
                                <select name="<?php echo $field_name; ?>[close]">
                                    <option value=""></option>
                                    <?php for ( $i=0; $i < 24; $i++ ) : ?>
                                        <?php $hour_string = date( 'H:i', strtotime( "$i:00" ) ); ?>
                                        <?php $half_string  = date( 'H:i', strtotime( "$i:30" ) ) ; ?>
                                        <option value="<?php echo $hour_string; ?>" <?php echo ( $hour_set[ $key ]['close'] == $hour_string ? ' selected ' : '' ); ?>><?php echo date( 'h:i A', strtotime( "$i:00" ) ); ?></option>
                                        <option value="<?php echo $half_string; ?>" <?php echo ( $hour_set[ $key ]['close'] == $half_string ? ' selected ' : '' ); ?>><?php echo date( 'h:i A', strtotime( "$i:30" ) ); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="ghc-hour-controls__alternate">
                                <label>
                                    <input class="ghc-hour-split" type="checkbox" name="<?php echo $field_name; ?>[split]" value="true" <?php echo ( $is_split ? ' checked ' : '' ); ?>>
                                    <?php _e( 'Split', 'ghc' ); ?>
                                </label>
                                <!--<label>
                                    <input type="checkbox" name="<?php echo $field_name; ?>[alternating]" value="true" <?php echo ( $this->get_array_value( 'alternating', $hour_set[ $key ] ) == 'true' ? ' checked ' : '' ); ?>>
                                    <?php _e( 'Alternating', 'ghc' ); ?>
                                </label>-->

                            </div>
                        </div>
                        <div class="ghc-hour-controls__secondary"<?php echo ( ! $is_split ? ' style="display: none;" ' : '' ); ?>>
                            <div class="ghc-hour-controls__hour">
                                <label><?php _e( 'Open', 'ghc' ); ?></label>
                                <select name="<?php echo $field_name; ?>[open_split]">
                                    <option value=""></option>
                                    <?php for ( $i=0; $i < 24; $i++ ) : ?>
                                        <?php $hour_string = date( 'H:i', strtotime( "$i:00" ) ); ?>
                                        <?php $half_string  = date( 'H:i', strtotime( "$i:30" ) ) ; ?>
                                        <option value="<?php echo $hour_string; ?>" <?php echo ( $hour_set[ $key ]['open_split'] == $hour_string ? ' selected ' : '' ); ?>><?php echo date( 'h:i A', strtotime( "$i:00" ) ); ?></option>
                                        <option value="<?php echo $half_string; ?>" <?php echo ( $hour_set[ $key ]['open_split'] == $half_string ? ' selected ' : '' ); ?>><?php echo date( 'h:i A', strtotime( "$i:30" ) ); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="ghc-hour-controls__hour">
                                <label><?php _e( 'Close', 'ghc' ); ?></label>
                                <select name="<?php echo $field_name; ?>[close_split]">
                                    <option value=""></option>
                                    <?php for ( $i=0; $i < 24; $i++ ) : ?>
                                        <?php $hour_string = date( 'H:i', strtotime( "$i:00" ) ); ?>
                                        <?php $half_string  = date( 'H:i', strtotime( "$i:30" ) ) ; ?>
                                        <option value="<?php echo $hour_string; ?>" <?php echo ( $hour_set[ $key ]['close_split'] == $hour_string ? ' selected ' : '' ); ?>><?php echo date( 'h:i A', strtotime( "$i:00" ) ); ?></option>
                                        <option value="<?php echo $half_string; ?>" <?php echo ( $hour_set[ $key ]['close_split'] == $half_string ? ' selected ' : '' ); ?>><?php echo date( 'h:i A', strtotime( "$i:30" ) ); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <button class="ghc-hour-group-remove button" type="button">Remove Hour Set</button>
        </div>
        <?php
    }

    */


}

new GHCPostType;
