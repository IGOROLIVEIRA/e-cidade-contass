<?php

use ECidade\Patrimonial\Licitacao\PNCP\ModeloBasePNCP;

/**
 * Classe responsvel pelo Envio de Avisos de Licitacao - PNCP
 *
 * @package  ECidade\model\licitacao\PNCP
 * @author   Mario Junior
 */
class ResultadoItensPNCP extends ModeloBasePNCP
{

    /**
     *
     * @param \stdClass $dados
     */
    function __construct($dados = null)
    {
        parent::__construct($dados);
    }

    public function montarDados()
    {
        //ini_set('display_errors', 'on');
        $aDadosAPI = array();

        $oDado = $this->dados;

        $oDadosAPI                                  = new \stdClass;
        $oDadosAPI->quantidadeHomologada            = $oDado[0]->quantidadehomologada;
        $oDadosAPI->valorUnitarioHomologado         = $oDado[0]->valorunitariohomologado;
        $oDadosAPI->valorTotalHomologado            = $oDado[0]->valortotalhomologado;
        $oDadosAPI->percentualDesconto              = $oDado[0]->percentualdesconto;
        $oDadosAPI->tipoPessoaId                    = $oDado[0]->tipopessoaid;
        $oDadosAPI->niFornecedor                    = $oDado[0]->nifornecedor;
        $oDadosAPI->nomeRazaoSocialFornecedor       = utf8_encode($oDado[0]->nomerazaosocialfornecedor);
        $oDadosAPI->porteFornecedorId               = $oDado[0]->portefornecedorid;
        $oDadosAPI->codigoPais                      = $oDado[0]->codigopais;
        $oDadosAPI->indicadorSubcontratacao         = $oDado[0]->indicadorsubcontratacao == 'f' ? 'false' : 'true';
        $oDadosAPI->ordemClassificacaoSrp           = 1;
        $oDadosAPI->dataResultado                   = $this->formatDate($oDado[0]->dataresultado);
        //naturezaJuridicaId faltando campo nao obrigatorio

        /*echo "<pre>";
        print_r($oDadosAPI);
        exit;*/

        $aDadosAPI = json_encode($oDadosAPI);

        return $aDadosAPI;
    }

    public function montarRetificacao()
    {
        //ini_set('display_errors', 'on');
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
        $oDadosAPI->objetoCompra                    = $this->formatText($oDado->objetocompra);
        $oDadosAPI->informacaoComplementar          = $oDado->informacaocomplementar;
        $oDadosAPI->srp                             = $oDado->srp == 'f' ? 'false' : 'true';
        $oDadosAPI->orcamentoSigiloso               = $oDado->orcamentosigiloso == 'f' ? 'false' : 'true';
        $oDadosAPI->dataAberturaProposta            = $this->formatDate($oDado->dataaberturaproposta);
        $oDadosAPI->dataEncerramentoProposta        = $this->formatDate($oDado->dataencerramentoproposta);
        $oDadosAPI->amparoLegalId                   = $oDado->amparolegalid;
        $oDadosAPI->linkSistemaOrigem               = $oDado->linksistemaorigem;

        $aDadosAPI = json_encode($oDadosAPI);

        return $aDadosAPI;
    }

    public function enviarResultado($oDados, $sCodigoControlePNCP, $iAnoCompra, $seqitem)
    {
        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj = '17316563000196';

        $url = "https://treina.pncp.gov.br/pncp-api/v1/orgaos/" . $cnpj . "/compras/$iAnoCompra/$sCodigoControlePNCP/itens/$seqitem/resultados";

        $method = 'POST';

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token
        );

        $optionspncp = array(
            CURLOPT_RETURNTRANSFER => 1,            // return web page
            CURLOPT_POST           => 1,
            CURLOPT_HEADER         => true,         // don't return headers
            CURLOPT_FOLLOWLOCATION => true,         // follow redirects
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_AUTOREFERER    => true,         // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
            CURLOPT_TIMEOUT        => 120,          // timeout on response
            CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
            CURLOPT_CUSTOMREQUEST  => $method,      // i am sending post data
            CURLOPT_POSTFIELDS     => $oDados,
            CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,        //
            CURLOPT_VERBOSE        => 1,            //
            CURLINFO_HEADER_OUT    => true
        );


        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);
        curl_close($chpncp);

        $retorno = explode(':', $contentpncp);

        if (substr($retorno[0], 7, 3) == 201) {
            return array($retorno[5] . $retorno[6], substr($retorno[0], 7, 3));
        } else {
            return array($retorno[17], substr($retorno[0], 7, 3));
        }
    }
}
