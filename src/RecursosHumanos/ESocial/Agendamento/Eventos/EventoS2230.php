<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S2200 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS2230 extends EventoBase
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
        $aDadosAPI = array();
         echo "evento";
         echo '<pre>';
         print_r($this->dados);
         exit;

        $iSequencial = 1;
        foreach ($this->dados as $oDados) {
           
            $oDadosAPI                                = new \stdClass;
            $oDadosAPI->evtAfastTemp                      = new \stdClass;
            $oDadosAPI->evtAfastTemp->sequencial          = $iSequencial;
            $oDadosAPI->evtAfastTemp->modo                = $this->modo;
            $oDadosAPI->evtAfastTemp->indRetif            = 1;
            $oDadosAPI->evtAfastTemp->nrRecibo            = null;
            $oDadosAPI->evtAfastTemp->cpfTrab             = $oDados->trabalhador->cpfTrab;
            $oDadosAPI->evtAfastTemp->nisTrab             = $oDados->trabalhador->nisTrab;
            $oDadosAPI->evtAfastTemp->nmTrab              = $oDados->trabalhador->nmTrab;
            $oDadosAPI->evtAfastTemp->sexo                = $oDados->trabalhador->sexo;
            $oDadosAPI->evtAfastTemp->racaCor             = $oDados->trabalhador->racaCor;
            $oDadosAPI->evtAfastTemp->estCiv              = empty($oDados->trabalhador->estCiv) ? null : $oDados->trabalhador->estCiv;
            $oDadosAPI->evtAfastTemp->grauInstr           = $oDados->trabalhador->grauInstr;
            $oDadosAPI->evtAfastTemp->indPriEmpr          = $oDados->trabalhador->indPriEmpr;
            $oDadosAPI->evtAfastTemp->nmSoc               = empty($oDados->trabalhador->nmSoc) ? null : $oDados->trabalhador->nmSoc;

            $oDadosAPI->evtAfastTemp->dtNascto            = $oDados->nascimento->dtNascto;
            $oDadosAPI->evtAfastTemp->codMunic            = empty($oDados->nascimento->codMunic) ? null : $oDados->nascimento->codMunic;
            $oDadosAPI->evtAfastTemp->uf                  = empty($oDados->nascimento->uf) ? null : $oDados->nascimento->uf;
            $oDadosAPI->evtAfastTemp->paisNascto          = $oDados->nascimento->paisNascto;
            $oDadosAPI->evtAfastTemp->paisNac             = $oDados->nascimento->paisNac;
            $oDadosAPI->evtAfastTemp->nmMae               = empty($oDados->nascimento->nmMae) ? null : $oDados->nascimento->nmMae;
            $oDadosAPI->evtAfastTemp->nmPai               = empty($oDados->nascimento->nmPai) ? null : $oDados->nascimento->nmPai;

            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }
        // echo '<pre>';
        // print_r($aDadosAPI);
        // exit;
        return $aDadosAPI;
    }
}
