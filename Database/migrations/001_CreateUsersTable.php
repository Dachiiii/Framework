<?php

use Framework\Database\Connection\MysqlConnection;

class CreateUsersTable {
	public function migrate(MysqlConnection $connection) {
		$table = $connection->createTable('users');
		$table->id('id');
		$table->string('name')->char(255);
		$table->string('email')->char(255);
		$table->string('password')->char(255);
		$table->execute();
	}
}