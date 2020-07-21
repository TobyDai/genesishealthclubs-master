<?php

/*
 * Employee Post Type, Corresponding Taxonomies and Meta
 */
class GHCPostTypeEmployee extends GHCPostType {

    /*
     * Slug: cannot be changed once posts have been created
     * Sets: the post type key and the taxonomy and post meta namespace
     */
    public $slug = 'ghc_employee';

    public $meta_boxes = array(
        array(
            'slug'      => 'profile',
            'name'      => 'Profile',
            'context'   => 'normal',
            'priority'  => 'high',
            'fields'    => array(
                array(
                    'name'  => 'first_name',
                    'label' => 'First Name',
                    'type'  => 'text',
                    'width' => 50,
                ),
                array(
                    'name'      => 'last_name',
                    'label'     => 'Last Name',
                    'type'      => 'gravityform',
                    'type'  => 'text',
                    'width' => 50,
                ),
                array(
                    'name'      => 'job_title',
                    'label'     => 'Title',
                    'type'      => 'text',
                    'width'     => 100
                ),
                array(
                    'name'      => 'email',
                    'label'     => 'Email',
                    'type'      => 'email',
                    'width'     => 100
                ),
                array(
                    'name'      => 'phone',
                    'label'     => 'Phone',
                    'type'      => 'tel',
                    'width'     => 80
                ),
                array(
                    'name'      => 'phone_extension',
                    'label'     => 'Ext.',
                    'type'      => 'text',
                    'width'     => 20
                ),
                array(
                    'name'      => 'bio',
                    'label'     => 'About',
                    'type'      => 'wysiwyg',
                    'width'     => 100
                ),
            )
        ),
        array(
            'slug'      => 'visibility',
            'name'      => 'Visibility',
            'context'   => 'normal',
            'priority'  => 'high',
            'fields'    => array(
                array(
                    'name'  => 'locations',
                    'label' => 'Locations',
                    'type'  => 'multiselect-posts',
                    'width' => 100,
                    'post_type' => 'ghc_location'
                ),
            )
        ),
    );

	public function __construct() {

        add_action( 'init', array( $this, 'register_post_type'), 0 );
        add_action( 'init', array( $this, 'register_taxonomies' ), 0 );

		if ( is_admin() ) {
            //add_action( 'admin_init', array($this, 'add_capabilities') );

            // Metaboxes
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );



            add_action( 'admin_menu', array( $this, 'modify_admin' ) );
		}
        else {
            add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
        }

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

        $role->add_cap( 'edit_employee' );
        $role->add_cap( 'read_employee' );
    }
    */
    public function register_post_type() {

        /*
         * https://codex.wordpress.org/Function_Reference/register_post_type
        **/
        register_post_type(
            $this->slug,
            array(
                'label'                 => __( 'Employee', 'ghc' ),
                'description'           => __( 'Employee Description', 'ghc' ),
                'supports'              => array( 'thumbnail' ),
                'taxonomies'            => array(),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 5,
                'menu_icon'             => 'dashicons-id',
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'show_in_rest'          => true, /* true: enables the gutenburg block editor */
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'page',
                /*'capabilities'          => array(
                    'edit_post'          => 'edit_employee',
                    'read_post'          => 'read_employee',
                    'delete_post'        => 'delete_employee',
                    'edit_posts'         => 'edit_employees',
                    'edit_others_posts'  => 'edit_others_employees',
                    'publish_posts'      => 'publish_employees',
                    'read_private_posts' => 'read_private_employees',
                    'create_posts'       => 'edit_employees',
                ),
                'map_meta_cap'          => true,*/
                'rewrite'               => array(
                    'slug'              => 'employees',
                    'with_front'        => false
                ), /* https://codex.wordpress.org/Function_Reference/register_post_type#rewrite */
                'labels'                => array(
                    'name'                  => _x( 'Employees', 'Employee General Name', 'ghc' ),
                    'singular_name'         => _x( 'Employee', 'Employee Singular Name', 'ghc' ),
                    'menu_name'             => __( 'Employees', 'ghc' ),
                    'name_admin_bar'        => __( 'Employee', 'ghc' ),
                    'archives'              => __( 'Employee Archives', 'ghc' ),
                    'attributes'            => __( 'Employee Attributes', 'ghc' ),
                    'parent_item_colon'     => __( 'Parent Employee:', 'ghc' ),
                    'all_items'             => __( 'All Employees', 'ghc' ),
                    'add_new_item'          => __( 'Add New Employee', 'ghc' ),
                    'add_new'               => __( 'Add New', 'ghc' ),
                    'new_item'              => __( 'New Employee', 'ghc' ),
                    'edit_item'             => __( 'Edit Employee', 'ghc' ),
                    'update_item'           => __( 'Update Employee', 'ghc' ),
                    'view_item'             => __( 'View Employee', 'ghc' ),
                    'view_items'            => __( 'View Employees', 'ghc' ),
                    'search_items'          => __( 'Search Employee', 'ghc' ),
                    'not_found'             => __( 'Not found', 'ghc' ),
                    'not_found_in_trash'    => __( 'Not found in Trash', 'ghc' ),
                    'featured_image'        => __( 'Featured Image', 'ghc' ),
                    'set_featured_image'    => __( 'Set featured image', 'ghc' ),
                    'remove_featured_image' => __( 'Remove featured image', 'ghc' ),
                    'use_featured_image'    => __( 'Use as featured image', 'ghc' ),
                    'insert_into_item'      => __( 'Insert into employee', 'ghc' ),
                    'uploaded_to_this_item' => __( 'Uploaded to this employee', 'ghc' ),
                    'items_list'            => __( 'Employees list', 'ghc' ),
                    'items_list_navigation' => __( 'Employees list navigation', 'ghc' ),
                    'filter_items_list'     => __( 'Filter employees list', 'ghc' ),
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
                    'name'                  => _x( 'Employee Hours', 'General Name', 'ghc' ),
                ),
            )
        );

    }

    public function register_taxonomies() {

        /*
         * https://codex.wordpress.org/Function_Reference/register_taxonomy
         */
        register_taxonomy(
             $this->slug . '_department',
             array( $this->slug ),
             array(
                 'hierarchical'               => false,
                 'public'                     => true,
                 'show_ui'                    => true,
                 'show_admin_column'          => false,
                 'show_in_nav_menus'          => true,
                 'show_tagcloud'              => false,
                 'rewrite'               => array(
                     'slug'              => 'departments',
                     'with_front'        => false
                 ), /* https://codex.wordpress.org/Function_Reference/register_post_type#rewrite */
                 'labels'                     => array(
                     'name'                       => _x( 'Departments', 'Category General Name', 'ghc' ),
                     'singular_name'              => _x( 'Department', 'Department Singular Name', 'ghc' ),
                     'menu_name'                  => __( 'Departments', 'ghc' ),
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


    public function get_employees( $args = array() ) {
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

new GHCPostTypeEmployee;

/*
$empController = new GHCPostTypeEmployee;
$employees = $empController->get_employees();
foreach ( $employees as $employee ) {
    $locations_list = get_post_meta($employee->ID, 'ghc_employee_locations_list', true);
    $locations = explode(',', $locations_list);
    foreach ( $locations as $location_id ) {
        update_post_meta($employee->ID, 'ghc_employee_locations_' . $location_id, '1' );
    }
    if ( isset( $_GET['debug'] ) ) {
        update_post_meta($employee->ID, 'ghc_employee_locations', '' );
    }
}
*/
