<?php

require __DIR__ . '/vendor/autoload.php';

define('BASE_PATH',dirname(__DIR__));

function dd($dump) {
	echo "<pre>";
		var_dump($dump);
	echo "</pre>";
	exit();
}
use Framework\Database\Command\MigrateCommand;
use Dotenv\Dotenv;
// dd(BASE_PATH);
$dotenv = Dotenv::createImmutable(BASE_PATH.'/Framework');
$dotenv->load();

$commands = require __DIR__ . '/App/commands.php';

foreach($commands as $command) {
	$command = new $command;
	$command->execute();
}
