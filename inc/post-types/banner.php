<?php

/*
 * Location Post Type, Corresponding Taxonomies and Meta
 */
class GHCPostTypeBanner extends GHCPostType {

    /*
     * Slug: cannot be changed once posts have been created
     * Sets: the post type key and the taxonomy and post meta namespace
     */
    public $slug = 'ghc_banner';
    public $name = 'Banner';
    public $name_plural = 'Banners';

    public $meta_boxes = array(
        array(
            'slug'      => 'content',
            'name'      => 'Content',
            'context'   => 'normal',
            'priority'  => 'high',
            'fields'    => array(
                array(
                    'name'  => 'image_wide',
                    'label' => 'Wide Image',
                    'type'  => 'image',
                    'width' => 100,
                ),
                array(
                    'name'  => 'image_narrow',
                    'label' => 'Narrow Image',
                    'type'  => 'image',
                    'width' => 100,
                ),
                array(
                    'name'  => 'headline',
                    'label' => 'Headline',
                    'type'  => 'text',
                    'width' => 100,
                ),
                array(
                    'name'  => 'subtitle',
                    'label' => 'Subtitle',
                    'type'  => 'text',
                    'width' => 100,
                ),
                array(
                    'name'  => 'url',
                    'label' => 'URL',
                    'type'  => 'url',
                    'width' => 70,
                ),
                array(
                    'name'  => 'url_target_blank',
                    'label' => 'Open in New Window',
                    'type'  => 'boolean',
                    'width' => 30,
                ),
            ),
        ),
        array(
            'slug'      => 'settings',
            'name'      => 'Display Settings',
            'context'   => 'normal',
            'priority'  => 'high',
            'fields'    => array(
                array(
                    'name'  => 'date_display_start',
                    'label' => 'Display Start',
                    'type'  => 'date',
                    'width' => 50,
                ),
                array(
                    'name'  => 'date_display_end',
                    'label' => 'Display End',
                    'type'  => 'date',
                    'width' => 50,
                ),
                array(
                    'name'  => 'locations',
                    'label' => 'Location Pages',
                    'type'  => 'multiselect-posts',
                    'post_type' => 'ghc_location',
                    'width' => 100,
                )
            ),
        ),
    );

	public function __construct() {

        add_action( 'init', array( $this, 'register_post_type'), 1 );

		if ( is_admin() ) {

            wp_enqueue_media();

            // Metaboxes
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );

            // Admin Columns
            //add_filter( 'manage_' . $this->slug . '_posts_columns', array( $this, 'add_admin_columns' ) );
            //add_action( 'manage_' . $this->slug . '_posts_custom_column' , array( $this, 'add_admin_columns_data' ), 10, 2 );
            //add_filter( 'manage_edit-' . $this->slug . '_sortable_columns', array( $this, 'make_admin_columns_sortable' ) );
            //add_action( 'load-edit.php', array( $this, 'add_admin_columns_sort_request' ) );
            //add_filter('manage_posts_columns', array( $this, 'do_column_order' ) );

            add_action( 'admin_init', array($this, 'admin_remove_date_filter') );

		}

    }

    function register_post_type() {
        /*
         * https://codex.wordpress.org/Function_Reference/register_post_type
        **/
        register_post_type(
            $this->slug,
            array(
                'label'                 => __( 'Banner', 'ghc' ),
                'description'           => __( 'Banners for a specific location', 'ghc' ),
                'supports'              => array( 'title', ),
                'taxonomies'            => array(),
                'hierarchical'          => false,
                'public'                => false,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 6,
                'menu_icon'             => 'dashicons-megaphone',
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'show_in_rest'          => false, /* true: enables the gutenburg block editor */
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'page',
                'rewrite'               => array(
                    'slug'              => 'locations/%ghc_location%',
                    'with_front'        => false
                ), /* https://codex.wordpress.org/Function_Reference/register_post_type#rewrite */
                'labels'                => array(
                    'name'                  => _x( 'Banners', 'Banner General Name', 'ghc' ),
                    'singular_name'         => _x( 'Banner', 'Banner Singular Name', 'ghc' ),
                    'menu_name'             => __( 'Banners', 'ghc' ),
                    'name_admin_bar'        => __( 'Banner', 'ghc' ),
                    'archives'              => __( 'Banner Archives', 'ghc' ),
                    'attributes'            => __( 'Banner Attributes', 'ghc' ),
                    'parent_item_colon'     => __( 'Parent Banner:', 'ghc' ),
                    'all_items'             => __( 'All Banners', 'ghc' ),
                    'add_new_item'          => __( 'Add New Banner', 'ghc' ),
                    'add_new'               => __( 'Add New', 'ghc' ),
                    'new_item'              => __( 'New Banner', 'ghc' ),
                    'edit_item'             => __( 'Edit Banner', 'ghc' ),
                    'update_item'           => __( 'Update Banner', 'ghc' ),
                    'view_item'             => __( 'View Banner', 'ghc' ),
                    'view_items'            => __( 'View Banners', 'ghc' ),
                    'search_items'          => __( 'Search Banner', 'ghc' ),
                    'not_found'             => __( 'Not found', 'ghc' ),
                    'not_found_in_trash'    => __( 'Not found in Trash', 'ghc' ),
                    'featured_image'        => __( 'Featured Image', 'ghc' ),
                    'set_featured_image'    => __( 'Set featured image', 'ghc' ),
                    'remove_featured_image' => __( 'Remove featured image', 'ghc' ),
                    'use_featured_image'    => __( 'Use as featured image', 'ghc' ),
                    'insert_into_item'      => __( 'Insert into banner', 'ghc' ),
                    'uploaded_to_this_item' => __( 'Uploaded to this banner', 'ghc' ),
                    'items_list'            => __( 'Banners list', 'ghc' ),
                    'items_list_navigation' => __( 'Banners list navigation', 'ghc' ),
                    'filter_items_list'     => __( 'Filter banners list', 'ghc' ),
                ),
            )
        );

    }

    public function get_banners( $args = array() ) {
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

new GHCPostTypeBanner;
