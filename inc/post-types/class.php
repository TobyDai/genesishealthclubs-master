<?php

/*
 * Class Post Type, Corresponding Taxonomies and Meta
 */
class GHCPostTypeClass extends GHCPostType {

    /*
     * Slug: cannot be changed once posts have been created
     * Sets: the post type key and the taxonomy and post meta namespace
     */
    public $slug = 'ghc_class';

    public $meta_boxes = array(
        array(
            'slug'      => 'content',
            'name'      => 'Content',
            'context'   => 'normal',
            'priority'  => 'high',
            'fields'    => array(
                array(
                    'name'  => 'short_description',
                    'label' => 'Short Description',
                    'type'  => 'wysiwyg',
                    'width' => 100,
                ),
                array(
                    'name'  => 'video',
                    'label' => 'Video',
                    'type'  => 'url',
                    'width' => 100,
                )
            )
        ),
        array(
            'slug'      => 'display',
            'name'      => 'Display Settings',
            'context'   => 'side',
            'priority'  => 'default',
            'fields'    => array(
                array(
                    'name'  => 'is_featured_on_archive',
                    'label' => 'Feature on Archive Page',
                    'type'  => 'boolean',
                ),
            )
        )
    );

	public function __construct() {

        add_action( 'init', array( $this, 'register_post_type'), 0 );
        add_action( 'init', array( $this, 'register_taxonomies' ), 0 );

		if ( is_admin() ) {
            //add_action( 'admin_init', array($this, 'add_capabilities') );

            // Metaboxes
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );

            add_action( 'load-post.php', array( $this, 'init_class_instance_meta_box' ) );
            add_action( 'load-post-new.php', array( $this, 'init_class_instance_meta_box' ) );

            add_action( 'admin_menu', array( $this, 'modify_admin' ) );

		}
        else {
            add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
        }

    }

    public function pre_get_posts( $query ) {
        if ( $query->is_main_query() && is_post_type_archive( $this->slug ) ) {
            $query->set( 'posts_per_page', '-1' );
            $query->set( 'meta_query', array(
                array(
                    'key'       => 'ghc_class_is_featured_on_archive',
                    'value'     => '1',
                    'compare'   => '='
                )
            ) );
        }
        return $query;
    }

    public function modify_admin() {
        remove_meta_box( 'tagsdiv-ghc_class_studio', $this->slug, 'side' );
    }

    public function register_post_type() {

        /*
         * https://codex.wordpress.org/Function_Reference/register_post_type
        **/
        register_post_type(
            $this->slug,
            array(
                'label'                 => __( 'Class', 'ghc' ),
                'description'           => __( 'Class Description', 'ghc' ),
                'supports'              => array( 'title', 'thumbnail' ),
                'taxonomies'            => array(),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 5,
                'menu_icon'             => 'dashicons-universal-access-alt',
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'show_in_rest'          => true, /* true: enables the gutenburg block editor */
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'page',
                'rewrite'               => array(
                    'slug'              => 'classes',
                    'with_front'        => false
                ), /* https://codex.wordpress.org/Function_Reference/register_post_type#rewrite */
                'labels'                => array(
                    'name'                  => _x( 'Classes', 'Class General Name', 'ghc' ),
                    'singular_name'         => _x( 'Class', 'Class Singular Name', 'ghc' ),
                    'menu_name'             => __( 'Classes', 'ghc' ),
                    'name_admin_bar'        => __( 'Class', 'ghc' ),
                    'archives'              => __( 'Class Archives', 'ghc' ),
                    'attributes'            => __( 'Class Attributes', 'ghc' ),
                    'parent_item_colon'     => __( 'Parent Class:', 'ghc' ),
                    'all_items'             => __( 'All Classes', 'ghc' ),
                    'add_new_item'          => __( 'Add New Class', 'ghc' ),
                    'add_new'               => __( 'Add New', 'ghc' ),
                    'new_item'              => __( 'New Class', 'ghc' ),
                    'edit_item'             => __( 'Edit Class', 'ghc' ),
                    'update_item'           => __( 'Update Class', 'ghc' ),
                    'view_item'             => __( 'View Class', 'ghc' ),
                    'view_items'            => __( 'View Classes', 'ghc' ),
                    'search_items'          => __( 'Search Class', 'ghc' ),
                    'not_found'             => __( 'Not found', 'ghc' ),
                    'not_found_in_trash'    => __( 'Not found in Trash', 'ghc' ),
                    'featured_image'        => __( 'Featured Image', 'ghc' ),
                    'set_featured_image'    => __( 'Set featured image', 'ghc' ),
                    'remove_featured_image' => __( 'Remove featured image', 'ghc' ),
                    'use_featured_image'    => __( 'Use as featured image', 'ghc' ),
                    'insert_into_item'      => __( 'Insert into class', 'ghc' ),
                    'uploaded_to_this_item' => __( 'Uploaded to this class', 'ghc' ),
                    'items_list'            => __( 'Classes list', 'ghc' ),
                    'items_list_navigation' => __( 'Classes list navigation', 'ghc' ),
                    'filter_items_list'     => __( 'Filter classes list', 'ghc' ),
                ),
            )
        );

        /*
         * https://codex.wordpress.org/Function_Reference/register_post_type
        **/
        register_post_type(
            $this->slug . '_instance',
            array(
                'taxonomies'            => array(),
                'hierarchical'          => false,
                'public'                => false,
                'show_ui'               => false,
                'show_in_menu'          => false,
                'show_in_admin_bar'     => false,
                'show_in_nav_menus'     => false,
                'can_export'            => true,
                'show_in_rest'          => true, /* true: enables the gutenburg block editor */
                'has_archive'           => false,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'page',
                'labels'                => array(
                    'name'                  => _x( 'Class Instances', 'General Name', 'ghc' ),
                ),
            )
        );

    }

    public function register_taxonomies() {

        /*
         * https://codex.wordpress.org/Function_Reference/register_taxonomy
         */
        register_taxonomy(
             $this->slug . '_studio',
             array( $this->slug ),
             array(
                 'hierarchical'               => false,
                 'public'                     => false,
                 'show_ui'                    => true,
                 'show_admin_column'          => false,
                 'show_in_nav_menus'          => false,
                 'show_tagcloud'              => false,
                 'labels'                     => array(
                     'name'                       => _x( 'Studios', 'Category General Name', 'ghc' ),
                     'singular_name'              => _x( 'Studio', 'Studio Singular Name', 'ghc' ),
                     'menu_name'                  => __( 'Studios', 'ghc' ),
                     'all_items'                  => __( 'All Items', 'ghc' ),
                     'parent_item'                => __( 'Parent Item', 'ghc' ),
                     'parent_item_colon'          => __( 'Parent Item:', 'ghc' ),
                     'new_item_name'              => __( 'New Item Name', 'ghc' ),
                     'add_new_item'               => __( 'Add New Item', 'ghc' ),
                     'edit_item'                  => __( 'Edit Item', 'ghc' ),
                     'update_item'                => __( 'Update Item', 'ghc' ),
                     'view_item'                  => __( 'View Item', 'ghc' ),
                     'separate_items_with_commas' => __( 'Separate items with commas', 'ghc' ),
                     'add_or_remove_items'        => __( 'Add or remove items', 'ghc' ),
                     'choose_from_most_used'      => __( 'Choose from the most used', 'ghc' ),
                     'popular_items'              => __( 'Popular Items', 'ghc' ),
                     'search_items'               => __( 'Search Items', 'ghc' ),
                     'not_found'                  => __( 'Not Found', 'ghc' ),
                     'no_terms'                   => __( 'No items', 'ghc' ),
                     'items_list'                 => __( 'Items list', 'ghc' ),
                     'items_list_navigation'      => __( 'Items list navigation', 'ghc' ),
                 ),
             )
        );

    }

    public function init_class_instance_meta_box() {
        add_action( 'add_meta_boxes', array( $this, 'add_class_instance_meta_box' ) );
        add_action( 'save_post', array( $this, 'save_class_instance_meta_box' ), 10, 2 );
    }

    public function add_class_instance_meta_box() {
        add_meta_box(
            $this->slug . '_instances',    // $id
            __( 'Sessions', 'ghc' ), // $title
            array( $this, 'render_class_instance_meta_box' ),  // $callback
            $this->slug,                              // $screen
            'normal',               // $context
            'high',              // $priority
            array()                      // $callback_args
        );
    }

    public function get_class_instances( $class_id = 0, $options = array() ) {


        $args = array(
            'post_type'     => $this->slug . '_instance',
            'posts_per_page'    => '-1',
            'meta_query'        => array(
                'relation'      => 'AND',
                'ghc_class_instance_weekday_clause' => array(
                    'key'       => 'ghc_class_instance_weekday',
                    'compare'   => 'EXISTS'
                ),
                'ghc_class_instance_start_time_clause' => array(
                    'key'       => 'ghc_class_instance_start_time',
                    'compare'   => 'EXISTS'
                )
            ),
            'orderby'           => array(
                'ghc_class_instance_weekday_clause'     => 'ASC',
                'ghc_class_instance_start_time_clause'  => 'ASC'
            )
        );

        if ( $class_id ) {
            $args['meta_query'][] = array(
                'key'       => $this->slug . '_instance_class_id',
                'value'     => $class_id,
                'compare'   => '='
            );
        }

        if ( isset( $options['location'] ) ) {
            $args['meta_query'][] = array(
                'key'       => $this->slug . '_instance_location',
                'value'     => $options['location'],
                'compare'   => '='
            );
        }
        if ( isset( $options['weekday'] ) ) {
            $args['meta_query'][] = array(
                'key'       => $this->slug . '_instance_weekday',
                'value'     => $options['weekday'],
                'compare'   => '='
            );
        }

        return get_posts( $args );
    }

    public function render_class_instance_meta_box( $post, $callback_args ) {
        $class_instances = $this->get_class_instances( $post->ID );

        wp_nonce_field( $this->slug . '_instances_nonce_action', $this->slug . '_instances_nonce' );

        ?>
        <div id="ghc-class-instances-groups">
            <?php
            $n = 0;
            foreach ( $class_instances as $class_instance ) {
                $this->display_class_instance( $class_instance->ID, $n );
                $n += 1;
            }
            ?>
        </div>
        <button class="ghc-class-instance-add button" type="button">Add Class Set</button>
        <?php
            ob_start();
            $field_prefix = $field['name'];
            $this->display_class_instance();
            $output = preg_replace( '/\'/', "\'", ob_get_clean() );
        ?>
        <script>
            jQuery(document).ready(function(){
                jQuery( '.ghc-class-instance-add' ).on( 'click', function () {
                    console.log('click');
                    var current_hour_count = jQuery( '.ghc-class-instance-group' ).length,
                    template = '<?php echo preg_replace( "/[\n\r]/","", $output ); ?>';

                    template = template.replace( /\[\]/g, '[' + current_hour_count + ']');

                    jQuery( '#ghc-class-instances-groups' ).append(
                        jQuery( template )
                    );
                });

                jQuery( '#ghc-class-instances-groups' ).on( 'click', '.ghc-remove', function () {
                    jQuery( this ).closest( '.ghc-class-instance-group' ).remove();
                });
                /*
                jQuery( '#ghc-hour-groups' ).on( 'change', '.ghc-hour-split', function () {
                    if ( jQuery( this ).is(':checked') ) {
                        jQuery( this ).closest( '.ghc-hour-controls' ).find( '.ghc-hour-controls__secondary' ).show();
                    }
                    else {
                        jQuery( this ).closest( '.ghc-hour-controls' ).find( '.ghc-hour-controls__secondary' ).hide();
                    }
                })
                */
            });
        </script>
        <?php
    }

    public function display_class_instance( $class_instance_id = 0, $n = '' ) {
        ?>
        <div class="ghc-controls ghc-class-instance-group">
            <div class="ghc-control ghc-control--40">
                <label><?php _e( 'Location', 'ghc' ); ?></label>
                <?php $this->display_post_type_select(
                    array(
                        'key_override'  => $this->slug . '_instance_location',
                        'post_type'     => 'ghc_location',
                        'name'          => 'class_instances[' . $n . '][location]',
                    ),
                    $class_instance_id
                ); ?>
            </div>
            <div class="ghc-control ghc-control--30">
                <label><?php _e( 'Studio', 'ghc' ); ?></label>
                <?php $this->display_taxonomy_select(
                    array(
                        'key_override'  => $this->slug . '_instance_studio',
                        'taxonomy'      => $this->slug . '_studio',
                        'name'          => 'class_instances[' . $n . '][studio]',
                    ),
                    $class_instance_id
                ); ?>
            </div>
            <div class="ghc-control ghc-control--30">
                <label><?php _e( 'Instructor', 'ghc' ); ?></label>
                <input type="text" name="class_instances[<?php echo $n; ?>][instructor]" value="<?php echo get_post_meta( $class_instance_id, $this->slug . '_instance_instructor', true ); ?>">
            </div>
            <div class="ghc-control ghc-control--20">
                <label>Day of Week</label>
                <?php $this->display_weekday_select(
                        array(
                            'key_override'  => $this->slug . '_instance_weekday',
                            'name'          => 'class_instances[' . $n . '][weekday]',
                        ),
                        $class_instance_id
                ); ?>
            </div>
            <div class="ghc-control ghc-control--20">
                <label><?php _e( 'Start Time', 'ghc' ); ?></label>
                <input type="text" name="class_instances[<?php echo $n; ?>][start_time]" value="<?php echo get_post_meta( $class_instance_id, $this->slug . '_instance_start_time', true ); ?>">
            </div>
            <div class="ghc-control ghc-control--20">
                <label><?php _e( 'End Time', 'ghc' ); ?></label>
                <input type="text" name="class_instances[<?php echo $n; ?>][end_time]" value="<?php echo get_post_meta( $class_instance_id, $this->slug . '_instance_end_time', true ); ?>">
            </div>
            <div class="ghc-control ghc-control--20">
                <label><?php _e( 'Display Start', 'ghc' ); ?></label>
                <input type="date" name="class_instances[<?php echo $n; ?>][display_start_date]" value="<?php echo get_post_meta( $class_instance_id, $this->slug . '_instance_display_start_date', true ); ?>">
            </div>
            <div class="ghc-control ghc-control--20">
                <label><?php _e( 'Display End', 'ghc' ); ?></label>
                <input type="date" name="class_instances[<?php echo $n; ?>][display_end_date]" value="<?php echo get_post_meta( $class_instance_id, $this->slug . '_instance_display_end_date', true ); ?>">
            </div>
            <input type="hidden" name="class_instances[<?php echo $n; ?>][id]" value="<?php echo $class_instance_id; ?>">

            <button class="ghc-remove button" type="button">Delete</button>
        </div>
        <?php
    }

    public function save_class_instance_meta_box( $post_id, $post ) {

        // Check if the user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return;

        // Check if it's not an autosave.
        if ( wp_is_post_autosave( $post_id ) )
            return;

        // Check if it's not a revision.
        if ( wp_is_post_revision( $post_id ) )
            return;

        // Add nonce for security and authentication.
        $nonce_name   = $_POST[ $this->slug . '_instances_nonce'];
        $nonce_action = $this->slug . '_instances_nonce_action';

        // Check if a nonce is set.
        if ( ! isset( $nonce_name ) )
            return;

        // Check if a nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
            return;

        $class_instances = $_POST['class_instances'];

        remove_action('save_post', array( $this, 'save_class_instance_meta_box' ), 10, 2 );

        $keep_class_instances = array();
        foreach ( $class_instances as $class_instance ) {

            $id = $class_instance['id'] == '0' ? false : $class_instance['id'];

            if ( ! $id ) {
                $id = wp_insert_post( array(
                    'post_type' => $this->slug . '_instance',
                    'post_status'   => 'publish'
                ) );
                update_post_meta( $id, $this->slug . '_instance_class_id', $post_id );
            }

            foreach ( $class_instance as $key => $value ) {
                if ( $key == 'id' ) {
                    continue;
                }
                if ( preg_match( '/time/', $key ) && $value != '' ) {
                    $value = $this->value_format_time( $value );
                }
                else if ( preg_match( '/date/', $key ) && $value != '' ) {
                    $value = $this->value_format_date( $value );
                }
                update_post_meta( $id, $this->slug . '_instance_' . $key, $value );
            }

            array_push( $keep_class_instances, $id );
        }

        $remove_classes = get_posts( array(
            'post_type'         => $this->slug . '_instance',
            'posts_per_page'    => '-1',
            'meta_query'        => array(
                array(
                    'key'       => $this->slug .'_instance_class_id',
                    'value'     => $post_id,
                    'compare'   => '='
                )
            ),
            'exclude'           => $keep_class_instances
        ) );

        foreach ( $remove_classes as $remove_class ) {
            wp_delete_post( $remove_class->ID );
        }

        add_action('save_post', array( $this, 'save_class_instance_meta_box' ), 10, 2 );

    }

    public function get_class_instance_display_hours( $class_instance_id, $args = array() ) {
        return date( 'h:i A', strtotime( get_post_meta( $class_instance_id, 'ghc_class_instance_start_time', true ) ) ) . ' - ' . date( 'h:i A',  strtotime( get_post_meta( $class_instance_id, 'ghc_class_instance_end_time', true ) ) );
        //return $this->format_hours( get_post_meta( $class_instance_id, 'ghc_class_instance_start_time', true ) ) . ' - ' . $this->format_hours( get_post_meta( $class_instance_id, 'ghc_class_instance_end_time', true ) );
    }

}

new GHCPostTypeClass;
