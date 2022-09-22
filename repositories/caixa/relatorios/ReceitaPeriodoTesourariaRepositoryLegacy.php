<?php

namespace repositories\caixa\relatorios;

use repositories\caixa\relatorios\SQLBuilder\ReceitaPeriodoTesourariaSQLBuilder;
use interfaces\caixa\relatorios\IReceitaPeriodoTesourariaRepository;
use Exception;

require_once 'repositories/caixa/relatorios/SQLBuilder/ReceitaPeriodoTesourariaSQLBuilder.php';
require_once 'interfaces/caixa/relatorios/IReceitaPeriodoTesourariaRepository.php';

class ReceitaPeriodoTesourariaRepositoryLegacy
implements IReceitaPeriodoTesourariaRepository
{
    /**
     * @var ReceitaPeriodoTesourariaSQLBuilder
     */
    private $oReceitaPeriodoTesourariaSQLBuilder;

    public function __construct(
        $sTipo,
        $sTipoReceita,
        $iFormaArrecadacao,
        $sOrdem,
        $dDataInicial,
        $dDataFinal,
        $sDesdobramento,
        $iEmendaParlamentar,
        $iRegularizacaoRepasse,
        $iInstituicao,
        $sReceitas = NULL,
        $sEstrutura = NULL,
        $sContas = NULL,
        $sContribuintes = NULL) 
    {
        $this->sTipo = $sTipo;
        $this->oReceitaPeriodoTesourariaSQLBuilder = new ReceitaPeriodoTesourariaSQLBuilder(
            $sTipo,
            $sTipoReceita,
            $iFormaArrecadacao,
            $sOrdem,
            $dDataInicial,
            $dDataFinal,
            $sDesdobramento,
            $iEmendaParlamentar,
            $iRegularizacaoRepasse,
            $iInstituicao,
            $sReceitas,
            $sEstrutura,
            $sContas,
            $sContribuintes);
    }

    /**
     * @return array
     */
    public function pegarDados()
    {
        $aDados = array();
        if (!$result = pg_query($this->oReceitaPeriodoTesourariaSQLBuilder->pegarSQL()))
            throw new Exception("Erro realizando consulta");
        while ($data = pg_fetch_object($result)) {
            $aDados[$data->tipo][] = $data;
        }
        return $aDados;
    }

    /**
     * @return string
     */
    public function pegarFormatoPagina()
    {
        if (in_array($this->sTipo, array(ReceitaTipoRepositoryLegacy::RECEITA, ReceitaTipoRepositoryLegacy::ESTRUTURAL)))
            return "Portrait";
        return "Landscape";
    }
}
