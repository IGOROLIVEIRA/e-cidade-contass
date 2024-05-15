<?php

abstract class ImportacaoReceitaLayout2
{
    /**
     * Objeto da Receita
     *
     * @var stdClass
     */
    public $oReceita; 

    /**
     * @param [string] $sLinha
     * @return void
     */
    public function __construct($sLinha)
    {
        $this->oReceita = new stdClass();
        $this->preencherLinha($sLinha);
    }

    /**
     * Função responsavel por preencher todos os campos para layout
     *
     * @param String $sLinha
     * @return void
     */
    public function preencherLinha(String $sLinha) {}

    /**
     * Recupera o objeto da receita
     *
     * @return stdClass
     */
    public function recuperarLinha()
    {
        return $this->oReceita;
    }

    /**
     * Função para formatar a data confida no txt
     *
     * @param [string] $sData
     * @return date
     */
    public function montarData($sData)
    {
        $sDia = substr($sData, 0, 2);
        $sMes = substr($sData, 2, 2);
        $sAno = substr($sData, 4, 4);
        return date("Y-m-d", strtotime("{$sDia}-{$sMes}-{$sAno}"));
    }

    /**
     * Função para formatar os valores contidos no txt
     *
     * @param [string] $sValor
     * @return float
     */
    public function montarValor($sValor)
    {
        $operador = substr($sValor, 0, 1) . 1;
        $valorDecimal = (float) ((int) substr($sValor, 1, 10)) . "." . substr($sValor, 11, 2);
        return $operador * $valorDecimal;
    }
}
