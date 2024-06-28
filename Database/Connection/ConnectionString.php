<?php

namespace Framework\Database\Connection;

class ConnectionString {
	public array $configuration = [];
	public string $configureString = '';
	public string $configureDB = '';
	public string $configureUser = '';
	public string $configurePass = '';

	public function generateConnectionString() {
		$this->configuration = [
			'host' => $_ENV['host'],
			'port' => $_ENV['port'],
			'dbname' => $_ENV['dbname'],
		];
		$this->configureDB = $_ENV['DB'];
		$this->configureUser = $_ENV['username'];
		$this->configurePass = $_ENV['password'];
		$this->configureString = $this->configureDB .':'.http_build_query($this->configuration,'',';');
	}

}