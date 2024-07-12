<?php

namespace Framework\Http\Controllers;
use Framework\Http\Response;
use Framework\Http\Request;

class HomeController {
	
	public function index(Request $request): Response {
		return new Response(__FUNCTION__);
	}

}
