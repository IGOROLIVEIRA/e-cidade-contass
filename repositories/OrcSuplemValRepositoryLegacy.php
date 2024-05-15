<?php
require_once "classes/db_orcsuplemval_classe.php";
require_once "interfaces/orcamento/IOrcSuplemValRepository.php";

/**
 * @author widouglas
 */
class OrcSuplemValRepositoryLegacy implements IOrcSuplemValRepository
{
    /**
     * @var cl_orcsuplemval
     */
    private $oRepositorio;

    /**
     * @var int
     */
    private $iAnoUsu;

    /**
     * @var int
     */
    private $iInstituicao;

    /**
     * @param string $iAnoUsu
     * @param string $iInstituicao
     */
    public function __construct($iAnoUsu, $iInstituicao)
    {
        $this->oRepositorio = new cl_orcsuplemval;
        $this->iAnoUsu = $iAnoUsu;
        $this->iInstituicao = $iInstituicao;
    }

    /**
     * @param string $sFonte
     * @param array $aTipoSup
     * @return float
     */
    public function pegarValorSuplementadoPorFonteETipoSup($sFonte, $aTipoSup)
    {
        $rResult = $this->oRepositorio->sql_record(
            $this->oRepositorio->sql_query_superavit_deficit_suplementado_por_fonte_tiposup_scope(
                $this->iAnoUsu, $this->iInstituicao, implode(", ", $aTipoSup), $sFonte));
        if (pg_num_rows($rResult) === 0)
            return 0.00;
        $oSuplementado = db_utils::fieldsMemory($rResult, 0);
        return $oSuplementado->valor;
    }

    /**
     * @param array $aTipoSup
     * @return array
     */
    public function pegarArrayValorPelaFonteSuplementadoPorTipoSup($aTipoSup)
    {
        $aValorPelaFonte = array();
        $rResult = $this->oRepositorio->sql_record(
            $this->oRepositorio->sql_query_superavit_deficit_suplementado_por_tiposup_scope(
                $this->iAnoUsu, $this->iInstituicao, implode(", ", $aTipoSup)));

        for ($i = 0; $i < pg_num_rows($rResult); $i++) {
            $oSuplementado = db_utils::fieldsMemory($rResult, $i);
            $aValorPelaFonte[] = $oSuplementado;
        }

        ksort($aValorPelaFonte);
        return $aValorPelaFonte;
    }
}
