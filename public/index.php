<?php
define( 'BASE_PATH', dirname( __DIR__ ) );
define( 'APP_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'App' );

require APP_PATH . '/App.php';

App::init();
App::$o_core->launch();