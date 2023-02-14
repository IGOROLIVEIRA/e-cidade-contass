<?php

namespace App\Services\Tributario\Arrecadacao;

use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Contracts\IConfiguration;
use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\DTO\PixArrecadacaoResponseDTO;

class GeneratePixWithQRCodeService
{
    private IConfiguration $configuration;

    public function __construct(IConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function execute(array $data): PixArrecadacaoResponseDTO
    {
        $provider = $this->configuration->getFinancialProvider();
        return $provider->generatePixArrecadacaoQrCodes($data);
    }
}
