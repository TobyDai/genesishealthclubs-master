<?php

if ( ! function_exists( 'ghc_get_employees' ) ) {
	function ghc_get_employees( $args = array() ) {
		$controller = new GHCPostTypeEmployee;
		$employees = $controller->get_employees( $args );
		return $employees;
	}
}

if ( ! function_exists( 'ghc_get_employees_by_location' ) ) {
	function ghc_get_employees_by_location( $location_id ) {
		return ghc_get_employees(array(
			'meta_query'	=> array(
				array(
					'key'	=> 'ghc_employee_locations_' . $location_id,
					'value'=> 1,
				)
			)
		));
	}
}

if ( ! function_exists( 'ghc_get_employee_name' ) ) {
    function ghc_get_employee_name( $employee_id ) {
        return get_post_meta( $employee_id, 'ghc_employee_first_name', true ) . ' ' . get_post_meta( $employee_id, 'ghc_employee_last_name', true );
    }
}

if ( ! function_exists( 'ghc_get_employee_job_title' ) ) {
    function ghc_get_employee_job_title( $employee_id ) {
        return get_post_meta( $employee_id, 'ghc_employee_job_title', true );
    }
}
