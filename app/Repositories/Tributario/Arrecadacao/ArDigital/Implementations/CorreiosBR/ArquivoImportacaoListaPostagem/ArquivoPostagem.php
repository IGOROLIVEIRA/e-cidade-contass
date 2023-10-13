<?php

namespace App\Repositories\Tributario\Arrecadacao\ArDigital\Implementations\CorreiosBR\ArquivoImportacaoListaPostagem;

use App\Repositories\Tributario\Arrecadacao\ArDigital\DTO\ArquivoPostagemDTO;
use Exception;

class ArquivoPostagem
{
    public const TIPO_REGISTRO_LISTA_POSTAGEM = 3;
    public const TIPO_REGISTRO_TRAILER = 9;
    public const FILLER = '0';
    public const NOME_GRAFICA = 'CDIPBH';

    public const PATH_TO_SAVE =  'tmp' . DS;

    /**
     * @var ListaDePostagem[]
     */
    private array $registrosListaPostagem;
    private ArquivoTrailer $trailer;

    public function __construct()
    {
        $this->trailer = new ArquivoTrailer();
    }

    public function getListaDePostagemInstance(ArquivoPostagemDTO $data): ListaDePostagem
    {
        return new ListaDePostagem($data);
    }

    /**
     * @param ListaDePostagem $listaDePostagem
     * @return void
     */
    public function setRegistrosListaPostagem(ListaDePostagem $listaDePostagem): self
    {
        $this->registrosListaPostagem[] = $listaDePostagem;
        return $this;
    }

    public function toString(): string
    {
        $string = '';

        try {
            foreach ($this->registrosListaPostagem as $listaPostagem) {
                $string .= $listaPostagem->toString();
            }

            $this->trailer->quantidadeRegistros = count($this->registrosListaPostagem)+1;
            $string .= $this->trailer->toString();
        } catch (Exception $exception) {
            throw new Exception('Erro no toString: ' . $exception->getMessage());
        }

        return $string;
    }

    public function getFileName(): string
    {
        return 'PMNomePrefeitura' . self::NOME_GRAFICA . date('mdY') . '.' . 'txt';
    }

    public function getPathToSave(): string
    {
        return self::PATH_TO_SAVE . $this->getFileName();
    }
}