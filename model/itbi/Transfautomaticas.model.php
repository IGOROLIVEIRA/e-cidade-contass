<?php

class Transfautomaticas {

    CONST STATUS_FAIL = 1;
    CONST STATUS_SUCCESS = 2;

    public $it35_guia;

    public $it35_transmitente;

    public $it35_comprador;

    public $it35_data;

    public $it35_usuario;

    public $it35_numpre;

    public $it35_status;

    public $it35_observacao;


    public function findAll($it35_guia)
    {
        $aRetorno = array();
        $oTransfautomaticas = db_utils::getDao('transfautomaticas');
        $aTransfautomaticas = db_utils::getCollectionByRecord($oTransfautomaticas->sql_record($oTransfautomaticas->sql_query($it35_guia)));

        foreach ($aTransfautomaticas as $obj) {
            $this->it35_guia = $obj->it35_guia;
            $this->it35_transmitente = $obj->it35_transmitente;
            $this->it35_comprador = $obj->it35_comprador;
            $this->it35_usuario = $obj->it35_usuario;
            $this->it35_numpre = $obj->it35_numpre;
            $this->it35_status = $obj->it35_status;
            $this->it35_observacao = $obj->it35_observacao;
            $this->it35_data = $obj->it35_data;
            $aRetorno[] = $this;
        }

        return $aRetorno;

    }


}