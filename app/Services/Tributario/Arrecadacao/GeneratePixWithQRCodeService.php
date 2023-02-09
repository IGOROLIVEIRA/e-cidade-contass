<?php

namespace App\Services\Tributario\Arrecadacao;

use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Contracts\IConfiguration;

class GeneratePixWithQRCodeService
{
    private IConfiguration $configuration;

    public function __construct(IConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function execute(array $data): void
    {
        $provider = $this->configuration->getFinancialProvider();
        $response = $provider->generatePixArrecadacaoQrCodes($data);
    }
}
