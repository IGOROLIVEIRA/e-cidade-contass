<?php

class Siope {

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

    public function setNomeArquivo($sNomeArq) {
        $this->sNomeArquivo = $sNomeArq;
    }

    public function getNomeArquivo() {
        return $this->sNomeArquivo;
    }

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
        return substr($elemento, 0, 1).".".substr($elemento, 1, 2).".".substr($elemento, 3, 2).".".substr($elemento, 5, 2).".".substr($elemento, 7, 2).".".substr($elemento, 9, 2);
    }

}