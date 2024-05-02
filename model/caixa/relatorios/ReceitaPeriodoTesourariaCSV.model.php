<?php

namespace model\caixa\relatorios;

use repositories\caixa\relatorios\ReceitaTipoRepositoryLegacy;
use repositories\caixa\relatorios\ReceitaTipoReceitaRepositoryLegacy;

require_once "repositories/caixa/relatorios/ReceitaTipoReceitaRepositoryLegacy.php";
require_once "repositories/caixa/relatorios/ReceitaTipoRepositoryLegacy.php";

class ReceitaPeriodoTesourariaCSV
{
    /**
     * @var IReceitaPeriodoTesourariaRepository;
     */
    private $oReceitaPeriodoTesourariaRepository;

    public function __construct(
        $sTipo,
        $sTipoReceita,
        $iFormaArrecadacao,
        $dDataInicial,
        $dDataFinal,
        $oReceitaPeriodoTesourariaRepository
    ) {

        $this->sTipo = $sTipo;
        $this->sTipoReceita = $sTipoReceita;
        $this->iFormaArrecadacao = $iFormaArrecadacao;
        $this->dDataInicial = $dDataInicial;
        $this->dDataFinal = $dDataFinal;
        $this->oReceitaPeriodoTesourariaRepository = $oReceitaPeriodoTesourariaRepository;
        $this->pegarDados();
    }

    /**
     * @return void
     */
    public function pegarDados()
    {
        $this->aDadosRelatorio = $this->oReceitaPeriodoTesourariaRepository->pegarDados();
    }

    /**
     * @return void
     */
    public function processar()
    {
        if (count($this->aDadosRelatorio) == 0) {
            db_redireciona('db_erros.php?fechar=true&db_erro=Não existem lançamentos para a receita');
        }

        $csv = fopen('php://output', "w");

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=Receita_Periodo_Tesouraria.csv");
        header("Pragma: no-cache");

        $this->aLinhas = array();

        if ($this->sTipo == ReceitaTipoRepositoryLegacy::DIARIO) {
            $this->montarTabelaReceitaDiaria();
            foreach ($this->aLinhas as $aLinha) {
                fputcsv($csv, $aLinha, ';');
            }
            fclose($csv);
            return;
        }

        $this->montarTabelaReceitaOrcamentaria();
        $this->montarTabelaReceitaExtraOrcamentaria();
        $this->montarTotalGeral();

        foreach ($this->aLinhas as $aLinha) {
            fputcsv($csv, $aLinha, ';');
        }
        fclose($csv);
    }

    /**
     * @return void
     */
    public function montarTabelaReceitaDiaria()
    {
        $totalGeralDiario = 0;
        foreach ($this->aDadosRelatorio as $aReceita) {
            $totalDiario = 0;
            foreach ($aReceita as $oReceita) {
                $aLinha = $this->montarDadosDiarios($oReceita);
                $totalDiario += $aLinha['valor'];
                $totalGeralDiario += $aLinha['valor'];
                $this->aLinhas[] = $aLinha;
            }
            $this->aLinhas[] = array('descricao' => "Total Diario", 'total' => number_format($totalDiario, 2, ",", ""));
        }
        $this->aLinhas[] = array('descricao' => "Total Geral", 'total' => number_format($totalGeralDiario, 2, ",", ""));
    }

    /**
     * @param stdClass $oReceita
     * @return array
     */
    public function montarDadosDiarios($oReceita)
    {
        $aLinha = array();
        $aLinha['codigo']          = $oReceita->codigo;
        $aLinha['reduzido']        = $oReceita->reduzido;
        $aLinha['data']            = $oReceita->data;
        $aLinha['numpre']          = $oReceita->numpre;
        $aLinha['estrutural']      = $oReceita->estrutural;
        $aLinha['fonte']           = $oReceita->fonte;
        $aLinha['descricao']       = $oReceita->descricao;
        $aLinha['conta']           = $oReceita->conta;
        $aLinha['conta_descricao'] = $oReceita->conta_descricao;
        $aLinha['valor']           = $oReceita->valor;

        return $aLinha;
    }

    /**
     * @return void
     */
    public function montarTotalGeral()
    {
        $this->aLinhas[] = array('descricao' => "Total Geral", 'total' => number_format($this->totalOrcamentaria + $this->totalExtra, 2, ",", ""));
    }

    /**
     * @return void
     */
    public function montarTabelaReceitaOrcamentaria()
    {
        if (!array_key_exists(ReceitaTipoReceitaRepositoryLegacy::ORCAMENTARIA, $this->aDadosRelatorio))
            return;

        foreach ($this->aDadosRelatorio['O'] as $tipo => $oReceita) {
            if (is_array($oReceita)) {
                if ($tipo == "CGM") {
                    $this->aLinhas = array_merge($this->aLinhas, $this->preencherDadosReceitaContribuinte($oReceita, 'O'));
                    continue;
                }

                if ($tipo == "RECEITA") {
                    $this->aLinhas = array_merge($this->aLinhas, $this->preencherDadosAnaliticoReceita($oReceita, 'O'));
                    continue;
                }

                if ($tipo == "OPCREDITO") {
                    $this->aLinhas = array_merge($this->aLinhas, $this->preencherDadosOperacaoCredito($oReceita, 'O'));
                    continue;
                }
            }

            $this->aLinhas[] = $this->preencherDadosReceita($oReceita);
        }
        $this->aLinhas[] =  array('descricao' => 'Total Receita Orçamentaria', 'total' => number_format($this->totalOrcamentaria, 2, ",", ""));
    }

    /**
     * @return void
     */
    public function montarTabelaReceitaExtraOrcamentaria()
    {
        if (!array_key_exists(ReceitaTipoReceitaRepositoryLegacy::EXTRA, $this->aDadosRelatorio))
            return;

        foreach ($this->aDadosRelatorio['E'] as $tipo => $oReceita) {
            if (is_array($oReceita)) {
                if ($tipo == "CGM") {
                    $this->aLinhas = array_merge($this->aLinhas, $this->preencherDadosReceitaContribuinte($oReceita, 'E'));
                    continue;
                }

                if ($tipo == "RECEITA") {
                    $this->aLinhas = array_merge($this->aLinhas, $this->preencherDadosAnaliticoReceita($oReceita, 'E'));
                    continue;
                }

                if ($tipo == "OPCREDITO") {
                    $this->aLinhas = array_merge($this->aLinhas, $this->preencherDadosOperacaoCredito($oReceita, 'E'));
                    continue;
                }
            }

            $this->aLinhas[] = $this->preencherDadosReceitaExtraOrcamentaria($oReceita, 'E');
        }
        $this->aLinhas[] =  array('descricao' => 'Total Receita Extraorçamentaria', 'total' => number_format($this->totalExtra, 2, ",", ""));
    }

    public function preencherDadosAnaliticoReceita($oReceita, $sTipo)
    {
        $aLinhas = array();
        foreach ($oReceita as $codigoReceita => $oReceitaContribuinte) {
            $aLinhas[] = array("receita" => $codigoReceita);
            $this->totalReceita = 0;
            foreach ($oReceitaContribuinte as $oReceitaFinal) {
                if ($sTipo == "O") {
                    $aLinhas[] = $this->preencherDadosReceita($oReceitaFinal);
                    continue;
                }
                $aLinhas[] = $this->preencherDadosReceitaExtraOrcamentaria($oReceitaFinal);
            }
            $aLinhas[] = array("descricao" => "TOTAL RECEITA", "total" => $this->totalReceita);
        }
        return $aLinhas;
    }

    public function preencherDadosReceitaContribuinte($oReceita, $sTipo)
    {
        $aLinhas = array();
        foreach ($oReceita as $cgm => $oReceitaContribuinte) {
            $aLinhas[] =  array('cgm' => $cgm);
            $this->totalCGM = 0;
            foreach ($oReceitaContribuinte as $oReceitaFinal) {
                if ($sTipo == "O") {
                    $aLinhas[] = $this->preencherDadosReceita($oReceitaFinal);
                    continue;
                }
                $aLinhas[] = $this->preencherDadosReceitaExtraOrcamentaria($oReceitaFinal);
            }
            $aLinhas[] =  array('descricao' => 'Total CGM', 'total' => number_format($this->totalCGM, 2, ",", ""));
        }
        return $aLinhas;
    }

    public function preencherDadosOperacaoCredito($oReceita, $sTipo)
    {
        $aLinhas = array();
        foreach ($oReceita as $opCredito => $oReceitaOpCredito) {
            $aLinhas[] =  array('operacao' => $opCredito);
            $this->totalOpCredito = 0;
            foreach ($oReceitaOpCredito as $oReceitaFinal) {
                if ($sTipo == "O") {
                    $aLinhas[] = $this->preencherDadosReceita($oReceitaFinal);
                    continue;
                }
                $aLinhas[] = $this->preencherDadosReceitaExtraOrcamentaria($oReceitaFinal);
            }
            $aLinhas[] =  array('descricao' => 'TOTAL OPERAÇÃO DE CRÉDITO', 'total' => number_format($this->totalOpCredito, 2, ",", ""));
        }
        return $aLinhas;
    }

    public function preencherDadosReceita($oReceita)
    {
        $this->totalOrcamentaria += $oReceita->valor;
        $this->totalCGM += $oReceita->valor;
        $this->totalReceita += $oReceita->valor;
        $this->totalOpCredito += $oReceita->valor;

        return $this->montarDados($oReceita);
    }

    public function preencherDadosReceitaExtraOrcamentaria($oReceita)
    {

        $this->totalExtra += $oReceita->valor;
        $this->totalCGM += $oReceita->valor;
        $this->totalReceita += $oReceita->valor;
        $this->totalOpCredito += $oReceita->valor;

        return $this->montarDados($oReceita);
    }

    /**
     * @param stdClass $oReceita
     * @return void
     */
    public function montarDados($oReceita)
    {
        $aLinha = array();
        if ($this->sTipo != ReceitaTipoRepositoryLegacy::ESTRUTURAL) {
            $aLinha['codigo'] = $oReceita->codigo;
            $aLinha['reduzido'] = $oReceita->reduzido;
        }

        if ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO || $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO_RECEITA) {
            $aLinha['data'] = str_replace('/', '', db_formatar($oReceita->data, 'd'));
            if ($oReceita->tipo == "O") {
                $aLinha['numpre'] = $oReceita->numpre;
            }
        }

        $aLinha['estrutural'] = $oReceita->estrutural;
        $aLinha['descricao'] = strtoupper($oReceita->descricao);

        if ($this->sTipo == ReceitaTipoRepositoryLegacy::CONTA) {
            $aLinha['conta'] = $oReceita->conta;
            $aLinha['conta_descricao'] = $oReceita->conta_descricao;
        }

        $aLinha['valor'] = number_format($oReceita->valor, 2, ',', '');
        if ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO || $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO_RECEITA) {
            if ($oReceita->tipo == "O") {
                $aLinha['conta'] = $oReceita->conta;
                $aLinha['conta_descricao'] = $oReceita->conta_descricao;
            }
            if (trim($oReceita->historico) != '' && ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO || $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO_RECEITA)) {
                $aLinha['historico'] = substr($oReceita->historico, 0, 44);
            }
            if (trim($oReceita->historico) == '' && ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO || $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO_RECEITA) && $oReceita->tipo == "E") {
                $aLinha['historico'] = "";
            }
        }
        return $aLinha;
    }
}
