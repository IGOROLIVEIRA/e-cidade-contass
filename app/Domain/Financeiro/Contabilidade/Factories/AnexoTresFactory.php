<?php

namespace App\Domain\Financeiro\Contabilidade\Factories;

use App\Domain\Financeiro\Contabilidade\Contracts\AnexosFactoryInterface;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO\AnexoTres\AnexoTresInRsService;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO\AnexoTres\AnexoTresMdf2022Service;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO\AnexoTres\AnexoTresMdfService;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF\RREO\AnexoTres\AnexoTresService;
use Exception;

class AnexoTresFactory extends AnexosFactory implements AnexosFactoryInterface
{
    const OPCAO_MODELO = 'modelo_rreo_anexo3';

    /**
     * @param $exercicio
     * @return array
     * @throws Exception
     */
    public static function getDadosView($exercicio)
    {
        $programa = self::getProgramaRelatorio($exercicio);
        $relatorio = self::getCodigoRelatorio($exercicio);
        $rota = self::getRota($exercicio);
        return ['relatorio' => $relatorio, 'programa' => $programa, 'rota' => $rota];
    }

    /**
     * @param $exercicio
     * @return int
     * @throws Exception
     */
    public static function getCodigoRelatorio($exercicio)
    {
        switch (self::getModelo($exercicio)) {
            case 'in13':
                return static::getCodigoRelatorioInRS($exercicio);
            case 'mdf':
                return static::getCodigoRelatorioMDF($exercicio);
            default:
                throw new Exception("N�o foi implementado o modelo para configura��o atual.");
        }
    }

    public static function getProgramaRelatorio($exercicio)
    {
        return 'pla2_anexos_rreo_consolida001.php';
    }

    /**
     * @param $exercicio
     * @return int
     */
    private static function getCodigoRelatorioMDF($exercicio)
    {
        switch ($exercicio) {
            case 2021:
                return 259;
            case 2022:
                return 262;
            default:
                return 262;
        }
    }

    /**
     * @param $exercicio
     * @return int
     */
    private static function getCodigoRelatorioInRS($exercicio)
    {
        switch ($exercicio) {
            case 2021:
                return 258;
            default:
                return 258;
        }
    }

    private static function getRota($exercicio)
    {
        switch (self::getModelo($exercicio)) {
            case 'in13':
                return 'financeiro/contabilidade/relatorio/rreo/anexo-3-in-rs';
            case 'mdf':
                return 'financeiro/contabilidade/relatorio/rreo/anexo-3-mdf';
            default:
                throw new Exception("N�o foi implementado o modelo para configura��o atual.");
        }
    }

    /**
     * @param $exercicio
     * @param $filtros
     * @return AnexoTresMdf2022Service|AnexoTresMdfService|AnexoTresService
     * @throws Exception
     */
    public static function getService($exercicio, $filtros)
    {
        $modelo = self::getModelo($exercicio);
        switch ($modelo) {
            case 'in13':
                return self::getServiceIn($exercicio, $filtros);
            case 'mdf':
                return self::getServiceMdf($exercicio, $filtros);
        }
    }

    /**
     * Retorna o service respons�vel pelo processamento do modelo MDF
     * @throws Exception
     * @return AnexoTresService
     */
    public static function getServiceMdf($exercicio, $filtros)
    {
        switch ($exercicio) {
            case 2021:
                return new AnexoTresMdfService($filtros);
            case 2022:
            default:
                return new AnexoTresMdf2022Service($filtros);
        }
    }

    /**
     * @param $exercicio
     * @param $filtros
     * @return AnexoTresService
     * @throws Exception
     */
    public static function getServiceIn($exercicio, $filtros)
    {
        return new AnexoTresInRsService($filtros);
    }

    /**
     * O Anexo III processa apenas per�odos bimestrais e mensais
     *
     * Outros relat�rios que precisem acessar os dados da RCL, mas possuem per�odos incompat�veis, devem usar esse
     * m�todo para converter per�odos Semestral e Quadrimestral o equivalente mensal
     *
     * @param $codigo
     * @return int
     * @throws Exception
     */
    public static function transformPeriodo($codigo)
    {
        if (in_array($codigo, [6, 7, 8, 9, 10, 11, 17,  18,  19,  20,  21,  22,  23,  24,  25,  26, 27, 28])) {
            return $codigo;
        }
        switch ($codigo) {
            case 12: //1� SEMESTRE
                return 22;
            case 13: //2� SEMESTRE
            case 16: //3� QUADRIMESTRE
                return 28;
            case 14: //1� QUADRIMESTRE
                return 20;
            case 15: //2� QUADRIMESTRE
                return 24;
            default:
                throw new \Exception("Per�odo n�o mapeado");
        }
    }
}
