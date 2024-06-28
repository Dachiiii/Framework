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
