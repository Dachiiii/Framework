<?php

namespace Framework\Database\Migration;

use Framework\Database\Connection\MysqlConnection;
use Framework\Database\Migration\Field\Field;
use Framework\Database\Migration\Field\BoolField;
use Framework\Database\Migration\Field\DateTimeField;
use Framework\Database\Migration\Field\FloatField;
use Framework\Database\Migration\Field\IdField;
use Framework\Database\Migration\Field\IntField;
use Framework\Database\Migration\Field\StringField;
use Framework\Database\Migration\Field\TextField;
use Framework\Database\Migration\Field\ForeignKey;

class MysqlMigration extends Migration {
	protected MysqlConnection $connection;
	protected string $table;
	protected string $type;
	protected array $drops = [];
	
	public function __construct(MysqlConnection $connection, string $table, string $type) {
		$this->connection = $connection;
		$this->table = $table;
		$this->type = $type;
	}

	public function execute() {
		$fields = array_map(fn($field) => $this->stringForField($field), $this->fields);
		$fields = join(',' . PHP_EOL, $fields);
		$primary = array_filter($this->fields, fn($field) => $field instanceof IdField);
		$primaryKey = isset($primary[0]) ? "PRIMARY KEY (`{$primary[0]->name}`)" : '';
		if ($this->type === 'create') {
			$query = "
				CREATE TABLE `{$this->table}` (
					{$fields},
					{$primaryKey}
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
			";
		}
		if ($this->type === 'alter') {
			$fields = join(PHP_EOL,array_map(fn($field) => "{$field}"));
			$query = "ALTER TABLE `{$this->table}` ($fields)";
		}		
		$statement = $this->connection->pdo()->prepare($query);
		$statement->execute();
	}
	private function stringForField(Field $field): string {
		if ($field instanceof BoolField) {
			$template = "`{$field->name}` tinyint(4) ";

			if ($field->nullable) {
				$template .= " DEFAULT NULL ";
			}
			if ($field->default !== NULL) {
				$default = (int) $field->default;
				$template .= "DEFAULT {$default}";
			}
			return $template;
		}
		if ($field instanceof DateTimeField) {
			$template = "`{$field->name}` datetime ";

			if ($field->nullable) {
				$template .= " DEFAULT NULL ";
			}
			if ($field->default !== 'CURRENT_TIMESTAMP') {
				$template .= "DEFAULT CURRENT_TIMESTAMP ";
			} else if ($field->default != null) {
				$template .= "DEFAULT {$field->default}";
			}
			return $template;
		}

		if ($field instanceof FloatField) {
			$template = "`{$field->name}` float ";

			if ($field->nullable) {
				$template .= " DEFAULT NULL ";
			}
			if ($field->default !== NULL) {
				$template .= "DEFAULT '{$field->default}'";
			}
			return $template;
		}

		if ($field instanceof IdField) {
			$template = "`{$field->name}` int(11) unsigned NOT NULL AUTO_INCREMENT ";

			if ($field->nullable) {
				$template .= " DEFAULT NULL ";
			}
			// if ($field->default !== NULL) {
				// $template .= "DEFAULT {$field->default}";
			// }
			return $template;
		}

		if ($field instanceof IntField) {
			$template = "`{$field->name}` int(11) unsigned ";

			if ($field->nullable) {
				$template .= " DEFAULT NULL ";
			}
			if ($field->default != NULL) {
				$default = strval($field->default);
				$template .= "DEFAULT {$default}";
			}
			return $template;
		}

		if ($field instanceof StringField) {
			$template = "`{$field->name}` varchar({$field->chars}) ";

			if ($field->nullable) {
				$template .= " DEFAULT NULL ";
			}
			if ($field->default != NULL) {
				$template .= "DEFAULT {$field->default}";
			}
			return $template;
		}
		if ($field instanceof TextField) {
			return "`{$field->name}` text ";
		}
		if ($field instanceof ForeignKey) {
			$toTable = new $field->to();
			$template = "`{$field->name}` int(11) unsigned,";
			$template .= " FOREIGN KEY ({$field->name}) REFERENCES {$toTable->getTable()}({$field->column}) ON DELETE {$field->delete}";
			return $template;
		}

	}

	public function dropColumn(string $name): static {
		$this->drops[] = $name;
		return $this;
	}
}
















