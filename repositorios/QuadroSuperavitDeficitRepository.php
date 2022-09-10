<?php

require_once("classes/db_quadrosuperavitdeficit_classe.php");

class QuadroSuperavitDeficitRepository
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

    public function __construct($iAnoUsu, $iInstituicao)
    {
        $this->oRepositorio = new cl_quadrosuperavitdeficit;
        $this->iAnoUsu = $iAnoUsu;
        $this->iInstituicao = $iInstituicao;
    }

    public function calcularPorFonte($sFonte)
    {
        $sWhere = " c241_fonte = {$sFonte} AND c241_ano = {$this->iAnoUsu} AND c241_instit = {$this->iInstituicao} ";
        $rResult = $this->oRepositorio->sql_record($this->oRepositorio->sql_query(null, "c241_valor as valor", null, $sWhere));
        $this->iRegistros = pg_num_rows($rResult);
        if ($this->iRegistros === 0)
            $this->nValor = 0;
        $oQuadro = db_utils::fieldsMemory($rResult, 0);
        $this->nValor = $oQuadro->valor;
    }

    public function pegarValor()
    {
        return $this->nValor;
    }

    public function pegarNumeroRegistros()
    {
        return $this->iRegistros;
    }
}
