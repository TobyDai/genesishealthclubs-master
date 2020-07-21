<?php

/*
 * Alert Post Type, Corresponding Taxonomies and Meta
 */
class GHCPostTypeAlert extends GHCPostType {

    /*
     * Slug: cannot be changed once posts have been created
     * Sets: the post type key and the taxonomy and post meta namespace
     */
    public $slug = 'ghc_alert';

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
                    'name'  => 'display_start',
                    'label' => 'Display Start',
                    'type'  => 'date',
                    'width' => 33
                ),
                array(
                    'name'  => 'display_end',
                    'label' => 'Display End',
                    'type'  => 'date',
                    'width' => 33
                ),
                array(
                    'name'  => 'auto_delete',
                    'label' => 'Delete after display end',
                    'type'  => 'boolean',
                    'width' => 33
                ),
                array(
                    'name'  => 'locations',
                    'label' => 'Location Pages',
                    'type'  => 'multiselect-posts',
                    'post_type' => 'ghc_location',
                    'width' => 100,
                )
            )
        ),
    );

	public function __construct() {

        add_action( 'init', array( $this, 'register_post_type'), 0 );

		if ( is_admin() ) {
            //add_action( 'admin_init', array($this, 'add_capabilities') );

            // Metaboxes
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );

		}

    }

    public function register_post_type() {

        /*
         * https://codex.wordpress.org/Function_Reference/register_post_type
        **/
        register_post_type(
            $this->slug,
            array(
                'label'                 => __( 'Alert', 'ghc' ),
                'description'           => __( 'Alert Description', 'ghc' ),
                'supports'              => array( 'title' ),
                'taxonomies'            => array(),
                'hierarchical'          => false,
                'public'                => false,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 5,
                'menu_icon'             => 'dashicons-info',
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'show_in_rest'          => true, /* true: enables the gutenburg block editor */
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'page',
                'rewrite'               => array(
                    'slug'              => 'alerts',
                    'with_front'        => false
                ), /* https://codex.wordpress.org/Function_Reference/register_post_type#rewrite */
                'labels'                => array(
                    'name'                  => _x( 'Alerts', 'Alert General Name', 'ghc' ),
                    'singular_name'         => _x( 'Alert', 'Alert Singular Name', 'ghc' ),
                    'menu_name'             => __( 'Alerts', 'ghc' ),
                    'name_admin_bar'        => __( 'Alert', 'ghc' ),
                    'archives'              => __( 'Alert Archives', 'ghc' ),
                    'attributes'            => __( 'Alert Attributes', 'ghc' ),
                    'parent_item_colon'     => __( 'Parent Alert:', 'ghc' ),
                    'all_items'             => __( 'All Alerts', 'ghc' ),
                    'add_new_item'          => __( 'Add New Alert', 'ghc' ),
                    'add_new'               => __( 'Add New', 'ghc' ),
                    'new_item'              => __( 'New Alert', 'ghc' ),
                    'edit_item'             => __( 'Edit Alert', 'ghc' ),
                    'update_item'           => __( 'Update Alert', 'ghc' ),
                    'view_item'             => __( 'View Alert', 'ghc' ),
                    'view_items'            => __( 'View Alerts', 'ghc' ),
                    'search_items'          => __( 'Search Alert', 'ghc' ),
                    'not_found'             => __( 'Not found', 'ghc' ),
                    'not_found_in_trash'    => __( 'Not found in Trash', 'ghc' ),
                    'featured_image'        => __( 'Featured Image', 'ghc' ),
                    'set_featured_image'    => __( 'Set featured image', 'ghc' ),
                    'remove_featured_image' => __( 'Remove featured image', 'ghc' ),
                    'use_featured_image'    => __( 'Use as featured image', 'ghc' ),
                    'insert_into_item'      => __( 'Insert into alert', 'ghc' ),
                    'uploaded_to_this_item' => __( 'Uploaded to this alert', 'ghc' ),
                    'items_list'            => __( 'Alerts list', 'ghc' ),
                    'items_list_navigation' => __( 'Alerts list navigation', 'ghc' ),
                    'filter_items_list'     => __( 'Filter alerts list', 'ghc' ),
                ),
            )
        );

    }

}

new GHCPostTypeAlert;
