<?php

use Framework\View;

function view(string $template, array $data = []): string {
	static $manager;
	if (!$manager) {
		$manager = new View\Manager();
		$manager->addPath(BASE_PATH . '/templates');
		$manager->addEngine('view.php',new View\Engine\BasicEngine());
		$manager->addEngine('template.php', new View\Engine\TemplateEngine());
		$manager->addEngine('php',new View\Engine\PhpEngine());
	}
	return $manager->render($template, $data);
}

function csrf() {
	$_SESSION['token'] = bin2hex(random_bytes(32));
	return $_SESSION['token'];
}

function secure() {
	if(!isset($_POST['csrf']) || !isset($_SESSION['token']) ||
		!hash_equals($_SESSION['token'], $_POST['csrf'])) {
		throw new Exception('CSRF token mismatch');
	}
}