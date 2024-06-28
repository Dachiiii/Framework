<?php

namespace Framework\Route;
use Framework\Http\Response;

class Routing {
	
	public array $routes;

	public function route() {
		$routing = include_once "web.php";
		foreach($routing as $route) {
			$this->routes[] = [
				'method' => $route[0],
				'uri' => $route[1],
				'controller' => $route[2],
			];
		}
	}
	public function matches($route, $url) {
		$variables = [];
		$pattern = "/{[a-zA-Z]+}/";
		$found = [];
		preg_match_all($pattern, $route, $found);
		$u = explode('/', $url);
		$r = explode('/', $route);
		if ($found[0] && (count($u)==count($r))) {
			foreach($found[0] as $f) {
				foreach($r as $index => $i) {
					if ($i === $f) {
						$var = '';
						preg_match("/[a-zA-Z]+/", $f, $var);
						$variables[$var[0]] = $u[$index];
						$r[$index] = $u[$index];
					}
				$route = implode('/',$r);
				}
			}
			if (!in_array('', $variables))
				return $variables;
		}
		return false;
	}
	public function dispatchNotFound() {
		http_response_code(404);
		return Response::dispatch(__FUNCTION__);
	}
	public function dispatchMethodNotAllowed() {
		http_response_code(405);
		return Response::dispatch(__FUNCTION__);
	}
}