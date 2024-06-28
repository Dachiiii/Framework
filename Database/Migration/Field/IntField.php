<?php

namespace Framework\Database\Migration\Field;

class IntField extends Field {
	public string $name;
	public $default;

	public function default($value): static {
		$this->default = $value;
		return $this;
	}
}