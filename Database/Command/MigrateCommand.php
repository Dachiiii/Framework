<?php

namespace Framework\Database\Command;

use Framework\Database\Connection\MysqlConnection;
use Framework\Database\Connection\ConnectionString;

class MigrateCommand {
	protected static $defaultName = 'migrate';

	public function execute() {
		$current = getcwd();
		$pattern = 'Database/migrations/*.php';
		$paths = glob("{$current}/{$pattern}");

		if (count($paths) === 0) {
			$this->writeln('No migrations found');
			return Command::SUCCESS;
		}
		$connection = new MysqlConnection(ConnectionString::class);
		foreach($paths as $path) {
			[$prefix, $file] = explode('_', $path);
			[$class, $extension] = explode('.',$file);
			require $path;
			$obj = new $class();
			try{
				$obj->migrate($connection);
			}catch(\PDOException $e) {
				echo $e->getMessage() . "\n";
			}
		}

	}
}