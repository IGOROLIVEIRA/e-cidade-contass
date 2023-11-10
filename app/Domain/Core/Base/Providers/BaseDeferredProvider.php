<?php

namespace App\Domain\Core\Base\Providers;

use Illuminate\Support\ServiceProvider;

abstract class BaseDeferredProvider extends ServiceProvider
{
    /**
     * Indica que o carregamento do provider � adiado.
     * @var bool
     */
    protected $defer = true;

    /**
     * Registra o service provider.
     * @return void
     */

    /**
     * Retorna os Services registrados no provider.
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
