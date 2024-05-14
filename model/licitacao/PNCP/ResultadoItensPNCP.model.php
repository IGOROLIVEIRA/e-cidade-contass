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
        $oDadosAPI->indicadorSubcontratacao         = $oDado[0]->indicadorsubcontratacao == 2 ? 'false' : 'true';
        $oDadosAPI->ordemClassificacaoSrp           = 1;
        $oDadosAPI->dataResultado                   = $this->formatDate($oDado[0]->dataresultado);
        $oDadosAPI->situacaoCompraItemResultadoId   = 1;

        //naturezaJuridicaId faltando campo nao obrigatorio

        return json_encode($oDadosAPI);
    }

    public function montarRetificacao()
    {

        $oDado = $this->dados;

        $oDadosAPI                                  = new \stdClass;
        $oDadosAPI->codigoUnidadeCompradora         = $this->getUndCompradora();
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

        return json_encode($oDadosAPI);
    }

    public function enviarResultado($oDados, $sCodigoControlePNCP, $iAnoCompra, $seqitem)
    {
        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj =  $this->getCnpj();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/compras/$iAnoCompra/$sCodigoControlePNCP/itens/$seqitem/resultados";

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token
        );

        $optionspncp = $this->getParancurl('POST',$oDados,$headers,null,true);

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

    public function retificarResultado($oDados, $sCodigoControlePNCP, $iAnoCompra, $seqitem, $seqresultado)
    {
        $token = $this->login();

        $cnpj =  $this->getCnpj();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/compras/$iAnoCompra/$sCodigoControlePNCP/itens/$seqitem/resultados/$seqresultado";

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token
        );

        $optionspncp = $this->getParancurl('PUT',$oDados,$headers,false,true);

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

        if (substr($retorno[0], 7, 3) == '200') {
            return array(201, "Enviado com Sucesso!");
        } elseif(substr($retorno[0],7,3) == "404"){
            return array(422, $retorno[22] . "-".$retorno[23]);
        }else {
            return array(422, $retorno[17]);
        }
    }
}
