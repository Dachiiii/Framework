<?php

namespace Framework\View\Engine;

class PhpEngine implements Engine {
	protected string $path;
	protected $layouts = [];

	public function render(string $path, array $data = []): string {
		$this->path = $path;
		extract($data);
		ob_start();
		include($this->path);
		$contents = ob_get_contents();
		ob_end_clean();
		return $contents;	
	}

	protected function escape(string $content): string {
		return htmlspecialchars($content);
	}

	protected function extends(string $template): static {
		$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,1);
		$this->layouts[realpath($backtrace[0]['file'])] = $template;
		return $this;
	}

	protected function includes(string $template, $data = []): void {
		print view($template,$data);
	}
}