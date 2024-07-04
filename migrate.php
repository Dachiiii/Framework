<?php

require __DIR__ . '/vendor/autoload.php';

define('BASE_PATH',dirname(__DIR__));

use Framework\Database\Command\MigrateCommand;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$commands = require __DIR__ . '/App/commands.php';

foreach($commands as $command) {
	$command = new $command;
	$command->execute();
}
