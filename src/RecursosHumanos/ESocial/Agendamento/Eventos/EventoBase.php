<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

/**
 * Classe base para eventos Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
abstract class EventoBase
{
    /**
     * Dados do Evento
     * @var \stdClass
     */
    protected $dados;

    /**
     * Início Validade das informações
     *
     * @var string
     */
    protected $iniValid;

    /**
     *
     * @param \stdClass $dados
     */
    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    /**
     *
     * @param string $iniValid
     */
    public function setIniValid($iniValid)
    {
        $this->iniValid = $iniValid;
    }

    public function setModo($modo)
    {
        $this->modo = $modo;
    }

    public function setDtAlteracao($dt_alteracao)
    {
        $this->dt_alteracao = $dt_alteracao;
    }

    public function setIndApuracao($indapuracao)
    {
        $this->indapuracao = $indapuracao;
    }

    public function setTppgto($tppgto)
    {
        $this->tppgto = $tppgto;
    }

    public function setTpevento($tpevento)
    {
        $this->tpevento = $tpevento;
    }

    public function setTransDCTFWeb($transDCTFWeb)
    {
        $this->transDCTFWeb = $transDCTFWeb;
    }

    public function setEvtpgtos($evtpgtos)
    {
        $this->evtpgtos = $evtpgtos;
    }

    public function setDadosExclusao($aDadosExclusao)
    {
        $this->aDadosExclusao = $aDadosExclusao;
    }

    /**
     * Retorna dados no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    abstract public function montarDados();
}
