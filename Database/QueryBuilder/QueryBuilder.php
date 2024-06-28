<?php

namespace Framework\Database\QueryBuilder;

use Framework\Database\Connection\Connection;
use PdoStatement;
use Pdo;

class QueryBuilder {
	protected string $type;
	protected $columns;
	protected string $table;
	protected int $limit = 0;
	protected int $offset = 0;
	protected array $wheres = [];
	protected array $w = [];

	public function all(): array {
		if (!isset($this->type)) {
			$this->select();
		}
		$statement = $this->prepare();
		$statement->execute($this->w);
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getWhereValues(): array {
		$values = [];
		if (count($this->wheres) === 0) {
			return $values;
		}
		foreach($this->wheres as $key => $where) {
			if (isset($this->wheres[$key+1] )){
				$values[$where] = $this->wheres[$key+1];
			}
		}
		return $values;
	}

	public function prepare(): PdoStatement {
		$query = '';
		if ($this->type === 'select') {
			$query = $this->compileSelect($query);
			$query = $this->compileWhere($query);
			$query = $this->compileLimit($query);
		}
		if ($this->type === 'update') {
			$query = $this->compileUpdate($query);
			$query = $this->compileWhere($query);
		}
		if ($this->type === 'delete') {
			$query = $this->compileDelete($query);
			$query = $this->compileWhere($query);
		}
		if ($this->type === 'insert') {
			$query = $this->compileInsert($query);
		}
		return $this->pdo()->prepare($query);
	}

	protected function compileInsert(string $query): string {
		$joinedColumns = join(', ', $this->columns);
		$joinedPlaceholders = join(', ', array_map(fn($column) => ":{$column}", $this->columns));
		$query .= " INSERT INTO {$this->table} ({$joinedColumns}) VALUES ({$joinedPlaceholders})";
		return $query;
	}

	protected function compileUpdate(string $query): string {
		$joinedColumns = '';
		foreach ($this->columns as $i => $column) {
			if ($i > 0) {
				$joinedColumns .= ', ';
			}
			$joinedColumns .= " {$column} = :{$column}";
		}

		$query .= " UPDATE {$this->table} SET {$joinedColumns}";
		return $query;
	}

	public function update(array $columns, array $values): int {
		$this->type = 'update';
		$this->columns = $columns;
		$this->values = $values;
		$statement = $this->prepare();
		return $statement->execute($this->getWhereValues() + $values);
	}

	protected function compileWhere(string $query): string {
		// dd($this->wheres);
		if (count($this->wheres) === 0) {
			return $query;
		}
		$query .= ' WHERE';
		$wheres = $this->getWhereValues();
		foreach($wheres as $i => $where) {
			if (count($wheres) > 1) {
				$query .= ', ';
			}
			$query .= " {$i} = :{$i}";
		}
		// $this->wheres = [];
		$this->w = $wheres;
		// dd($this->wheres);
		return $query;
	}

	protected function compileDelete(string $query):string {
		$query .= " DELETE FROM {$this->table}";
		return $query;
	}
	public function delete(): int {
		$this->type = 'delete';
		$statement = $this->prepare();
		return $statement->execute($this->getWhereValues());
	}

	protected function compileSelect(string $query): string {
		$query .= " SELECT {$this->columns} FROM {$this->table}";
		return $query;
	}

	protected function compileLimit(string $query): string {
		if ($this->limit) {
			$query .= " LIMIT {$this->limit}";
		}
		if ($this->offset) {
			$query .= " OFFSET {$this->offset}";
		}
		return $query;
	}

	public function first(): array {
		$statement = $this->take(1)->prepare();
		// dd($statement);
		$statement->execute($this->w);
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		if (count($result) === 1) {
			return $result[0];
		} return null;
	}

	public function take(int $limit, int $offset = 0): static {
		$this->limit = $limit;
		$this->offset = $offset;
		return $this;
	}

	public function from(string $table): static {
		$this->table = $table;
		return $this;
	}

	public function select(string $columns = '*'): static {
		$this->type = 'select';
		$this->columns = $columns;
		return $this;
	}

	public function getLastInsertedId(): string {
		return $this->pdo()->lastInsertId();
	}

	public function where($args) {
		// dd($args);
		$this->wheres = $args;
		$this->all();
		return $this;
	}
	public function insert(array $columns, array $values): int {
		$this->type = 'insert';
		$this->columns = $columns;
		$this->values = $values;
		$statement = $this->prepare();
		return $statement->execute($values);
	}

}



