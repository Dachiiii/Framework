<?php

namespace Framework\Database\Migration\Field;

class BoolField extends Field {
	public string $name;
	public bool $default;

	public function default(bool $value): static {
		$this->default = $value;
		return $this;
	}
}