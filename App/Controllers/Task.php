<?php

namespace App\Controllers;

class Task extends \App\Controller {
	public function sort() {
		$b_success = true;
		$a_messages = [];

		if ( empty( $_GET[ 's_field' ] ) ) {
			$a_messages[] = [ 'danger', 'Empty Sort Column.' ];

			$b_success = false;
		}

		if ( empty( $b_success ) ) {
			$this->getSession()->a_messages = $a_messages;

			return $this->getRouter()->redirectBack();
		}

		$s_sort_dir = $this->getSession()->s_sort_dir;
		if ( $s_sort_dir == 'DESC' ) {
			$s_sort_dir = 'ASC';
		} else {
			$s_sort_dir = 'DESC';
		}

		$this->getSession()->s_sort_dir = $s_sort_dir;

		$this->getSession()->s_sort_field = $_GET[ 's_field' ];

		return $this->getRouter()->redirectBack();
	}

	public function add() {
		$b_success = true;
		$a_messages = [];

		if ( empty( $_POST ) ) {
			$a_messages[] = [ 'danger', 'Empty Request Data.' ];

			$b_success = false;
		}

		$this->getSession()->a_form_data = $_POST;

		if ( $b_success ) {
			$a_required_fields = [
				's_user_name' => 'User Name',
				's_email' => 'Email',
				's_text' => 'Text'
			];

			foreach ( $a_required_fields as $s_name => $s_label ) {
				if ( empty( $_POST[ $s_name ] ) ) {
					$a_messages[] = [ 'danger', $s_label . ' field is required.' ];

					$b_success = false;
				}
			}
		}

		if (
			$b_success
			and
			empty( filter_var( $_POST[ 's_email' ], FILTER_VALIDATE_EMAIL ) )
		) {
			$a_messages[] = [ 'danger', 'Wrong Email Address.' ];

			$b_success = false;
		}

		if ( empty( $b_success ) ) {
			$this->getSession()->a_messages = $a_messages;

			return $this->getRouter()->redirectBack();
		}

		$o_task_model = new \App\Models\Task();

		$o_task_model->store( $_POST );

		unset( $this->getSession()->a_form_data );

		return $this->getRouter()->redirectBack();
	}

	public function edit() {
		$b_success = true;
		$a_messages = [];

		if ( empty( $this->getSession()->auth ) ) {
			$b_success = false;

			$a_messages[] = [ 'danger', 'No access to edit task. Please Login.' ];
		}

		if ( empty( $_POST ) ) {
			$a_messages[] = [ 'danger', 'Empty Request Data.' ];

			$b_success = false;
		}

		if ( empty( $b_success ) ) {
			$this->getSession()->a_messages = $a_messages;

			return $this->getRouter()->redirectBack();
		}

		$o_task_model = new \App\Models\Task();
		$a_task = $o_task_model->get( $_POST[ 'i_id' ] );

		if ( $_POST[ 's_task' ] == 'toggle_status' ) {
			$_POST[ 'b_complete' ] = $a_task[ 'b_complete' ] * -1 + 1;
		} else {
			if ( $a_task[ 's_text' ] != $_POST[ 's_text' ] ) {
				$_POST[ 'b_edited' ] = 1;
			}
		}

		$o_task_model->save( $_POST );

		return $this->getRouter()->redirectBack();
	}
}