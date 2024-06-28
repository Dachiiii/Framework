<?php
function dd($dump) {
	echo "<pre>";
		var_dump($dump);
	echo "</pre>";
	exit();
}

require __DIR__ . '/../vendor/autoload.php';

define('BASE_PATH',dirname(__DIR__));

use Framework\Http\Application;
use Framework\Http\Request;
use Framework\Route\Routing;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

$request = new Request();

$route = new Routing();
$route->route();

$app = new Application($route);
$app->handle($request);