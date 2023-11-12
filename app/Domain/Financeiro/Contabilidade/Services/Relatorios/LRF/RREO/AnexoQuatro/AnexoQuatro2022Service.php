<?php

namespace App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO\AnexoQuatro;

use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO\AnexoQuatro\AnexoQuatroService;

/**
 * 12� Edi��o do Anexo IV
 * Relat�rio de c�digo: 263 no sistema
 */
class AnexoQuatro2022Service extends AnexoQuatroService
{
    protected $sections = [
        'receita_1' => [1, 22],  // RECEITAS PREVIDENCI�RIAS - RPPS (FUNDO EM CAPITALIZA��O)
        'despesa_1' => [24, 29], // DESPESAS PREVIDENCI�RIAS - RPPS (FUNDO EM CAPITALIZA��O)
        'receita_2' => [32, 32], // RECURSOS RPPS ARRECADADOS EM EXERC�CIOS ANTERIORES
        'despesa_2' => [33, 33], // RESERVA OR�AMENT�RIA DO RPPS
        'verificacao_1' => [34, 37], // APORTES DE RECURSOS PARA O FUNDO EM CAPITALIZA��O DO RPPS
        'verificacao_2' => [38, 40], // BENS E DIREITOS DO RPPS (FUNDO EM CAPITALIZA��O)
        'receita_3' => [41, 62], // BENS E DIREITOS DO RPPS (FUNDO EM CAPITALIZA��O)
        'despesa_3' => [63, 69], // DESPESAS PREVIDENCI�RIAS - RPPS (FUNDO EM REPARTI��O)
        'verificacao_3' => [71, 72], // APORTES DE RECURSOS PARA O FUNDO EM REPARTI��O DO RPPS
        'verificacao_4' => [73, 75], // BENS E DIREITOS DO RPPS (FUNDO EM REPARTI��O)
        'receita_4' => [76, 76], // RECEITAS DA ADMINISTRA��O - RPPS
        'despesa_4' => [78, 82], // DESPESAS DA ADMINISTRA��O - RPPS
        'verificacao_5' => [84, 86], // BENS E DIREITOS - ADMINISTRA��O DO RPPS
        'despesa_5' => [87, 88], // DESPESAS PREVIDENCI�RIAS (BENEF�CIOS MANTIDOS PELO TESOURO)
        'despesa_6' => [90, 93], // DESPESAS PREVIDENCI�RIAS (BENEF�CIOS MANTIDOS PELO TESOURO)
    ];

    /**
     * Retorna um array de objetos com os dados necess�rios para impress�o do quadro simplificado
     * Para isso executa o relat�rio legal processando totalizando as linhas necess�rias do quadro
     * @return array
     */
    public function processaLinhasSimplificado()
    {
        $this->linhasNaoProcessar = [
            32, 33, 34, 35, 36, 37, 38, 39, 71, 72, 73, 74, 75, 76, 77, 80, 81, 87, 88, 90, 91, 92
        ];
        $this->processaLinhas($this->linhas);
        $this->criaProriedadesValor();

        // realiza o calculo dos totalizadores das linhas
        $this->calculaLinha23Simplificado();
        $this->calculaLinha30Simplificado();
        $this->calculaLinha31Simplificado();
        $this->calculaLinha62Simplificado();
        $this->calculaLinha69Simplificado();
        $this->calculaLinha70Simplificado();

        return $this->linhasSimplificado();
    }
}
