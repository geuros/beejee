<?php

namespace App;

class Controller {
	public $s_body;

	public function renderLayout() {
		ob_start();
		require APP_PATH . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'Layout' . DIRECTORY_SEPARATOR . 'Layout.php';

		return ob_get_clean();
	}

	public function render( $fs_view_name, array $fa_params = [] ) {
		$s_view_file = APP_PATH . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $fs_view_name . '.php';

		extract( $fa_params );

		ob_start();
		require $s_view_file;
		$this->s_body = ob_get_clean();
		ob_end_clean();

		return $this->renderLayout();
	}

	public function getSession() {
		return \App::$o_session;
	}

	public function getRouter() {
		return \App::$o_router;
	}
}