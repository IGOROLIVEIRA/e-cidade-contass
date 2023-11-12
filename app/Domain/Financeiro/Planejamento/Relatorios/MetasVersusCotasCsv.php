<?php

namespace App\Domain\Financeiro\Planejamento\Relatorios;

use ECidade\File\Csv\Dumper\Dumper;

class MetasVersusCotasCsv extends Dumper
{
    /**
     * depara para os per�odos
     * @var string[]
     */
    protected $descricaoPeriodos = [
        'janeiro' => 'Janeiro',
        'fevereiro' => 'Fevereiro',
        'marco' => 'Mar�o',
        'abril' => 'Abril',
        'maio' => 'Maio',
        'junho' => 'Junho',
        'julho' => 'Julho',
        'agosto' => 'Agosto',
        'setembro' => 'Setembro',
        'outubro' => 'Outubro',
        'novembro' => 'Novembro',
        'dezembro' => 'Dezembro',
        'bimestre_1' => '1� Bimestre',
        'bimestre_2' => '2� Bimestre',
        'bimestre_3' => '3� Bimestre',
        'bimestre_4' => '4� Bimestre',
        'bimestre_5' => '5� Bimestre',
        'bimestre_6' => '6� Bimestre',
    ];
    /**
     * @var array
     */
    private $dados;

    /**
     * @var mixed
     */
    private $agrupadorSelecionado;
    /**
     * @var string[]
     */
    private $dadosImprimir = [];
    /**
     * @var string[]
     */
    private $periodosImpressao = [];

    public function setDados(array $dados)
    {
        $this->dados = $dados;

        $this->agrupadorSelecionado = $this->dados['filtros']['agruparPor'];
        $this->periodosImpressao = $this->dados['periodosImpressao'];
    }

    public function emitir()
    {
        $filename = sprintf('tmp/meta-x-cotas-%s.csv', time());
        $this->dumpToFile($this->organizarDados(), $filename);
        return [
            'csv' => $filename,
            'csvLinkExterno' => ECIDADE_REQUEST_PATH . $filename
        ];
    }

    private function organizarDados()
    {
        $this->dadosImprimir = ['METAS DE ARRECADA��O X COTAS DA DESPESA'];
        if ($this->agrupadorSelecionado === 'geral') {
            $this->imprimeTotalGeral();
        } else {
            $this->imprimeRecursos();
        }

        return $this->dadosImprimir;
    }

    private function imprimeTotalGeral()
    {
        $totalGeral = $this->dados['totalGeral'];
        $this->cabecalho($totalGeral->descricao);

        $this->imprimeTabela($totalGeral);
    }

    private function imprimeRecursos()
    {
        foreach ($this->dados['dados'] as $dado) {
            $this->cabecalho($dado->descricao);
            $this->imprimeTabela($dado);
            $this->dadosImprimir[] = '';
        }
    }

    private function cabecalho($descricao)
    {
        $this->dadosImprimir[] = $descricao;
        $this->dadosImprimir[] = [
            'Per�odo',
            'Vlr Receita',
            '% Receita',
            'Vlr Despesa',
            '% Despesa',
            'Diferen�a'
        ];
    }

    private function imprimeTabela($objeto)
    {
        foreach ($this->periodosImpressao as $periodo) {
            $descricao = $this->descricaoPeriodos[$periodo];
            $this->dadosImprimir[] = [
                $descricao,
                formataValorMonetario($objeto->{$periodo}->receita->valor),
                formataValorMonetario($objeto->{$periodo}->receita->percentual),
                formataValorMonetario($objeto->{$periodo}->despesa->valor),
                formataValorMonetario($objeto->{$periodo}->despesa->percentual),
                formataValorMonetario($objeto->{$periodo}->diferenca)
            ];
        }

        $this->dadosImprimir[] = [
            'TOTAL',
            formataValorMonetario($objeto->total_receita),
            100,
            formataValorMonetario($objeto->total_despesa),
            100,
            formataValorMonetario($objeto->diferenca)
        ];
    }
}
