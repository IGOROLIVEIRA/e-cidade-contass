<?php

namespace App\Routes;

use App\Http\Controllers\Api\PixController;
use Silex\Application;
use Silex\ControllerProviderInterface;

class Api implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $controllers->post('/return', function () use ($app) {
            return (new PixController($app["request"]))->index();
        });

        return $controllers;
    }
}