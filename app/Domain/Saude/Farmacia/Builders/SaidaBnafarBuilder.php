<?php

namespace App\Domain\Saude\Farmacia\Builders;

class SaidaBnafarBuilder extends BnafarBuilder
{
    protected function buildCaracterizacao()
    {
        $tiposSaida = [
            '1' => 'S-D', // Doa��o
            '2' => 'S-PE', // Perda
            '3' => 'S-AE', // Ajuste de estoque
            '7' => 'S-TR', // Transfer�ncia/remanejamento
            '9' => 'S-VV', // Validade vencida
            '10' => 'S-DD', // Distribui��o
            '11' => 'S-EE', // Devolu��o de empr�stimo
            '12' => 'S-E', // Empr�stimo
            '13' => 'S-AS', // Apreens�o sanit�ria
            '14' => 'S-AEA', // Amostra, exposi��o e an�lise
            '15' => 'S-DEP' // Devolu��o de entrada de produto
        ];
        $dado = $this->dados->first();
        $tipoSaida = array_key_exists($dado->movimentacao, $tiposSaida) ? $tiposSaida[$dado->movimentacao] : '';

        $estabelecimentoDestino = $dado->cnpj_estabelecimento;
        if (empty($estabelecimentoDestino)) {
            $estabelecimentoDestino = $dado->cnes_estabelecimento;
        }

        return (object)[
            'codigoOrigem' => $dado->codigo_origem,
            'dataSaida' => $dado->data_saida,
            'estabelecimentoDestino' => $estabelecimentoDestino,
            'tipoSaida' => $tipoSaida
        ];
    }
}
