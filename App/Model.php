<?php

namespace App;

class Model {
	public function getSession() {
		return \App::$o_session;
	}

	public function getRouter() {
		return \App::$o_router;
	}
}