<?php

namespace App\Domain\Financeiro\Contabilidade\Contracts;

interface AnexosFactoryInterface
{
    /**
     * O retorno deve seguir o exemplo:
     * ['relatorio' => $relatorio, 'programa' => $programa, 'rota' => $rota];
     * onde:
     * $relatorio � o c�digo do relat�rio
     * $programa � a view para selecionar os filtros
     * $rota � a rota de impress�oa
     * @param $exercicio
     * @return array
     */
    public static function getDadosView($exercicio);

    /**
     * @param $exercicio
     * @return integer
     */
    public static function getCodigoRelatorio($exercicio);
}
