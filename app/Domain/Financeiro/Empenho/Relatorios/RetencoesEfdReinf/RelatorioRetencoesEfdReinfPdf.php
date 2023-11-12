<?php

namespace app\domain\Financeiro\Empenho\Relatorios\RetencoesEfdReinf;

use App\Domain\Financeiro\Empenho\Relatorios\RetencoesEfdReinf\RelatorioRetencoesEfdReinfFiltros;
use ECidade\Pdf\Pdf;

class RelatorioRetencoesEfdReinfPdf extends Pdf
{

    /**
     * @var RetencoesEfdReinfFiltros $filtros
     */
    protected $filtros;
    protected $dados;
    

    public function __construct($orientation = 'L')
    {
        parent::__construct($orientation);
    }

    /**
     * Cabe�alho do relat�rio
     */
    public function headers()
    {
        $this->addTitulo("Relat�rio de Reten��es da Efd Reinf");
        $this->addTitulo("Data  : ".$this->dados['headerData']);
        $this->addTitulo("Quebra: ".$this->dados['headerQuebra']);
        $this->addTitulo($this->dados['headerOrgaoUnidade']);

        $this->init(false);
    }

    /**
     * Unidade l�gica de processamento
     */


    public function emitir()
    {
        $this->imprimir();
        
        $fileName = 'tmp/RetencoesEfdReinf' . time() . '.pdf';
        $this->output('F', $fileName);

        return [
            "name" => "Relat�rio Reten��es EFD-Reinf PDF",
            "path" => $fileName,
            'pathExterno' => ECIDADE_REQUEST_PATH . $fileName
        ];
    }

    public function imprimir()
    {
        $sFonte = "Arial";
        $lEscreverHeader = true;
        $nTotalRetencoes = 0;
        $vlrTotalNl = 0;
        $vlrBaseCalc = 0;
        $iTamCell = 0;
        $iTamFonte = 6;
        $textoQuebra = '';

        $this->addPage();
        $aRetencoes = $this->dados['retencoes'];

        foreach ($aRetencoes as $oQuebra) {
            $this->setFont($sFonte, "b", $iTamFonte + 2);
            $lEscreverHeader = true;

            foreach ($oQuebra->itens as $oRetencaoAtiva) {
                if ($this->Gety() > $this->getH() - 27 || $lEscreverHeader) {
                    if ($this->Gety() > $this->getH() - 27) {
                        $this->addPage();
                    }
                    if ($oQuebra->texto != "") {
                        $this->cell(0, 5, $oQuebra->texto, 0, 1);
                        if ($textoQuebra != $oQuebra->texto) {
                            $textoQuebra = $oQuebra->texto;
                            $vlrTotalNl = 0;
                            $vlrBaseCalc = 0;
                        }
                    }

                    $this->imprimeCabecalho($sFonte, $iTamCell, $iTamFonte);
                    $lEscreverHeader = false;
                }
                $vlrTotalNl += $oRetencaoAtiva->valor_nota_liq;
                $vlrBaseCalc += $oRetencaoAtiva->valor_base_calc;
                $this->imprimeDadosRelatorio($sFonte, $iTamCell, $iTamFonte, $oRetencaoAtiva);
            }
            $this->imprimeTotalizadorQuebra($sFonte, $iTamFonte, $oQuebra, $vlrTotalNl, $vlrBaseCalc);
            $nTotalRetencoes += $oQuebra->total;
        }
        if (count($aRetencoes) > 0) {
            $this->imprimeTotalizadorGeral($sFonte, $iTamFonte, $nTotalRetencoes);
        }
    }

    public function imprimeDadosRelatorio($sFonte, $iTamCell, $iTamFonte, $oRetencaoAtiva)
    {

        $yAtual = $this->getY();
        $this->SetFont($sFonte, "", $iTamFonte);
        $this->cell(15 + $iTamCell, 6, $oRetencaoAtiva->numero_nota, "T", 0, "R", 0);
        $this->cell(17 + $iTamCell, 6, db_formatar($oRetencaoAtiva->data_emissao, 'd'), "T", 0, "C");
        $this->cell(65 + $iTamCell, 6, $oRetencaoAtiva->nome_prestador, "T", 0, "C");
        $this->cell(24, 6, $oRetencaoAtiva->cnpj_prestador, "T", 0, "C");
        $this->cell(16, 6, $oRetencaoAtiva->empenho_numero, "T", 0, "R");
        $this->cell(18 + $iTamCell, 6, $oRetencaoAtiva->retencao_tipo, "T", 0, "C");
        
        $xAtual = $this->getX();
        $this->multicell(25 + $iTamCell, 6, $oRetencaoAtiva->referencia_tipo_servico_desc, "T", "J", 0);
       
        $yNovo = $this->getY();
        $this->setxy($xAtual+25, $yAtual);
        
        $this->cell(22, 6, $oRetencaoAtiva->indicativo_obra_cno, "T", 0, "C");
        $this->cell(20, 6, db_formatar($oRetencaoAtiva->valor_nota_liq, "f"), "T", 0, "C");
        $this->cell(20, 6, db_formatar($oRetencaoAtiva->valor_base_calc, "f"), "T", 0, "C");
        $this->cell(14, 6, $oRetencaoAtiva->aliquota != "" ? $oRetencaoAtiva->aliquota."%": "", "T", 0, "C");
        $this->cell(22, 6, db_formatar($oRetencaoAtiva->valor_retencao, "f"), "T", 1, "C");

        $this->setY($yNovo);
    }

    public function imprimeCabecalho($sFonte, $iTamCell, $iTamFonte)
    {
        $this->setFont($sFonte, "b", $iTamFonte + 1);

        $this->cell(15 + $iTamCell, 5, "NF", 1, 0, "C", 1);
        $this->cell(17, 5, "DATA DA NF", 1, 0, "C", 1);
        $this->cell(65 + $iTamCell, 5, "PRESTADOR DE SERVI�O", 1, 0, "C", 1);
        $this->cell(24 + $iTamCell, 5, "CNPJ/CPF", 1, 0, "C", 1);
        $this->cell(16, 5, "EMPENHO", 1, 0, "C", 1);
        $this->cell(18 + $iTamCell, 5, "RETEN��O", 1, 0, "C", 1);
        $this->cell(25 + $iTamCell, 5, "TIPO DE SERVI�O", 1, 0, "C", 1);
        $this->cell(22, 5, "CNO", 1, 0, "C", 1);
        $this->cell(20, 5, "VLR DA NL", 1, 0, "C", 1);
        $this->cell(20, 5, "BASE DE CALC", 1, 0, "C", 1);
        $this->cell(14, 5, "AL�Q", 1, 0, "C", 1);
        $this->cell(22, 5, "VLR RETIDO", 1, 1, "C", 1);
    }

    public function imprimeTotalizadorQuebra($sFonte, $iTamFonte, $oQuebra, $vlrTotalNl, $vlrBaseCalc)
    {
        $this->SetFont($sFonte, "b", $iTamFonte);
        $this->cell(202, 5, "TOTALIZADORES:", "TBR", 0, "C", 1);
        $this->cell(20, 5, db_formatar($vlrTotalNl, "f"), "TBR", 0, "C", 1);
        $this->cell(20, 5, db_formatar($vlrBaseCalc, "f"), "TBR", 0, "C", 1);
        $this->cell(14, 5, '', "TB", 0, "C", 1);
        $this->cell(22, 5, db_formatar($oQuebra->total, "f"), "TBL", 1, "C", 1);
    }

    public function imprimeTotalizadorGeral($sFonte, $iTamFonte, $nTotalRetencoes)
    {
        $this->SetFont($sFonte, "b", $iTamFonte);
        $this->cell(256, 5, "Total Geral:", "TBR", 0, "R", 1);
        $this->cell(22, 5, db_formatar($nTotalRetencoes, "f"), "TBL", 1, "C", 1);
    }
    /**
     * Inicializa��o do relatorio com informa��es sobre filtros e dados de processamento;
     */
    public function setDados($dados)
    {
        $this->dados = $dados;
    }

    public function setFiltros(RelatorioRetencoesEfdReinfFiltros $filtros)
    {
        $this->filtros = $filtros;
    }
}
