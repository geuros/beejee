<?php

class App {
	public static $o_router;

	public static $o_db;

	public static $o_core;

	public static $o_session;

	public static function init() {
		spl_autoload_register( [ 'static', 'loadClass' ] );
		static::bootstrap();
	}

	public static function bootstrap() {
		static::$o_router = new App\Router;
		static::$o_core = new App\Core;
		static::$o_db = App\DB::getInstance();
		static::$o_session = App\Session::getInstance();
	}

	public static function loadClass( $fs_class_name ) {
		$fs_class_name = str_replace( '\\', DIRECTORY_SEPARATOR, $fs_class_name );
		require_once BASE_PATH . DIRECTORY_SEPARATOR . $fs_class_name . '.php';
	}
}