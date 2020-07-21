<?php

/*
 * Location Post Type, Corresponding Taxonomies and Meta
 */
class GHCPostTypeLocationPage extends GHCPostType {

    /*
     * Slug: cannot be changed once posts have been created
     * Sets: the post type key and the taxonomy and post meta namespace
     */
    public $slug = 'ghc_location_page';
    public $name = 'Location Page';
    public $name_plural = 'Location Pages';

    public $meta_boxes = array(
        array(
            'slug'      => 'contact',
            'name'      => 'Page Settings',
            'context'   => 'side',
            'priority'  => 'default',
            'fields'    => array(
                array(
                    'name'      => 'location_id',
                    'label'     => 'Location',
                    'type'      => 'post_select',
                    'post_type' => 'ghc_location'
                ),
                array(
                    'name'      => 'show_in_menu',
                    'label'     => 'Show in Menu',
                    'type'      => 'boolean',
                ),
                array(
                    'name'      => 'offer_form',
                    'label'     => 'Offer Form',
                    'type'      => 'gravityform',
                ),
                array(
                    'name'      => 'featured_block',
                    'label'     => 'Show as Featured Block',
                    'type'      => 'boolean',
                ),
            )
        ),
    );

	public function __construct() {

        add_action( 'init', array( $this, 'register_post_type'), 1 );
        //add_action( 'init', array( $this, 'register_taxonomy_market' ), 0 );
        add_filter('init', array( $this, 'rewrite_rules' ) );

        add_filter( 'post_type_link', array( $this, 'post_link' ), 1, 3 );

		if ( is_admin() ) {
            // Admin Menu
            add_action( 'admin_menu', array( $this, 'add_admin_menu' ), 0 );

            // Metaboxes
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );

            // Admin Columns
            //add_filter( 'manage_' . $this->slug . '_posts_columns', array( $this, 'add_admin_columns' ) );
            //add_action( 'manage_' . $this->slug . '_posts_custom_column' , array( $this, 'add_admin_columns_data' ), 10, 2 );
            //add_filter( 'manage_edit-' . $this->slug . '_sortable_columns', array( $this, 'make_admin_columns_sortable' ) );
            //add_action( 'load-edit.php', array( $this, 'add_admin_columns_sort_request' ) );
            //add_filter('manage_posts_columns', array( $this, 'do_column_order' ) );

            add_action( 'admin_init', array($this, 'add_admin_filters') );
            add_action( 'admin_init', array($this, 'admin_remove_date_filter') );

		}

    }

    public function rewrite_rules( $rules ) {
        add_rewrite_rule(
            'locations/(.+)/(.+)/?',
            'index.php?' . $this->slug . '=$matches[2]',
            'top'
        );
    }

    public function add_admin_menu() {

        add_submenu_page(
            'edit.php?post_type=ghc_location',
            'Pages',
            'Pages',
            'manage_options',
            'edit.php?post_type=ghc_location_page'
        );
    }

    public function post_link( $post_link, $id = 0 ) {
        $post = get_post( $id );
        if ( is_object( $post ) && $post->post_type == $this->slug ) {
            $location = get_post( get_post_meta( $post->ID, 'ghc_location_page_location_id', true ) );
            if ( $location ) {
                return str_replace( '%ghc_location%' , $location->post_name , $post_link );
            }
        }
        return $post_link;
    }

    function register_post_type() {
        /*
         * https://codex.wordpress.org/Function_Reference/register_post_type
        **/
        register_post_type(
            $this->slug,
            array(
                'label'                 => __( 'Location Page', 'ghc' ),
                'description'           => __( 'Pages for a specific location', 'ghc' ),
                'supports'              => array('title', 'editor', 'page-attributes', 'thumbnail', 'excerpt'),
                'taxonomies'            => array(),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => false,
                'menu_position'         => 6,
                'menu_icon'             => 'dashicons-location',
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'show_in_rest'          => true, /* true: enables the gutenburg block editor */
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'page',
                'rewrite'               => array(
                    'slug'              => 'locations/%ghc_location%',
                    'with_front'        => false
                ), /* https://codex.wordpress.org/Function_Reference/register_post_type#rewrite */
                'labels'                => array(
                    'name'                  => _x( 'Location Pages', 'Location Page General Name', 'ghc' ),
                    'singular_name'         => _x( 'Location Page', 'Location Page Singular Name', 'ghc' ),
                    'menu_name'             => __( 'Location Pages', 'ghc' ),
                    'name_admin_bar'        => __( 'Location Page', 'ghc' ),
                    'archives'              => __( 'Location Page Archives', 'ghc' ),
                    'attributes'            => __( 'Location Page Attributes', 'ghc' ),
                    'parent_item_colon'     => __( 'Parent Location Page:', 'ghc' ),
                    'all_items'             => __( 'All Location Pages', 'ghc' ),
                    'add_new_item'          => __( 'Add New Location Page', 'ghc' ),
                    'add_new'               => __( 'Add New', 'ghc' ),
                    'new_item'              => __( 'New Location Page', 'ghc' ),
                    'edit_item'             => __( 'Edit Location Page', 'ghc' ),
                    'update_item'           => __( 'Update Location Page', 'ghc' ),
                    'view_item'             => __( 'View Location Page', 'ghc' ),
                    'view_items'            => __( 'View Location Pages', 'ghc' ),
                    'search_items'          => __( 'Search Location Page', 'ghc' ),
                    'not_found'             => __( 'Not found', 'ghc' ),
                    'not_found_in_trash'    => __( 'Not found in Trash', 'ghc' ),
                    'featured_image'        => __( 'Featured Image', 'ghc' ),
                    'set_featured_image'    => __( 'Set featured image', 'ghc' ),
                    'remove_featured_image' => __( 'Remove featured image', 'ghc' ),
                    'use_featured_image'    => __( 'Use as featured image', 'ghc' ),
                    'insert_into_item'      => __( 'Insert into location page', 'ghc' ),
                    'uploaded_to_this_item' => __( 'Uploaded to this location page', 'ghc' ),
                    'items_list'            => __( 'Location pages list', 'ghc' ),
                    'items_list_navigation' => __( 'Location pages list navigation', 'ghc' ),
                    'filter_items_list'     => __( 'Filter location pagess list', 'ghc' ),
                ),
            )
        );

    }

    public function add_admin_columns( $columns ) {
        $columns['address_region']  = 'State';
        $columns['postal_code']     = 'Post Code';

        return $columns;
    }

    public function add_admin_columns_data( $column, $post_id ) {
        switch ( $column ) {
            case 'address_region':
                echo get_post_meta( $post_id, $this->slug . '_address_region', true );
                break;
            case 'postal_code':
                echo get_post_meta( $post_id, $this->slug . '_postal_code', true );
                break;
        }
    }

    public function make_admin_columns_sortable( $columns ) {
        $columns['address_region'] = 'address_region';
        $columns['postal_code'] = 'postal_code';

        return $columns;
    }

    function add_admin_columns_sort_request() {
        add_filter( 'request', array( $this, 'add_admin_column_do_sortable' ) );
    }

    function add_admin_column_do_sortable( $vars ) {

        if ( isset( $vars['post_type'] ) && $this->slug == $vars['post_type'] ) {

            if (  isset( $vars['orderby'] ) &&  ( $vars['orderby'] == 'address_region' || $vars['orderby'] == 'postal_code' ) ) {

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
                $n_columns['address_region'] = '';
                $n_columns['postal_code'] = '';
            }
            $n_columns[$key] = $value;
        }
        return $n_columns;
    }

    public function add_admin_filters() {

        add_action( 'restrict_manage_posts', array($this, 'restrict_manage_posts') );
        add_filter( 'parse_query', array($this, 'admin_posts_filter'), 10 );

    }

    /* TODO: Move this to the parent class. try to combine with the tax filter used in location post type */
    function admin_posts_filter( $query ){
        //modify the query only if it admin and main query.
        if( !(is_admin() && $query->is_main_query()) ){
            return $query;
        }
        if( 'ghc_location_page' != $query->query['post_type'] ) {
            return $query;
        }
        //for the default value of our filter no modification is required
        if( ! isset( $_REQUEST['ghc_location_id'] ) || $_REQUEST['ghc_location_id'] == '' ){
            return $query;
        }
        //modify the query_vars.
        $query->query_vars['meta_query'][] = array(
            'field' => 'ghc_location_page_location_id',
            'value' => $_REQUEST['ghc_location_id'],
            'compare' => '=',
        );
        return $query;
    }

    function restrict_manage_posts() {
        global $typenow;
        if ( $typenow == $this->slug ) {
            echo "<select name='".strtolower('ghc_location_id')."' id='".strtolower('ghc_location_id')."' class='postform'>";
            echo "<option value=''>Show All Locations</option>";
            $this->generate_restrict_manage_posts_options(null,0,0,(isset($_GET[strtolower('ghc_location_id')])? $_GET[strtolower('ghc_location_id')] : null));
            echo "</select>";
        }
    }

    function generate_restrict_manage_posts_options($tax_slug, $parent = '', $level = 0,$selected = null) {

        $locations = get_posts(array(
            'post_type' => 'ghc_location',
            'order'     => 'ASC',
            'orderby'   => 'title',
            'posts_per_page'    => '-1',
        ));
        foreach ($locations as $location) {
            echo '<option value='. $location->ID, $selected == $location->ID ? ' selected="selected"' : '','>' . $location->post_title .'</option>';
        }

    }

}

new GHCPostTypeLocationPage;


function ghc_get_location_pages( $location_id ) {
    $posts = get_posts( array(
        'post_type'         => 'ghc_location_page',
        'posts_per_page'    => '-1',
        'orderby'           => 'menu_order',
        'order'             => 'ASC',
        'meta_query'        => array(
            'relation'      => 'AND',
            array(
                'key'       => 'ghc_location_page_show_in_menu',
                'value'     => '1',
                'compare'   => '=',
            ),
            array(
                'key'       => 'ghc_location_page_location_id',
                'value'     => $location_id,
                'compare'   => '='
            ),
        ),
    ) );

    return $posts;
}

function ghc_get_featured_location_pages( $location_id ) {
    $posts = get_posts( array(
        'post_type'         => 'ghc_location_page',
        'posts_per_page'    => '-1',
        'orderby'           => 'menu_order',
        'order'             => 'ASC',
        'meta_query'        => array(
            'relation'      => 'AND',
            array(
                'key'       => 'ghc_location_page_featured_block',
                'value'     => '1',
                'compare'   => '=',
            ),
            array(
                'key'       => 'ghc_location_page_location_id',
                'value'     => $location_id,
                'compare'   => '='
            ),
        ),
    ) );

    return $posts;
}
