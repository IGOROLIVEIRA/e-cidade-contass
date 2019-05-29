<?php

class Itbinumpre {

    public $it15_guia;
    public $it15_numpre;
    public $it15_sequencial;
    public $it15_ultimaguia;
    public $aItbinumpre;

    public function __construct($it15_sequencial = null)
    {
        if(!empty($it15_sequencial)) {
            $oItbinumpre = db_utils::getDao('itbinumpre');
            $oItbinumpre = current(db_utils::getCollectionByRecord($oItbinumpre->sql_record($oItbinumpre->sql_query(null, "*", null, "it15_sequencial = {$it15_sequencial}"))));
            $this->it15_guia = $oItbinumpre->it15_guia;
            $this->it15_numpre = $oItbinumpre->it15_numpre;
            $this->it15_sequencial = $oItbinumpre->it15_sequencial;
            $this->it15_ultimaguia = $oItbinumpre->it15_ultimaguia;
        }
        return $this;
    }

    public function getInstanceByNumpre($iNumpre)
    {
        if(empty($iNumpre)){
            throw new Exception('Numpre não informado!');
        }

        $oItbinumpre = db_utils::getDao('itbinumpre');
        $oItbinumpre = current(db_utils::getCollectionByRecord($oItbinumpre->sql_record($oItbinumpre->sql_query(null, "*", null, "it15_numpre = {$iNumpre}"))));

        return new Itbinumpre($oItbinumpre->it15_sequencial);
    }

    /**
     * Busca todos os numpre de uma guia de ITBI
     * @param int $it15_guia
     * @return Array
     */
    public function findAllByItbi($it15_guia)
    {
        $oItbinumpre = db_utils::getDao('itbinumpre');
        $oItbinumpre = db_utils::getCollectionByRecord($oItbinumpre->sql_record($oItbinumpre->sql_query(null, "*", null, "it15_guia = {$it15_guia}")));
        
        foreach ($oItbinumpre as $obj) {
            $this->aItbinumpre[] = new Itbinumpre($obj->it15_sequencial);
        }

        return $this->aItbinumpre;

    }

}