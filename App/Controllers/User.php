<?php

namespace App\Controllers;

class User extends \App\Controller {
	public function login() {
		if ( $this->getSession()->auth ) {
			return $this->getRouter()->redirect( '/' );
		}

		return $this->render( 'User/Login' );
	}

	public function logout() {
		if ( $this->getSession()->auth ) {
			unset( $this->getSession()->auth );

			return $this->getRouter()->redirect( '/' );
		}
	}

	public function loginSubmit() {
		if ( $this->getSession()->auth ) {
			return $this->getRouter()->redirect( '/' );
		}

		$b_success = true;
		$a_messages = [];

		if ( empty( $_POST ) ) {
			$a_messages[] = [ 'danger', 'Empty Request Data.' ];

			$b_success = false;
		}

		if (
			$_POST[ 's_login' ] != 'admin'
			or
			$_POST[ 's_password' ] != 123
		) {
			$a_messages[] = [ 'danger', 'Wrong Login/Password.' ];

			$b_success = false;
		}

		if ( empty( $b_success ) ) {
			$this->getSession()->a_messages = $a_messages;

			return $this->getRouter()->redirect( '/user/login' );
		}

		$this->getSession()->auth = true;

		$a_messages[] = [ 'success', 'Success Login.' ];

		$this->getSession()->a_messages = $a_messages;

		return $this->getRouter()->redirect( '/' );
	}
}