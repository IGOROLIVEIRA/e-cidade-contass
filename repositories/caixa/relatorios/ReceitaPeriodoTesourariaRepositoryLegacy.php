<?php

namespace repositories\caixa\relatorios;

class ReceitaPeriodoTesourariaRepositoryLegacy
{
    private $iEmendaParlamentar;
    private $iRegularizacaoRepasse;
    private $sReceitas;
    private $sContribuintes;

    public function definirSQLWhereReceita()
    {
        if ($this->sReceitas) {
            $this->sWhere .= " AND g.k02_codigo in ({$this->sReceitas}) ";
        }
    }

    public function definirSQLWhereContribuinte()
    {
        if ($this->sContribuintes) {
            $this->sWhere .= " AND k81_numcgm in ({$this->sContribuintes}) ";
        }
    }

    public function definirSQLWhereEmenda()
    {
        if ($this->iEmendaParlamentar != 0) {
            $this->sWhere .= " AND k81_emparlamentar = {$this->iEmendaParlamentar} ";
        }
    }

    public function definirSQLWhereRepasse()
    {
        if ($this->iRegularizacaoRepasse != 0) {
            $this->sWhere .= " and k81_regrepasse = {$this->iRegularizacaoRepasse} ";
        }
    }
}
