<?php

namespace Framework\Database;

class TableName {
	public string $name;

	public function __construct(string $name) {
		$this->name = $name;
	}
}