<?php

namespace App\Providers;

use App\Routes\Api;
use App\Routes\Legacy;
use App\Routes\Web;
use Silex\Application;
use Silex\ServiceProviderInterface;

class RouteServiceProvider implements ServiceProviderInterface {

    public function register(Application $app) {
        // Podemos pegar a lógica de registro dos middlewares da aplicação para que seja definido aqui.
    }

    public function boot(Application $app) {
        $prefix = $app['ecidade_api.mount_prefix'];
        $app->mount($prefix . '/pix', new Api());
    }

}
