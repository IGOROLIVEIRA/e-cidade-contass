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
            CURLOPT_POSTFIELDS     => $oDadosAta,
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

    public function enviarRetificacaoAta($oDados, $sCodigoControlePNCP, $iAnoCompra, $iCodigoAta)
    {
        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj =  $this->getCnpj();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/compras/" . $iAnoCompra . "/" . $sCodigoControlePNCP . "/atas/$iCodigoAta";

        $method = 'PUT';

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token
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

        $method = 'DELETE';

        $chpncp = curl_init($url);

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
            //CURLOPT_POSTFIELDS     => $oDados,
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

        $retorno = json_decode($contentpncp);

        return $retorno;
    }

    public function enviarAnexos($iAnoCompra,$iCodigoCompra,$iCodigoAta,$iArquivo,$sDescricao,$iTipoAnexo)
    {
        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj =  $this->getCnpj();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/compras/" . $iAnoCompra . "/" . $iCodigoCompra . "/atas/".$iCodigoAta."/arquivos";

        $method = 'POST';

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
            CURLOPT_POSTFIELDS     => $post_data,
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

        if ($retorno[5] == ' https') {
            return array(201, $retorno[6]);
        } else {
            return array(422, "Erro ao enviar anexo");
        }
    }

    public function excluirAnexos($iAnoContrato,$iCodigoContrato,$iCodigoTermo,$iSeqAnexo)
    {

        $cnpj =  $this->getCnpj();
        $token = $this->login();

        $url = $this->envs['URL'] . "orgaos/" . $cnpj . "/contratos/" . $iAnoContrato . "/" . $iCodigoContrato . "/termos/".$iCodigoTermo."/arquivos/".$iSeqAnexo;

        $method = 'DELETE';

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token
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
            //CURLOPT_POSTFIELDS     => $oDados,
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

        $retorno = json_decode($contentpncp);

        if ($retorno->status) {
            return array(422, $retorno->message);
        } else {
            return array(201, "Excluido com Sucesso !");
        }
    }
}
