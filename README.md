![PHP Version](https://img.shields.io/badge/php-8.3.4-blue)
![Tested ON](https://img.shields.io/badge/Tested%20On-Ubuntu-yellow)
![OS](https://img.shields.io/badge/OS-Ubuntu-orange/#icon=Linux)

# MVC Framework (not finished)

I'm building basic MVC Framework from scratch, currently it supports only **MYSQL** Database But I'll probably add sqlite support to framework.
Command to run: **php -S localhost:8080 -t public**

# Install
```
git clone https://github.com/Dachiiii/phpFramework.git
cd phpFramework
composer require vlucas/phpdotenv
```
# How to use it

***
### Receive Request and Send Response using Controllers
```
namespace Framework\Http\Controllers;
use Framework\Http\Response;
use Framework\Http\Request;

class HomeController {
    public function index(Request &request): Response {
        return new Response(__FUNCTION__);  // Default template name is function name
    }
}
```
### Route for HomeController
```
// Framework/Route/web.php
use Framework\Route\Routing;
use Framework\Http\Controllers\HomeController;

return [
	['GET', '/', [HomeController::class,'index']],
];
```
# Template Engines
Framework has it's own Template Engines (BasicEngine, TemplateEngine), with extensions: index.view.php, index.template.php.
Engines translates template code to **PHP** code.
basicEngine(.view.php) only supports variables. for example: ```<p>This is {engine} Engine.</p> is translated to <p>This is BasicEngine Engine.</p>.```
TemplateEngine is much more advanced than BasicEngine. it supports if statements, extending layout, foreach and variables.
## how engines works
```
 <p>This is {engine} Engine</p>** // is translated to <p>This is <?php print $this->escape($engine); ?> Engine</p>
```
## TemplateEngine Syntax
**@extends('layout')@** is looking for file(layout.template.php) in templates/layout/ folder.
```
@extends('layout')@

@foreach($users as $user)@
	@if(statement)@
		<p>Hello {{user->name}}</p>
	@endif@
@endforeach@
```
