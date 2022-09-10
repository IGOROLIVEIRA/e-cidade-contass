<?php
require_once("classes/db_orcsuplemval_classe.php");

class OrcSuplemValRepository
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

    public function __construct($iAnoUsu, $iInstituicao)
    {
        $this->oRepositorio = new cl_orcsuplemval;
        $this->iAnoUsu = $iAnoUsu;
        $this->iInstituicao = $iInstituicao;
    }

    public function pegarValorSuplementadoPorFonteETipoSup($sFonte, $aTipoSup)
    {
        $rResult = $this->oRepositorio->sql_record(
            $this->oRepositorio->sql_query_superavit_deficit_suplementado_scope(
                $this->iAnoUsu, $sFonte, $this->iInstituicao, implode(", ", $aTipoSup)));

        if (pg_num_rows($rResult) === 0)
            return 0;
        $oSuplementado = db_utils::fieldsMemory($rResult, 0);
        return $oSuplementado->valor;
    }
}
