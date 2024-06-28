<?php

namespace Framework\Database\Migration\Field;

class FloatField extends Field {
	public string $name;
	public float $default = 0.0;

	public function default(float $value): static {
		$this->default = $value;
		return $this;
	}
}