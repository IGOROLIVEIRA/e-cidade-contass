<?php

use ECidade\Patrimonial\Licitacao\PNCP\ModeloBasePNCP;

/**
 * Classe responsvel por montar as informaes do Envio de Atas de Registro de precos - PNCP
 *
 * @package  ECidade\model\licitacao\PNCP
 * @author   Mario Junior
 */
class AtaRegistroprecoPNCP extends ModeloBasePNCP
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
        $oDadosAPI->numeroAtaRegistroPreco          = $oDado->numeroataregistropreco;
        $oDadosAPI->anoAta                          = $oDado->anoata;
        $oDadosAPI->dataAssinatura                  = $oDado->dataassinatura;
        $oDadosAPI->dataVigenciaInicio              = $oDado->datavigenciainicio;
        $oDadosAPI->dataVigenciaFim                 = $oDado->datavigenciafim;

        $aDadosAPI = json_encode($oDadosAPI);

        return $aDadosAPI;
    }

    public function montarRetificacao()
    {
        //
    }

    /**
     * Realiza o requisicao na api do PNCP
     *
     * @param \obj
     * oDadosAta - dados de envio da ata
     */

    public function enviarAta($oDadosAta, $sCodigoControlePNCP, $iAnoCompra)
    {

        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj =  $this->getCnpj();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/compras/" . $iAnoCompra . "/" . $sCodigoControlePNCP . "/atas";

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token
        );

        $optionspncp  = $this->getParancurl('POST',$oDadosAta,$headers,false,true);

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

        if(substr($retorno[0], 7, 3) != 201 && $retorno[17]){
            return array($retorno[17], substr($retorno[0], 7, 3));
        }

        if (substr($retorno[0], 7, 3) == 201) {
            return array($retorno[5] . $retorno[6], substr($retorno[0], 7, 3));
        }

        if(substr($retorno[8], 1, 3) == "422"){
            return array($retorno[2],"422");
        }
    }

    public function enviarRetificacaoAta($oDados, $sCodigoControlePNCP, $iAnoCompra, $iCodigoAta)
    {
        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj =  $this->getCnpj();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/compras/" . $iAnoCompra . "/" . $sCodigoControlePNCP . "/atas/$iCodigoAta";

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token
        );

        $optionspncp = $this->getParancurl('PUT',$oDados,$headers,false,false);

        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);

        curl_close($chpncp);

        $retorno = explode(':', $contentpncp);

        if ($retorno[0] == '{"numeroAtaRegistroPreco"') {
            return array('201');
        } else {
            return array($retorno[2]);
        }
    }

    public function excluirAta($sCodigoControlePNCP, $iAnoCompra, $iCodigoAta)
    {
        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj =  $this->getCnpj();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/compras/$iAnoCompra/$sCodigoControlePNCP/atas/$iCodigoAta";

        $chpncp = curl_init($url);

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

        return $retorno;
    }

    public function enviarAnexos($iAnoCompra,$iCodigoCompra,$iCodigoAta,$iArquivo,$sDescricao,$iTipoAnexo)
    {
        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj =  $this->getCnpj();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/compras/" . $iAnoCompra . "/" . $iCodigoCompra . "/atas/".$iCodigoAta."/arquivos";

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
            'Tipo-Documento: ' . $iTipoAnexo
        );

        $optionspncp = $this->getParancurl('POST',$post_data,$headers,false,true);

        curl_setopt_array($chpncp, $optionspncp);
        $contentpncp = curl_exec($chpncp);
        curl_close($chpncp);
        $retorno = explode(':', $contentpncp);

        if ($retorno[5] == ' https') {
            return array(201, $retorno[6]);
        } else {
            return array(422, "Erro ao enviar anexo");
        }
    }

    public function excluirAnexos($iAnoCompra,$iCodigoCompra,$iCodigoAta,$iSeqAnexo)
    {

        $cnpj =  $this->getCnpj();
        $token = $this->login();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/compras/" . $iAnoCompra . "/" . $iCodigoCompra . "/atas/".$iCodigoAta."/arquivos/".$iSeqAnexo;

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
