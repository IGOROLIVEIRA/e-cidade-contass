<?php

namespace ECidade\Financeiro\Efdreinf\Efdreinf;

use \ECidade\V3\Extension\Registry;
use \ECidade\Core\Config;
use DBHttpRequest;
use Exception;

/**
 * Classe respons?vel pelo envio dos dados do eSocial para a API do e-cidade
 */
class Efdreinf
{
    /**
     * Classe para requisi??o HTTP
     *
     * @var DBHttpRequest
     */
    private $httpRequest;

    /**
     * Configura??o da aplica??o
     *
     * @var Config
     */
    private $config;

    /**
     * Recurso para envio dos dados
     *
     * @var string
     */
    private $recurso;

    /**
     * Dados a ser enviados
     *
     * @var array|\stdClass
     */
    private $dados;

    public function __construct($baseUrl, $recurso = NULL)
    {
     
        $httpRequest = new DBHttpRequest(Registry::get('app.config'));
        $httpRequest->addOptions(array(
            'baseUrl' => $baseUrl,
            'headers' => array(
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            )
        ));
        $this->httpRequest = $httpRequest;
     

        $this->recurso = $recurso;
    }

    /**
     * Seta os dados a ser enviados
     *
     * @param \stdClass[] $dados
     */
    public function setDados($dados)
    {
        $this->dados = $dados;
    }

    /**
     * Realiza a requisi??o enviando os dados para API
     */
    public function request()
    {
        $data = json_encode($this->dados);
        
        $resultSend = $this->httpRequest->sendReinf($this->recurso, 'POST', array(
            'body' => $data
        ));

        $result = json_decode($this->httpRequest->getBody());
       
        if ($this->httpRequest->getResponseCode() >= 400) {
            throw new Exception($result->message);
        }
        // print_r($resultSend);exit;
        return $resultSend;
    }

    /**
     * Retorna o c?digo de resposta HTTP da requisi??o
     *
     * @return integer
     */
    public function getResponseCode()
    {
        return $this->httpRequest->getResponseCode();
    }

    /**
     * Retorna o numero do protocolo de envio request realizado
     *
     * @return string
     */
    public function getProtocoloEnvioLote()
    {
        return $this->httpRequest;
    }

    /**
     * Retorna o id do processamento
     *
     * @return string
     */
    public function getIdProcessamento()
    {
        $arrId = current($this->httpRequest->getObjXml()->retornoEventos->evento->attributes());
        return (string) current($arrId);
    }

    /**
     * Retorna o numero do recibo de envio
     *
     * @return string
     */
    public function getNumeroRecibo()
    {
        return $this->httpRequest->getObjXml()->retornoEventos->evento->retornoEvento->eSocial->retornoEvento->recibo->nrRecibo;
    }

    /**
     * Retorna descricao da resposta no status
     *
     * @return string
     */
    public function getDescResposta()
    {
        return (string) $this->httpRequest->getObjXml()->status->descResposta;
    }

    /**
     * Retorna codigo da resposta da conusulta do envio
     *
     * @return string
     */
    public function getCdRespostaProcessamento()
    {
        return (string) $this->httpRequest->getObjXml()->retornoEventos->evento->retornoEvento->eSocial->retornoEvento->processamento->cdResposta;
    }

    /**
     * Retorna descricao da resposta da conusulta do envio
     *
     * @return string
     */
    public function getDescRespostaProcessamento()
    {
        return (string) $this->httpRequest->getObjXml()->retornoEventos->evento->retornoEvento->eSocial->retornoEvento->processamento->ocorrencias->ocorrencia->descricao;
    }

    /**
     * Retorna codigo da resposta da conusulta do envio
     *
     * @return string
     */
    public function getCdRespostaConsulta()
    {
        return (string) $this->httpRequest->getObjXml()->status->cdResposta;
    }

}
