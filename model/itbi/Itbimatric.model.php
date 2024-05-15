<?php

class Itbimatric {

    public $it06_guia;
    public $it06_matric;

    public function __construct($it06_guia)
    {
        if(!empty($it06_guia)) {
            $oItbimatric = db_utils::getDao('itbimatric');
            $oItbimatric = current(db_utils::getCollectionByRecord($oItbimatric->sql_record($oItbimatric->sql_query($it06_guia))));
            $this->it06_guia = $oItbimatric->it06_guia;
            $this->it06_matric = $oItbimatric->it06_matric;
        }
        return $this;
    }

}