<?php

namespace App\Repositories\Tributario\Arrecadacao\ArDigital\Implementations\CorreiosBR\ArquivoImportacaoListaPostagem;

use App\Repositories\Tributario\Arrecadacao\ArDigital\Support\StringUtils;

final class ArquivoTrailer
{
    use StringUtils;

    public string $quantidadeRegistros = '00000000';

    public function toString(): string
    {
        return
            ArquivoPostagem::TIPO_REGISTRO_TRAILER .
            $this->format($this->quantidadeRegistros, 8) .
            $this->filler(' ', 129);
    }
}