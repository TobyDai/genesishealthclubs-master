<?php


if ( ! function_exists( 'ghc_get_class_instances' ) ) {
	function ghc_get_class_instances( $class_id, $args = array() ) {
		$class = new GHCPostTypeClass;
		$instances = $class->get_class_instances( $class_id, $args );
		return $instances;
	}
}

if ( ! function_exists( 'ghc_get_class_instance_session_list_item' ) ) {
	function ghc_get_class_instance_session_list_item( $class_instance_id, $args = array() ) {
		$class = new GHCPostTypeClass;
		return '<li><label>' . date( 'D', strtotime('Sunday +' .get_post_meta( $class_instance_id, 'ghc_class_instance_weekday', true ) . ' days' ) ) . '</label><span><time>' . $class->get_class_instance_display_hours( $class_instance_id, $args ) . '</time></span></li>';
	}
}

if ( ! function_exists( 'ghc_get_class_instance_session_list' ) ) {
	function ghc_get_class_instance_session_list( $class_instances, $args = array() ) {
		$class = new GHCPostTypeClass;
		ob_start();
		?>
		<ul class="list-hours">
			<?php for ( $i = 0; $i < count( $class_instances ); $i++ ) : ?>
				<?php
				if (
					$i === 0
					||
					get_post_meta( $class_instances[$i]->ID, 'ghc_class_instance_weekday', true ) != get_post_meta( $class_instances[$i-1]->ID, 'ghc_class_instance_weekday', true )

				) :
				$day_label = date( 'D', strtotime('Sunday +' . get_post_meta( $class_instances[$i]->ID, 'ghc_class_instance_weekday', true ) . ' days' ) );
				?>
				<li<?php echo ( $day_label == date('D') ? ' class="is-active" ' : '' ); ?>><label><?php echo $day_label; ?></label>
				<span>
				<?php endif; ?>
				<time><?php echo $class->get_class_instance_display_hours( $class_instances[$i]->ID, $args ); ?></time>
				<?php
				if (
					get_post_meta( $class_instances[$i]->ID, 'ghc_class_instance_weekday', true ) != get_post_meta( $class_instances[$i+1]->ID, 'ghc_class_instance_weekday', true )

				) :
				?>
				</span>
				</li>
				<?php endif; ?>
			<?php endfor; ?>
		</ul>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'ghc_get_location_classes_today' ) ) {
	function ghc_get_location_classes_today( $location_id ) {
		$class = new GHCPostTypeClass;
		$class_instances = $class->get_class_instances(0, array('location' => $location_id, 'weekday' => date('N') ) );
		return $class_instances;
	}
}
if ( ! function_exists( 'ghc_get_location_classes_by_date' ) ) {
	function ghc_get_location_classes_by_date( $location_id, $datestring ) {
		$class = new GHCPostTypeClass;
		$class_instances = $class->get_class_instances(0, array('location' => $location_id, 'weekday' => date('N', strtotime( $datestring ) ) ) );
		return $class_instances;
	}
}

if ( ! function_exists( 'ghc_get_class_instance_class_id' ) ) {
	function ghc_get_class_instance_class_id( $class_instance_id ) {
		return get_post_meta( $class_instance_id, 'ghc_class_instance_class_id', true );
	}
}
if ( ! function_exists( 'ghc_get_class_instance_class_title' ) ) {
	function ghc_get_class_instance_class_title( $class_instance_id ) {
		return get_the_title( ghc_get_class_instance_class_id( $class_instance_id ) );
	}
}
if ( ! function_exists( 'ghc_get_class_instance_display_hours' ) ) {
	function ghc_get_class_instance_display_hours( $class_instance_id ) {
		$class = new GHCPostTypeClass;
		return $class->get_class_instance_display_hours( $class_instance_id );
	}
}
if ( ! function_exists( 'ghc_get_class_instance_display_hours_start' ) ) {
	function ghc_get_class_instance_display_hours_start( $class_instance_id ) {
		$class = new GHCPostTypeClass;
		return $class->format_hours( get_post_meta( $class_instance_id, 'ghc_class_instance_start_time', true ) );
	}
}
if ( ! function_exists( 'ghc_get_class_instance_instructor' ) ) {
	function ghc_get_class_instance_instructor( $class_instance_id ) {
		return get_post_meta( $class_instance_id, 'ghc_class_instance_instructor', true );
	}
}
if ( ! function_exists( 'ghc_get_class_instance_studio_name' ) ) {
	function ghc_get_class_instance_studio_name( $class_instance_id ) {
		$term = get_term( get_post_meta( $class_instance_id, 'ghc_class_instance_studio', true ) );
        if ( ! preg_match( '/pool/i', $term->name) ) {
            return _e('Studio', 'ghc') . ' ' . $term->name;
        }
		return $term->name;
	}
}
