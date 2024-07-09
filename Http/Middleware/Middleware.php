<?php

namespace Framework\Http\Middleware;
use Framework\Http\Request;

class Middleware {

	public static function HandleAll(Request $request) {
		$model = new static();
		foreach ($model->middlewares() as $middleware) {;
			$object = new $middleware;
			$object->handle($request);
		}
		return static::class;
	}

	public static function middlewares() {
		return [
			CSRFMiddleware::class
		];
	}
}