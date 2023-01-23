<?php

require_once("classes/db_quadrosuperavitdeficit_classe.php");
require_once('interfaces/contabilidade/IQuadroSuperavitDeficitRepository.php');

/**
 * @author widouglas
 */
class QuadroSuperavitDeficitRepositoryLegacy implements IQuadroSuperavitDeficitRepository
{
    /**
     * @var cl_quadrosuperavitdeficit
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
     * @var int
     */
    private $iRegistros;

    /**
     * @param string $iAnoUsu
     * @param string $iInstituicao
     * @return void
     */
    public function __construct($iAnoUsu, $iInstituicao)
    {
        $this->oRepositorio = new cl_quadrosuperavitdeficit;
        $this->iAnoUsu = $iAnoUsu;
        $this->iInstituicao = $iInstituicao;
    }

    /**
     * @param string $sFonte
     * @return float
     */
    public function pegarValorPorFonte($sFonte)
    {
        $sWhere = " c241_fonte = {$sFonte} AND c241_ano = {$this->iAnoUsu} AND c241_instit = {$this->iInstituicao} ";
        $rResult = $this->oRepositorio->sql_record($this->oRepositorio->sql_query(null, "c241_valor as valor", null, $sWhere));

        $this->iRegistros = pg_num_rows($rResult);
        
        if ($this->iRegistros === 0)
            return 0.00;

        $oQuadro = db_utils::fieldsMemory($rResult, 0);
        return $oQuadro->valor;
    }

    /**
     * Devolve array de valores por fonte
     *
     * @return array
     */
    public function pegarArrayValoresPelaFonte()
    {
        $aValorPelaFonte = array();
        $sWhere = " c241_ano = {$this->iAnoUsu} AND c241_instit = {$this->iInstituicao} ";
        $rResult = $this->oRepositorio->sql_record($this->oRepositorio->sql_query(null, " c241_fonte as fonte, c241_valor as valor ", null, $sWhere));
        $this->iRegistros = pg_num_rows($rResult);
        if ($this->iRegistros === 0)
            return $aValorPelaFonte;
        for ($i = 0; $i < $this->iRegistros; $i++) {
            $oQuadro = db_utils::fieldsMemory($rResult, $i);
            $aValorPelaFonte[$oQuadro->fonte] = $oQuadro->valor;
        }
        return $aValorPelaFonte;
    }

    /**
     * @return int
     */
    public function pegarNumeroRegistros()
    {
        return $this->iRegistros;
    }
}
