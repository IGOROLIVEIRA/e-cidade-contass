<?php

namespace App\Domain\Financeiro\Contabilidade\Factories;

use App\Domain\Financeiro\Contabilidade\Contracts\AnexosFactoryInterface;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RGF\AnexoDois\AnexoDoisService;

class AnexoDoisRgfFactory extends AnexosFactory implements AnexosFactoryInterface
{
    /**
     * @param $exercicio
     * @return array
     */
    public static function getDadosView($exercicio)
    {
        $programa = self::getProgramaRelatorio($exercicio);
        $relatorio = self::getCodigoRelatorio($exercicio);
        $rota = self::getRota($exercicio);
        return ['relatorio' => $relatorio, 'programa' => $programa, 'rota' => $rota];
    }

    /**
     * C�digo do relat�rio para o exerc�cio
     * @param $exercicio
     * @return int
     */
    public static function getCodigoRelatorio($exercicio)
    {
        switch ($exercicio) {
            case 2022:
            default:
                return 265;
        }
    }

    /**
     * Retora a view para renderizar a tela
     * @param $exercicio
     * @return string
     */
    public static function getProgramaRelatorio($exercicio)
    {
        return 'pla2_anexos_rreo001.php';
    }

    /**
     * Service para processamento e impress�o do relat�rio
     * @param $exercicio
     * @param $filtros
     * @return AnexoDoisService
     */
    public static function getService($exercicio, $filtros)
    {
        switch ($exercicio) {
            case 2022:
            default:
                return new AnexoDoisService($filtros);
        }
    }

    /**
     * Rota usada para emiss�o
     * @param $exercicio
     * @return string
     */
    private static function getRota($exercicio)
    {
        return 'financeiro/contabilidade/relatorio/rgf/anexo-2';
    }
}
