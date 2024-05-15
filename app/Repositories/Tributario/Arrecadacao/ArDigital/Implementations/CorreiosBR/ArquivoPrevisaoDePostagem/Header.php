<?php

namespace App\Repositories\Tributario\Arrecadacao\ArDigital\Implementations\CorreiosBR\ArquivoPrevisaoDePostagem;

use App\Repositories\Tributario\Arrecadacao\ArDigital\Support\StringUtils;

final class Header
{
    use StringUtils;

    public string $codigoDoCliente = '8443';
    public string $nomeDoCliente = '';
    public string $dataGeracao = '';
    /**
     * Quantidade de Registro do arquivo, inclui o Registro Header.
     * @var int
     */
    public int $quantidadeRegistros = 0;
    public string $numeroSequencialArquivo = '00001';
    public string $numeroSequencialRegistro = '0000001';

    public function toString(): string
    {
        return
            ArquivoPrevisaoPostagem::TIPO_REGISTRO_HEADER .
            $this->format($this->codigoDoCliente, 4) .
            $this->filler('0', 15) .
            $this->format($this->nomeDoCliente, 40, ' ', STR_PAD_RIGHT) .
            date('Ymd') .
            $this->format($this->quantidadeRegistros, 6) .
            $this->filler('0', 100) .
            $this->format($this->numeroSequencialArquivo, 5) .
            $this->format($this->numeroSequencialRegistro, 7) . PHP_EOL;
    }
}