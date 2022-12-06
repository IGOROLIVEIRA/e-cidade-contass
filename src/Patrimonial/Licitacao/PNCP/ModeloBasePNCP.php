<?php

namespace ECidade\Patrimonial\Licitacao\PNCP;

use funcao;
use stdClass;

/**
 * Classe base para PNCP
 *
 * @package  PNCP
 * @author   Mario Junior
 */
abstract class ModeloBasePNCP
{
    /**
     * Dados
     * @var \stdClass
     */
    protected $dados;

    /**
     *
     * @param \stdClass $dados
     */
    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    /**
     * Retorna dados no formato necessario para envio
     * @return array stdClass
     */
    abstract public function montarDados();

    /**
     * Retorna dados no formato necessario para envio de Retificacao
     * @return array stdClass
     */
    abstract public function montarRetificacao();


    public function formatDate($date)
    {
        $date = \DateTime::createFromFormat('Y-m-d', $date);
        return $date->format('Y-m-d\TH:i:s');
    }

    public function formatText($text)
    {
        return preg_replace(array("/(�|�|�|�|�)/", "/(�|�|�|�|�)/", "/(�|�|�|�)/", "/(�|�|�|�)/", "/(�|�|�|�)/", "/(�|�|�|�)/", "/(�|�|�|�|�)/", "/(�|�|�|�|�)/", "/(�|�|�|�)/", "/(�|�|�|�)/", "/(�)/", "/(�)/", "/(�)/", "/(�)/", "/(-)/"), explode(" ", "a A e E i I o O u U n c C N "), $text);
    }

    /**
     * Realiza o login com Usuario e Senha da Instituicao na api do PNCP
     * @return token de acesso valido por 60 minutos
     */
    public function login()
    {
        $url = "https://treina.pncp.gov.br/pncp-api/v1/usuarios/login";

        $curl_data = array(
            'login' => 'f96951f1-dc6d-4762-a054-e28188fbf642',
            'senha' =>  'wAAv1v27F34VEu6Y'
        );

        $headers = array(
            'Content-Type: application/json'
        );

        $method = 'POST';

        $options = array(
            CURLOPT_RETURNTRANSFER => true,         // return web page
            CURLOPT_HEADER         => true,         // don't return headers
            CURLOPT_FOLLOWLOCATION => true,         // follow redirects
            //CURLOPT_USERAGENT      => "spider",     // who am i
            CURLOPT_AUTOREFERER    => true,         // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
            CURLOPT_TIMEOUT        => 120,          // timeout on response
            CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
            CURLOPT_CUSTOMREQUEST  => $method,      // i am sending post data
            CURLOPT_POSTFIELDS     => json_encode($curl_data),   // this are my post vars
            CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,        //
            CURLOPT_VERBOSE        => 1,            //
            CURLOPT_HTTPHEADER     => $headers
        );

        $ch      = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $err     = curl_errno($ch);
        $errmsg  = curl_error($ch);
        $header  = curl_getinfo($ch);
        curl_close($ch);

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['header']  = $content;

        $aHeader = explode(':', $content);
        $token = substr($aHeader[5], 1, -24);

        return $token;
    }

    /**
     * Realiza o requisicao na api do PNCP
     *
     * @param \int $tipoDocumento
     * 1  - Aviso de Contratao Direta
     * 2  - Edital
     * 11 - Ata de Registro de Preo
     */

    public function enviarAviso($tipodocumento, $processo)
    {

        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj = '17316563000196';

        $url = "https://treina.pncp.gov.br/pncp-api/v1/orgaos/" . $cnpj . "/compras";

        $method = 'POST';

        $file = 'model/licitacao/PNCP/arquivos/Compra' . $processo . '.json';
        $filezip = curl_file_create('model/licitacao/PNCP/arquivos/Compra' . $processo . '.zip');

        $cfile = new \CURLFile($file, 'application/json', 'compra');
        //$cfilezip = new \CURLFile($filezip, 'application/zip', 'documento');
        $post_data =  array(
            'compra' => $cfile,
            'documento' => $filezip
        );

        $chpncp      = curl_init($url);

        $headers = array(
            'Content-Type: multipart/form-data',
            'Authorization: ' . $token,
            'Titulo-Documento:Compra' . $processo,
            'Tipo-Documento-Id:' . $tipodocumento
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
            CURLOPT_POSTFIELDS     => $post_data,
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

    public function enviarRetificacao($oDados, $sCodigoControlePNCP, $iAnoCompra)
    {
        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj = '17316563000196';

        $url = "https://treina.pncp.gov.br/pncp-api/v1/orgaos/" . $cnpj . "/compras/$iAnoCompra/$sCodigoControlePNCP";

        $method = 'PATCH';

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

        $retorno = json_decode($contentpncp);

        return $retorno;
    }

    public function excluirAviso($sCodigoControlePNCP, $iAnoCompra)
    {
        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj = '17316563000196';

        $url = "https://treina.pncp.gov.br/pncp-api/v1/orgaos/" . $cnpj . "/compras/$iAnoCompra/$sCodigoControlePNCP";

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
        /*echo "<pre>";
        print_r(json_decode($contentpncp));
        exit;*/

        curl_close($chpncp);

        $retorno = json_decode($contentpncp);

        return $retorno;
    }

    public function enviarContrato($dados,$processo,$tipodocumento)
    {

        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj = '17316563000196';

        $url = "https://treina.pncp.gov.br/pncp-api/v1/orgaos/" . $cnpj . "/contratos";

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
       
        curl_close($chpncp);

        $retorno = explode(':',$contentpncp);
       
        if (substr($retorno[0],7,3) == 201)
            return array($retorno[5].$retorno[6],substr($retorno[0],7,3));
        return array($retorno[17],substr($retorno[0],7,3));    
            
    }

    public function excluirContrato($codigo)
    {
        $token = $this->login();

        //aqui sera necessario informar o cnpj da instituicao de envio
        $cnpj = '17316563000196';

        $ano  = '2022';

        $sequencial = '104';

        $url = "https://treina.pncp.gov.br/pncp-api/v1/orgaos/" . $cnpj . "/contratos"."/".$ano."/".$sequencial;

        $method = 'DELETE';
         
        $chpncp      = curl_init($url);

        $justificativa = array("justificativa" => "Teste envio");

        $justificativaJson =  json_encode($justificativa);
    
        $headers = array(
            'Content-Type: application/json',
            'Authorization: ' . $token,
            // 'Titulo-Documento:Compra' . $processo,
            // 'Tipo-Documento-Id:' . $tipodocumento
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
            CURLOPT_POSTFIELDS     => $justificativaJson,
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
        print_r($contentpncp);
        exit;*/
        // print_r(utf8_encode_all($contentpncp));exit;
        curl_close($chpncp);

        $retorno = json_decode($contentpncp);
        // print_r(utf8_encode_all($retorno));exit;
        return $retorno;
    }    
}
