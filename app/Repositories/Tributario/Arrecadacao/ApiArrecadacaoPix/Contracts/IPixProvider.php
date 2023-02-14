<?php

namespace App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Contracts;

use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\DTO\PixArrecadacaoResponseDTO;

interface IPixProvider
{
    /**
     * @param array $payload
     * @return PixArrecadacaoResponseDTO
     */
    public function generatePixArrecadacaoQrCodes(array $payload): PixArrecadacaoResponseDTO;
}
