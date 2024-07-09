<?php

namespace Framework\Http\Middleware;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Http\Controllers\HomeController;

class CSRFMiddleware {

	public function handle(Request $request) {
		if ($request->method == 'POST') {
			require_once BASE_PATH . '/helpers.php';
			secure();
		}
	}
}