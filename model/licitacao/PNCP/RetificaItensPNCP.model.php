<?php

use ECidade\Patrimonial\Licitacao\PNCP\ModeloBasePNCP;

/**
 * Classe responsvel pelo Envio de Avisos de Licitacao - PNCP
 *
 * @package  ECidade\model\licitacao\PNCP
 * @author   Mario Junior
 */
class RetificaitensPNCP extends ModeloBasePNCP
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

        $vlrtotal = $oDado[0]->pc11_quant * $oDado[0]->valorunitarioestimado;
        $oDadosAPI                                  = new \stdClass;
        $oDadosAPI->numeroItem                  = $oDado[0]->numeroitem;
        $oDadosAPI->materialOuServico           = $oDado[0]->materialouservico;
        if($oDado[0]->modalidadeid == "1" || $oDado[0]->modalidadeid == "13"){
            $oDadosAPI->tipoBeneficioId         = 5;
        }else{
            $oDadosAPI->tipoBeneficioId         = $oDado[0]->tipobeneficioid;
        }
        $oDadosAPI->incentivoProdutivoBasico    = $oDado[0]->incentivoprodutivobasico == 'f' ? 'false' : 'true';
        $oDadosAPI->descricao                   = utf8_encode($oDado[0]->descricao);
        $oDadosAPI->quantidade                  = $oDado[0]->pc11_quant;
        $oDadosAPI->unidadeMedida               = utf8_encode($oDado[0]->unidademedida);
        $oDadosAPI->orcamentoSigiloso           = $oDado[0]->l21_sigilo == 'f' ? 'false' : 'true';
        $oDadosAPI->valorUnitarioEstimado       = $oDado[0]->valorunitarioestimado;
        $oDadosAPI->valorTotal                  = $vlrtotal;
        $oDadosAPI->situacaoCompraItemId        = $oDado[0]->situacaocompraitemid;
        $oDadosAPI->criterioJulgamentoId        = $oDado[0]->criteriojulgamentoid;

        //DISPENSA E INEXIGIBILIDADE
        if($oDado[0]->modalidadeid == "8" || $oDado[0]->modalidadeid == "9"){
            $oDadosAPI->situacaoCompraItemId        = $oDado[0]->pc23_orcamforne ? 2 : 4;
            $oDadosAPI->criterioJulgamentoId        = 7;
        }

        //CONCURSO
        if($oDado[0]->modalidadeid == "3"){
            $oDadosAPI->criterioJulgamentoId    = 8;
        }
        if($oDado[0]->modalidadeid == "1" || $oDado[0]->modalidadeid == "13"){
            $oDadosAPI->itemCategoriaId             = 2;
        }else{
            $oDadosAPI->itemCategoriaId             = 3;
        }

        $oDadosAPI->justificativa           = utf8_encode($oDado[0]->justificativa);

        return json_encode($oDadosAPI);
    }

    public function montarRetificacao()
    {

    }

    public function retificarItem($oDados, $sCodigoControlePNCP, $iAnoCompra, $seqitem)
    {

        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj =  $this->getCnpj();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/compras/$iAnoCompra/$sCodigoControlePNCP/itens/$seqitem";

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
        print_r($header);*/

        $retorno = explode(':', $contentpncp);

        if (substr($retorno[0], 7, 3) == '200') {
            return array(201, "Enviado com Sucesso!");
        } else {
            return array(422, "Retificacao do Item Erro:".$retorno[17].' - '.$retorno[22]);
        }
    }
}
