<?php


class GHC_Walker_Nav_Menu_Checkbox extends Walker_Nav_Menu {
    function start_el ( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $force_label = isset( $args->walker_force_label ) && ! $args->walker_force_label ? false : true;

        if ( ! $force_label && in_array( 'menu-item-has-children', $item->classes ) ) {
            $classes[] = 'menu-item--has-toggle';
        }

        $namespace = isset( $args->walker_namespace ) ? $args->walker_namespace : false;

        $item_name = $item->object_id;
        if ( $namespace ) {
            $item_name .= '-' . $namespace;
        }

        /**
         * Filters the arguments for a single nav menu item.
         *
         * @since 4.4.0
         *
         * @param stdClass $args  An object of wp_nav_menu() arguments.
         * @param WP_Post  $item  Menu item data object.
         * @param int      $depth Depth of menu item. Used for padding.
         */
        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

        /**
         * Filters the CSS class(es) applied to a menu item's list item element.
         *
         * @since 3.0.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array    $classes The CSS classes that are applied to the menu item's `<li>` element.
         * @param WP_Post  $item    The current menu item.
         * @param stdClass $args    An object of wp_nav_menu() arguments.
         * @param int      $depth   Depth of menu item. Used for padding.
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        /**
         * Filters the ID applied to a menu item's list item element.
         *
         * @since 3.0.1
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
         * @param WP_Post  $item    The current menu item.
         * @param stdClass $args    An object of wp_nav_menu() arguments.
         * @param int      $depth   Depth of menu item. Used for padding.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';


        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : esc_attr( apply_filters( 'the_title', $item->title, $item->ID ) );
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        /**
         * Filters the HTML attributes applied to a menu item's anchor element.
         *
         * @since 3.6.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         *     @type string $title  Title attribute.
         *     @type string $target Target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param WP_Post  $item  The current menu item.
         * @param stdClass $args  An object of wp_nav_menu() arguments.
         * @param int      $depth Depth of menu item. Used for padding.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $is_hash_link = false;
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( $attr === 'href' && $value === '#' ) {
                $is_hash_link = true;
                continue;
            }
            else if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        /** This filter is documented in wp-includes/post-template.php */
        $title = apply_filters( 'the_title', $item->title, $item->ID );

        /**
         * Filters a menu item's title.
         *
         * @since 4.4.0
         *
         * @param string   $title The menu item's title.
         * @param WP_Post  $item  The current menu item.
         * @param stdClass $args  An object of wp_nav_menu() arguments.
         * @param int      $depth Depth of menu item. Used for padding.
         */
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        $item_output = $args->before;

        if ( is_array( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {
            $item_output .= '<input id="menu-item-submenu-control-' . $item_name . '" type="checkbox" name="menu-item-submenu-control" value="' . $item->object_id . '" aria-hidden="true" autocomplete="off" ';
            /*
            if ( $depth == 0 ) {
                $item_output .= ' checked ';
            }
            */
            $item_output .= '>';
            //$item_output .= '<input id="menu-item-submenu-control-' . $item->object_id . '-radio" type="radio" name="menu-item-submenu-control" value="' . $item->object_id . '" aria-hidden="true" autocomplete="off" ';
            //$item_output .= '>';
            //$item_output .= '<label class="menu-item-toggle" for="menu-item-submenu-control-' . $item->object_id . '"><i></i></label>';
        }
        $tag = $is_hash_link ? 'label' : 'a';
        $item_output .= '<' . $tag . $attributes;
        if ( $is_hash_link ) {
            $item_output .= ' for="menu-item-submenu-control-' . $item_name . '" ';
        }
        /*if ( $depth != 0 || in_array( 'menu-item-has-children', $item->classes ) ) {
            $thumbnail_id = get_woocommerce_term_meta( $item->object_id, 'thumbnail_id', true );
            $item_image = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
            $item_image_url = $item_image[0];
            $item_output .= ' data-preload="' . $item_image_url . '" data-preload-media-query="(min-width: 48em)" data-menu-image="' . $item_image_url . '" data-menu-text="' . $title . '" data-menu-id="' . $item->object_id . '"';
        }*/
        $item_output .= ' tabindex="0">';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</' . $tag . '>';
        if ( is_array( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {
        $item_output .= '<label class="menu-item-toggle" for="menu-item-submenu-control-' . $item_name . '"><i></i></label>';
        }
        $item_output .= $args->after;


        /**
         * Filters a menu item's starting output.
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since 3.0.0
         *
         * @param string   $item_output The menu item's starting HTML output.
         * @param WP_Post  $item        Menu item data object.
         * @param int      $depth       Depth of menu item. Used for padding.
         * @param stdClass $args        An object of wp_nav_menu() arguments.
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        if ( is_array( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {
            $item_output = "\n</div>\n";
        }
        $output .= "</li>{$n}";
    }
}


class GHC_Walker_Nav_Menu_Radio extends Walker_Nav_Menu {
    function start_el ( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        /**
         * Filters the arguments for a single nav menu item.
         *
         * @since 4.4.0
         *
         * @param stdClass $args  An object of wp_nav_menu() arguments.
         * @param WP_Post  $item  Menu item data object.
         * @param int      $depth Depth of menu item. Used for padding.
         */
        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

        /**
         * Filters the CSS class(es) applied to a menu item's list item element.
         *
         * @since 3.0.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array    $classes The CSS classes that are applied to the menu item's `<li>` element.
         * @param WP_Post  $item    The current menu item.
         * @param stdClass $args    An object of wp_nav_menu() arguments.
         * @param int      $depth   Depth of menu item. Used for padding.
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        /**
         * Filters the ID applied to a menu item's list item element.
         *
         * @since 3.0.1
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
         * @param WP_Post  $item    The current menu item.
         * @param stdClass $args    An object of wp_nav_menu() arguments.
         * @param int      $depth   Depth of menu item. Used for padding.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        /*if ( $item->object_id == 6905 ) {
            $output .= '<textarea style="position: fixed;bottom:1em;right:1em;z-index:1000;">' . json_encode($item) . '</textarea>';
        }*/

        $output .= $indent . '<li' . $id . $class_names .'>';




        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : esc_attr( apply_filters( 'the_title', $item->title, $item->ID ) );
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

        /**
         * Filters the HTML attributes applied to a menu item's anchor element.
         *
         * @since 3.6.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         *     @type string $title  Title attribute.
         *     @type string $target Target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param WP_Post  $item  The current menu item.
         * @param stdClass $args  An object of wp_nav_menu() arguments.
         * @param int      $depth Depth of menu item. Used for padding.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $is_hash_link = false;
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ( $attr === 'href' && $value === '#' || ( is_array( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) && $depth == 0 ) ) {
                $is_hash_link = true;
                continue;
            }
            else if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        /** This filter is documented in wp-includes/post-template.php */
        $title = apply_filters( 'the_title', $item->title, $item->ID );

        /**
         * Filters a menu item's title.
         *
         * @since 4.4.0
         *
         * @param string   $title The menu item's title.
         * @param WP_Post  $item  The current menu item.
         * @param stdClass $args  An object of wp_nav_menu() arguments.
         * @param int      $depth Depth of menu item. Used for padding.
         */
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        $item_output = $args->before;

        $input_id = 'menu-item-submenu-control-' . $item->object_id . '-radio-depth-' . $depth;
        $input_name = 'primary-menu-item-submenu-control-depth-' . $depth;
        if ( $depth > 0 ) {
            $input_id .= '-' . $item->menu_item_parent;
            $input_name .= '-' . $item->menu_item_parent;
        }


        if ( is_array( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {
            $item_output .= '<input id="' . $input_id . '" type="radio" name="' . $input_name . '" value="' . $item->object_id . '" aria-hidden="true" autocomplete="off" ';
            if ( $depth > 0 && is_array( $item->classes ) && in_array('is-auto-expand', $item->classes ) ) {
                $item_output .= ' checked ';
            }
            $item_output .= '>';
            //$item_output .= '<label class="menu-item-toggle" for="menu-item-submenu-control-' . $item->object_id . '"><i></i></label>';
        }
        $tag = $is_hash_link ? 'label' : 'a';
        $item_output .= '<' . $tag . $attributes;
        if ( $is_hash_link ) {
            $item_output .= ' for="' . $input_id . '" ';
        }
        /*if ( $depth != 0 || in_array( 'menu-item-has-children', $item->classes ) ) {
            $thumbnail_id = get_woocommerce_term_meta( $item->object_id, 'thumbnail_id', true );
            $item_image = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
            $item_image_url = $item_image[0];
            $item_output .= ' data-preload="' . $item_image_url . '" data-preload-media-query="(min-width: 48em)" data-menu-image="' . $item_image_url . '" data-menu-text="' . $title . '" data-menu-id="' . $item->object_id . '"';
        }*/
        $item_output .= ' tabindex="0">';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</' . $tag . '>';
        if ( is_array( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) && $depth < 1 ) {
            $item_output .= '<label class="menu-close" for="primary-menu-item-submenu-control-null">' . $args->link_before . $title . $args->link_after . '</label>';
        }
        if ( is_array( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {
        $item_output .= '<label class="menu-item-toggle" for="menu-item-submenu-control-' . $item->object_id . '-radio-depth-' . $depth . '"><i></i></label>';
        }
        $item_output .= $args->after;


        /**
         * Filters a menu item's starting output.
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since 3.0.0
         *
         * @param string   $item_output The menu item's starting HTML output.
         * @param WP_Post  $item        Menu item data object.
         * @param int      $depth       Depth of menu item. Used for padding.
         * @param stdClass $args        An object of wp_nav_menu() arguments.
         */
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        if ( is_array( $item->classes ) && in_array( 'menu-item-has-children', $item->classes ) ) {
            $item_output = "\n</div>\n";
        }
        $output .= "</li>{$n}";
    }
}
