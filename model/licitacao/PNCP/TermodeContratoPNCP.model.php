<?php

use ECidade\Patrimonial\Licitacao\PNCP\ModeloBasePNCP;

/**
 * Classe responsvel pelo Envio de Avisos de Licitacao - PNCP
 *
 * @package  ECidade\model\licitacao\PNCP
 * @author   Mario Junior
 */
class TermodeContrato extends ModeloBasePNCP
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

        $aDadosAPI = array();

        $oDado = $this->dados;

        $oDadosAPI                                          = new \stdClass;
        $oDadosAPI->tipoTermoContratoId                     = $oDado[0]->tipotermocontratoid;
        //aqui eu precisei criar um novo numero de termo quando o tipo for recisao pois nao existe uma posicao no acordo.
        if($oDado[0]->tipotermocontratoid == "1"){
            $oDadosAPI->numeroTermoContrato                     = $oDado[0]->numerotermocontrato + 1;
        }else{
            $oDadosAPI->numeroTermoContrato                     = $oDado[0]->numerotermocontrato;
        }
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

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token
        );

        $optionspncp = $this->getParancurl('POST',$oDados,$headers,false,true);
        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);
        curl_close($chpncp);

        $retorno = explode(':', $contentpncp);

        if (substr($retorno[0], 7, 3) == 201) {
            return array($retorno[6], 201);
        } else {
            return array($retorno[17], 422);
        }
    }

    public function excluirTermo($iAnoContrato, $iCodigoContrato, $iCodigoTermo)
    {
        $token = $this->login();

        $url = $this->envs['URL'] . "orgaos/" . $this->getCnpj() . "/contratos/$iAnoContrato/$iCodigoContrato/termos/$iCodigoTermo";

        $chpncp = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token
        );

        $optionspncp = $this->getParancurl('DELETE',null,$headers,false,false);

        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);
        curl_close($chpncp);

        $retorno = json_decode($contentpncp);

        return $retorno;
    }

    public function enviarAnexos($iAnoContrato,$iCodigoContrato,$iCodigoTermo,$iArquivo,$sDescricao,$iTipoAnexo){

        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj =  $this->getCnpj();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/contratos/" . $iAnoContrato . "/" . $iCodigoContrato . "/termos/".$iCodigoTermo."/arquivos";

        db_inicio_transacao();
        global $conn;

        $sNomeArquivo = "tmp/$iArquivo.pdf";
        pg_lo_export($conn, $iArquivo, $sNomeArquivo);
        db_fim_transacao();

        //arquivo para envio
        $filezip = curl_file_create($sNomeArquivo);

        $post_data =  array(
            'arquivo' => $filezip
        );

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: multipart/form-data',
            'Authorization: ' . $token,
            'Titulo-Documento: ' . $sDescricao,
            'Tipo-Documento-Id: ' . $iTipoAnexo
        );

        $optionspncp = $this->getParancurl('POST',$post_data,$headers,false,true);

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

        if ($retorno[5] == ' https') {
            return array(201, $retorno[6]);
        }

        if (substr($retorno[8],1,3) == "422") {
            return array(422, $retorno[2]);
        }
    }

    public function excluirAnexos($iAnoContrato,$iCodigoContrato,$iCodigoTermo,$iSeqAnexo)
    {

        $cnpj =  $this->getCnpj();
        $token = $this->login();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/contratos/" . $iAnoContrato . "/" . $iCodigoContrato . "/termos/".$iCodigoTermo."/arquivos/".$iSeqAnexo;

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token
        );

        $optionspncp = $this->getParancurl('DELETE',null,$headers,false,false);

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

        $retorno = json_decode($contentpncp);

        if ($retorno->status) {
            return array(422, $retorno->message);
        } else {
            return array(201, "Excluido com Sucesso !");
        }
    }
}
