<?php

namespace app\domain\Financeiro\Empenho\Relatorios\RetencoesEfdReinf;

use ECidade\File\Csv\Dumper\Dumper;
use App\Domain\Financeiro\Empenho\Relatorios\RetencoesEfdReinf\RelatorioRetencoesEfdReinfFiltros;

class RelatorioRetencoesEfdReinfCsv extends Dumper
{
    
    protected $dados;
    protected $filtros;

    /**
     * Unidade l�gica de processamento
     */
    public function emitir()
    {

        $fileName = 'tmp/RetencoesEfdReinf' . time() . '.csv';
        $this->dumpToFile($this->imprimir(), $fileName);
        return [
            "name" => "Relat�rio Reten��es EFD-Reinf CSV",
            "path" => $fileName,
            'pathExterno' => ECIDADE_REQUEST_PATH . $fileName
        ];
    }

    public function imprimir()
    {
        $this->dadosImprimir = [];
        $aRetencoes = $this->dados['retencoes'];
        $nTotalRetencoes = 0;
        $vlrTotalNl = 0;
        $vlrBaseCalc = 0;
        $textoQuebra = '';

        foreach ($aRetencoes as $oQuebra) {
            $lEscreverHeader = true;

            foreach ($oQuebra->itens as $oRetencaoAtiva) {
                if ($lEscreverHeader) {
                    if ($oQuebra->texto != "") {
                        $this->dadosImprimir[] = $this->imprimeQuebra($oQuebra->texto);
                        if ($textoQuebra != $oQuebra->texto) {
                            $textoQuebra = $oQuebra->texto;
                            $vlrTotalNl = 0;
                            $vlrBaseCalc = 0;
                        }
                    }

                    $this->dadosImprimir[] = $this->imprimeCabecalho();
                    $lEscreverHeader = false;
                }
                $vlrTotalNl += $oRetencaoAtiva->valor_nota_liq;
                $vlrBaseCalc += $oRetencaoAtiva->valor_base_calc;
                $this->dadosImprimir[] = $this->imprimeDadosRelatorio($oRetencaoAtiva);
            }
            $this->dadosImprimir[] = $this->imprimeTotalizadorQuebra($oQuebra, $vlrTotalNl, $vlrBaseCalc);
            $nTotalRetencoes += $oQuebra->total;
        }

        if (count($aRetencoes) > 0) {
            $this->dadosImprimir[] = $this->imprimeTotalizadorGeral($nTotalRetencoes);
        }
        return $this->dadosImprimir;
    }

    public function imprimeCabecalho()
    {

        $cabecalho = [
            "NF",
            "DATA DA NF",
            "PRESTADOR DE SERVI�O",
            "CNPJ/CPF",
            "EMPENHO",
            "RETEN��O",
            "TIPO DE SERVI�O",
            "CNO",
            "VLR DA NL",
            "BASE DE CALC",
            "AL�Q",
            "VLR RETIDO"
        ];
        
        return $cabecalho;
    }

    public function imprimeQuebra($texto)
    {

        $quebra = [
            $texto,
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            ""
        ];
        
        return $quebra;
    }

    public function imprimeDadosRelatorio($oRetencaoAtiva)
    {
        $dadosRelatorio = [
            $oRetencaoAtiva->numero_nota,
            db_formatar($oRetencaoAtiva->data_emissao, 'd'),
            $oRetencaoAtiva->nome_prestador,
            $oRetencaoAtiva->cnpj_prestador,
            $oRetencaoAtiva->empenho_numero,
            $oRetencaoAtiva->retencao_tipo,
            $oRetencaoAtiva->referencia_tipo_servico_desc,
            $oRetencaoAtiva->indicativo_obra_cno,
            db_formatar($oRetencaoAtiva->valor_nota_liq, "f"),
            db_formatar($oRetencaoAtiva->valor_base_calc, "f"),
            $oRetencaoAtiva->aliquota != "" ? $oRetencaoAtiva->aliquota."%": "",
            db_formatar($oRetencaoAtiva->valor_retencao, "f")
        ];

        return $dadosRelatorio;
    }

    public function imprimeTotalizadorQuebra($oQuebra, $vlrTotalNl, $vlrBaseCalc)
    {
        $totalizadorQuebra = [
            "Totalizadores:",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            db_formatar($vlrTotalNl, "f"),
            db_formatar($vlrBaseCalc, "f"),
            "",
            db_formatar($oQuebra->total, "f")
        ];
        return $totalizadorQuebra;
    }

    public function imprimeTotalizadorGeral($nTotalRetencoes)
    {
        $totalizadorGeral = [
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "Total Geral:",
            db_formatar($nTotalRetencoes, "f")
        ];
        return $totalizadorGeral;
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
