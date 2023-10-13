<?php

namespace App\Repositories\Tributario\Arrecadacao\ArDigital\Implementations\CorreiosBR\ArquivoPrevisaoDePostagem;

use App\Repositories\Tributario\Arrecadacao\ArDigital\DTO\ArquivoPrevisaoPostagemDetalheDTO;
use App\Repositories\Tributario\Arrecadacao\ArDigital\Support\StringUtils;

class Detalhe
{
    use StringUtils;

    public ArquivoPrevisaoPostagemDetalheDTO $arquivoPrevisaoPostagemDetalheDTO;

    public function __construct(ArquivoPrevisaoPostagemDetalheDTO $data)
    {
        $this->arquivoPrevisaoPostagemDetalheDTO = $data;
    }

    public function toString(): string
    {
        return ArquivoPrevisaoPostagem::TIPO_REGISTRO_DETALHE .
            $this->format($this->arquivoPrevisaoPostagemDetalheDTO->codigoDoCliente, 4) .
            $this->format($this->arquivoPrevisaoPostagemDetalheDTO->identificadorDoCliente, 8, ' ', STR_PAD_RIGHT) .
            $this->format($this->arquivoPrevisaoPostagemDetalheDTO->siglaDoObjeto, 2) .
            $this->format($this->arquivoPrevisaoPostagemDetalheDTO->numeroDoObjeto, 9) .
            $this->arquivoPrevisaoPostagemDetalheDTO->paisDeOrigem .
            $this->arquivoPrevisaoPostagemDetalheDTO->codigoDaOperacao .
            $this->format($this->arquivoPrevisaoPostagemDetalheDTO->conteudo, 16, ' ') .
            $this->format($this->arquivoPrevisaoPostagemDetalheDTO->nomeDestinatario, 40, ' ', STR_PAD_RIGHT) .
            $this->format($this->arquivoPrevisaoPostagemDetalheDTO->enderecoDestinatario, 40, ' ', STR_PAD_RIGHT) .
            $this->format($this->arquivoPrevisaoPostagemDetalheDTO->cidade, 30, ' ', STR_PAD_RIGHT) .
            $this->arquivoPrevisaoPostagemDetalheDTO->uf .
            $this->format($this->arquivoPrevisaoPostagemDetalheDTO->cep, 8) .
            $this->filler('0', 8) .
            $this->format($this->arquivoPrevisaoPostagemDetalheDTO->numeroSequencialArquivo,5) .
            $this->format($this->arquivoPrevisaoPostagemDetalheDTO->numeroSequencialRegistro, 7);
    }
}
