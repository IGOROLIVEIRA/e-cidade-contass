<?php

use ECidade\Financeiro\Orcamento\Repository\RecursoRepository as RecursoRepositoryAlias;

/**
 * Retorna o c�digo do recurso com base no n�mero do recurso.
 * Caso exista mais de um recurso com a fonte de recurso,
 * retorna o que tem o complemento 0.
 */
if (!function_exists('obterCodigoRecursoPorFonte')) {
    function obterCodigoRecursoPorFonte($recurso)
    {
        $recursos = RecursoRepositoryAlias::getRecursosValidosPorFonteRecurso($recurso);
        /**
         * em breve ser� utilizado o codigo da gestao, (fonterecurso)
         * quando homologar e efetivar a STN sera alterado
         */
        $retorno = $recursos[0]->o15_codigo;

        // Existindo mais de um, pega o que tem o complemento 0(zero)
        if (count($recursos) > 1) {
            $filtroAdicional = " o15_complemento = 0 ";
            $recursosSearch = RecursoRepositoryAlias::getRecursosValidosPorFonteRecurso($recurso, $filtroAdicional);
            if (count($recursosSearch) == 1) {
                return $recursosSearch[0]->o15_codigo;
            }
        }

        return $retorno;
    }
}
