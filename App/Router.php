<?php

namespace App;

class Router {
	public function parse() {
		$i_pos = strpos( $_SERVER[ 'REQUEST_URI' ], '?' );
		if ( $i_pos !== false ) {
			$s_route = substr( $_SERVER[ 'REQUEST_URI' ], 0, $i_pos );
		}

		if ( isset( $s_route ) == false ) {
			$s_route = $_SERVER[ 'REQUEST_URI' ];
		}

		$a_route = explode( '/', $s_route );
		array_shift( $a_route );

		$a_result = [
			array_shift( $a_route ),
			implode( '', $a_route ),
			$a_route
		];

		return $a_result;
	}

	public function redirect( $fs_path ) {
		header( 'Location: ' . $fs_path );
		die();
	}

	public function redirectBack() {
		$s_path = $_SERVER[ 'HTTP_REFERER' ];
		header( 'Location: ' . $s_path );
		die();
	}
}