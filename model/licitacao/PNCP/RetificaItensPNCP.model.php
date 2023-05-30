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
        $oDadosAPI->tipoBeneficioId             = $oDado[0]->tipobeneficioid;
        $oDadosAPI->incentivoProdutivoBasico    = $oDado[0]->incentivoprodutivobasico == 'f' ? 'false' : 'true';
        $oDadosAPI->descricao                   = utf8_encode($oDado[0]->descricao);
        $oDadosAPI->quantidade                  = $oDado[0]->pc11_quant;
        $oDadosAPI->unidadeMedida               = utf8_encode($oDado[0]->unidademedida);
        $oDadosAPI->orcamentoSigiloso           = $oDado[0]->l21_sigilo == 'f' ? 'false' : 'true';
        $oDadosAPI->valorUnitarioEstimado       = $oDado[0]->valorunitarioestimado;
        $oDadosAPI->valorTotal                  = $vlrtotal;
        $oDadosAPI->situacaoCompraItemId        = $oDado[0]->situacaocompraitemid;    
           
        //DISPENSA E INEXIGIBILIDADE
        if($oDado[0]->modalidadeid == "8" || $oDado[0]->modalidadeid == "9"){
        $oDadosAPI->criterioJulgamentoId        = 7;
        }else{
            $oDadosAPI->criterioJulgamentoId    = $oDado[0]->itemcategoriaid;
        }
        //CONCURSO
        if($oDado[0]->modalidadeid == "3"){
            $oDadosAPI->criterioJulgamentoId    = 8;
        }
        $oDadosAPI->itemCategoriaId             = $oDado[0]->itemcategoriaid;
        if($oDado[0]->itemcategoriaid == '3'){
            $oDadosAPI->justificativa           = utf8_encode($oDado[0]->justificativa);
        }

        $aDadosAPI = json_encode($oDadosAPI);

        return $aDadosAPI;
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

        if (substr($retorno[0], 7, 3) == '200') {
            return array(201, "Enviado com Sucesso!");
        } else {
            return array(422, $retorno[17]);
        }
    }
}
