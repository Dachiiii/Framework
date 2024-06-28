<?php

namespace Framework\Http;

class Response {
	private string $template;
	private array $content;
	private int $status_code;

	public function __construct(string $template, array $content = [], int $status_code = 200) {
		$this->template = $template;
		$this->content = $content;
		$this->tatus_code = $status_code;
	}

	public function template() {
		require_once BASE_PATH . '/helpers.php';
		$html = view($this->template, $this->content);
		return $html;
	}

	public static function dispatch(string $dispatcher) {
		require BASE_PATH . "/templates/dispatch/{$dispatcher}.view.php";
	}
}