<?php

namespace App\Services\Tributario\Notificacoes;

use App\Repositories\Tributario\Arrecadacao\ArDigital\DTO\ArquivoPrevisaoPostagemDetalheDTO;

class ResolveCorreiosTagNumber
{
    protected string $tipoPostal = ArquivoPrevisaoPostagemDetalheDTO::TIPO_POSTAL;
    protected string $paisOrigem = ArquivoPrevisaoPostagemDetalheDTO::PAIS_ORIGEM;

    public function execute(string $tagNumber, string $checkerDigit)
    {
        return "{$this->tipoPostal}{$tagNumber}{$checkerDigit}{$this->paisOrigem}";
    }
}
