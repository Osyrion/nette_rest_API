<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;

        $router[] = new Route('api/insertdata/', 'Api:default');
        $router[] = new Route('api/deletedata/<parameter>/<value>', 'Api:default');
        $router[] = new Route('api/<parameter>/<value>', 'Api:default');
        $router[] = new Route('api/', 'Api:default');

		return $router;
	}
}
