<?php

namespace Framework\Database\Migration\Field;

class ForeignKey extends Field {
	public string $name;
	public string $column;
	public string $to;
	public string $delete = 'CASCADE';
	// public bool $default;

	public function default(bool $value): static {
		// $this->default = $value;
		// return $this;
	}

	public function column(string $column): static {
		$this->column = $column;
		return $this;
	}

	public function to(string $to): static {
		$this->to = $to;
		return $this;
	}

	public function onDelete(string $onDelete): static {
		$this->delete = $onDelete;
		return $this;
	}
}