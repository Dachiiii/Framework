<?php

use Framework\Route\Routing;
use Framework\Http\Controllers\HomeController;

return [
	['GET', '/', [HomeController::class,'index']],
	['POST','/',[HomeController::class,'post']],
];