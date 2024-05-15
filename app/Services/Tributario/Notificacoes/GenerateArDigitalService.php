<?php

namespace App\Services\Tributario\Notificacoes;

use App\Repositories\Tributario\Arrecadacao\ArDigital\DTO\ArDigitalServicePayloadDTO;
use App\Repositories\Tributario\Arrecadacao\ArDigital\DTO\ArDigitalServiceResponseDTO;
use App\Repositories\Tributario\Arrecadacao\ArDigital\DTO\ArquivoPostagemDTO;
use App\Repositories\Tributario\Arrecadacao\ArDigital\DTO\ArquivoPrevisaoPostagemDetalheDTO;
use App\Repositories\Tributario\Arrecadacao\ArDigital\Implementations\CorreiosBR\ArquivoImportacaoListaPostagem\ArquivoPostagem;
use App\Repositories\Tributario\Arrecadacao\ArDigital\Implementations\CorreiosBR\ArquivoPrevisaoDePostagem\ArquivoPrevisaoPostagem;
use BusinessException;
use Exception;

class GenerateArDigitalService
{
    public ArquivoPostagem $arquivoPostagem;
    public ArquivoPrevisaoPostagem $arquivoPrevisaoPostagem;

    public function __construct()
    {
        $this->arquivoPostagem = new ArquivoPostagem();
        $this->arquivoPrevisaoPostagem = new ArquivoPrevisaoPostagem();
    }

    /**
     * @param ArDigitalServicePayloadDTO[] $data
     * @throws BusinessException
     * @throws Exception
     * @return ArDigitalServiceResponseDTO
     */
    public function execute(array $data): ArDigitalServiceResponseDTO
    {
        $arquivoPostagem = $this->generateArquivoPostagem($data);
        $arquiviPrevisaoPostagem = $this->generateArquivoPrevisaoPostagem($data);
        return (new ArDigitalServiceResponseDTO($arquivoPostagem, $arquiviPrevisaoPostagem));
    }

    /**
     * @param ArDigitalServicePayloadDTO[] $data
     * @return string
     * @throws BusinessException
     */
    private function generateArquivoPostagem(array $data): string
    {
        foreach ($data as $item) {
            $arquivoPostagemDTO = new ArquivoPostagemDTO((array) $item);
            $registro3 = $this->arquivoPostagem->getListaDePostagemInstance($arquivoPostagemDTO);
            $this->arquivoPostagem->setRegistrosListaPostagem($registro3);
        }
        $content = $this->arquivoPostagem->toString();
        if (!file_put_contents($this->arquivoPostagem->getPathToSave(), $content)) {
            throw new BusinessException('Falha ao screver arquivo AR Digital - Lista de Postagem');
        }
        return $this->arquivoPostagem->getPathToSave();
    }

    /**
     * @param ArDigitalServicePayloadDTO[] $data
     * @return string
     * @throws Exception
     */
    private function generateArquivoPrevisaoPostagem(array $data): string
    {
        foreach ($data as $key => $item) {
            $arquivoPrevisaoPostagemDetalhe = new ArquivoPrevisaoPostagemDetalheDTO();
            $arquivoPrevisaoPostagemDetalhe->nomeDestinatario = $item->nomeDestinatario;
            $arquivoPrevisaoPostagemDetalhe->enderecoDestinatario = $item->nomeLogradouroDestinatario . ' '
                . $item->numeroLogradouro . ' '
                . $item->complementoEnderecoDestinatario . ' '
                . $item->bairroDestinatario;
            $arquivoPrevisaoPostagemDetalhe->cidade = $item->cidadeDestinatario;
            $arquivoPrevisaoPostagemDetalhe->uf = $item->estadoDestinatario;
            $arquivoPrevisaoPostagemDetalhe->numeroSequencialRegistro = $key+2;
            $arquivoPrevisaoPostagemDetalhe->cep = $item->cepDestino;
            $arquivoPrevisaoPostagemDetalhe->numeroDoObjeto = $item->numeroEtiqueta;
            $detalhe = $this->arquivoPrevisaoPostagem->getDetalheInstance($arquivoPrevisaoPostagemDetalhe);
            $this->arquivoPrevisaoPostagem->setRegistroDetalhe($detalhe);
        }

        $content = $this->arquivoPrevisaoPostagem->toString();

        if (!file_put_contents($this->arquivoPrevisaoPostagem->getPathToSave(), $content)) {
            throw new BusinessException('Falha ao screver arquivo AR Digital - Previsao de Postagem');
        }

        return $this->arquivoPrevisaoPostagem->getPathToSave();
    }
}
