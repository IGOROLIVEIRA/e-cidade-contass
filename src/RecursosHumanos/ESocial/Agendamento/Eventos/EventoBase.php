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
     * In�cio Validade das informa��es
     *
     * @var string
     */
    protected $iniValid;

    /**
     *
     * @param \stdClass $dados
     */
    function __construct($dados)
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

    /**
     * Retorna dados no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    abstract public function montarDados();
}
