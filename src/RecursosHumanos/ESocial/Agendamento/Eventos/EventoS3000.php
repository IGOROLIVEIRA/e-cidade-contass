<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use db_utils;
use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe respons�vel por montar as informa��es do evento S3000 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Marcelo Hernane
 */
class EventoS3000 extends EventoBase
{

    /**
     *
     * @param \stdClass $dados
     */
    function __construct($dados)
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
        $data = "$ano-$mes-01";
        $data = new \DateTime($data);
        $data->modify('last day of this month');
        $ultimoDiaDoMes = $data->format('d');
        $aDadosAPI = array();
        $iSequencial = 1;
        $aDados = $this->buscaDados($this->aDadosExclusao);
        //var_dump($aDados);exit;
        foreach ($aDados as $dados) {
            //var_dump($dados);exit;
            $json_dados = reset(json_decode($dados->rh213_dados));
            for ($i = 0; $i < count($json_dados); $i++) {
                $primeira_chave = reset($json_dados);
                // var_dump($primeira_chave->idevinculo->cpftrab);
                // exit;
                //carrega os dados do envento
                $std = new \stdClass();
                $std->sequencial = $iSequencial;

                $std->modo                = $this->modo;
                $std->indRetif            = 1;
                $std->nrRecibo            = null;

                $infoexclusao = new \stdClass();
                $infoexclusao->tpevento = 'S-' . (int)$this->aDadosExclusao->evento;
                $infoexclusao->nrrecEvt = preg_replace('/[^0-9.]/', '', $this->aDadosExclusao->recibo); //$dados->rh215_recibo

                $std->infoexclusao = $infoexclusao;

                if ($infoexclusao->tpevento == 'S-1200' || $infoexclusao->tpevento == 'S-1202' || $infoexclusao->tpevento == 'S-1207' || $infoexclusao->tpevento == 'S-1210') {

                    $idefolhapagto = new \stdClass();

                    if($infoexclusao->tpevento != 'S-1210')
                        $idefolhapagto->indapuracao = $this->indapuracao;

                    $idefolhapagto->perapur = $ano . '-' . $mes;
                    if ($this->indapuracao == 2) {
                        $idefolhapagto->perapur         = $ano;
                    }

                    $std->idefolhapagto = $idefolhapagto;
                }

                $idetrabalhador = new \stdClass();

                $idetrabalhador->cpftrab = $this->findElementByName('cpftrab', $primeira_chave); //$primeira_chave->idevinculo->cpftrab;
                if ($idetrabalhador->cpftrab === false) {
                    $idetrabalhador->cpftrab = $this->findElementByName('cpfbenef', $primeira_chave);
                }
                //$idetrabalhador->nistrab = '11111111111';

                $std->idetrabalhador = $idetrabalhador;

                $oDadosAPI                                   = new \stdClass;
                $oDadosAPI->evtExclusao                      = new \stdClass;
                $oDadosAPI->evtExclusao = $std;

                $aDadosAPI[] = $oDadosAPI;
                $iSequencial++;
            }
        }
        // echo '<pre>';
        // var_dump($aDadosAPI);exit;
        return $aDadosAPI;
    }

    private function findElementByName($name, $object)
    {
        foreach ($object as $key => $value) {
            if ($key == $name) {
                return $value;
            } elseif (is_array($value)) {
                $this->findElementByName($name, $value);
            }
        }
        return false;
    }

    private function buscaDados($aDadosExclusao)
    {
        $clesocialenvio = db_utils::getDao("esocialenvio");

        $sql = $clesocialenvio->sql_query(null, "rh213_dados,rh213_evento,rh215_recibo", null, "rh213_situacao = 2 and rh213_sequencial = " . (int)$aDadosExclusao->codigo);
        $rs  = db_query($sql);
        for ($iCont2 = 0; $iCont2 < pg_num_rows($rs); $iCont2++) {
            $oDados[] = db_utils::fieldsMemory($rs, $iCont2);
        }
        return $oDados;
    }
}
