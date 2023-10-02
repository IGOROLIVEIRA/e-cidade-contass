<?php

namespace App\Repositories\Tributario\Arrecadacao\ArDigital\Implementations\CorreiosBR\ArquivoPrevisaoDePostagem;

use App\Repositories\Tributario\Arrecadacao\ArDigital\DTO\ArquivoPrevisaoPostagemDetalheDTO;
use Exception;

class ArquivoPrevisaoPostagem
{
    public const TIPO_REGISTRO_HEADER = 8;
    public const TIPO_REGISTRO_DETALHE = 9;
    public const FILLER = '0';

    public const PATH_TO_SAVE =  'tmp' . DS;

    /**
     * @var Detalhe[] $detalhes
     */
    public array $detalhes;

    public function getDetalheInstance(ArquivoPrevisaoPostagemDetalheDTO $data): Detalhe
    {
        return new Detalhe($data);
    }

    public function setRegistroDetalhe(Detalhe $detalhe)
    {
        $this->detalhes[] = $detalhe;
    }

    public function getHeaderInstance()
    {
        return new Header();
    }

    public function toString(): string
    {
        $string = [];

        try {
            foreach ($this->detalhes as $detalhe) {
                $string[] = $detalhe->toString();
            }

            $header = $this->getHeaderInstance();

            $header->quantidadeRegistros = count($this->detalhes)+1;
            $header->nomeDoCliente = 'Prefeitura Municial Teste';
        } catch (Exception $exception) {
            throw new Exception('Erro no toString: ' . $exception->getMessage());
        }

        $string = implode(PHP_EOL, $string);

        return $header->toString() . $string;
    }

    public function getFileName(): string
    {
        return 'MHF1'.date('dm').'0.'.'SD1';
    }

    public function getPathToSave(): string
    {
        return self::PATH_TO_SAVE . $this->getFileName();
    }
}
