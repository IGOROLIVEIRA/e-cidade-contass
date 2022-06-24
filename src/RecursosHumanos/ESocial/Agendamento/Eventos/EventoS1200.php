<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

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
        $aDadosAPI = array();

        $iSequencial = 1;
        foreach ($this->dados as $oDados) {
            // print_r($oDados);
            // exit;
            //$this->buscarRubricas($oDados->vinculo->matricula);
            $oDadosAPI                                   = new \stdClass;
            $oDadosAPI->evtRemun                      = new \stdClass;
            $oDadosAPI->evtRemun->sequencial          = $iSequencial;
            $oDadosAPI->evtRemun->indRetif            = 1;
            $oDadosAPI->evtRemun->nrRecibo            = null;

            // $oDadosAPI->evtRemun->indapuracao         = $oDados->indapuracao;
            // $oDadosAPI->evtRemun->perapur             = $oDados->perapur;
            $oDadosAPI->evtRemun->cpfTrab             = $oDados->cpfTrab;

            $oDadosAPI->evtRemun->infomv->indmv       = $oDados->indmv;
            $oDadosAPI->evtRemun->infomv->remunoutrempr->tpinsc = 1;
            $oDadosAPI->evtRemun->infomv->remunoutrempr->nrinsc  = $oDados->cgc;
            $oDadosAPI->evtRemun->infomv->remunoutrempr->codcateg  = $oDados->codcateg;
            $oDadosAPI->evtRemun->infomv->remunoutrempr->vlrremunoe  = $oDados->vlrremunoe;

            $oDadosAPI->evtRemun->dmdev->idedmdev  = $this->buscarIdentificador($oDados->matricula);
            $oDadosAPI->evtRemun->dmdev->codcateg  = $oDados->codcateg;


            $oDadosAPI->evtRemun->dmdev->remunperapur->matricula   = $oDados->matricula;

            //$oDadosAPI->evtRemun->dtAlteracao         = '2021-01-29'; //$oDados->altContratual->dtAlteracao;
        }

        $aDadosAPI[] = $oDadosAPI;
        $iSequencial++;

        echo '<pre>';
        print_r($aDadosAPI);
        exit;
        return $aDadosAPI;
    }

    /**
     * Retorna dados dos dependentes no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarIdentificador($matricula)
    {
        $iAnoUsu           = db_getsession('DB_anousu');
        $iMesusu           = DBPessoal::getMesFolha();
        $aPontos = array('salario','complementar','13salario');
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

                default:
                continue;
                break;
            }
            if ($opcao) {
                $sql = "  select distinct
                        case
                        when {$arquivo} = 'gerfsal' then 1
                        when {$arquivo} = 'gerfcom' then 3
                        when {$arquivo} = 'gerffer' then 4
                        end as ideDmDev
                        from {$arquivo}
                        where ".$sigla."anousu = '".$iAnoUsu."'
                        and  ".$sigla."mesusu = '".$iMesusu."'
                        and  ".$sigla."instit = ".db_getsession("DB_instit")."
                        and {$sigla}regist = $matricula";
            }

            $rsIdentificadores = db_query($sql);
            if ($rsIdentificadores) {
                $oIdentificadores = \db_utils::fieldsMemory($rsIdentificadores, 0);
                $oIdentFormatado = new \stdClass;
                $oIdentFormatado->ideDmDev = $oIdentificadores->ideDmDev;
                $aIdentificadores[] = $oIdentFormatado->ideDmDev;
                // echo $sql;
                // db_criatabela($result);
                // exit;
            }
        }
        // var_dump($aIdentificadores);
        // exit;
    }

    /**
     * Retorna dados no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarRubricas($matricula)
    {
        $iAnoUsu           = db_getsession('DB_anousu');
        $iMesusu           = DBPessoal::getMesFolha();
        $aPontos = array('salario','complementar','ferias','rescisao','adiantamento','13salario','fixo','previden','irf','gerfprovfer','gerfprovs13');
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

            case 'ferias':
              $sigla          = 'r31_';
              $arquivo        = 'gerffer';
              $xtipo          = ' r31_tpp ';
              $sTituloCalculo = 'F?rias';
              break;

            case 'rescisao':
              $sigla          = 'r20_';
              $arquivo        = 'gerfres';
              $xtipo          = ' r20_tpp ';
              $sTituloCalculo = 'Rescis?o';
              break;

            case 'adiantamento':
              $sigla          = 'r22_';
              $arquivo        = 'gerfadi';
              $sTituloCalculo = 'Adiantamento';
              break;

            case '13salario':
              $sigla          = 'r35_';
              $arquivo        = 'gerfs13';
              $sTituloCalculo = '13? Sal?rio';
              break;

            case 'fixo':
              $sigla          = 'r53_';
              $arquivo        = 'gerffx';
              $sTituloCalculo = 'Calculo Fixo';
              break;

            case 'previden':
              $sigla          = 'r60_';
              $arquivo        = 'previden';
              $sTituloCalculo = 'Previd?ncia';
              break;

            case 'irf':
              $sigla          = 'r61_';
              $arquivo        = 'ajusteir';
              $sTituloCalculo = 'IRF';
              break;

            case 'gerfprovfer':
              $sigla          = 'r93_';
              $arquivo        = 'gerfprovfer';
              $sTituloCalculo = 'Proventos de F?rias';
              break;

            case 'gerfprovs13':
              $sigla          = 'r94_';
              $arquivo        = 'gerfprovs13';
              $sTituloCalculo = 'Proventos de 13? sal?rio';
              break;

            default:
              echo "SEM CALCULO NO M?S";
              $sTituloCalculo = 'Sem Calculo';
              $opcao = "";
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

                        where ".$sigla."anousu = '".$iAnoUsu."'
                        and  ".$sigla."mesusu = '".$iMesusu."'
                        and {$sigla}regist = $matricula
                        and {$sigla}pd != 3
                        order by {$sigla}pd,{$sigla}rubric";
            }
            echo $sql;
            $result = db_query($sql);
            db_criatabela($result);
            exit;
            //$aIdentificadores[] = $oDependFormatado;
        }
    }
}
