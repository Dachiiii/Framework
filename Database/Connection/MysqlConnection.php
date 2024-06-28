<?php

namespace Framework\Database\Connection;
use Framework\Database\Connection\ConnectionString;
use Framework\Database\QueryBuilder\MysqlQueryBuilder;
use Framework\Database\Migration\MysqlMigration;
use InvalidArgumentException;
use PDOException;
use Pdo;

class MysqlConnection extends MysqlQueryBuilder {
	private Pdo $pdo;

	public function __construct(string $connectionString) {
		$this->connectionString = new $connectionString();
		$this->connectionString->generateConnectionString();
		try {
			$this->pdo = new Pdo(
				$this->connectionString->configureString,
				$this->connectionString->configureUser,
				$this->connectionString->configurePass);
		} catch (PDOException $e) {
			return false;
		}
	}

	public function pdo(): Pdo {
		return $this->pdo;
	}

	public function createTable(string $table): MysqlMigration {
		return new MysqlMigration($this, $table, 'create');
	}

}