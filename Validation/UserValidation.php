<?php

namespace Framework\Validation;

class UserValidation extends Validation {

	public function __construct() {
		$this->initRules();
		$this->initMessages();
	}

	public function initRules() {
		// $this->rules['username'] 	= \Respect\Validation\Validator::alnum('_')->length(6,20);
		// $this->rules['email'] 		= \Respect\Validation\Validator::email();
		// $this->rules['password'] 	= \Respect\Validation\Validator::alnum()->length(4,20);
	}

	public function initMessages() {
		$this->messages = [
			// 'username' => "{{name}} must only contain alphabetic characters.",
			// 'email'	   => "Please make sure you typed a correct email address.",
			// 'password' => "Password confirmation doesn't match",
		];
	}

}