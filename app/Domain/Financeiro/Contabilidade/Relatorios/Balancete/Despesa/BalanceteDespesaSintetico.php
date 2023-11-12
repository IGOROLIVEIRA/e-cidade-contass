<?php


namespace App\Domain\Financeiro\Contabilidade\Relatorios\Balancete\Despesa;

class BalanceteDespesaSintetico extends BalanceteDespesa
{
    /**
     * De para do n�vel para oo nome do que esta sendo impresso.
     * @var string[]
     */
    private $deParaClassificacao = [
        'orgao' => '�rg�o',
        'unidade' => 'Unidade',
        'funcao' => 'Fun��o',
        'subfuncao' => 'Subfun��o',
        'programa' => 'Programa',
        'projeto' => 'Projeto/Atividade',
        'elemento' => 'Elementos',
        'recurso' => 'Recursos',
    ];

    /**
     * @var string
     */
    protected $modelo = 'SINT�TICO';

    protected function imprimir()
    {
        $this->imprimeCabecalho();
        foreach ($this->dados as $dado) {
            $this->imprimeClassificacao($dado);
        }

        $this->imprimeTotalizador($this->totalizador);

        $this->imprimirAssinaturas();
    }

    /**
     * Fun��o recursiva que imprime os dados do relat�rio
     * @param $dado
     */
    private function imprimeClassificacao($dado)
    {
        $classificacao = $this->deParaClassificacao[$dado->nivel];
        $descricao = sprintf('%s: %s - %s', $classificacao, $dado->formatado, $dado->descricao);
        $this->bold();
        $this->Cell($this->wLinhaP, $this->hLinha, $descricao, 0, 1);
        $this->regular();
        if (!empty($dado->filho)) {
            foreach ($dado->filho as $proximoNivel) {
                $this->imprimeClassificacao($proximoNivel);
            }
        } else {
            $this->imprimeRecursos($dado->recursos);
            $this->imprimeSaldos($dado->valores);
        }

        $mensagem = sprintf(
            'Total %s: %s - %s:',
            $this->deParaClassificacao[$dado->nivel],
            $dado->formatado,
            $dado->descricao
        );

        $this->imprimeTotalizador($dado->valores, $mensagem);
    }
}
