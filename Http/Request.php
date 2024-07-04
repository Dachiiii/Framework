<?php

namespace Framework\Http;

class Request {
	public array $request;
	public string $uri;
	public string $method;

	public function __construct() {
		$this->request = $_SERVER;
		$this->uri = $this->request['REQUEST_URI'];
		$this->method = $this->request['REQUEST_METHOD'];
	}

	public function POST() {
		return $_POST;
	}
}