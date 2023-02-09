<?php

namespace App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Contracts;

interface IConfiguration
{
    public function getHost();

    /**
     * @return string
     */
    public function getUrlAuthOauth2();

    public function getAccessToken();

    public function getClientId();

    public function getClientSecret();

    public function getApplicationKey();

    public function getFinancialProvider(): IPixProvider;
}
