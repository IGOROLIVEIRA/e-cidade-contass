<?php
namespace repositories\caixa\relatorios;

use repositories\caixa\relatorios\ReceitaOrdemRepositoryLegacy;
use repositories\caixa\relatorios\ReceitaTipoRepositoryLegacy;

require_once 'repositories/caixa/relatorios/ReceitaOrdemRepositoryLegacy.php';
require_once 'repositories/caixa/relatorios/ReceitaTipoRepositoryLegacy.php';

class ReceitaPeriodoTesourariaRepositoryLegacy
{
    private $iEmendaParlamentar;
    private $iRegularizacaoRepasse;
    private $sReceitas;
    private $sContribuintes;

    public function definirSQLWhereTipo()
    {
        if ($this->sTipoReceita != ReceitaTipoRepositoryLegacy::TODOS)
            return " AND g.k02_tipo = '{$this->sTipoReceita}' ";
    }

    public function definirSQLWhereReceita()
    {
        if ($this->sReceitas) {
            return " AND g.k02_codigo in ({$this->sReceitas}) ";
        }
    }

    public function definirSQLWhereContribuinte()
    {
        if ($this->sContribuintes) {
            return " AND k81_numcgm in ({$this->sContribuintes}) ";
        }
    }

    public function definirSQLWhereEmenda()
    {
        if ($this->iEmendaParlamentar != 0) {
            return " AND k81_emparlamentar = {$this->iEmendaParlamentar} ";
        }
    }

    public function definirSQLWhereRepasse()
    {
        if ($this->iRegularizacaoRepasse != 0) {
            return " and k81_regrepasse = {$this->iRegularizacaoRepasse} ";
        }
    }

    public function definirSQLOrderBy()
    {
        if ($this->sOrdem == ReceitaOrdemRepositoryLegacy::CODIGO) {
            return " ORDER BY k02_tipo, k02_codigo ";
        }
        if ($this->sOrdem == ReceitaOrdemRepositoryLegacy::ESTRUTURAL) {
        }
        if ($this->sOrdem == ReceitaOrdemRepositoryLegacy::ALFABETICA) {
        }
        if ($this->sOrdem == ReceitaOrdemRepositoryLegacy::REDUZIDO_ORCAMENTO) {
        }
        if ($this->sOrdem == ReceitaOrdemRepositoryLegacy::REDUZIDO_CONTA) {
        }
        /*
    if ($ordem == 'r') {
        $orderby = ' order by k02_tipo, k02_codigo ';
    }
    elseif ($ordem == 'e') {
        $orderby = ' order by k02_tipo, estrutural ';
    }
    elseif ($ordem == 'd') {
        $orderby = ' order by k02_tipo, codrec ';
    } elseif ($ordem == 'a') {
        $orderby = ' order by k02_tipo, k02_drecei ';
    } elseif ($ordem == 'c') {
      if ($sinana == 'S1') {
          $orderby = ' order by k02_tipo, codrec';
      } else {
          $orderby = ' order by k02_tipo, c61_reduz ';
      }
    }
    
    if($sinana == 'S4'){
        $orderby = ' order by k12_data, k02_tipo, k02_codigo ';
    }
    */
    }

}
