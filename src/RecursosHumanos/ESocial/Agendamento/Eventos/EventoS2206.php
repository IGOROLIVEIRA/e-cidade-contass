<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use DateTime;
use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsÃ¡vel por montar as informaÃ§Ãµes do evento S2200 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS2206 extends EventoBase
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
        $aDadosAPI = array();
        $iSequencial = 1;
        
        foreach ($this->dados as $oDados) {

            if($this->comparaDados($oDados->matricula,$oDados->rh02_salari,$oDados->rh02_funcao,$oDados->rh20_cargo) == false){
                continue;
            }

            $oDadosAPI                                   = new \stdClass;
            $oDadosAPI->evtAltContratual                      = new \stdClass;
            $oDadosAPI->evtAltContratual->sequencial          = $iSequencial;
            $oDadosAPI->evtAltContratual->modo                = $this->modo;
            $oDadosAPI->evtAltContratual->dtAlteracao         = $this->contarDias($this->dataDoSistema())? $this->dataDoSistema() : null; //implode('-', array_reverse(explode('/', $this->dt_alteracao))); //'2021-01-29'; //$oDados->altContratual->dtAlteracao;
            $oDadosAPI->evtAltContratual->indRetif            = 1;
            $oDadosAPI->evtAltContratual->nrRecibo            = null;
            $oDadosAPI->evtAltContratual->cpfTrab             = $oDados->cpftrab;
            $oDadosAPI->evtAltContratual->matricula           = $oDados->matricula;

            $oDadosAPI->evtAltContratual->dtef                = $this->dataDoSistema();
            $oDadosAPI->evtAltContratual->dscalt              = $this->comparaDados($oDados->matricula,$oDados->rh02_salari,$oDados->rh02_funcao,$oDados->rh20_cargo);

            $oDadosAPI->evtAltContratual->tpRegPrev = $oDados->r33_tiporegime;

            if ($oDados->rh30_regime == 2) {
                $oDadosAPI->evtAltContratual->infoCeletista->tpRegJor = 1;
                $oDadosAPI->evtAltContratual->infoCeletista->natAtividade = 1;
                //$oDadosAPI->evtAltContratual->infoCeletista->dtBase = //SEMPRE EM BRANCO;
                $oDadosAPI->evtAltContratual->infoCeletista->cnpjSindCategProf = $oDados->rh116_cnpj;

                // if (!empty($oDados->trabTemporario)) {

                //     $oDadosAPI->evtAltContratual->infoCeletista->trabTemporario = $oDados->trabTemporario;
                //     $oDadosAPI->evtAltContratual->infoCeletista->trabTemporario->justContr = $oDados->trabTemporario->justContr;
                // }
                // $oDadosAPI->evtAltContratual->infoCeletista->aprend = empty($oDados->aprend) ? null : $oDados->aprend;
            } else {
                
                // $oDadosAPI->evtAltContratual->infoEstatutario = $oDados->infoEstatutario;
                $oDadosAPI->evtAltContratual->infoEstatutario->tpPlanRP = intval($oDados->rh02_plansegreg);
                $oDadosAPI->evtAltContratual->infoEstatutario->indTetoRGPS = 'N';
                $oDadosAPI->evtAltContratual->infoEstatutario->indAbonoPerm = ($oDados->rh02_abonopermanencia == 'f')? 'N' : 'S';
            }
            

            // if (!empty($oDados->infoContrato)) {

                //$oDadosAPI->evtAltContratual->infoContrato = $oDados->infoContrato;
                $oDadosAPI->evtAltContratual->infoContrato->nmCargo = $oDados->nmcargo;
                $oDadosAPI->evtAltContratual->infoContrato->CBOCargo = $oDados->cbocargo;
                //$oDadosAPI->evtAltContratual->infoContrato->codCateg = $oDados->infoContrato->codCateg;

                $oDadosAPI->evtAltContratual->infoContrato->nmFuncao = $oDados->nmcargo;
                $oDadosAPI->evtAltContratual->infoContrato->CBOFuncao = $oDados->cbocargo;

                $oDadosAPI->evtAltContratual->infoContrato->acumCargo = $oDados->acumcargo;

                $oDadosAPI->evtAltContratual->infoContrato->codCateg = $oDados->h13_categoria;

                if (!empty($oDados->rh02_salari) && !empty($oDados->undsalfixo)) {
                    $oDadosAPI->evtAltContratual->infoContrato->vrSalFx = number_format($oDados->rh02_salari, 2, ".", "");
                    $oDadosAPI->evtAltContratual->infoContrato->undSalFixo = $oDados->undsalfixo;
                }
                
                //$oDadosAPI->evtAltContratual->infoContrato->dscSalVar = empty($oDados->remuneracao->dscSalVar) ? null : $oDados->remuneracao->dscSalVar;

                $oDadosAPI->evtAltContratual->infoContrato->tpContr = $oDados->tpcontr;
                $oDadosAPI->evtAltContratual->infoContrato->dtTerm = empty($oDados->dtterm) ? null : $oDados->dtterm;
                //$oDadosAPI->evtAltContratual->infoContrato->objDet = empty($oDados->duracao->objDet) ? null : $oDados->duracao->objDet;

                $oDadosAPI->evtAltContratual->infoContrato->localtrabgeral->tpinsc   = 1;
                $oDadosAPI->evtAltContratual->infoContrato->localtrabgeral->nrinsc   = $oDados->nrinsc_localtrabgeral;
                $oDadosAPI->evtAltContratual->infoContrato->localtrabgeral->desccomp = $oDados->desccomp_localtrabgeral;


                $oDadosAPI->evtAltContratual->infoContrato->horcontratual->qtdhrssem  = empty($oDados->rh02_hrssem) ? null : $oDados->rh02_hrssem; $oDados->rh02_hrssem;
                $oDadosAPI->evtAltContratual->infoContrato->horcontratual->tpjornada  = empty($oDados->rh02_tipojornada) ? null : intval($oDados->rh02_tipojornada);
                $oDadosAPI->evtAltContratual->infoContrato->horcontratual->tmpparc    = 0;
                $oDadosAPI->evtAltContratual->infoContrato->horcontratual->hornoturno = ($oDados->rh02_horarionoturno == 'f') ? 'N' : 'S';
                $oDadosAPI->evtAltContratual->infoContrato->horcontratual->dscjorn    = $oDados->jt_nome;
                
            //}

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
    private function buscarDependentes($matricula)
    {

        $oDaorhdepend = \db_utils::getDao("rhdepend");
        $sqlDependentes = $oDaorhdepend->sql_query_file(null, "*", "rh31_codigo", "rh31_regist = {$matricula}");
        $rsDependentes = db_query($sqlDependentes);
        if (pg_num_rows($rsDependentes) == 0) {
            return null;
        }
        $aDependentes = array();
        for ($iCont = 0; $iCont < pg_num_rows($rsDependentes); $iCont++) {
            $oDependentes = \db_utils::fieldsMemory($rsDependentes, $iCont);
            $oDependFormatado = new \stdClass;
            switch ($oDependentes->rh31_gparen) {
                case 'C':
                    $oDependFormatado->tpdep = '01';
                    break;
                case 'F':
                    $oDependFormatado->tpdep = '03';
                    break;
                case 'P':
                case 'M':
                case 'A':
                    $oDependFormatado->tpdep = '09';
                    break;

                default:
                    $oDependFormatado->tpdep = '99';
                    break;
            }
            $oDependFormatado->nmdep = $oDependentes->rh31_nome;
            $oDependFormatado->dtnascto = $oDependentes->rh31_dtnasc;
            $oDependFormatado->cpfdep = empty($oDependentes->rh31_cpf) ? null : $oDependentes->rh31_cpf;
            $oDependFormatado->depirrf = ($oDependentes->rh31_depirrf == "0" ? "N" : "S");
            $oDependFormatado->depsf = ($oDependentes->rh31_depend == "N" ? "N" : "S");
            $oDependFormatado->inctrab = ($oDependentes->rh31_depirrf == "N" ? "N" : "S");

            $aDependentes[] = $oDependFormatado;
        }
        return $aDependentes;
    }


    /**
     * Retorna dados dos horario no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarHorarios($matricula)
    {

        $aHorarios = array();
        $oDaoJornada = \db_utils::getDao("jornada");
        $rsHorarios = db_query($oDaoJornada->sqlQueryHorario($matricula));
        if (pg_num_rows($rsHorarios) == 0) {
            return null;
        }
        for ($iCont = 0; $iCont < pg_num_rows($rsHorarios); $iCont++) {
            $oHorarioFormatado = new \stdClass;
            $oHorario = \db_utils::fieldsMemory($rsHorarios, $iCont);
            $oHorarioFormatado->codHorContrat = $oHorario->rh188_sequencial;
            $oHorarioFormatado->dia = date('w', strtotime($oHorario->diatrabalho));
            $aHorarios[] = $oHorarioFormatado;
        }
        return $aHorarios;
    }

    /**
     * Retorna dados dos afastamentos no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarAfastamentos($matricula)
    {


        $acodMotAfastEsocial = array(
            'O1' => '01',
            'O2' => '01',
            'O3' => '01',
            'P1' => '03',
            'P2' => '01',
            'Q1' => '17',
            'Q2' => '35',
            'Q3' => '19',
            'Q4' => '20',
            'Q5' => '20',
            'Q6' => '20',
            'R' => '29',
            'U3' => '06',
            'W' => '24',
            'X' => '21'
        );

        $acodMotAfastEcidade = array('O1', 'O2', 'O3', 'P1', 'P2', 'Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'R', 'U3', 'W', 'X');
        $aAfastamentos = array();
        $oDaoAfasta = \db_utils::getDao("afasta");
        $rsAfastamentos = db_query($oDaoAfasta->sql_query_file(null, "*", null, "r45_regist = {$matricula} AND r45_codafa IN ('" . implode("','", $acodMotAfastEcidade) . "')"));
        if (pg_num_rows($rsAfastamentos) == 0) {
            return null;
        }
        for ($iCont = 0; $iCont < pg_num_rows($rsAfastamentos); $iCont++) {
            $oAfastamentoFormatado = new \stdClass;
            $oAfastamento = \db_utils::fieldsMemory($rsAfastamentos, $iCont);
            $oAfastamentoFormatado->dtIniAfast = $oAfastamento->r45_dtafas;
            $oAfastamentoFormatado->codMotAfast = $acodMotAfastEsocial[$oAfastamento->r45_codafa];
            $aAfastamentos[] = $oAfastamentoFormatado;
        }
        return $aAfastamentos;
    }

    private function dataDoSistema($formato = "Y-m-d"){
        return date($formato,db_getsession("DB_datausu"));
    }

    private function contarDias($data) {
        
        $dataAtual = new DateTime();
        $dataFornecida = new DateTime($data);
        $intervalo = $dataFornecida->diff($dataAtual);
        $diferenca = $intervalo->days;
    
        if ($diferenca > 180) {
            return false;
        } else {
            return true;
        }
    }

    private function subtrairMes($data) {
        $dataObj = new DateTime($data);
        $dataObj->modify('-1 month');
        return $dataObj->format('Y-m-d');
    }

    private function comparaDados($matricula, $rh02_salari_origem, $rh02_funcao_origem, $rh02_carga_origem)
    {
        $dTMesAnterior = $this->subtrairMes($this->dataDosistema("Y-m-d"));

        list($ano, $mes, $dia) = explode('-', $dTMesAnterior);

        $sql = "SELECT rh02_salari, rh02_funcao, rh20_cargo
        FROM rhpessoalmov
        left join rhpescargo   on rhpescargo.rh20_seqpes   = rhpessoalmov.rh02_seqpes
        WHERE 1=1 
        AND rh02_regist     = $matricula
        AND rh02_anousu = $ano
        AND rh02_mesusu = $mes
        ";

        $rs = \db_query($sql);
        // echo $sql;
        // db_criatabela($rs);
        // exit;
        if (!$rs) {
            throw new \Exception("Erro na busca no evt2206");
        }
        $oDados = \db_utils::getCollectionByRecord($rs);

        // Comparar valores obtidos com os valores de origem
        $salari = $oDados->rh02_salari;
        $funcao = $oDados->rh02_funcao;
        $carga = $oDados->rh02_carga;

        if ($salari !== $rh02_salari_origem) {
            return "reajuste salarial";
        }
        
        if ($funcao !== $rh02_funcao_origem || $carga !== $rh02_carga_origem) {
            return "alteração de cargo";
        }
        
        return false;
        
    }
}
