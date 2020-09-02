<?php

namespace App;

class DB {
	private static $instance;

	private function __construct() {
	}

	public static function getInstance() {
		if ( isset( self::$instance ) == false ) {
			self::$instance = new self;
		}

		self::$instance->startDB();

		return self::$instance;
	}

	public function startDB() {
		$a_config = include APP_PATH . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'DB.php';

		self::$instance = new Classes\SafeMySQL(
			[
				'host' => $a_config[ 's_host' ],
				'user' => $a_config[ 's_user' ],
				'pass' => $a_config[ 's_password' ],
				'db' => $a_config[ 's_dbname' ],
				'charset' => $a_config[ 's_charset' ]
			]
		);
	}
}