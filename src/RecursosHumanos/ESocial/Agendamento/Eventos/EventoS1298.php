<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use cl_rubricasesocial;
use db_utils;
use DBPessoal;
use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Marcelo Hernane
 */
class EventoS1298 extends EventoBase
{
    /**
     *
     * @param \stdClass $dados
     */
    public function __construct($dados)
    {
        parent::__construct($dados);
    }

    /**
     * Retorna dados no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    public function montarDados()
    {
        $ano = date("Y", db_getsession("DB_datausu"));
        $mes = date("m", db_getsession("DB_datausu"));
        $dia = date("d", db_getsession("DB_datausu"));
        $data = "$ano-$mes-01";
        $data = new \DateTime($data);
        $data->modify('last day of this month');
        $ultimoDiaDoMes = $data->format('d');

        $aDadosAPI = array();
        $iSequencial = 1;

                $oDadosAPI                                     = new \stdClass();
                $oDadosAPI->evtReabreEvPer                      = new \stdClass();
                $oDadosAPI->evtReabreEvPer->sequencial          = $iSequencial;
                $oDadosAPI->evtReabreEvPer->modo                = $this->modo;
                $oDadosAPI->evtReabreEvPer->indRetif            = 1;
                $oDadosAPI->evtReabreEvPer->nrRecibo            = null;

                $oDadosAPI->evtReabreEvPer->indapuracao         = $this->indapuracao;
                $oDadosAPI->evtReabreEvPer->perapur             = $ano . '-' . $mes;
                if ($this->indapuracao == 2) {
                    $oDadosAPI->evtReabreEvPer->perapur         = $ano;
                }
                //$oDadosAPI->evtReabreEvPer->indguia             = 1;

                // $std = new \stdClass();

                // $oDadosAPI->evtReabreEvPer->infofech = $std->infofech;

                $aDadosAPI[] = $oDadosAPI;
        
        // echo '<pre>';
        // var_dump($aDadosAPI);
        // exit;
        return $aDadosAPI;
    }

}
