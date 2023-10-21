<?php

include __DIR__.'/vendor/autoload.php';

use App\Contracts\DataManager;
use App\Entities\User;
use Lemon\Http\Middlewares\Cors;
use Lemon\Kernel\Application;
use Lemon\Protection\Middlwares\Csrf;
use Lemon\Terminal;

$application = new Application(__DIR__);

// --- Loading default Lemon services ---
$application->loadServices();

// --- Loading Zests for services ---
$application->loadZests();

// --- Loading Error/Exception handlers ---
$application->loadHandler();

$application->get('config')->load();

foreach ($application->get('config')->get('services') as $service => $aliases) {
    $application->add($service);
    foreach ($aliases as $alias) {
        $application->alias($alias, $service);
    }
}

Terminal::command('make:user {name} {password}', function(DataManager $data, $name, $password) {
    $data->set(new User($name, password_hash($password, PASSWORD_ARGON2I)));
}, 'Creates new user');

/** @var \Lemon\Routing\Router $router */
$router = $application->get('routing');

$router->file('routes.web')
    ->middleware(Csrf::class)
;

$router->file('routes.api')
    ->prefix('api')
    ->middleware(Cors::class)
;

return $application;
