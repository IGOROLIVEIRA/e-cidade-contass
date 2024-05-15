<?php

namespace repositories\caixa;

class ReceitaTesourariaRepositoryLegacy
{
    public $tipo;
    public $descricao;
    public $estrutural; 
    public $valor;
    public $reduzido;
    public $codigo;
    public $historico;
    public $data;
    public $numpre;
    public $conta;
    public $contaDescricao; 

    public function __construct($sTipo, $sDescricao, $sEstrutural, $nValor)
    {
        $this->tipo = $sTipo;
        $this->descricao = $sDescricao;
        $this->estrutural = $sEstrutural;
        $this->valor = $nValor;
    }
}