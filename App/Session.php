<?php

namespace App;

class Session {
	const SESSION_STARTED = true;
	const SESSION_NOT_STARTED = false;

	private $b_session_state = self::SESSION_NOT_STARTED;

	private static $instance;

	private function __construct() {
	}

	public static function getInstance() {
		if ( isset( self::$instance ) == false ) {
			self::$instance = new self;
		}

		self::$instance->startSession();

		return self::$instance;
	}

	public function startSession() {
		if ( $this->b_session_state == self::SESSION_NOT_STARTED ) {
			$this->b_session_state = session_start();
		}

		return $this->b_session_state;
	}

	public function __set( $name, $value ) {
		$_SESSION[ $name ] = $value;
	}

	public function __get( $name ) {
		if ( isset( $_SESSION[ $name ] ) ) {
			return $_SESSION[ $name ];
		}
	}

	public function __isset( $name ) {
		return isset( $_SESSION[ $name ] );
	}

	public function __unset( $name ) {
		unset( $_SESSION[ $name ] );
	}

	public function destroy() {
		if ( $this->b_session_state == self::SESSION_STARTED ) {
			$this->b_session_state = !session_destroy();
			unset( $_SESSION );

			return !$this->b_session_state;
		}

		return false;
	}
}