<?php

use ECidade\Patrimonial\Licitacao\PNCP\ModeloBasePNCP;

/**
 * Classe responsvel por montar as informaes do Envio de Contratos - PNCP
 *
 * @package  ECidade\model\contrato\PNCP
 * @author   Dayvison Nunes
 */
class ContratoPNCP extends ModeloBasePNCP
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
        $oDado = $this->dados;

        if ($oDado->receita = 't')
            $oDado->receita = true;

        $aDadosAPI = array(
            'cnpjCompra'                               => '17316563000196', //$oDado->cnpjcompra,
            'anoCompra'                                => $oDado->anocompra,
            'sequencialCompra'                         => $oDado->sequencialcompra,
            'tipoContratoId'                           => $oDado->tipocontratoid,
            'numeroContratoEmpenho'                    => $oDado->numerocontratoempenho,
            'anoContrato'                              => $oDado->anocontrato,
            'processo'                                 => $oDado->processo,
            'categoriaProcessoId'                      => 8,
            'niFornecedor'                             => $oDado->nifornecedor,
            'tipoPessoaFornecedor'                     => 'PJ', //$oDado->tipopessoafornecedor,
            'nomeRazaoSocialFornecedor'                => $oDado->nomerazaosocialfornecedor,
            'receita'                                  => $oDado->receita,
            'codigoUnidade'                            => '01001', //$oDado->codigounidade,
            'objetoContrato'                           => $oDado->objetocontrato,
            'valorInicial'                             => $oDado->valorinicial,
            'numeroParcelas'                           => $oDado->numeroparcelas,
            'valorParcela'                             => $oDado->valorparcela,
            'valorGlobal'                              => $oDado->valorglobal,
            'dataAssinatura'                           => $oDado->dataassinatura,
            'dataVigenciaInicio'                       => $oDado->datavigenciainicio,
            'dataVigenciaFim'                          => $oDado->datavigenciafim,
            'valorAcumulado'                           => $oDado->valorAcumulado,
        );
        $oDadosAPI = $aDadosAPI;

        return $oDadosAPI;
    }

    public function montarRetificacao()
    {
        $oDado = $this->dados;

        if ($oDado->receita = 't')
            $oDado->receita = true;

        $aDadosAPI = array(
            'cnpjCompra'                               => '17316563000196', //$oDado->cnpjcompra,
            'anoCompra'                                => $oDado->anocompra,
            'sequencialCompra'                         => $oDado->sequencialcompra,
            'tipoContratoId'                           => $oDado->tipocontratoid,
            'numeroContratoEmpenho'                    => $oDado->numerocontratoempenho,
            'anoContrato'                              => $oDado->anocontrato,
            'processo'                                 => $oDado->processo,
            'categoriaProcessoId'                      => $oDado->categoriaprocessoid,
            'niFornecedor'                             => $oDado->nifornecedor,
            'tipoPessoaFornecedor'                     => 'PJ', //$oDado->tipopessoafornecedor,
            'nomeRazaoSocialFornecedor'                => $oDado->nomerazaosocialfornecedor,
            'receita'                                  => $oDado->receita,
            'codigoUnidade'                            => '01001', //$oDado->codigounidade,
            'objetoContrato'                           => $oDado->objetocontrato,
            'valorInicial'                             => $oDado->valorinicial,
            'numeroParcelas'                           => $oDado->numeroparcelas,
            'valorParcela'                             => $oDado->valorparcela,
            'valorGlobal'                              => $oDado->valorglobal,
            'dataAssinatura'                           => $oDado->dataassinatura,
            'dataVigenciaInicio'                       => $oDado->datavigenciainicio,
            'dataVigenciaFim'                          => $oDado->datavigenciafim,
            'valorAcumulado'                           => $oDado->valorAcumulado,
        );

        $oDadosAPI = $aDadosAPI;

        return $oDadosAPI;
    }

    public function enviarContrato($dados)
    {

        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj = '17316563000196';

        $url = "https://pncp.gov.br/pncp-api/v1/orgaos/" . $cnpj . "/contratos";

        $method = 'POST';

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token,
        );

        $optionspncp = array(
            CURLOPT_RETURNTRANSFER => 1,            // return web page
            CURLOPT_POST           => 1,
            CURLOPT_HEADER         => true,         // return headers
            CURLOPT_FOLLOWLOCATION => true,         // follow redirects
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_AUTOREFERER    => true,         // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
            CURLOPT_TIMEOUT        => 120,          // timeout on response
            CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
            CURLOPT_CUSTOMREQUEST  => $method,      // i am sending post data
            CURLOPT_POSTFIELDS     => $dados,
            CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,        //
            CURLOPT_VERBOSE        => 1,            //
            CURLINFO_HEADER_OUT    => true
        );

        curl_setopt_array($chpncp, $optionspncp);

        $contentpncp = curl_exec($chpncp);
        /*$err     = curl_errno($chpncp);
        $errmsg  = curl_error($chpncp);
        $header  = curl_getinfo($chpncp);
        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['header']  = $contentpncp;
        echo "<pre>";
        print_r($header);
        exit;*/
        curl_close($chpncp);

        $retorno = explode(':', $contentpncp);

        ////erro ao enviar aviso
        if ($retorno[23]) {
            return array(422, $retorno[17]);
        }
        //caso tenha enviado com sucesso!
        else {
            return array(201, $retorno[6]);
        }
    }

    public function enviarRetificacaoContrato($dadosPNCP, $dadosExtras)
    {
        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj = substr($dadosExtras->ac213_numerocontrolepncp, 0, 14);
        $ano = $dadosExtras->anocompra;

        $sequencial = $dadosExtras->ac213_sequencialpncp;

        $url = "https://pncp.gov.br/pncp-api/v1/orgaos/" . $cnpj . "/contratos" . "/" . $ano . "/" . $sequencial;

        $method = 'PUT';

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
            CURLOPT_POSTFIELDS     => $dadosPNCP,
            CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,        //
            CURLOPT_VERBOSE        => 1,            //
            CURLINFO_HEADER_OUT    => true
        );


        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);
        $err     = curl_errno($chpncp);
        $errmsg  = curl_error($chpncp);
        $header  = curl_getinfo($chpncp);
        /*$header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['header']  = $contentpncp;
        echo "<pre>";
        print_r($header);
        exit;
        */
        curl_close($chpncp);

        $retorno = explode(':', $contentpncp);

        if (substr($retorno[0], 7, 3) == 201)
            return array($retorno[5] . $retorno[6], substr($retorno[0], 7, 3));
        return array($retorno[22], substr($retorno[0], 7, 3));
    }

    public function enviarRetificacaoEmpenho($dadosPNCP, $dadosExtras)
    {
        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj = substr($dadosExtras->e213_numerocontrolepncp, 0, 14);

        $ano = $dadosExtras->anocompra;

        $sequencial = $dadosExtras->e213_sequencialpncp;

        $url = "https://pncp.gov.br/pncp-api/v1/orgaos/" . $cnpj . "/contratos" . "/" . $ano . "/" . $sequencial;

        $method = 'PUT';

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
            CURLOPT_POSTFIELDS     => $dadosPNCP,
            CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,        //
            CURLOPT_VERBOSE        => 1,            //
            CURLINFO_HEADER_OUT    => true
        );


        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);
        $err     = curl_errno($chpncp);
        $errmsg  = curl_error($chpncp);
        $header  = curl_getinfo($chpncp);
        /*$header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['header']  = $contentpncp;
        echo "<pre>";
        print_r($header);
        exit;
        */
        curl_close($chpncp);

        $retorno = explode(':', $contentpncp);

        if (substr($retorno[0], 7, 3) == 201)
            return array($retorno[5] . $retorno[6], substr($retorno[0], 7, 3));
        return array($retorno[22], substr($retorno[0], 7, 3));
    }

    public function excluirContrato($sequencial, $ano, $cnpj)
    {
        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj = substr($cnpj, 0, 14);

        $url = "https://pncp.gov.br/pncp-api/v1/orgaos/" . $cnpj . "/contratos" . "/" . $ano . "/" . $sequencial;

        $method = 'DELETE';

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token,
        );

        $optionspncp = array(
            CURLOPT_RETURNTRANSFER => 1,            // return web page
            CURLOPT_POST           => 1,
            CURLOPT_HEADER         => false,         // don't return headers
            CURLOPT_FOLLOWLOCATION => true,         // follow redirects
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_AUTOREFERER    => true,         // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
            CURLOPT_TIMEOUT        => 120,          // timeout on response
            CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
            CURLOPT_CUSTOMREQUEST  => $method,      // i am sending post data
            CURLOPT_POSTFIELDS     => '',
            CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,        //
            CURLOPT_VERBOSE        => 1,            //
            CURLINFO_HEADER_OUT    => true
        );


        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);

        curl_close($chpncp);

        $retorno = json_decode($contentpncp);

        return $retorno;
    }

    public function enviarArquivoContrato($dados, $file, $Documentos)
    {

        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj = substr($dados->ac213_numerocontrolepncp, 0, 14);

        $url = "https://pncp.gov.br/pncp-api/v1/orgaos/" . $cnpj . "/contratos" . "/" . $dados->ac213_ano . "/" . $dados->ac213_sequencialpncp . "/arquivos";

        $method = 'POST';

        $cfile = new \CURLFile($file);

        $arquivo = array(
            'arquivo' =>  $cfile
        );

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: multipart/form-data',
            'Authorization: ' . $token,
            'Titulo-Documento: Contrato ' . $dados->ac213_sequencialpncp . "/" . $dados->ac213_ano . " Anexo " . $Documentos,
            'Tipo-Documento-Id: 12'
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
            CURLOPT_POSTFIELDS     => $arquivo,
            CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,        //
            CURLOPT_VERBOSE        => 1,            //
            CURLINFO_HEADER_OUT    => true
        );


        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);
        /*$err     = curl_errno($chpncp);
        $errmsg  = curl_error($chpncp);
        $header  = curl_getinfo($chpncp);
        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['header']  = $contentpncp;
        echo "<pre>";
        print_r($header);
        exit;*/

        curl_close($chpncp);


        $retorno = explode(':', $contentpncp);

        if (substr($retorno[0], 7, 3) == 201)
            return array($retorno[5] . $retorno[6], substr($retorno[0], 7, 3));
        return array($retorno[24], $retorno[17], $retorno[18]);
    }

    public function excluirArquivoContrato($dados)
    {

        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj = substr($dados->ac214_numerocontrolepncp, 0, 14);

        $url = "https://pncp.gov.br/pncp-api/v1/orgaos/" . $cnpj . "/contratos" . "/" . $dados->ac214_ano . "/" . $dados->ac214_sequencialpncp . "/arquivos" . "/" . $dados->ac214_sequencialarquivo;

        $method = 'DELETE';

        $justificativa = '{"justificativa":"Excluindo arquivo do PNCP"}';

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token,
        );

        $optionspncp = array(
            CURLOPT_RETURNTRANSFER => 1,            // return web page
            CURLOPT_POST           => 1,
            CURLOPT_HEADER         => false,         // don't return headers
            CURLOPT_FOLLOWLOCATION => true,         // follow redirects
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_AUTOREFERER    => true,         // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
            CURLOPT_TIMEOUT        => 120,          // timeout on response
            CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
            CURLOPT_CUSTOMREQUEST  => $method,      // i am sending post data
            CURLOPT_POSTFIELDS     => $justificativa,
            CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,        //
            CURLOPT_VERBOSE        => 1,            //
            CURLINFO_HEADER_OUT    => true
        );


        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);

        curl_close($chpncp);

        $retorno = json_decode($contentpncp);

        return $retorno;
    }
}
