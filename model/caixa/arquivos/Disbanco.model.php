<?php

class Disbanco
{
    public $k00_numbco;
    public $k15_codbco;
    public $k15_codage;
    public $codret;
    public $dtarq;
    public $dtpago;
    public $vlrpago;
    public $vlrjuros;
    public $vlrmulta;
    public $vlracres;
    public $vlrdesco;
    public $vlrtot;
    public $cedente;
    public $vlrcalc;
    public $idret;
    public $classi;
    public $k00_numpre;
    public $k00_numpar;
    public $convenio;
    public $instit;
    public $dtcredito;
    public $Disbanco;

    public function getNumpresByCodRet($codret)
    {
        $this->Disbanco = db_utils::getDao('disbanco');
        $this->Disbanco = db_utils::getCollectionByRecord($this->Disbanco->sql_record($this->Disbanco->sql_query(null, "disbanco.*", null, "disbanco.codret = {$codret}")));

        return $this->Disbanco;
    }
}