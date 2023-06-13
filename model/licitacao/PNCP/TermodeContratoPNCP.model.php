<?php

use ECidade\Patrimonial\Licitacao\PNCP\ModeloBasePNCP;

/**
 * Classe responsvel pelo Envio de Avisos de Licitacao - PNCP
 *
 * @package  ECidade\model\licitacao\PNCP
 * @author   Mario Junior
 */
class TermdoeContrato extends ModeloBasePNCP
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

        $oDadosAPI                                          = new \stdClass;
        $oDadosAPI->tipoTermoContratoId                     = $oDado[0]->tipotermocontratoid;
        $oDadosAPI->numeroTermoContrato                     = $oDado[0]->numerotermocontrato;
        $oDadosAPI->objetoTermoContrato                     = utf8_encode($oDado[0]->objetotermocontrato);
        $oDadosAPI->qualificacaoAcrescimoSupressao          = $oDado[0]->qualificacaoacrescimosupressao == 'f' ? 'false' : 'true';
        $oDadosAPI->qualificacaoVigencia                    = $oDado[0]->qualificacaovigencia == 'f' ? 'false' : 'true';
        $oDadosAPI->qualificacaoFornecedor                  = $oDado[0]->qualificacaofornecedor == 'f' ? 'false' : 'true';
        $oDadosAPI->qualificacaoInformativo                 = 'false';
        $oDadosAPI->qualificacaoReajuste                    = $oDado[0]->qualificacaoreajuste == 'f' ? 'false' : 'true';
        $oDadosAPI->dataAssinatura                          = $this->formatDate($oDado[0]->dataassinatura);
        $oDadosAPI->niFornecedor                            = $oDado[0]->nifornecedor;
        $oDadosAPI->tipoPessoaFornecedor                    = $oDado[0]->tipopessoafornecedor;
        $oDadosAPI->nomeRazaoSocialFornecedor               = utf8_encode($oDado[0]->nomerazaosocialfornecedor);
        //$oDadosAPI->niFornecedorSubContratado               = $oDado[0]->niFornecedorSubContratado;
        //$oDadosAPI->tipoPessoaFornecedorSubContratado       = $oDado[0]->tipoPessoaFornecedorSubContratado;
        //$oDadosAPI->nomeRazaoSocialFornecedorSubContratado  = $oDado[0]->nomeRazaoSocialFornecedorSubContratado;
        //$oDadosAPI->informativoObservacao                   = $oDado[0]->informativoObservacao; CAMPO JUSTIFICATIVA
        //$oDadosAPI->fundamentoLegal                         = $oDado[0]->fundamentoLegal;
        //$oDadosAPI->valorAcrescido                          = $oDado[0]->valoracrescido;
        //$oDadosAPI->numeroParcelas                          = $oDado[0]->numeroParcelas;
        //$oDadosAPI->valorParcela                            = $oDado[0]->valorParcela;
        //$oDadosAPI->valorGlobal                             = $oDado[0]->valorGlobal;
        //$oDadosAPI->prazoAditadoDias                        = $oDado[0]->prazoAditadoDias;
        //$oDadosAPI->dataVigenciaInicio                      = $oDado[0]->dataVigenciaInicio;
        //$oDadosAPI->dataVigenciaFim                         = $oDado[0]->dataVigenciaFim;

        $aDadosAPI = json_encode($oDadosAPI);

        return $aDadosAPI;
    }

    public function montarRetificacao()
    {
        //ini_set('display_errors', 'on');
        $aDadosAPI = array();
        
        $oDado = $this->dados;

        $oDadosAPI                                          = new \stdClass;
        $oDadosAPI->tipoTermoContratoId                     = $oDado[0]->tipotermocontratoid;
        $oDadosAPI->numeroTermoContrato                     = $oDado[0]->numerotermocontrato;
        $oDadosAPI->objetoTermoContrato                     = $oDado[0]->objetotermocontrato;
        $oDadosAPI->qualificacaoAcrescimoSupressao          = $oDado[0]->qualificacaoacrescimosupressao;
        $oDadosAPI->qualificacaoVigencia                    = $oDado[0]->qualificacaovigencia;
        $oDadosAPI->qualificacaoFornecedor                  = $oDado[0]->qualificacaofornecedor;
        $oDadosAPI->qualificacaoInformativo                 = 'false';
        $oDadosAPI->qualificacaoReajuste                    = $oDado[0]->qualificacaoreajuste;
        $oDadosAPI->dataAssinatura                          = $this->formatDate($oDado[0]->dataassinatura);
        $oDadosAPI->niFornecedor                            = $oDado[0]->nifornecedor;
        $oDadosAPI->tipoPessoaFornecedor                    = $oDado[0]->tipopessoafornecedor;
        $oDadosAPI->nomeRazaoSocialFornecedor               = utf8_encode($oDado[0]->nomerazaosocialfornecedor);
        //$oDadosAPI->niFornecedorSubContratado               = $oDado[0]->niFornecedorSubContratado;
        //$oDadosAPI->tipoPessoaFornecedorSubContratado       = $oDado[0]->tipoPessoaFornecedorSubContratado;
        //$oDadosAPI->nomeRazaoSocialFornecedorSubContratado  = $oDado[0]->nomeRazaoSocialFornecedorSubContratado;
        //$oDadosAPI->informativoObservacao                   = $oDado[0]->informativoObservacao;
        //$oDadosAPI->fundamentoLegal                         = $oDado[0]->fundamentoLegal;
        //$oDadosAPI->valorAcrescido                          = $oDado[0]->valoracrescido;
        //$oDadosAPI->numeroParcelas                          = $oDado[0]->numeroParcelas;
        //$oDadosAPI->valorParcela                            = $oDado[0]->valorParcela;
        //$oDadosAPI->valorGlobal                             = $oDado[0]->valorGlobal;
        //$oDadosAPI->prazoAditadoDias                        = $oDado[0]->prazoAditadoDias;
        //$oDadosAPI->dataVigenciaInicio                      = $oDado[0]->dataVigenciaInicio;
        //$oDadosAPI->dataVigenciaFim                         = $oDado[0]->dataVigenciaFim;
        $aDadosAPI = json_encode($oDadosAPI);

        return $aDadosAPI;
    }

    public function enviarTermo($oDados, $sCodigoControlePNCP, $iAnoContrato)
    {
        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj =  $this->getCnpj();
        
        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/contratos/$iAnoContrato/$sCodigoControlePNCP/termos";
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
        /*$err     = curl_errno($chpncp);
        $errmsg  = curl_error($chpncp);
        $header  = curl_getinfo($chpncp);
        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['header']  = $contentpncp;
        echo "<pre>";
        print_r($header);
        exit;*/

        $retorno = explode(':', $contentpncp);
        
        if (substr($retorno[0], 7, 3) == 201) {
            return array($retorno[6], 201);
        } else {
            return array($retorno[17], 422);
        }
    }

    public function retificarResultado($oDados, $sCodigoControlePNCP, $iAnoContrato, $seqitem, $seqresultado)
    {
        ///nada
    }
}
