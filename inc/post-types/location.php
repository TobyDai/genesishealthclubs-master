<?php

/*
 * Location Post Type, Corresponding Taxonomies and Meta
 */
class GHCPostTypeLocation extends GHCPostType {

    /*
     * Slug: cannot be changed once posts have been created
     * Sets: the post type key and the taxonomy and post meta namespace
     */
    public $slug = 'ghc_location';

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
                    'width' => 100
                ),
                array(
                    'name'      => 'offer_form',
                    'label'     => 'Offer Form',
                    'type'      => 'gravityform',
                ),
                array(
                    'name'      => 'ibex_id',
                    'label'     => 'Ibex ID',
                    'type'      => 'text',
                ),
            )
        ),
        array(
            'slug'      => 'contact',
            'name'      => 'Contact Details',
            'context'   => 'normal',
            'priority'  => 'high',
            'fields'    => array(
                array(
                    'name'  => 'street_address',
                    'label' => 'Street Address',
                    'type'  => 'text',
                    'width' => 100
                ),
                array(
                    'name'  => 'address_locality',
                    'label' => 'City',
                    'type'  => 'text',
                    'width' => 50
                ),
                array(
                    'name'  => 'address_region',
                    'label' => 'State',
                    'type'  => 'text',
                    'width' => 20
                ),
                array(
                    'name'  => 'postal_code',
                    'label' => 'Post Code',
                    'type'  => 'text',
                    'width' => 30
                ),
                array(
                    'name'  => 'geo_latitude',
                    'label' => 'Latitude',
                    'type'  => 'text',
                    'width' => 50,
                ),
                array(
                    'name'  => 'geo_longitude',
                    'label' => 'Longitude',
                    'type'  => 'text',
                    'width' => 50,
                ),
                array(
                    'name'  => 'telephone',
                    'label' => 'Phone',
                    'type'  => 'tel',
                    'width' => 50,
                ),
                array(
                    'name'  => 'fax_number',
                    'label' => 'Fax',
                    'type'  => 'tel',
                    'width' => 50,
                ),
                array(
                    'name'  => 'email',
                    'label' => 'Email',
                    'type'  => 'text',
                    'hint'  => 'Comma separated list',
                ),
                array(
                    'name'  => 'email_manager',
                    'label' => 'Club Manager Email',
                    'type'  => 'text',
                    'hint'  => 'Comma separated list',
                ),
            )
        ),
        /*array(
            'slug'      => 'hours',
            'name'      => 'Hours',
            'context'   => 'normal',
            'priority'  => 'high',
            'fields'    => array(
                array(
                    'name'  => 'hours',
                    'label' => false,
                    'type'  => 'hours'
                )
            )
        ),*/
        array(
            'slug'      => 'social',
            'name'      => 'Social Details',
            'context'   => 'normal',
            'priority'  => 'high',
            'fields'    => array(
                array(
                    'name'  => 'facebook_url',
                    'label' => 'Facebook Page URL',
                    'type'  => 'url'
                ),
                array(
                    'name'  => 'twitter_username',
                    'label' => 'Twitter Username',
                    'type'  => 'text',
                    'width' => 50,
                ),
                array(
                    'name'  => 'twitter_hashtag',
                    'label' => 'Twitter Hashtag',
                    'type'  => 'text',
                    'width' => 50,
                ),
                array(
                    'name'  => 'instagram_username',
                    'label' => 'Instagram Username',
                    'type'  => 'text'
                )
            )
        ),
        array(
            'slug'      => 'nav_menu',
            'name'      => 'Navigation',
            'context'   => 'normal',
            'priority'  => 'high',
            'fields'    => array(
                array(
                    'name'  => 'page_navigation',
                    'label' => 'Navigation',
                    'type'  => 'sortable',
                    'post_type' => 'ghc_location_page',
                    'meta'  => array(
                        array(
                            'key'   => 'ghc_location_page_location_id',
                            'value' => 'post_id'
                        ),
                        array(
                            'key'   => 'ghc_location_page_show_in_menu',
                            'value' => '1'
                        ),
                    ),
                ),
            )
        ),
        array(
            'slug'      => 'featured_blocks',
            'name'      => 'Featured Blocks',
            'context'   => 'normal',
            'priority'  => 'high',
            'fields'    => array(
                array(
                    'name'  => 'featured_pages',
                    'label' => 'Featured Pages',
                    'type'  => 'sortable',
                    'post_type' => 'ghc_location_page',
                    'meta'  => array(
                        array(
                            'key'   => 'ghc_location_page_location_id',
                            'value' => 'post_id'
                        ),
                        array(
                            'key'   => 'ghc_location_page_featured_block',
                            'value' => '1'
                        ),
                    ),
                ),
            )
        ),
        array(
            'slug'      => 'integrations',
            'name'      => 'Integrations',
            'context'   => 'side',
            'priority'  => 'default',
            'fields'    => array(
                array(
                    'name'  => 'clubsales_location_number',
                    'label' => 'Club Sales Location Number',
                    'type'  => 'text'
                ),
                array(
                    'name'  => 'club_os_id',
                    'label' => 'Club OS ID',
                    'type'  => 'text',
                ),
                array(
                    'name'  => 'listen360_id',
                    'label' => 'Listen360 ID',
                    'type'  => 'text',
                    'hint'  => 'How to get Listen360 ID...',
                ),
            )
        ),
    );

	public function __construct() {

        add_filter( 'query_vars', array( $this, 'register_query_variables') );
        add_action( 'init', array( $this, 'rewrite_rules' ) );
        add_action( 'init', array( $this, 'register_post_type'), 0 );
        add_action( 'init', array( $this, 'register_taxonomies' ), 0 );

		if ( is_admin() ) {
            //add_action( 'admin_init', array($this, 'add_capabilities') );

            // Metaboxes
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );


            add_action( 'load-post.php', array( $this, 'init_location_hours_meta_box' ) );
            add_action( 'load-post-new.php', array( $this, 'init_location_hours_meta_box' ) );

            // Admin Columns
            add_filter( 'manage_' . $this->slug . '_posts_columns', array( $this, 'add_admin_columns' ) );
            add_action( 'manage_' . $this->slug . '_posts_custom_column' , array( $this, 'add_admin_columns_data' ), 10, 2 );
            add_filter( 'manage_edit-' . $this->slug . '_sortable_columns', array( $this, 'make_admin_columns_sortable' ) );
            add_action( 'load-edit.php', array( $this, 'add_admin_columns_sort_request' ) );
            add_filter( 'manage_posts_columns', array( $this, 'do_column_order' ) );

            add_action( 'admin_init', array($this, 'add_admin_filters') );
            add_action( 'admin_init', array($this, 'admin_remove_date_filter') );

            add_action( 'admin_menu', array( $this, 'modify_admin' ) );

            add_action( 'ghc_location_market_add_form_fields', array( $this, 'market_taxonomy_field_display' ) );
            add_action( 'ghc_location_market_edit_form_fields', array( $this, 'market_taxonomy_field_display' ) );

            add_action( 'edited_ghc_location_market', array( $this, 'taxonomy_meta_fields_save' ), 10, 2);
            add_action( 'created_ghc_location_market', array( $this, 'taxonomy_meta_fields_save' ), 10, 2);
		}
        else {
            add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
        }

    }

    public function rewrite_rules( $rules ) {
        add_rewrite_rule(
            'locations/(.+)/staff/?',
            'index.php?' . $this->slug . '=$matches[1]&template_view=staff',
            'top'
        );
    }
    public function register_query_variables( $qvars ) {
        $qvars[] = 'template_view';
        return $qvars;
    }

    public function pre_get_posts( $query ) {
        if (
            $query->is_main_query() && is_post_type_archive( $this->slug ) ||
            $query->is_main_query() && is_tax( $this->slug . '_market' )
        ) {
            $query->set( 'posts_per_page', '-1' );
            $query->set( 'orderby', 'post_title' );
            $query->set( 'order', 'ASC' );
        }
    }

    public function modify_admin() {
        remove_meta_box( 'pageparentdiv', $this->slug, 'side' );
    }
    /*
    public function add_capabilities() {
        $role = get_role( 'administrator' );

        $role->add_cap( 'edit_location' );
        $role->add_cap( 'read_location' );
    }
    */
    public function register_post_type() {

        /*
         * https://codex.wordpress.org/Function_Reference/register_post_type
        **/
        register_post_type(
            $this->slug,
            array(
                'label'                 => __( 'Location', 'ghc' ),
                'description'           => __( 'Location Description', 'ghc' ),
                'supports'              => array( 'title', 'page-attributes', 'thumbnail' ),
                'taxonomies'            => array(),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 5,
                'menu_icon'             => 'dashicons-location',
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'show_in_rest'          => true, /* true: enables the gutenburg block editor */
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'page',
                /*'capabilities'          => array(
                    'edit_post'          => 'edit_location',
                    'read_post'          => 'read_location',
                    'delete_post'        => 'delete_location',
                    'edit_posts'         => 'edit_locations',
                    'edit_others_posts'  => 'edit_others_locations',
                    'publish_posts'      => 'publish_locations',
                    'read_private_posts' => 'read_private_locations',
                    'create_posts'       => 'edit_locations',
                ),
                'map_meta_cap'          => true,*/
                'rewrite'               => array(
                    'slug'              => 'locations',
                    'with_front'        => false
                ), /* https://codex.wordpress.org/Function_Reference/register_post_type#rewrite */
                'labels'                => array(
                    'name'                  => _x( 'Locations', 'Location General Name', 'ghc' ),
                    'singular_name'         => _x( 'Location', 'Location Singular Name', 'ghc' ),
                    'menu_name'             => __( 'Locations', 'ghc' ),
                    'name_admin_bar'        => __( 'Location', 'ghc' ),
                    'archives'              => __( 'Location Archives', 'ghc' ),
                    'attributes'            => __( 'Location Attributes', 'ghc' ),
                    'parent_item_colon'     => __( 'Parent Location:', 'ghc' ),
                    'all_items'             => __( 'All Locations', 'ghc' ),
                    'add_new_item'          => __( 'Add New Location', 'ghc' ),
                    'add_new'               => __( 'Add New', 'ghc' ),
                    'new_item'              => __( 'New Location', 'ghc' ),
                    'edit_item'             => __( 'Edit Location', 'ghc' ),
                    'update_item'           => __( 'Update Location', 'ghc' ),
                    'view_item'             => __( 'View Location', 'ghc' ),
                    'view_items'            => __( 'View Locations', 'ghc' ),
                    'search_items'          => __( 'Search Location', 'ghc' ),
                    'not_found'             => __( 'Not found', 'ghc' ),
                    'not_found_in_trash'    => __( 'Not found in Trash', 'ghc' ),
                    'featured_image'        => __( 'Featured Image', 'ghc' ),
                    'set_featured_image'    => __( 'Set featured image', 'ghc' ),
                    'remove_featured_image' => __( 'Remove featured image', 'ghc' ),
                    'use_featured_image'    => __( 'Use as featured image', 'ghc' ),
                    'insert_into_item'      => __( 'Insert into location', 'ghc' ),
                    'uploaded_to_this_item' => __( 'Uploaded to this location', 'ghc' ),
                    'items_list'            => __( 'Locations list', 'ghc' ),
                    'items_list_navigation' => __( 'Locations list navigation', 'ghc' ),
                    'filter_items_list'     => __( 'Filter locations list', 'ghc' ),
                ),
            )
        );

        /*
         * https://codex.wordpress.org/Function_Reference/register_post_type
        **/
        register_post_type(
            $this->slug . '_hours',
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
                    'name'                  => _x( 'Location Hours', 'General Name', 'ghc' ),
                ),
            )
        );

    }

    public function register_taxonomies() {

        /*
         * https://codex.wordpress.org/Function_Reference/register_taxonomy
         */
        register_taxonomy(
             $this->slug . '_market',
             array( $this->slug ),
             array(
                 'hierarchical'               => false,
                 'public'                     => true,
                 'show_ui'                    => true,
                 'show_admin_column'          => false,
                 'show_in_nav_menus'          => true,
                 'show_tagcloud'              => false,
                 'rewrite'               => array(
                     'slug'              => 'markets',
                     'with_front'        => false
                 ), /* https://codex.wordpress.org/Function_Reference/register_post_type#rewrite */
                 'labels'                     => array(
                     'name'                       => _x( 'Markets', 'Category General Name', 'ghc' ),
                     'singular_name'              => _x( 'Market', 'Market Singular Name', 'ghc' ),
                     'menu_name'                  => __( 'Markets', 'ghc' ),
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

        register_taxonomy(
            $this->slug . '_amenity',
            array( $this->slug ),
            array(
                'hierarchical'               => false,
                'public'                     => false,
                'show_ui'                    => true,
                'show_admin_column'          => false,
                'show_in_nav_menus'          => false,
                'show_tagcloud'              => false,
                'labels'                     => array(
                    'name'                       => _x( 'Amenities', 'Category General Name', 'ghc' ),
                    'singular_name'              => _x( 'Amenity', 'Amenity Singular Name', 'ghc' ),
                    'menu_name'                  => __( 'Amenities', 'ghc' ),
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


    public function market_taxonomy_field_display( $term ) {
        $short_description = get_term_meta( $term->term_id, $this->slug . '_market_short_description', true );
        $excerpt = get_term_meta( $term->term_id, $this->slug . '_market_excerpt', true );

        ?>
        <tr class="form-field">
            <th scope="row"><?php _e( 'Short Description', 'ghc' );?></th>
            <td>
                <?php
                wp_editor( $short_description , 'short_description', array(
                    'wpautop'       => true,
                    'media_buttons' => false,
                    'textarea_name' => 'term_meta[' . $this->slug . '_market_short_description]',
                    'textarea_rows' => 10,
                    'teeny'         => true,
                ) );
                ?>
                <p class="description">This description will appear above the gym listings on the market page. Please keep it relatively short.</p>
            </td>
        </tr>
        <tr class="form-field">
            <th scope="row"><?php _e( 'Archive Page Excerpt', 'ghc' );?></th>
            <td>
                <textarea style="height:150px" name="term_meta[<?php echo $this->slug; ?>_market_excerpt]" id="excerpt"><?php echo $excerpt; ?></textarea>
                <p class="description">This description will appear on the main Gyms archive page.</p>
            </td>
        </tr>
        <tr class="form-field term-group-wrap">
            <th scope="row">
                <label for="category-image-id"><?php _e( 'Image', 'hero-theme' ); ?></label>
            </th>
            <td>
                <?php $image_id = get_term_meta( $term->term_id, $this->slug . '_market_image_id', true ); ?>
                <input type="hidden" id="category-image-id" name="term_meta[<?php echo $this->slug; ?>_market_image_id]" value="<?php echo $image_id; ?>">
                <div id="category-image-wrapper">
                <?php if ( $image_id ) { ?>
                    <?php echo wp_get_attachment_image( $image_id, 'thumbnail' ); ?>
                <?php } ?>
                </div>
                <p>
                <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'hero-theme' ); ?>" />
                <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'hero-theme' ); ?>" />
                </p>
            </td>
        </tr>
        <?php
    }
    public function taxonomy_meta_fields_save( $term_id ) {

        if ( !isset( $_POST['term_meta'] ) ) return;

        foreach ( $_POST['term_meta'] as $slug => $value){

            switch($slug){
                default:
                    $value = $value;
                break;
            }

            update_term_meta( $term_id, $slug, $value );
        }

    }


    public function init_location_hours_meta_box() {
        add_action( 'add_meta_boxes', array( $this, 'add_location_hours_meta_box' ) );
        add_action( 'save_post', array( $this, 'save_location_hours_meta_box' ), 10, 2 );
    }

    public function add_location_hours_meta_box() {
        add_meta_box(
            $this->slug . '_hours',
            __( 'Hours', 'ghc' ),
            array( $this, 'render_location_hours_meta_box' ),
            $this->slug,
            'normal',
            'high',
            array()
        );
    }


    public function get_location_hours( $location_id, $primary_only = false ) {

        $args = array(
            'post_type'     => $this->slug . '_hours',
            'posts_per_page'    => '-1',
            'orderby'           => 'meta_key',
            'meta_key'          => 'ghc_location_hours_is_primary',
            'order'             => 'DESC',
            'meta_query'        => array(
                array(
                    'key'       => 'ghc_location_hours_location_id',
                    'value'     => $location_id,
                    'compare'   => '='
                )
            )
        );
        if ( $primary_only ) {
            $args['posts_per_page'] = '1';
            $args['meta_query'][] = array(
                'key'   => 'ghc_location_hours_is_primary',
                'value' => '1',
                'compare'   => '='
            );
        }

        return get_posts( $args );
    }


    public function render_location_hours_meta_box( $post, $callback_args ) {
        $location_hours = $this->get_location_hours( $post->ID );

        wp_nonce_field( $this->slug . '_hours_nonce_action', $this->slug . '_hours_nonce' );

        ?>
        <div id="ghc-hour-groups" class="ghc-hour-groups">
            <?php
            $n = 0;
            foreach ( $location_hours as $location_hour ) {
                $this->display_hour_set( $location_hour->ID, $n );
                $n += 1;
            }
            ?>
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
        <?php
    }


    public function save_location_hours_meta_box( $post_id, $post ) {

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
        $nonce_name   = $_POST[ $this->slug . '_hours_nonce'];
        $nonce_action = $this->slug . '_hours_nonce_action';

        // Check if a nonce is set.
        if ( ! isset( $nonce_name ) )
            return;

        // Check if a nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) )
            return;

        $location_hours = $_POST['location_hours'];

        remove_action('save_post', array( $this, 'save_location_hours_meta_box' ), 10, 2 );

        $keep_location_hours = array();
        foreach ( $location_hours as $location_hours ) {

            $id = $location_hours['id'] == '0' ? false : $location_hours['id'];

            if ( ! $id ) {
                $id = wp_insert_post( array(
                    'post_type' => $this->slug . '_hours',
                    'post_status'   => 'publish'
                ) );
                update_post_meta( $id, $this->slug . '_hours_location_id', $post_id );
            }

            foreach ( $location_hours as $key => $value ) {
                if ( $key == 'id' ) {
                    continue;
                }
                if ( preg_match( '/time/', $key ) && $value != '' ) {
                    $value = $this->value_format_time( $value );
                }
                else if ( preg_match( '/date/', $key ) && $value != '' ) {
                    $value = $this->value_format_date( $value );
                }
                update_post_meta( $id, $this->slug . '_hours_' . $key, $value );
            }

            wp_update_post( array(
                'ID'        => $id,
                'post_title'    => get_the_title( $post_id ) . ' - ' . get_post_meta( $id, $this->slug . '_hours_title', true)
            ) );

            array_push( $keep_location_hours, $id );
        }

        $remove_location_hours = get_posts( array(
            'post_type'         => $this->slug . '_hours',
            'posts_per_page'    => '-1',
            'meta_query'        => array(
                array(
                    'key'       => $this->slug .'_hours_location_id',
                    'value'     => $post_id,
                    'compare'   => '='
                )
            ),
            'exclude'           => $keep_location_hours
        ) );

        foreach ( $remove_location_hours as $remove_location_hour ) {
            wp_delete_post( $remove_location_hour->ID );
        }

        add_action('save_post', array( $this, 'save_location_hours_meta_box' ), 10, 2 );

    }


    public function display_hour_set( $location_hours_id, $n = '' ) {

        $name = 'location_hours';
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
                <input name="<?php echo $name . '[' . $n . '][title]'; ?>" value="<?php echo esc_attr( get_post_meta( $location_hours_id, $this->slug . '_hours_title', true ) ); ?>" placeholder="Hour set title">
            </div>
            <?php foreach ( $days as $key => $value ) : ?>
                <?php $field_name = $name . '[' . $n . '][' . $key . ']'; ?>
                <?php $field_name = $name . '[' . $n . ']'; ?>
                <?php $is_split = get_post_meta( $location_hours_id, $this->slug . '_hours_' . $key . '_is_split', true) == '1' ? true : false; ?>
                <div class="ghc-hour-control">
                    <label for="<?php echo $field_name; ?>"><?php _e( $value, 'ghc' ); ?></label>
                    <div class="ghc-hour-controls">
                        <div class="ghc-hour-controls__primary">
                            <div class="ghc-hour-controls__hour">
                                <label><?php _e( 'Open', 'ghc' ); ?></label>
                                <select name="<?php echo $field_name; ?>[<?php echo $key; ?>_open]">
                                    <option value=""></option>
                                    <?php for ( $i=0; $i < 24; $i++ ) : ?>
                                        <?php $hour_string = date( 'H:i', strtotime( "$i:00" ) ); ?>
                                        <?php $half_string  = date( 'H:i', strtotime( "$i:30" ) ) ; ?>
                                        <option value="<?php echo $hour_string; ?>" <?php echo ( get_post_meta( $location_hours_id, $this->slug . '_hours_' . $key . '_open', true ) == $hour_string ? ' selected ' : '' ); ?>><?php echo date( 'h:i A', strtotime( "$i:00" ) ); ?></option>
                                        <option value="<?php echo $half_string; ?>" <?php echo ( get_post_meta( $location_hours_id, $this->slug . '_hours_' . $key . '_open', true ) == $half_string ? ' selected ' : '' ); ?>><?php echo date( 'h:i A', strtotime( "$i:30" ) ); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="ghc-hour-controls__hour">
                                <label><?php _e( 'Close', 'ghc' ); ?></label>
                                <select name="<?php echo $field_name; ?>[<?php echo $key; ?>_close]">
                                    <option value=""></option>
                                    <?php for ( $i=0; $i < 24; $i++ ) : ?>
                                        <?php $hour_string = date( 'H:i', strtotime( "$i:00" ) ); ?>
                                        <?php $half_string  = date( 'H:i', strtotime( "$i:30" ) ) ; ?>
                                        <option value="<?php echo $hour_string; ?>" <?php echo ( get_post_meta( $location_hours_id, $this->slug . '_hours_' . $key . '_close', true ) == $hour_string ? ' selected ' : '' ); ?>><?php echo date( 'h:i A', strtotime( "$i:00" ) ); ?></option>
                                        <option value="<?php echo $half_string; ?>" <?php echo ( get_post_meta( $location_hours_id, $this->slug . '_hours_' . $key . '_close', true ) == $half_string ? ' selected ' : '' ); ?>><?php echo date( 'h:i A', strtotime( "$i:30" ) ); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="ghc-hour-controls__alternate">
                                <label>
                                    <input class="ghc-hour-split" type="checkbox" name="<?php echo $field_name; ?>[<?php echo $key; ?>_split]" value="true" <?php echo ( $is_split ? ' checked ' : '' ); ?>>
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
                                <select name="<?php echo $field_name; ?>[<?php echo $key; ?>_open_split]">
                                    <option value=""></option>
                                    <?php for ( $i=0; $i < 24; $i++ ) : ?>
                                        <?php $hour_string = date( 'H:i', strtotime( "$i:00" ) ); ?>
                                        <?php $half_string  = date( 'H:i', strtotime( "$i:30" ) ) ; ?>
                                        <option value="<?php echo $hour_string; ?>" <?php echo ( get_post_meta( $location_hours_id, $this->slug . '_hours_' . $key . '_open_split', true ) == $hour_string ? ' selected ' : '' ); ?>><?php echo date( 'h:i A', strtotime( "$i:00" ) ); ?></option>
                                        <option value="<?php echo $half_string; ?>" <?php echo ( get_post_meta( $location_hours_id, $this->slug . '_hours_' . $key . '_open_split', true ) == $half_string ? ' selected ' : '' ); ?>><?php echo date( 'h:i A', strtotime( "$i:30" ) ); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="ghc-hour-controls__hour">
                                <label><?php _e( 'Close', 'ghc' ); ?></label>
                                <select name="<?php echo $field_name; ?>[<?php echo $key; ?>_close_split]">
                                    <option value=""></option>
                                    <?php for ( $i=0; $i < 24; $i++ ) : ?>
                                        <?php $hour_string = date( 'H:i', strtotime( "$i:00" ) ); ?>
                                        <?php $half_string  = date( 'H:i', strtotime( "$i:30" ) ) ; ?>
                                        <option value="<?php echo $hour_string; ?>" <?php echo ( get_post_meta( $location_hours_id, $this->slug . '_hours_' . $key . '_close_split', true ) == $hour_string ? ' selected ' : '' ); ?>><?php echo date( 'h:i A', strtotime( "$i:00" ) ); ?></option>
                                        <option value="<?php echo $half_string; ?>" <?php echo ( get_post_meta( $location_hours_id, $this->slug . '_hours_' . $key . '_close_split', true ) == $half_string ? ' selected ' : '' ); ?>><?php echo date( 'h:i A', strtotime( "$i:30" ) ); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <input type="hidden" name="<?php echo $field_name; ?>[id]" value="<?php echo $location_hours_id; ?>">
            <button class="ghc-hour-group-remove button" type="button">Remove Hour Set</button>
        </div>
        <?php
    }

    public function add_admin_columns( $columns ) {
        $columns['address_locality']  = 'City';
        //$columns['address_region']  = 'State';
        //$columns['postal_code']     = 'Post Code';
        $columns['pages']           = 'Pages';

        return $columns;
    }

    public function add_admin_columns_data( $column, $post_id ) {
        switch ( $column ) {
            case 'address_locality':
                echo get_post_meta( $post_id, $this->slug . '_address_locality', true );
                break;
            /*case 'address_region':
                echo get_post_meta( $post_id, $this->slug . '_address_region', true );
                break;*/
            /*case 'postal_code':
                echo get_post_meta( $post_id, $this->slug . '_postal_code', true );
                break;*/
            case 'pages':
                echo '<a class="button button-link" style="text-decoration: none;" href="edit.php?s&post_status=all&post_type=ghc_location_page&ghc_location_id=' . $post_id . '&filter_action=Filter&paged=1"><span class="dashicons dashicons-admin-page"></span></a>';
                break;
        }
    }

    public function make_admin_columns_sortable( $columns ) {
        $columns['address_locality'] = 'address_locality';
        //$columns['address_region'] = 'address_region';
        //$columns['postal_code'] = 'postal_code';

        return $columns;
    }

    function add_admin_columns_sort_request() {
        add_filter( 'request', array( $this, 'add_admin_column_do_sortable' ) );
    }

    function add_admin_column_do_sortable( $vars ) {

        if ( isset( $vars['post_type'] ) && $this->slug == $vars['post_type'] ) {

            if (  isset( $vars['orderby'] ) &&  ( $vars['orderby'] == 'address_region' || $vars['orderby'] == 'postal_code' || $vars['orderby'] == 'address_locality' ) ) {

                // apply the sorting to the post list
                $vars = array_merge(
                    $vars,
                    array(
                        'meta_key' => $this->slug . '_' . $vars['orderby'],
                        'orderby' => 'meta_key'
                    )
                );
            }
        }

        return $vars;
    }

    public function do_column_order($columns) {
        $n_columns = array();
        $before = 'date'; // move before this

        foreach( $columns as $key => $value ) {
            if ( $key == $before ){
                $n_columns['address_locality'] = '';
                $n_columns['address_region'] = '';
                $n_columns['postal_code'] = '';
            }
            $n_columns[$key] = $value;
        }
        unset($n_columns['date']);
        return $n_columns;
    }



    /* TODO: Move this to the parent class. try to combine with the tax filter used in location post type */
    public function add_admin_filters() {

        add_action( 'restrict_manage_posts', array($this, 'restrict_manage_posts') );
    }


    public function restrict_manage_posts() {
        global $typenow;
        $tax_slug = $this->slug . '_market';
        if ( $typenow == $this->slug ) {
            $tax_obj = get_taxonomy($tax_slug);
            $tax_name = $tax_obj->labels->name;

            echo "<select name='".strtolower($tax_slug)."' id='".strtolower($tax_slug)."' class='postform'>";
            echo "<option value=''>Show All $tax_name</option>";
            $this->generate_taxonomy_options($tax_slug,0,0,(isset($_GET[strtolower($tax_slug)])? $_GET[strtolower($tax_slug)] : null));
            echo "</select>";
        }
    }

    public function generate_taxonomy_options($tax_slug, $parent = '', $level = 0,$selected = null) {
        $args = array('show_empty' => 1);
        if(!is_null($parent)) {
            $args = array('parent' => $parent);
        }
        $terms = get_terms($tax_slug,$args);
        $tab='';
        for($i=0;$i<$level;$i++){
            $tab.='--';
        }

        foreach ($terms as $term) {
            echo '<option value='. $term->slug, $selected == $term->slug ? ' selected="selected"' : '','>' .$tab. $term->name .' (' . $term->count .')</option>';
            $this->generate_taxonomy_options($tax_slug, $term->term_id, $level+1,$selected);
        }

    }

    public function get_day_open_hours( $location_hours_id, $day_key = false, $split = false ) {
        $key = $split ? '_open_split' : '_open';
        return get_post_meta( $location_hours_id, 'ghc_location_hours_' . $day_key . $key, true );
    }

    public function get_day_close_hours( $location_hours_id, $day_key = false, $split = false ) {
        $key = $split ? '_close_split' : '_close';
        return get_post_meta( $location_hours_id, 'ghc_location_hours_' . $day_key . $key, true );
    }
    public function day_hours_is_split( $location_hours_id, $day_key = false ) {
        return get_post_meta( $location_hours_id, 'ghc_location_hours_' . $day_key . '_is_split', true ) == 1 ? true : false;
    }


    public function format_hour_set( $location_hours_id, $combine_days = true ) {
        $days = array(
            array( 'key' => 'mon', 'label'	=> 'Mon' ),
            array( 'key' => 'tue', 'label'	=> 'Tue' ),
            array( 'key' => 'wed', 'label'	=> 'Wed' ),
            array( 'key' => 'thu', 'label'	=> 'Thu' ),
            array( 'key' => 'fri', 'label'	=> 'Fri' ),
            array( 'key' => 'sat', 'label'	=> 'Sat' ),
            array( 'key' => 'sun', 'label'	=> 'Sun' )
        );
        $hour_set = array();
        $day_set = array();
        $hour_set['title'] = get_post_meta( $location_hours_id, 'ghc_location_hours_title', true );
        for ( $i=0; $i < count( $days ); $i++ ) {
            $day_key = $days[ $i ]['key'];
            $day_label = $days[ $i ]['label'];
            $is_active = false;

            $day_open = $this->get_day_open_hours( $location_hours_id, $day_key );
            $day_close  = $this->get_day_close_hours( $location_hours_id, $day_key );
            $day_open_split = $this->get_day_open_hours( $location_hours_id, $day_key, true );
            $day_close_split  = $this->get_day_close_hours( $location_hours_id, $day_key, true );

            if ( date( 'D' ) == $days[ $i ]['label'] ) {
                $is_active = true;
            }
            $label = $day_label;
            $is_split = $this->day_hours_is_split( $location_hours_id, $day_key );
            if (
                ! $is_split
                &&
                $day_open != ''
                &&
                $day_close != ''
            ) {
                if ( $day_open == '00:00' && $day_close == '00:00' ) {
                    $value = __( 'Open 24 hours', 'ghc' );
                }
                else if ( $day_open == '00:00' && $day_close != '00:00') {
                    $value = __( 'Open until', 'ghc' ) . ' ' . $this->format_hours( $day_close );
                }
                else if ( $day_open != '00:00' && $day_close == '00:00') {
                    $value = __( 'Opens at', 'ghc' ) . ' ' . $this->format_hours( $day_open );
                }
                else {
                    $value = $this->format_hours( $day_open ) . ' - ' . $this->format_hours( $day_close );
                }
            }
            else if (
                $day_open != ''
                &&
                $day_close != ''
            ) {
                if ( $day_open == '00:00' && $day_close == '00:00' ) {
                    $value = __( 'Open 24 hours', 'ghc' );
                }
                else if ( $day_open == '00:00' && $day_close != '00:00') {
                    $value = __( 'Open until', 'ghc' ) . ' ' . $this->format_hours( $day_close );
                }
                else if ( $day_open != '00:00' && $day_close == '00:00') {
                    $value = __( 'Opens at', 'ghc' ) . ' ' . $this->format_hours( $day_open );
                }
                else {
                    $value = $this->format_hours( $day_open ) . ' - ' . $this->format_hours( $day_close );
                }

                if ( $day_open_split == '00:00' && $day_close_split == '00:00' ) {
                    $value_split = __( 'Open 24 hours', 'ghc' );
                }
                else if ( $day_open_split == '00:00' && $day_close_split != '00:00') {
                    $value_split = __( 'Open until', 'ghc' ) . ' ' . $this->format_hours( $day_close_split );
                }
                else if ( $day_open_split != '00:00' && $day_close_split == '00:00') {
                    $value_split = __( 'Opens at', 'ghc' ) . ' ' . $this->format_hours( $day_open );
                }
                else {
                    $value_split = $this->format_hours( $day_open_split ) . ' - ' . $this->format_hours( $day_close_split );
                }
            }
            else {
                $value = 'Closed';
            }

            if (
                $combine_days == true
                &&
                $day_open == $this->get_day_open_hours( $location_hours_id, $days[ $i+1 ]['key'] )
                &&
                $day_close == $this->get_day_close_hours( $location_hours_id, $days[ $i+1 ]['key'] )
                && (
                    (
                        ! $is_split
                        &&
                        ! $this->day_hours_is_split( $location_hours_id, $days[ $j+1 ]['key'] )
                    )
                    ||
                    (
                        $is_split
                        &&
                        $this->day_hours_is_split( $location_hours_id, $days[ $j+1 ]['key'] )
                        &&
                        $this->get_day_open_hours( $location_hours_id, $day_key, true ) == $this->get_day_open_hours( $location_hours_id, $days[ $i+1 ]['key'], true )
                        &&
                        $this->get_day_close_hours( $location_hours_id, $day_key, true ) == $this->get_day_close_hours( $location_hours_id, $days[ $i+1 ]['key'], true )
                    )
                )
            ) {

                $j = $i+1;
                for ( $j = $i+1; $j < count( $days ); $j++ ) {
                    if (
                        $day_open == $this->get_day_open_hours( $location_hours_id, $days[ $j+1 ]['key'] )
                        &&
                        $day_close == $this->get_day_close_hours( $location_hours_id, $days[ $j+1 ]['key'] )
                        && (
                            (
                                ! $is_split
                                &&
                                ! $this->day_hours_is_split( $location_hours_id, $days[ $j+1 ]['key'] )
                            )
                            ||
                            (
                                $is_split
                                &&
                                $this->day_hours_is_split( $location_hours_id, $days[ $j+1 ]['key'] )
                                &&
                                $this->get_day_open_hours( $location_hours_id, $day_key, true ) == $this->get_day_open_hours( $location_hours_id, $days[ $j+1 ]['key'], true )
                                &&
                                $this->get_day_close_hours( $location_hours_id, $day_key, true ) == $this->get_day_close_hours( $location_hours_id, $days[ $j+1 ]['key'], true )
                            )
                        )
                        &&
                        $i+2 < count( $days )
                    ) {
                        $i+=1;
                        if ( date( 'D' ) == $days[ $j ]['label'] ) {
                            $is_active = true;
                        }
                        continue;
                    }
                    else if (
                        $day_open == $this->get_day_open_hours( $location_hours_id, $days[ $j ]['key'] )
                        &&
                        $day_close == $this->get_day_close_hours( $location_hours_id, $days[ $j ]['key'] )
                    ) {
                        $label .= ' - ' . $days[ $j ]['label'];
                        if ( date( 'D' ) == $days[ $j ]['label'] ) {
                            $is_active = true;
                        }
                        $i+=1;
                        break;
                    }
                }
            }

            array_push( $day_set, array(
                'label'       => $label,
                'value'       => $value,
                'value_split'   => $value_split,
                'is_split'         => $is_split,
                //'alternating' => $this->get_array_value( 'alternating', $hour_data[ $day_key ] ),
                'is_active'   => $is_active,
            ) );

            $hour_set['days'] = $day_set;
        }

        return $hour_set;

    }

    public function get_hours( $post_id, $combine_days = true, $primary_only = false ) {
        $formated_array = array();

        $location_hours = $this->get_location_hours( $post_id, $primary_only );

        if ( is_array( $location_hours ) ) {

            foreach ( $location_hours as $location_hour ) {
                $hour_set = $this->format_hour_set( $location_hour->ID, $combine_days );
                array_push( $formated_array, $hour_set );
            }
        }
        return $formated_array;
    }

    public function has_hours( $post_id ) {
        $has_hours = false;
        $hours_data = $this->get_hours( $post_id, $combine_days );

        foreach ( $hours_data as $hour_data ) {
            if ( is_array( $hour_data['days'] ) && count( $hour_data ) > 0 ) {
                $has_hours = true;
            }
        }
        return $has_hours;
    }

    function get_hours_list( $post_id, $args = array() ) {

        $args = shortcode_atts( array(
            'combine_days'	=> true,
            'microdata'		=> true,
            'limit'			=> false,
            'show_title'	=> true,
            'primary_only'  => false
        ), $args );

        $combine_days = $args['combine_days'];
        $microdata = $args['microdata'];

        $hours_data = $this->get_hours( $post_id, $combine_days, $args['primary_only'] );

        ob_start();

        $n = 0;
        foreach ( $hours_data as $hour_data ) :
        ?>
            <?php if ( $args['show_title'] ) : ?>
                <details class="location-meta__hours"<?php if ( $hour_data == $hours_data[0] ) echo ' open'; ?>>
                    <summary><h3><?php echo $hour_data['title']; ?></h3></summary>
            <?php endif; ?>
            <ul class="list-hours">
                <?php foreach ( $hour_data['days'] as $day_data ) : ?>
                    <li <?php echo ( $day_data['is_active'] ? ' class="is-active"' : '' ); ?>>
                        <label><?php echo $day_data['label']; ?></label>
                        <span>
                            <time><?php echo $day_data['value']; ?></time><?php if ( $day_data['is_split'] && $day_data['value_split'] != '' ) : ?>
                                <time><?php echo $day_data['value_split']; ?></time>
                            <?php endif; ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php if ( $args['show_title'] ) : ?>
                </details>
            <?php endif; ?>
            <?php
            $n += 1;
            if ( $args['limit'] && $n == $args['limit'] ) {
                break;
            }
        endforeach;
        return ob_get_clean();
    }

    public function is_open_status( $post_id ) {
        $status = 'closed';
        $today_key = strtolower( date( 'D' ) );
        $now_timestamp = ghc_location_get_now_timestamp();
        $now_time = $now_timestamp->format( 'H:i' );
        $hours_data = get_post_meta( $post_id, $this->slug . '_hours', true );
        if ( is_array( $hours_data ) ) {

            foreach ( $hours_data as $hour_data ) {
                $today_open = date( 'H:i', strtotime( $hour_data[ $today_key ]['open'] ) );
                $today_close = date( 'H:i', strtotime( $hour_data[ $today_key ]['close'] ) );
                if ( $today_close < $today_open ) {
                    $today_close_split = explode( ':', $today_close );
                    $today_close = ( $today_close_split[0] + 24 ) . ':' . $today_close_split[1];
                }
                if ( $today_open < $now_time && $today_close > $now_time && $hour_data[ $today_key ]['alternating'] != 'true' ) {
                    $status = 'open';
                    break;
                }
                else if ( $hour_data[ $today_key ]['alternating'] ) {
                    $status = 'alternating';
                    break;
                }
            }
        }
        else {
            $status = 'no_hours';
        }
        return $status;
    }

    function is_open( $post_id ) {
        $open = $this->is_open_status( $post_id ) == 'open'
        ? true
        : false;
        return $open;
    }

    function is_open_tag( $post_id ) {
        $status = $this->is_open_status( $post_id );
        $html = '';
        switch ( $status ) {
            case 'open' :
                $string = 'Open';
                break;
            case 'closed' :
                $string = 'Closed';
                break;
            default :
                $string = '';
                break;
        }
        if ( $string != '' ) {
            $html = '<span class="cedar-location-open-status">';
            if ( $status == 'open' ) {
                $html .= '<span class="cedar-tooltip">Closes at ' . $this->format_hours( $this->get_today_close_time( $post_id ) ) . ' today.</span>';
            }
            $html .='<span>' . $string . '</span></span>';
        }
        return $html;
    }

    function get_today_close_time( $post_id ) {
        $today_key = strtolower( Date( 'D' ) );
        $hours_data = get_post_meta( $post_id, $this->slug . '_hours', true );
        if ( is_array( $hours_data ) ) {
            foreach ( $hours_data as $hour_data ) {
                $today_close = $this->format_hours( $hour_data[ $today_key ]['close'] );
            }
        }
        return $today_close;
    }

    public function get_locations( $args = array() ) {
        $defaults = array(
            'post_type'         => $this->slug,
            'posts_per_page'    => '-1',
            'orderby'           => 'title',
            'order'             => 'ASC',
            'tax_query'         => array(),
            'meta_query'        => array()
        );
        $args = shortcode_atts( $defaults, $args );
        return get_posts( $args );
    }

}

new GHCPostTypeLocation;
