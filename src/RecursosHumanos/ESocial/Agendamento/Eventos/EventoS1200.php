<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use cl_rubricasesocial;
use db_utils;
use DBPessoal;
use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsÃ¡vel por montar as informaÃ§Ãµes do evento S2200 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS1200 extends EventoBase
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
        $aDadosAPI = array();
        $iSequencial = 1;
        foreach ($this->dados as $oDados) {
            $oDadosAPI                                   = new \stdClass;
            $oDadosAPI->evtRemun                      = new \stdClass;
            $oDadosAPI->evtRemun->sequencial          = $iSequencial;
            $oDadosAPI->evtRemun->modo                = $this->modo;
            $oDadosAPI->evtRemun->indRetif            = 1;
            $oDadosAPI->evtRemun->nrRecibo            = null;
            // var_dump($this);
            // exit;
            $oDadosAPI->evtRemun->indapuracao         = $this->indapuracao;
            $oDadosAPI->evtRemun->perapur             = $ano . '-' . $mes;
            if ($oDados->indapuracao == 2) {
                $oDadosAPI->evtRemun->perapur         = $mes;
            }
            $oDadosAPI->evtRemun->cpftrab             = $oDados->cpftrab;

            if (strlen($oDados->indmv) > 0) {
                $oDadosAPI->evtRemun->infomv->indmv       = $oDados->indmv;

                $oRemunoutrempr = new \stdClass;
                $oRemunoutrempr->tpinsc      = 1;
                $oRemunoutrempr->nrinsc      = $oDados->nrinsc;
                $oRemunoutrempr->codcateg    = $oDados->codcateg;
                if (strlen($oDados->vlrremunoe) > 0) {
                    $oRemunoutrempr->vlrremunoe  = $oDados->vlrremunoe;
                }
                $aRemunoutrempr[] = $oRemunoutrempr;

                $oDadosAPI->evtRemun->infomv->remunoutrempr = $aRemunoutrempr;
            }

            $std = new \stdClass();

            //Identificação de cada um dos demonstrativos de valores devidos ao trabalhador.
            $std->dmdev[0] = new \stdClass(); //Obrigatório
            $std->dmdev[0]->idedmdev = $this->buscarIdentificador($oDados->matricula, $oDados->rh30_regime); //Obrigatório
            $std->dmdev[0]->codcateg = $oDados->codcateg; //Obrigatório

            //Identificação do estabelecimento e da lotação nos quais o
            //trabalhador possui remuneração no período de apuração
            $std->dmdev[0]->ideestablot[0] = new \stdClass(); //Opcional
            $std->dmdev[0]->ideestablot[0]->tpinsc = "1"; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->nrinsc = $oDados->nrinsc; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->codlotacao = 'LOTA1'; //Obrigatório

            //Informações relativas à remuneração do trabalhador no período de apuração.
            $std->dmdev[0]->ideestablot[0]->remunperapur[0] = new \stdClass(); //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->matricula = $oDados->matricula; //Opcional

            //Rubricas que compõem a remuneração do trabalhador.
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun = $this->buscarValorRubrica($oDados->matricula, $oDados->rh30_regime);

            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->infoagnocivo->grauexp = $oDados->grauexp; //Obrigatório

            $oDadosAPI->evtRemun->dmdev = $std->dmdev;

            if ($std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun != null) {
                $aDadosAPI[] = $oDadosAPI;
                $iSequencial++;
            }
        }
        return $aDadosAPI;
    }

    /**
     * Retorna dados dos dependentes no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarIdentificador($matricula, $rh30_regime)
    {
        $iAnoUsu = date("Y", db_getsession("DB_datausu"));
        $iMesusu = date("m", db_getsession("DB_datausu"));
        if ($rh30_regime == 1 || $rh30_regime == 3)
            $aPontos = array('salario', 'complementar', '13salario');
        else
            $aPontos = array('salario', 'complementar', '13salario');

        $aIdentificadores = array();
        foreach ($aPontos as $opcao) {
            switch ($opcao) {
                case 'salario':
                    $sigla          = 'r14_';
                    $arquivo        = 'gerfsal';
                    $sTituloCalculo = 'Salário';
                    break;

                case 'complementar':
                    $sigla          = 'r48_';
                    $arquivo        = 'gerfcom';
                    $sTituloCalculo = 'Complementar';
                    break;

                case '13salario':
                    $sigla          = 'r35_';
                    $arquivo        = 'gerfs13';
                    $sTituloCalculo = '13? Sal?rio';
                    break;

                case 'rescisao':
                    $sigla          = 'r20_';
                    $arquivo        = 'gerfres';
                    $sTituloCalculo = 'Rescis¬o';
                    break;

                default:
                    continue;
                    break;
            }
            if ($opcao) {
                $sql = "  select distinct
                        case
                        when '{$arquivo}' = 'gerfsal' then 1
                        when '{$arquivo}' = 'gerfcom' then 3
                        when '{$arquivo}' = 'gerfs13' then 4
                        when '{$arquivo}' = 'gerfres' then 2
                        end as ideDmDev
                        from {$arquivo}
                        where " . $sigla . "anousu = '" . $iAnoUsu . "'
                        and  " . $sigla . "mesusu = '" . $iMesusu . "'
                        and  " . $sigla . "instit = " . db_getsession("DB_instit") . "
                        and {$sigla}regist = $matricula";
            }

            $rsIdentificadores = db_query($sql);
            // echo $sql;
            // db_criatabela($rsIdentificadores);
            if (pg_num_rows($rsIdentificadores) > 0) {
                $oIdentificadores = \db_utils::fieldsMemory($rsIdentificadores, 0);
                return $oIdentificadores->idedmdev;
            }
        }
    }

    private function buscarValorRubrica($matricula, $rh30_regime)
    {
        require_once 'libs/db_libpessoal.php';
        $clrubricasesocial = new cl_rubricasesocial;
        $iAnoUsu = date("Y", db_getsession("DB_datausu"));
        $iMesusu = date("m", db_getsession("DB_datausu"));
        $xtipo = "'x'";

        if ($rh30_regime == 1 || $rh30_regime == 3)
            $aPontos = array('salario', 'complementar', '13salario', 'rescisao');
        else
            $aPontos = array('salario', 'complementar', '13salario');

        foreach ($aPontos as $opcao) {
            switch ($opcao) {
                case 'salario':
                    $sigla          = 'r14_';
                    $arquivo        = 'gerfsal';
                    $sTituloCalculo = 'Salário';
                    break;

                case 'complementar':
                    $sigla          = 'r48_';
                    $arquivo        = 'gerfcom';
                    $sTituloCalculo = 'Complementar';
                    break;

                case '13salario':
                    $sigla          = 'r35_';
                    $arquivo        = 'gerfs13';
                    $sTituloCalculo = '13? Sal?rio';
                    break;
                case 'rescisao':
                    $sigla          = 'r20_';
                    $arquivo        = 'gerfres';
                    $xtipo          = ' r20_tpp ';
                    $sTituloCalculo = 'Rescis¬o';
                    break;

                default:
                    continue;
                    break;
            }
            if ($opcao) {

                $sql = "  select '1' as ordem ,
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
                                                    and rh27_instit = " . db_getsession("DB_instit") . "
                          " . bb_condicaosubpesproc($sigla, $iAnoUsu . "/" . $iMesusu) . "
                           and {$sigla}regist = $matricula
                           and {$sigla}pd != 3
                           and {$sigla}rubric not in ('R985','R993','R981')
                           order by {$sigla}pd,{$sigla}rubric";
            }
            $rsValores = db_query($sql);
            // echo $sql;
            // db_criatabela($rsValores);
            if ($opcao != 'rescisao') {
                for ($iCont = 0; $iCont < pg_num_rows($rsValores); $iCont++) {
                    $oResult = \db_utils::fieldsMemory($rsValores, $iCont);
                    $oFormatado = new \stdClass();
                    $oFormatado->codrubr    = $oResult->rubrica;
                    $oFormatado->idetabrubr = 'tabrub1';
                    $oFormatado->vrrubr     = ($oResult->provdesc == 'Provento') ? $oResult->provento : $oResult->desconto;
                    $oFormatado->indapurir  = 0;

                    $aItens[] = $oFormatado;
                }
            } else {
                for ($iCont2 = 0; $iCont2 < pg_num_rows($rsValores); $iCont2++) {
                    $oResult = \db_utils::fieldsMemory($rsValores, $iCont2);
                    $rsRubEspeciais = db_query($clrubricasesocial->sql_query(null, "e990_sequencial,e990_descricao", null, "baserubricasesocial.e991_rubricas = '{$oResult->rubrica}' AND e990_sequencial IN ('1000','5001','1020')"));
                    $rubrica = $oResult->rubrica;
                    if (pg_num_rows($rsRubEspeciais) > 0) {
                        $oRubEspeciais = db_utils::fieldsMemory($rsRubEspeciais);
                        switch ($oRubEspeciais->e990_sequencial) {
                            case '1000':
                                $rubrica = '9000';
                                $rh27_descr = 'Saldo de Sal?rio na Rescis?o';
                                break;
                            case '5001':
                                $rubrica = '9001';
                                $rh27_descr = '13? Sal?rio na Rescis?o';
                                break;
                            case '1020':
                                $rubrica = '9002';
                                $rh27_descr = 'F?rias Proporcional na Rescis?o';
                                break;
                            case '1020':
                                $rubrica = '9003';
                                $rh27_descr = 'F?rias Vencidas na Rescis?o';
                                break;

                            default:
                                break;
                        }
                    }
                    $oFormatado = new \stdClass();
                    $oFormatado->codrubr    = $rubrica;
                    $oFormatado->idetabrubr = 'tabrub1';
                    $oFormatado->vrrubr     = ($oResult->provdesc == 'Provento') ? $oResult->provento : $oResult->desconto;
                    $oFormatado->indapurir  = 0;

                    $aItens[] = $oFormatado;
                }
            }
        }
        //exit;
        return $aItens;
    }
}
