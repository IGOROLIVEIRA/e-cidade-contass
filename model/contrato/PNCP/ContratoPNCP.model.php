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

        if ($oDado->receita == '')
            $oDado->receita = 'f';

        $aDadosAPI = array(
            'cnpjCompra'                               => $this->getCnpj(), //$oDado->cnpjcompra,
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
            'receita'                                  => $oDado->receita == 'f' ? 'true' : 'false',
            'codigoUnidade'                            => $this->getUndCompradora(),
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

        $aDadosAPI = array(
            'cnpjCompra'                               => $this->getCnpj(), //$oDado->cnpjcompra,
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
            'receita'                                  => $oDado->receita == 'f' ? 'true' : 'false',
            'codigoUnidade'                            => $this->getUndCompradora(),
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
        $cnpj =  $this->getCnpj();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/contratos";

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token,
        );

        $optionspncp = $this->getParancurl('POST',$dados,$headers,false,true);

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

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/contratos" . "/" . $ano . "/" . $sequencial;

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token
        );

        $optionspncp = $this->getParancurl('PUT',$dadosPNCP,$headers,false,false);

        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);
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

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/contratos" . "/" . $ano . "/" . $sequencial;

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token
        );

        $optionspncp = $this->getParancurl('PUT', $dadosPNCP,$headers,false,false);

        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);
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

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/contratos" . "/" . $ano . "/" . $sequencial;

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token,
        );

        $optionspncp = $this->getParancurl('DELETE', null,$headers,false,false);

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

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/contratos" . "/" . $dados->ac213_ano . "/" . $dados->ac213_sequencialpncp . "/arquivos";

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

        $optionspncp = $this->getParancurl('POST',$arquivo,$headers,false,false);

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

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/contratos" . "/" . $dados->ac214_ano . "/" . $dados->ac214_sequencialpncp . "/arquivos" . "/" . $dados->ac214_sequencialarquivo;

        $justificativa = '{"justificativa":"Excluindo arquivo do PNCP"}';

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token,
        );

        $optionspncp = $this->getParancurl('DELETE',$justificativa,$headers,false,false);

        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);

        curl_close($chpncp);

        $retorno = json_decode($contentpncp);

        return $retorno;
    }
}
