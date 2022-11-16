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
        //ini_set('display_errors', 'on');
        $aDadosAPI = array();

        $oDado = $this->dados;

        $oDadosAPI                                  = new \stdClass;
        $oDadosAPI->codigoUnidadeCompradora         = $oDado->codigounidadecompradora;
        $oDadosAPI->tipoinstrumentoconvocatorioid   = $oDado->tipoinstrumentoconvocatorioid;
        $oDadosAPI->modalidadeid                    = $oDado->modalidadeid;
        $oDadosAPI->mododisputaid                   = $oDado->mododisputaid;
        $oDadosAPI->numerocompra                    = $oDado->numerocompra;
        $oDadosAPI->anocompra                       = $oDado->anocompra;
        $oDadosAPI->numeroprocesso                  = $oDado->numeroprocesso;
        $oDadosAPI->objetocompra                    = urlencode($oDado->objetocompra);
        $oDadosAPI->informacaocomplementar          = $oDado->informacaocomplementar;
        $oDadosAPI->srp                             = $oDado->srp;
        $oDadosAPI->orcamentosigiloso               = $oDado->orcamentosigiloso;
        $oDadosAPI->dataaberturaproposta            = $oDado->dataaberturaproposta;
        $oDadosAPI->dataencerramentoproposta        = $oDado->dataencerramentoproposta;
        $oDadosAPI->amparolegalid                   = $oDado->amparolegalid;
        $oDadosAPI->linksistemaorigem               = $oDado->linksistemaorigem;
        //ITENS
        foreach ($oDado->itensCompra as $key => $item) {
            $oDadosAPI->itensCompra[$key]->numeroitem = $item->numeroitem;
            $oDadosAPI->itensCompra[$key]->materialouservico           = $item->materialouservico;
            $oDadosAPI->itensCompra[$key]->tipobeneficioid             = $item->tipobeneficioid;
            $oDadosAPI->itensCompra[$key]->incentivoprodutivobasico    = $item->incentivoprodutivobasico;
            $oDadosAPI->itensCompra[$key]->descricao                   = urlencode($item->descricao);
            $oDadosAPI->itensCompra[$key]->unidademedida               = urlencode($item->unidademedida);
            $oDadosAPI->itensCompra[$key]->valorunitarioestimado       = $item->valorunitarioestimado;
            $oDadosAPI->itensCompra[$key]->valortotal                  = $item->valortotal;
            $oDadosAPI->itensCompra[$key]->criteriojulgamentoid        = $item->criteriojulgamentoid;
        }

        $aDadosAPI = $oDadosAPI;

        $name = 'Compra' . $oDado->numerocompra . '.json';
        $arquivo = 'model/licitacao/PNCP/arquivos/' . $name;

        file_put_contents($arquivo, json_encode($aDadosAPI));
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
        //ini_set('display_errors', 'on');
        $this->enviarAviso($tipoDocumento, $processo);
        //criar forma de controle de informacoes enviadas
    }
}
