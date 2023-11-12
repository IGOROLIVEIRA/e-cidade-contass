<?php

namespace App\Domain\Saude\Farmacia\Validators;

class EntradaBnafarValidator extends BnafarValidator
{
    protected function validaCamposObrigatorios($movimentacao, $validaMovimentacao = true)
    {
        if ($movimentacao->cnpj_estabelecimento == '' && $movimentacao->cnes_estabelecimento == '') {
            yield ['id_estabelecimento' => '� obrigat�rio informar o campo CNPJ ou CNES do estabelecimento origem.'];
        }

        // Executado pela rotina de transfer�ncia entra dep�sitos
        $isTransferencia = $movimentacao->movimentacao == '7' && $movimentacao->codigo_transferencia != '';
        if ($movimentacao->numero_documento == '' && !$isTransferencia) {
            yield ['numero_documento' => 'O campo nota fiscal � obrigat�rio.'];
        }

        foreach (parent::validaCamposObrigatorios($movimentacao, $validaMovimentacao) as $erro) {
            yield $erro;
        }
    }
}
