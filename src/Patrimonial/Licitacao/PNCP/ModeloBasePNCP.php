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

    protected $envs;

    /**
     *
     * @param \stdClass $dados
     */
    public function __construct($dados)
    {
        $this->dados = $dados;
        $this->envs = parse_ini_file('legacy_config/PNCP/.env', true);
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


    protected function formatDate($date)
    {
        $date = \DateTime::createFromFormat('Y-m-d', $date);
        return $date->format('Y-m-d\TH:i:s');
    }

    protected function formatText($text)
    {
        return preg_replace(array("/(ï¿½|ï¿½|ï¿½|ï¿½|ï¿½)/", "/(ï¿½|ï¿½|ï¿½|ï¿½|ï¿½)/", "/(ï¿½|ï¿½|ï¿½|ï¿½)/", "/(ï¿½|ï¿½|ï¿½|ï¿½)/", "/(ï¿½|ï¿½|ï¿½|ï¿½)/", "/(ï¿½|ï¿½|ï¿½|ï¿½)/", "/(ï¿½|ï¿½|ï¿½|ï¿½|ï¿½)/", "/(ï¿½|ï¿½|ï¿½|ï¿½|ï¿½)/", "/(ï¿½|ï¿½|ï¿½|ï¿½)/", "/(ï¿½|ï¿½|ï¿½|ï¿½)/", "/(ï¿½)/", "/(ï¿½)/", "/(ï¿½)/", "/(ï¿½)/", "/(-)/"), explode(" ", "a A e E i I o O u U n c C N "), $text);
    }

    /**
     * Realiza o login com Usuario e Senha da Instituicao na api do PNCP
     * @return token de acesso valido por 60 minutos
     */
    protected function login()
    {

        $url = $this->envs['URL'] . 'usuarios/login';

        $curl_data = array(
            'login' => $this->getLogin(),
            'senha' =>  $this->getPassword()
        );

        $headers = array(
            'Content-Type: application/json'
        );

        $options = $this->getParancurl('POST',$curl_data,$headers,true,true);

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
        $token = substr($aHeader[5], 1, -9);

        return $token;
    }

    protected function getCnpj()
    {
        $sqlCnpj = "SELECT cgm.z01_cgccpf
        FROM db_config
        inner join cgm on db_config.numcgm = cgm.z01_numcgm
        WHERE db_config.codigo = " . db_getsession('DB_instit');
        $rsCnpj = db_query($sqlCnpj);
        $sCNPJ = pg_fetch_row($rsCnpj);
        return $sCNPJ[0];
    }

    protected function getLogin()
    {
        $sqlPNCP = "select l12_loginpncp from licitaparam where l12_instit = " . db_getsession('DB_instit');
        $rsPNCP = db_query($sqlPNCP);
        $sPNCP = pg_fetch_row($rsPNCP);
        return $sPNCP[0];
    }

    protected function getPassword()
    {
        $sqlPNCP = "select l12_passwordpncp from licitaparam where l12_instit = " . db_getsession('DB_instit');
        $rsPNCP = db_query($sqlPNCP);
        $sPNCP = pg_fetch_row($rsPNCP);
        return $sPNCP[0];
    }

    protected function getUndCompradora(){
        $sqlPNCP = "select l12_unidadecompradora from licitaparam where l12_instit = " . db_getsession('DB_instit');
        $rsPNCP = db_query($sqlPNCP);
        $sPNCP = pg_fetch_row($rsPNCP);
        return $sPNCP[0];
    }

    protected function getParancurl ($method,$curl_data,$headers, $jsonencode = false, $rturnHeader = false){
        if($jsonencode){
            $curl_data = json_encode($curl_data);
        }

        return array(
            CURLOPT_RETURNTRANSFER => true,                         // return web page
            CURLOPT_HEADER         => $rturnHeader,                 // don't return headers
            CURLOPT_FOLLOWLOCATION => true,                         // follow redirects
            //CURLOPT_USERAGENT      => "spider",                   // who am i
            CURLOPT_AUTOREFERER    => true,                         // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,                          // timeout on connect
            CURLOPT_TIMEOUT        => 120,                          // timeout on response
            CURLOPT_MAXREDIRS      => 10,                           // stop after 10 redirects
            CURLOPT_CUSTOMREQUEST  => $method,                      // i am sending post data
            CURLOPT_POSTFIELDS     => $curl_data,                   // this are my post vars
            CURLOPT_SSLVERSION     => 6,                            // Force requsts to use TLS 1.2
            CURLOPT_SSL_VERIFYHOST => 0,                            // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,                        //
            CURLOPT_VERBOSE        => 1,                            //
            CURLOPT_HTTPHEADER     => $headers
        );
    }
}
