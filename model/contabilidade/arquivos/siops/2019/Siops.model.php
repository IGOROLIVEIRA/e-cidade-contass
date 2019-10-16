<?php

require_once("classes/db_orcorgao_classe.php");
require_once("classes/db_orcdotacao_classe.php");
require_once("classes/db_orcreceita_classe.php");
require_once("classes/db_naturdessiops_classe.php");
//require_once("classes/db_naturrecsiope_classe.php");
require_once("libs/db_liborcamento.php");
require_once("libs/db_libcontabilidade.php");


class Siops {

    //@var integer
    public $iInstit;
    //@var integer
    public $iAnoUsu;
    //@var integer
    public $iBimestre;
    //@var string
    public $sFiltros;
    //@var string
    public $dtIni;
    //@var string
    public $dtFim;
    //@var array
    public $aDespesas = array();
    //@var array
    public $aReceitas = array();
    //@var array
    public $aReceitasAnoSeg = array();
    //@var array
    public $aDespesasAnoSeg = array();
    //@var array
    public $aDespesasAgrupadas = array();
    //@var array
    public $aReceitasAgrupadas = array();
    //@var array
    public $aReceitasAnoSegAgrupadas = array();
    //@var array
    public $aDespesasAnoSegAgrupadas = array();
    //@var array
    public $aDespesasAgrupadasFinal = array();
    //@var boolean
    public $aReceitasAgrupadasFinal = array();
    //@var boolean
    public $lOrcada;
    //@var string
    public $sNomeArquivo;
    //@var integer
    public $iErroSQL;
    //@var integer
    public $status;
    //@var string
    public $sMensagem;


    public function setAno($iAnoUsu) {
        $this->iAnoUsu = $iAnoUsu;
    }

    public function setInstit($iInstit) {
        $this->iInstit = $iInstit;
    }

    public function setBimestre($iBimestre) {
        $this->iBimestre = $iBimestre;
    }

    public function getErroSQL() {
        return $this->iErroSQL;
    }

    public function setErroSQL($iErroSQL) {
        $this->iErroSQL = $iErroSQL;
    }

    /**
     * Adiciona filtros da instituição, função 12 (Educação) e todos os orgãos
     */
    public function setFiltrosDespesa() {


    }

    /**
     * Adiciona filtros de todas as instituições
     */
    public function setFiltrosReceita() {


    }

    /**
     * Retorna datas correspondente ao período do bimestre, sempre cumulativo.
     */
    public function setPeriodo() {

        $iBimestre  = $this->iBimestre;
        $dtData     = new \DateTime("{$this->iAnoUsu}-01-01");
        $dtIni      = new \DateTime("{$this->iAnoUsu}-01-01");


        if($iBimestre == 1) {
            $dtData->modify('last day of next month');
        } elseif($iBimestre == 2) {
            $dtData->modify('last day of April');
        } elseif($iBimestre == 3) {
            $dtData->modify('last day of June');
        } elseif($iBimestre == 4) {
            $dtData->modify('last day of August');
        } elseif($iBimestre == 5) {
            $dtData->modify('last day of October');
        } elseif($iBimestre == 6) {
            $dtData->modify('last day of December');
        }

        $this->dtIni = $dtIni->format('Y-m-d');
        $this->dtFim = $dtData->format('Y-m-d');

    }

    /**
     * Busca as despesas conforme
     */
    public function setDespesas() {



    }

    public function getDespesas() {
        return $this->aDespesas;
    }



    /**
     * Busca as receitas conforme
     */
    public function setReceitas() {


    }

    /**
     * Realiza De/Para da Natureza da despesa com tabela eledessiope composta pelo Cód Elemento e Descrição
     */
    public function getNaturDesSiope($elemento) {

//        $clnaturdessiope    = new cl_naturdessiope();
//        $rsNaturdessiope    = db_query($clnaturdessiope->sql_query_siope(substr($elemento, 0, 11),"", $this->iAnoUsu));
//
//        if (pg_num_rows($rsNaturdessiope) > 0) {
//            $oNaturdessiope = db_utils::fieldsMemory($rsNaturdessiope, 0);
//            return $oNaturdessiope;
//        } else {
//            $this->status = 2;
//            if (strpos($this->sMensagem, $elemento) === false){
//                $this->sMensagem .= "{$elemento} ";
//            }
//        }

    }

    /**
     * Realiza De/Para da Natureza da despesa com tabela elerecsiope composta pela Natureza Receita e Descrição
     */
    public function getNaturRecSiope($natureza) {


//        $clnaturrecsiope    = new cl_naturrecsiope();
//        $rsNaturrecsiope    = db_query($clnaturrecsiope->sql_query_siope(substr($natureza, 0, 15),"", $this->iAnoUsu));
//
//        if (pg_num_rows($rsNaturrecsiope) > 0) {
//            $oNaturrecsiope = db_utils::fieldsMemory($rsNaturrecsiope, 0);
//            return $oNaturrecsiope;
//        } else {
//            $this->status = 2;
//            if (strpos($this->sMensagem, $natureza) === false){
//                $this->sMensagem .= "{$natureza} ";
//            }
//        }

    }

    /**
     * Se 6º bimestre, set true para buscar os valores dos anos seguintes.
     */
    public function setOrcado() {

        if($this->iBimestre == 6) {
            $this->lOrcada = true;
        } else {
            $this->lOrcada = false;
        }

    }

    public function getElementoFormat($elemento) {
//        return substr($elemento, 0, 1).".".substr($elemento, 1, 2).".".substr($elemento, 3, 2).".".substr($elemento, 5, 2).".".substr($elemento, 7, 2).".".substr($elemento, 9, 2);
    }

    public function getNaturezaFormat($natureza) {
//        return substr($natureza, 0, 1).".".substr($natureza, 1, 2).".".substr($natureza, 3, 2).".".substr($natureza, 5, 2).".".substr($natureza, 7, 2).".".substr($natureza, 9, 2);
    }


}