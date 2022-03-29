<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsÃ¡vel por montar as informaÃ§Ãµes do evento S2200 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS2299 extends EventoBase
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

        $iSequencial = 1;
        foreach ($this->dados as $oDados) {
            print_r($oDados);
            exit;
            //$this->buscarRubricas($oDados->vinculo->matricula);
            $oDadosAPI                                   = new \stdClass;
            $oDadosAPI->evtAltContratual                      = new \stdClass;
            $oDadosAPI->evtAltContratual->sequencial          = $iSequencial;
            $oDadosAPI->evtAltContratual->indRetif            = 1;
            $oDadosAPI->evtAltContratual->nrRecibo            = null;
            $oDadosAPI->evtAltContratual->cpfTrab             = $oDados->ideVinculo->cpfTrab;
            $oDadosAPI->evtAltContratual->matricula           = $oDados->ideVinculo->matricula;

            $oDadosAPI->evtAltContratual->dtAlteracao         = '2021-01-29'; //$oDados->altContratual->dtAlteracao;
            $oDadosAPI->evtAltContratual->altContratual->dtEf                = $oDados->altContratual->dtEf;
            $oDadosAPI->evtAltContratual->altContratual->dscAlt              = $oDados->altContratual->dscAlt;

            $oDadosAPI->evtAltContratual->tpRegPrev = $oDados->vinculo->tpRegPrev;

            if (!empty($oDados->infoCeletista)) {
                $oDadosAPI->evtAltContratual->infoCeletista->tpRegJor = $oDados->infoCeletista->tpRegJor;
                $oDadosAPI->evtAltContratual->infoCeletista->natAtividade = $oDados->infoCeletista->natAtividade;
                $oDadosAPI->evtAltContratual->infoCeletista->dtBase = $oDados->infoCeletista->dtBase;
                $oDadosAPI->evtAltContratual->infoCeletista->cnpjSindCategProf = $oDados->infoCeletista->cnpjSindCategProf;

                if (!empty($oDados->trabTemporario)) {
                    $oDadosAPI->evtAltContratual->infoCeletista->trabTemporario = $oDados->trabTemporario;
                    $oDadosAPI->evtAltContratual->infoCeletista->trabTemporario->justContr = $oDados->trabTemporario->justContr;
                }
                $oDadosAPI->evtAltContratual->infoCeletista->aprend = empty($oDados->aprend) ? null : $oDados->aprend;
            } else {
                if (!empty($oDadosAPI->evtAltContratual->infoEstatutario->tpPlanRP)) {
                    // $oDadosAPI->evtAltContratual->infoEstatutario = $oDados->infoEstatutario;
                    $oDadosAPI->evtAltContratual->infoEstatutario->tpPlanRP = $oDados->infoEstatutario->tpPlanRP;
                    $oDadosAPI->evtAltContratual->infoEstatutario->indTetoRGPS = $oDados->infoEstatutario->indTetoRGPS;
                    $oDadosAPI->evtAltContratual->infoEstatutario->indAbonoPerm = $oDados->infoEstatutario->indAbonoPerm;
                }
            }

            if (!empty($oDados->infoContrato)) {
                $oDadosAPI->evtAltContratual->infoContrato = $oDados->infoContrato;
                $oDadosAPI->evtAltContratual->infoContrato->nmCargo = $oDados->infoContrato->nmCargo;
                $oDadosAPI->evtAltContratual->infoContrato->acumCargo = $oDados->infoContrato->acumCargo;
                $oDadosAPI->evtAltContratual->infoContrato->codCateg = $oDados->infoContrato->codCateg;

                $oDadosAPI->evtAltContratual->infoContrato->vrSalFx = $oDados->remuneracao->vrSalFx;
                $oDadosAPI->evtAltContratual->infoContrato->undSalFixo = $oDados->remuneracao->undSalFixo;
                $oDadosAPI->evtAltContratual->infoContrato->dscSalVar = empty($oDados->remuneracao->dscSalVar) ? null : $oDados->remuneracao->dscSalVar;

                $oDadosAPI->evtAltContratual->infoContrato->tpContr = $oDados->duracao->tpContr;
                $oDadosAPI->evtAltContratual->infoContrato->dtTerm = empty($oDados->duracao->dtTerm) ? null : $oDados->duracao->dtTerm;
                $oDadosAPI->evtAltContratual->infoContrato->objDet = empty($oDados->duracao->objDet) ? null : $oDados->duracao->objDet;

                $oDadosAPI->evtAltContratual->infoContrato->localTrabGeral = empty($oDados->localTrabGeral) ? null : $oDados->localTrabGeral;

                $oDadosAPI->evtAltContratual->infoContrato->localTrabDom = empty($oDados->localTrabDom) ? null : $oDados->localTrabDom;

                if (empty($oDados->horContratual) && !empty($oDados->infoCeletista)) {
                    $oDadosAPI->evtAltContratual->infoContrato->horContratual = $oDados->horContratual;
                //$oDadosAPI->evtAltContratual->vinculo->infoContrato->horContratual->horario = $this->buscarHorarios($oDados->vinculo->matricula);
                } else {
                    $oDadosAPI->evtAltContratual->infoContrato->horContratual = null;
                }

                $oDadosAPI->evtAltContratual->infoContrato->alvaraJudicial = empty($oDados->alvaraJudicial) ? null : $oDados->alvaraJudicial;

                $oDadosAPI->evtAltContratual->infoContrato->observacoes = empty($oDados->observacoes) ? null : array($oDados->observacoes);

                $oDadosAPI->evtAltContratual->infoContrato->observacoes = empty($oDados->observacoes) ? null : array($oDados->observacoes);

                $oDadosAPI->evtAltContratual->infoContrato->treiCap = empty($oDados->treiCap) ? null : array($oDados->treiCap);
            }

            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }
        // echo '<pre>';
        // print_r($aDadosAPI);
        // exit;
        return $aDadosAPI;
    }

    /**
     * Retorna dados dos dependentes no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarRubricas($matricula)
    {
        $sigla          = 'r20_';
        $arquivo        = 'gerfres';
        $xtipo          = ' r20_tpp ';
        $sTituloCalculo = 'Rescisão';

        $sql = "select '1' as ordem ,
                   {$sigla}rubric as rubrica,
                   case
                     when rh27_pd = 3 then 0
                     else case
                            when {$sigla}pd = 1 then {$sigla}valor
                            else 0
                          end
                   end as Provento,
                   case
                     when rh27_pd = 3 then 0
                     else case
                            when {$sigla}pd = 2 then {$sigla}valor
                            else 0
                          end
                   end as Desconto,
                   {$sigla}quant as quant,
                   rh27_descr,
                   {$xtipo} as tipo ,
                   case
                     when rh27_pd = 3 then 'Base'
                     else case
                            when {$sigla}pd = 1 then 'Provento'
                            else 'Desconto'
                          end
                   end as provdesc
              from {$arquivo}
                   inner join rhrubricas on rh27_rubric = {$sigla}rubric
                                        and rh27_instit = ".db_getsession("DB_instit")."
               and {$sigla}regist = $matricula
               and {$sigla}pd != 3
               order by {$sigla}pd,{$sigla}rubric";

        $result = db_query($sql);
        db_criatabela($result);
        exit;
        // $oDaorubricasesocial = \db_utils::getDao("rubricasesocial");
        // $rsRubEspeciais = db_query($clrubricasesocial->sql_query(null, "e990_sequencial,e990_descricao", null, "baserubricasesocial.e991_rubricas = '{$rubrica}' AND e990_sequencial IN ('1000','5001','1020')"));
        // if (pg_num_rows($rsRubEspeciais) > 0) {
        //     $oRubEspeciais = db_utils::fieldsMemory($rsRubEspeciais);
        //     switch ($oRubEspeciais->e990_sequencial) {
        //     case '1000':
        //       $rubrica = '9000';
        //       $rh27_descr = 'Saldo de Salário na Rescisão';
        //       break;
        //     case '5001':
        //       $rubrica = '9001';
        //       $rh27_descr = '13º Salário na Rescisão';
        //       break;
        //     case '1020' && $tipo == 'P':
        //       $rubrica = '9002';
        //       $rh27_descr = 'Férias Proporcional na Rescisão';
        //       break;
        //     case '1020' && $tipo == 'V':
        //       $rubrica = '9003';
        //       $rh27_descr = 'Férias Vencidas na Rescisão';
        //       break;

        //     default:
        //       break;
        //   }
        // }

        // $aDependentes = array();
        // for ($iCont = 0; $iCont < pg_num_rows($rsDependentes); $iCont++) {
        //     $oDependentes = \db_utils::fieldsMemory($rsDependentes, $iCont);
        //     $oDependFormatado = new \stdClass;
        //     switch ($oDependentes->rh31_gparen) {
        //         case 'C':
        //             $oDependFormatado->tpdep = '01';
        //             break;
        //         case 'F':
        //             $oDependFormatado->tpdep = '03';
        //             break;
        //         case 'P':
        //         case 'M':
        //         case 'A':
        //             $oDependFormatado->tpdep = '09';
        //             break;

        //         default:
        //             $oDependFormatado->tpdep = '99';
        //             break;
        //     }
        //     $oDependFormatado->nmdep = $oDependentes->rh31_nome;
        //     $oDependFormatado->dtnascto = $oDependentes->rh31_dtnasc;
        //     $oDependFormatado->cpfdep = empty($oDependentes->rh31_cpf) ? null : $oDependentes->rh31_cpf;
        //     $oDependFormatado->depirrf = ($oDependentes->rh31_depirrf == "0" ? "N" : "S");
        //     $oDependFormatado->depsf = ($oDependentes->rh31_depend == "N" ? "N" : "S");
        //     $oDependFormatado->inctrab = ($oDependentes->rh31_depirrf == "N" ? "N" : "S");

        //     $aDependentes[] = $oDependFormatado;
        // }
        // return $aDependentes;
    }
}
