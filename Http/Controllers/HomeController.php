<?php

namespace Framework\Http\Controllers;
use Framework\Http\Response;
use Framework\Http\Request;
use Framework\Database\Connection\MysqlConnection;
use Framework\Database\Connection\ConnectionString;
use Framework\App\Models\User;
use Framework\Validation\UserValidation;

class HomeController {
	
	public function index(Request $request): Response {
		return new Response(__FUNCTION__);
	}

}