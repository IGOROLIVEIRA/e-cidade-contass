<?php

namespace App\Repositories\Tributario\Arrecadacao\ArDigital\Implementations\CorreiosBR\ArquivoImportacaoListaPostagem;

use App\Repositories\Tributario\Arrecadacao\ArDigital\DTO\ArquivoPostagemDTO;
use App\Repositories\Tributario\Arrecadacao\ArDigital\Support\StringUtils;

final class ListaDePostagem
{
    use StringUtils;

    public ArquivoPostagemDTO $arquivoPostagemDTO;

    public function __construct(ArquivoPostagemDTO $data)
    {
        $this->arquivoPostagemDTO = $data;
        $this->arquivoPostagemDTO->dataColeta = date('dmY');
    }

    public function toString(): string
    {
        return ArquivoPostagem::TIPO_REGISTRO_LISTA_POSTAGEM .
            $this->format($this->arquivoPostagemDTO->codigoGrafica, 2) .
            $this->filler(ArquivoPostagem::FILLER, 4) .
            $this->filler(ArquivoPostagem::FILLER, 4) .
            $this->format($this->arquivoPostagemDTO->dataColeta,8) .
            $this->filler(ArquivoPostagem::FILLER, 4) .
            $this->format($this->arquivoPostagemDTO->numeroContrato, 10) .
            $this->format($this->arquivoPostagemDTO->codigoAdministrativo, 8) .
            $this->format($this->arquivoPostagemDTO->cepDestino, 8) .
            $this->format($this->arquivoPostagemDTO->codigoServico, 5) .
            $this->format($this->arquivoPostagemDTO->codigoPais, 2) .
            $this->format($this->arquivoPostagemDTO->codServicoAdicional1, 2) .
            $this->format($this->arquivoPostagemDTO->codServicoAdicional2, 2) .
            $this->format($this->arquivoPostagemDTO->codServicoAdicional3, 2) .
            $this->format($this->arquivoPostagemDTO->valorDeclarado, 8) .
            $this->filler(ArquivoPostagem::FILLER, 9) .
            $this->filler(ArquivoPostagem::FILLER, 2) .
            $this->format($this->arquivoPostagemDTO->numeroEtiqueta, 9) .
            $this->format($this->arquivoPostagemDTO->peso, 5) .
            $this->filler(ArquivoPostagem::FILLER, 8) .
            $this->filler(ArquivoPostagem::FILLER, 2) .
            $this->filler(ArquivoPostagem::FILLER, 2) .
            $this->filler(ArquivoPostagem::FILLER, 8) .
            $this->filler(ArquivoPostagem::FILLER, 3) .
            $this->filler(ArquivoPostagem::FILLER, 2) .
            $this->filler(ArquivoPostagem::FILLER, 10) .
            $this->format($this->arquivoPostagemDTO->numeroLogradouro, 6) .
            $this->filler(ArquivoPostagem::FILLER, 2) .
            $this->format($this->arquivoPostagemDTO->numeroCartaoPostagem, 11) .
            $this->format($this->arquivoPostagemDTO->numeroNotaFiscal, 7) .
            $this->format($this->arquivoPostagemDTO->siglaServico, 2) .
            $this->format($this->arquivoPostagemDTO->comprimentoObjeto, 5) .
            $this->format($this->arquivoPostagemDTO->larguraObjeto, 5) .
            $this->format($this->arquivoPostagemDTO->alturaObjeto, 5) .
            $this->format($this->arquivoPostagemDTO->valorACobrarDestinatario, 8) .
            $this->format($this->arquivoPostagemDTO->nomeDestinatario, 40, ' ') .
            $this->format($this->arquivoPostagemDTO->codigoTipoObjeto, 3) .
            $this->format($this->arquivoPostagemDTO->diametroObjeto, 5) . PHP_EOL;
    }
}