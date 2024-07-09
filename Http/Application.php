<?php

namespace Framework\Http;
use Framework\Route\Routing;
use Framework\Http\Controllers\HomeController;
use Framework\Database\Connection\ConnectionString;
use Framework\Http\Middleware\Middleware;

class Application {
	private Request $request;
	private Routing $routing;

	public function __construct(Routing $routing){
		$this->routing = $routing;
	}

	public function handle(Request $request) {
		$this->request = $request;

		foreach($this->routing->routes as $route) {
			$match = $this->routing->matches($route['uri'], $this->request->uri);
			if ($route['method'] === $this->request->method) {
				if ($match or $route['uri'] === $this->request->uri) {
					Middleware::HandleAll($this->request);
					$route['controller'][0] = new $route['controller'][0]();
					$callable = call_user_func($route['controller'],$this->request,$match);
					return print($callable->template());					
				} 
			}

			// if ($match or $route['uri'] === $this->request->uri && ($route['method'] != $this->request->uri))
			// 	return $this->routing->dispatchMethodNotAllowed();
		}
		return $this->routing->dispatchNotFound();

	}
}