<?php

namespace Framework\Database\Migration\Field;

class StringField extends Field {
	public string $name;
	public $default;
	public int $chars;

	public function default($value): static {
		$this->default = $value;
		return $this;
	}

	public function char(int $chars): static {
		$this->chars = $chars;
		return $this;
	}
}