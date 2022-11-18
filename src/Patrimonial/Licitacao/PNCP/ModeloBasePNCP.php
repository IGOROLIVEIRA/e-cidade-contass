<?php

namespace ECidade\Patrimonial\Licitacao\PNCP;

use funcao;

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

    public function formatDate($date)
    {
        $date = \DateTime::createFromFormat('Y-m-d', $date);
        return $date->format('Y-m-d\TH:i:s');
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
     * Realiza o requisicao para buscar orgaos na api do PNCP
     * @return stdClass
     */

    public function getOrgao()
    {
        /* $token = $this->login();

        $url = "https://treina.pncp.gov.br/pncp-api/v1/orgaos/01348745000109";

        $curl_data = array(
            'cnpj' => '01348745000109'
        );

        $headers = array(
            'Content-Type: application/json',
            'Authorizarion:' . $token
        );

        $method = 'GET';

        $response = $this->requestPNCP($url, json_encode($curl_data), $method, $headers);*/
    }

    /**
     * Realiza o requisicao na api do PNCP
     * @paran
     * url = url da requisicao
     * curl_data = campos para requisicao
     * method = todos os metodos HTTP
     * headers = header da requisicao OBS: Obrigatorio token de auth
     */
    public function requestPNCP($url, $curl_data = null, $method, $headers, $token = null)
    {
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
        $filezip = 'model/licitacao/PNCP/arquivos/Compra' . $processo . '.zip';

        $cfile = new \CURLFile($file, 'application/json', 'compra');
        $cfilezip = new \CURLFile($filezip, 'application/json', 'documento');
        $post_data =  array(
            'compra' => $cfile,
            'documento' => $cfilezip
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
        echo "<pre>";
        print_r($optionspncp);
        $err     = curl_errno($chpncp);
        $errmsg  = curl_error($chpncp);
        $header  = curl_getinfo($chpncp);
        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['header']  = $contentpncp;
        echo "<pre>";
        print_r($header);
        exit;
        return $header;
    }
}
