<?php

namespace App\Providers;

use App\Routes\Api;
use App\Routes\Legacy;
use App\Routes\Web;
use Silex\Application;
use Silex\ServiceProviderInterface;

class RouteServiceProvider implements ServiceProviderInterface {

    public function register(Application $app) {
        // Podemos pegar a l�gica de registro dos middlewares da aplica��o para que seja definido aqui.
    }

    public function boot(Application $app) {
        $prefix = $app['ecidade_api.mount_prefix'];
        $app->mount($prefix . '/pix', new Api());
    }

}
