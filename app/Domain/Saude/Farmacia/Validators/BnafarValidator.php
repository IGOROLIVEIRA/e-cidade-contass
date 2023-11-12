<?php

namespace App\Domain\Saude\Farmacia\Validators;

class BnafarValidator
{
    /**
     * @var array
     */
    protected $erros;

    /**
     * @return bool
     */
    public function temInconsistencia()
    {
        return !empty($this->erros);
    }

    /**
     * @return array
     */
    public function getErros()
    {
        return $this->erros;
    }

    /**
     * @param object $movimentacao
     */
    public function validar($movimentacao)
    {
        $this->erros = [];
        foreach ($this->validaCamposObrigatorios($movimentacao) as $erro) {
            $this->erros = array_merge($this->erros, $erro);
        }
    }

    /**
     * @param object $movimentacao
     * @param bool $validaMovimentacao
     * @return \Generator
     */
    protected function validaCamposObrigatorios($movimentacao, $validaMovimentacao = true)
    {
        if ($movimentacao->movimentacao == '' && $validaMovimentacao) {
            yield ['movimentacao' => 'O campo tipo de movimenta��o � obrigat�rio.'];
        }
        if ($movimentacao->numero_produto == '') {
            yield ['numero_produto' => 'O campo identificador do produto(CATMAT) � obrigat�rio.'];
        }
        if ($movimentacao->tipo_produto == '') {
            yield ['tipo_produto' => 'O campo tipo de produto � obrigat�rio.'];
        }
        if ($movimentacao->lote == '') {
            yield ['lote' => 'O campo lote � obrigat�rio.'];
        }
        if ($movimentacao->data_validade == '') {
            yield ['data_validade' => 'O campo data de validade � obrigat�rio.'];
        }
        if ($movimentacao->cnpj_fabricante == '' && $movimentacao->nome_fabricante == '') {
            yield ['id_fabricante' => '� obrigat�rio informar o CNPJ do fabricante ou fabricante internacional.'];
        }
    }
}
