<?php

/*
 * FAQ Post Type, Corresponding Taxonomies and Meta
 */
class GHCPostTypeFAQ extends GHCPostType {

    /*
     * Slug: cannot be changed once posts have been created
     * Sets: the post type key and the taxonomy and post meta namespace
     */
    public $slug = 'ghc_faq';

    public $meta_boxes = array();

	public function __construct() {

        add_action( 'init', array( $this, 'register_post_type'), 0 );
        // add_action( 'init', array( $this, 'register_taxonomy_market' ), 0 );

		if ( is_admin() ) {
            // Metaboxes
			add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

    }

    function register_post_type() {

        /*
         * https://codex.wordpress.org/Function_Reference/register_post_type
         */
        $labels = array(
            'name'                  => _x( 'FAQs', 'FAQ General Name', 'ghc' ),
            'singular_name'         => _x( 'FAQ', 'FAQ Singular Name', 'ghc' ),
            'menu_name'             => __( 'FAQs', 'ghc' ),
            'name_admin_bar'        => __( 'FAQ', 'ghc' ),
            'archives'              => __( 'FAQ Archives', 'ghc' ),
            'attributes'            => __( 'FAQ Attributes', 'ghc' ),
            'parent_item_colon'     => __( 'Parent FAQ:', 'ghc' ),
            'all_items'             => __( 'All FAQs', 'ghc' ),
            'add_new_item'          => __( 'Add New FAQ', 'ghc' ),
            'add_new'               => __( 'Add New', 'ghc' ),
            'new_item'              => __( 'New FAQ', 'ghc' ),
            'edit_item'             => __( 'Edit FAQ', 'ghc' ),
            'update_item'           => __( 'Update FAQ', 'ghc' ),
            'view_item'             => __( 'View FAQ', 'ghc' ),
            'view_items'            => __( 'View FAQs', 'ghc' ),
            'search_items'          => __( 'Search FAQ', 'ghc' ),
            'not_found'             => __( 'Not found', 'ghc' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'ghc' ),
            'featured_image'        => __( 'Featured Image', 'ghc' ),
            'set_featured_image'    => __( 'Set featured image', 'ghc' ),
            'remove_featured_image' => __( 'Remove featured image', 'ghc' ),
            'use_featured_image'    => __( 'Use as featured image', 'ghc' ),
            'insert_into_item'      => __( 'Insert into faq', 'ghc' ),
            'uploaded_to_this_item' => __( 'Uploaded to this faq', 'ghc' ),
            'items_list'            => __( 'FAQs list', 'ghc' ),
            'items_list_navigation' => __( 'FAQs list navigation', 'ghc' ),
            'filter_items_list'     => __( 'Filter faqs list', 'ghc' ),
        );
        $args = array(
            'label'                 => __( 'FAQ', 'ghc' ),
            'description'           => __( 'FAQ Description', 'ghc' ),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', ),
            'taxonomies'            => array(),
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 30,
            'menu_icon'             => 'dashicons-info',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'show_in_rest'          => false, /* true: enables the gutenburg block editor */
            'has_archive'           => true,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'rewrite'               => array( 'slug' => 'faqs' ) /* https://codex.wordpress.org/Function_Reference/register_post_type#rewrite */
        );

        register_post_type( $this->slug, $args );

    }

    public function register_taxonomy_market() {

        /*
         * https://codex.wordpress.org/Function_Reference/register_taxonomy
         */

        $labels = array(
            'name'                       => _x( 'Markets', 'Category General Name', 'ghc' ),
            'singular_name'              => _x( 'Market', 'Market Singular Name', 'ghc' ),
            'menu_name'                  => __( 'Market', 'ghc' ),
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
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => false,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => false,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy( $this->slug . '_market', array( $this->slug ), $args );

    }



    public function add_admin_columns( $columns ) {
        $columns['address_locality']  = 'City';
        $columns['address_region']  = 'State';
        $columns['postal_code']     = 'Post Code';

        return $columns;
    }

    public function add_admin_columns_data( $column, $post_id ) {
        switch ( $column ) {
            case 'address_locality':
                echo get_post_meta( $post_id, $this->slug . '_address_locality', true );
                break;
            case 'address_region':
                echo get_post_meta( $post_id, $this->slug . '_address_region', true );
                break;
            case 'postal_code':
                echo get_post_meta( $post_id, $this->slug . '_postal_code', true );
                break;
        }
    }

    public function make_admin_columns_sortable( $columns ) {
        $columns['address_locality'] = 'address_locality';
        $columns['address_region'] = 'address_region';
        $columns['postal_code'] = 'postal_code';

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



    /* TODO: Move this to the parent class. try to combine with the tax filter used in faq post type */
    public function add_admin_filters() {

        add_action( 'restrict_manage_posts', array($this, 'restrict_manage_posts') );
    }


    function restrict_manage_posts() {
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

    function generate_taxonomy_options($tax_slug, $parent = '', $level = 0,$selected = null) {
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


}

new GHCPostTypeFAQ;

function ghc_get_site_faq() {
	$faqs = get_posts(array(
		'post_type'			=> 'ghc_faq',
		'posts_per_page'	=> 1,
		'meta_query'		=> array(
			array(
				'key'	=> 'ghc_faq_start_date'
			),
			array(
				'key'		=> 'ghc_faq_page',
				'value'	=> '',
				'compare'		=> '='
			)
		)
	));

	$faq = isset( $faqs[0] ) ? $faqs[0] : false;

    if ( $faq && isset( $_COOKIE['ghc_dismiss_faq_' . $faq->ID ] ) ) {
        return false;
    }

	return $faq;
}

function ghc_has_site_faq() {
	return ghc_get_site_faq() ? true : false;
}

function ghc_get_page_faq( $post_id ) {
	$faqs = get_posts(array(
		'post_type'			=> 'ghc_faq',
		'posts_per_page'	=> 1,
		'meta_query'		=> array(
			array(
				'key'	=> 'ghc_faq_start_date'
			),
			array(
				'key'		=> 'ghc_faq_page',
				'value'	=> $post_id,
				'compare'		=> '='
			)
		)
	));

	$faq = isset( $faqs[0] ) ? $faqs[0] : false;

	return $faq;
}


function ghc_has_page_faq( $post_id ) {
	return ghc_get_page_faq( $post_id ) ? true : false;
}
