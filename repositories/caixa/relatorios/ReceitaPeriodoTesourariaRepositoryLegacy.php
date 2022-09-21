<?php

namespace repositories\caixa\relatorios;

use repositories\caixa\relatorios\SQLBuider\ReceitaPeriodoTesourariaSQLBuider;
use interfaces\caixa\relatorios\IReceitaPeriodoTesourariaRepository;
use Exception;

require_once 'repositories/caixa/relatorios/ReceitaTipoSelecaoRepositoryLegacy.php';
require_once 'repositories/caixa/relatorios/SQLBuilder/ReceitaPeriodoTesourariaSQLBuider.php';
require_once 'interfaces/caixa/relatorios/IReceitaPeriodoTesourariaRepository.php';

class ReceitaPeriodoTesourariaRepositoryLegacy
implements IReceitaPeriodoTesourariaRepository
{
    /**
     * @var ReceitaPeriodoTesourariaSQLBuider
     */
    private $oReceitaPeriodoTesourariaSQLBuider;

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
        $this->oReceitaPeriodoTesourariaSQLBuider = new ReceitaPeriodoTesourariaSQLBuider(
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

    public function pegarDados()
    {
        $aDados = array();
        if (!$result = pg_query($this->oReceitaPeriodoTesourariaSQLBuider->pegarSQL()))
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
        return "Portrait";
    }
}
