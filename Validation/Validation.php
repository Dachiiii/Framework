<?php

namespace Framework\Validation;

class Validation {

	protected array $rules = [];
	
	protected array $messages = [];
	
	protected array $errors = [];

	public function isValidData(array $data): bool {
		foreach ($data as $name => $value) {
			if (!$this->rules[$name]->validate($value)) {
				$this->errors[] = $this->messages[$name];
			}
		}
		return empty($this->errors) ? true : false;
	}

	public function getInvalidInputMessages(): array {
		return $this->errors;
	}
}