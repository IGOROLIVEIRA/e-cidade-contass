<?php

use ECidade\Patrimonial\Licitacao\PNCP\ModeloBasePNCP;

/**
 * Classe responsvel por montar as informaes do Envio de Avisos de Licitacao - PNCP
 *
 * @package  ECidade\model\licitacao\PNCP
 * @author   Mario Junior
 */
class AvisoLicitacaoPNCP extends ModeloBasePNCP
{

    /**
     *
     * @param \stdClass $dados
     */
    function __construct($dados)
    {
        parent::__construct($dados);
    }

    public function montarDados()
    {
        $aDadosAPI = array();

        $oDado = $this->dados;

        $oDadosAPI                                  = new \stdClass;
        $oDadosAPI->codigoUnidadeCompradora         = '01001'; //$oDado->codigounidadecompradora;
        $oDadosAPI->tipoInstrumentoConvocatorioId   = $oDado->tipoinstrumentoconvocatorioid;
        $oDadosAPI->modalidadeId                    = $oDado->modalidadeid;
        $oDadosAPI->modoDisputaId                   = $oDado->mododisputaid;
        $oDadosAPI->numeroCompra                    = $oDado->numerocompra;
        $oDadosAPI->anoCompra                       = $oDado->anocompra;
        $oDadosAPI->numeroProcesso                  = $oDado->numeroprocesso;
        $oDadosAPI->objetoCompra                    = urlencode($oDado->objetocompra);
        $oDadosAPI->informacaoComplementar          = $oDado->informacaocomplementar;
        $oDadosAPI->srp                             = $oDado->srp == 'f' ? 'false' : 'true';
        $oDadosAPI->orcamentoSigiloso               = $oDado->orcamentosigiloso == 'f' ? 'false' : 'true';
        $oDadosAPI->dataAberturaProposta            = $this->formatDate($oDado->dataaberturaproposta);
        $oDadosAPI->dataEncerramentoProposta        = $this->formatDate($oDado->dataencerramentoproposta);
        $oDadosAPI->amparoLegalId                   = $oDado->amparolegalid;
        $oDadosAPI->linkSistemaOrigem               = $oDado->linksistemaorigem;
        //ITENS
        foreach ($oDado->itensCompra as $key => $item) {
            $oDadosAPI->itensCompra[$key]->numeroItem                  = $item->numeroitem;
            $oDadosAPI->itensCompra[$key]->materialOuServico           = $item->materialouservico;
            $oDadosAPI->itensCompra[$key]->tipoBeneficioId             = $item->tipobeneficioid;
            $oDadosAPI->itensCompra[$key]->incentivoProdutivoBasico    = $item->incentivoprodutivobasico == 'f' ? 'false' : 'true';
            $oDadosAPI->itensCompra[$key]->descricao                   = urlencode($item->descricao);
            $oDadosAPI->itensCompra[$key]->quantidade                  = 1;
            $oDadosAPI->itensCompra[$key]->unidadeMedida               = urlencode($item->unidademedida);
            $oDadosAPI->itensCompra[$key]->valorUnitarioEstimado       = 1; //$item->valorunitarioestimado;
            $oDadosAPI->itensCompra[$key]->valorTotal                  = 1; //$item->valortotal;
            $oDadosAPI->itensCompra[$key]->criterioJulgamentoId        = $item->criteriojulgamentoid;
        }

        $aDadosAPI = $oDadosAPI;

        $name = 'Compra' . $oDado->numerocompra . '.json';
        $arquivo = 'model/licitacao/PNCP/arquivos/' . $name;
        if (file_exists($arquivo)) {
            unlink($arquivo);
        }

        file_put_contents($arquivo, json_encode($aDadosAPI));
        $filename = 'model/licitacao/PNCP/arquivos/Compra' . $oDado->numerocompra . '.zip';
        $zip = new ZipArchive();
        if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
            exit("cannot open <$filename>\n");
        }
        $zip->addFile("model/licitacao/PNCP/arquivos/" . $name, $name);
        $zip->close();
    }

    /**
     *
     * @param \int $tipoDocumento
     * 1  - Aviso de Contratao Direta
     * 2  - Edital
     * 11 - Ata de Registro de Preo
     */

    public function enviar($tipoDocumento, $processo)
    {
        ini_set('display_errors', 'on');
        $this->enviarAviso($tipoDocumento, $processo);
        //criar forma de controle de informacoes enviadas
    }
}
