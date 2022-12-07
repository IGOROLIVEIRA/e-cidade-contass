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
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(ç)/", "/(Ç)/", "/(Ñ)/", "/(-)/"), explode(" ", "a A e E i I o O u U n c C N "), $text);
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
}
