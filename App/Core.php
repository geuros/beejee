<?php

namespace App;

use App;

class Core {
	public $s_default_controller = 'Home';

	public $s_default_action = 'index';

	public function launch() {
		list( $s_controller_name, $s_action_name, $a_params ) = App::$o_router->parse();

		echo $this->launchAction( $s_controller_name, $s_action_name, $a_params );
	}

	public function launchAction( $fs_controller_name, $fs_action_name, $fa_params ) {
		if ( empty( $fs_controller_name ) ) {
			$fs_controller_name = $this->s_default_controller;
		} else {
			$fs_controller_name = ucfirst( $fs_controller_name );
		}

		$s_controller_file = APP_PATH . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $fs_controller_name . '.php';
		if ( file_exists( $s_controller_file ) == false ) {
			throw new \Exception( 'Controller File is not exist.' );
		}

		require_once $s_controller_file;

		$fs_controller_name = '\\App\\Controllers\\' . ucfirst( $fs_controller_name );
		if ( class_exists( $fs_controller_name ) == false ) {
			throw new \Exception( 'Controller Class is not exist.' );
		}

		$o_controller = new $fs_controller_name;

		if ( empty( $fs_action_name ) ) {
			$fs_action_name = $this->s_default_action;
		}

		if ( method_exists( $o_controller, $fs_action_name ) == false ) {
			throw new \Exception( 'Controller Action is not exist.' );
		}

		return $o_controller->$fs_action_name( $fa_params );
	}
}