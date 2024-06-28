<?php

namespace Framework\Database\Migration;

// use Framework\Database\Connection\Connection;
use Framework\Database\Migration\Field\BoolField;
use Framework\Database\Migration\Field\DateTimeField;
use Framework\Database\Migration\Field\FloatField;
use Framework\Database\Migration\Field\IdField;
use Framework\Database\Migration\Field\IntField;
use Framework\Database\Migration\Field\StringField;
use Framework\Database\Migration\Field\TextField;
use Framework\Database\Migration\Field\ForeignKey;

class Migration {

	protected array $fields = [];

	public function bool(string $name): BoolField {
		$field = $this->fields[] = new BoolField($name);
		return $field;
	}

	public function dateTime(string $name): DateTimeField {
		$field = $this->fields[] = new DateTimeField($name);
		return $field;
	}

	public function float(string $name): FloatField {
		$field = $this->fields[] = new FloatField($name);
		return $field;
	}

	public function id(string $name): IdField {
		$field = $this->fields[] = new IdField($name);
		return $field;
	}

	public function string(string $name): StringField {
		return $this->fields[] = new StringField($name);
	}

	public function text(string $name): TextField {
		return $this->fields[] = new TextField($name);
	}

	public function int(string $name): IntField {
		return $this->fields[] = new IntField($name);
	}

	public function ForeignKey(string $name): ForeignKey {
		return $this->fields[] = new ForeignKey($name);
	}

	// abstract public function connection(): Connection;
	// abstract public function execute(): void;
	// abstract public function dropColumn(string $name): static;
}