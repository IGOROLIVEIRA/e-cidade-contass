<?php

namespace App\Repositories\Tributario\Arrecadacao\ArDigital\DTO;

class ArDigitalServiceResponseDTO
{
    public string $arquivoPostagem;
    public string $arquivoPrevisaoPostagem;

    public function __construct(string $arquivoPostagem, string $arquivoPrevisaoPostagem)
    {
        $this->arquivoPostagem = $arquivoPostagem;
        $this->arquivoPrevisaoPostagem = $arquivoPrevisaoPostagem;
    }
}