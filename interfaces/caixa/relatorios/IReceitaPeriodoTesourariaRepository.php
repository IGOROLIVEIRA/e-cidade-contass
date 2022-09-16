<?php

namespace interfaces\caixa\relatorios;

interface IReceitaPeriodoTesourariaRepository
{
    public function pegarDados();
    public function pegarTipoConstrutor();
    public function definirSQLDesconto();
    public function definirSQLInnerJoin();
    public function definirSQLWhereExterno();
    public function definirSQLCampos();
    public function definirSQLWhere();
    public function definirSQLWhereReceita();
    public function definirSQLWhereContribuinte();
    public function definirSQLWhereEmenda();
    public function definirSQLWhereRepasse();
}