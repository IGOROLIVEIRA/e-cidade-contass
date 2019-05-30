<?php

class Paritbi {

    private $it24_anousu;
    private $it24_grupoespbenfurbana;
    private $it24_grupotipobenfurbana;
    private $it24_grupoespbenfrural;
    private $it24_grupotipobenfrural;
    private $it24_grupoutilterrarural;
    private $it24_grupodistrterrarural;
    private $it24_diasvctoitbi;
    private $it24_alteraguialib;
    private $it24_impsituacaodeb;
    private $it24_taxabancaria;
    private $it24_grupopadraoconstrutivobenurbana;
    private $it24_cgmobrigatorio;
    private $it24_transfautomatica;

    public function __construct($it24_anousu = null){
        if(!empty($it24_anousu)){
            $oDaoParItbi = db_utils::getDao('paritbi');
            $oDaoParItbi = current(db_utils::getCollectionByRecord($oDaoParItbi->sql_record($oDaoParItbi->sql_query($it24_anousu))));
            $this->it24_anousu = $oDaoParItbi->it24_anousu;
            $this->it24_grupoespbenfurbana = $oDaoParItbi->it24_grupoespbenfurbana;
            $this->it24_grupotipobenfurbana = $oDaoParItbi->it24_grupotipobenfurbana;
            $this->it24_grupoespbenfrural = $oDaoParItbi->it24_grupoespbenfrural;
            $this->it24_grupotipobenfrural = $oDaoParItbi->it24_grupotipobenfrural;
            $this->it24_grupoutilterrarural = $oDaoParItbi->it24_grupoutilterrarural;
            $this->it24_grupodistrterrarural = $oDaoParItbi->it24_grupodistrterrarural;
            $this->it24_diasvctoitbi = $oDaoParItbi->it24_diasvctoitbi;
            $this->it24_alteraguialib = $oDaoParItbi->it24_alteraguialib;
            $this->it24_impsituacaodeb = $oDaoParItbi->it24_impsituacaodeb;
            $this->it24_taxabancaria = $oDaoParItbi->it24_taxabancaria;
            $this->it24_grupopadraoconstrutivobenurbana = $oDaoParItbi->it24_grupopadraoconstrutivobenurbana;
            $this->it24_cgmobrigatorio = $oDaoParItbi->it24_cgmobrigatorio;
            $this->it24_transfautomatica = $oDaoParItbi->it24_transfautomatica;
        }
    }

    /**
     * @return mixed
     */
    public function getAnousu()
    {
        return $this->it24_anousu;
    }

    /**
     * @param mixed $it24_anousu
     * @return Paritbi
     */
    public function setAnousu($it24_anousu)
    {
        $this->it24_anousu = $it24_anousu;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrupoespbenfurbana()
    {
        return $this->it24_grupoespbenfurbana;
    }

    /**
     * @param mixed $it24_grupoespbenfurbana
     * @return Paritbi
     */
    public function setGrupoespbenfurbana($it24_grupoespbenfurbana)
    {
        $this->it24_grupoespbenfurbana = $it24_grupoespbenfurbana;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrupotipobenfurbana()
    {
        return $this->it24_grupotipobenfurbana;
    }

    /**
     * @param mixed $it24_grupotipobenfurbana
     * @return Paritbi
     */
    public function setGrupotipobenfurbana($it24_grupotipobenfurbana)
    {
        $this->it24_grupotipobenfurbana = $it24_grupotipobenfurbana;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrupoespbenfrural()
    {
        return $this->it24_grupoespbenfrural;
    }

    /**
     * @param mixed $it24_grupoespbenfrural
     * @return Paritbi
     */
    public function setGrupoespbenfrural($it24_grupoespbenfrural)
    {
        $this->it24_grupoespbenfrural = $it24_grupoespbenfrural;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrupotipobenfrural()
    {
        return $this->it24_grupotipobenfrural;
    }

    /**
     * @param mixed $it24_grupotipobenfrural
     * @return Paritbi
     */
    public function setGrupotipobenfrural($it24_grupotipobenfrural)
    {
        $this->it24_grupotipobenfrural = $it24_grupotipobenfrural;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrupoutilterrarural()
    {
        return $this->it24_grupoutilterrarural;
    }

    /**
     * @param mixed $it24_grupoutilterrarural
     * @return Paritbi
     */
    public function setGrupoutilterrarural($it24_grupoutilterrarural)
    {
        $this->it24_grupoutilterrarural = $it24_grupoutilterrarural;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrupodistrterrarural()
    {
        return $this->it24_grupodistrterrarural;
    }

    /**
     * @param mixed $it24_grupodistrterrarural
     * @return Paritbi
     */
    public function setGrupodistrterrarural($it24_grupodistrterrarural)
    {
        $this->it24_grupodistrterrarural = $it24_grupodistrterrarural;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDiasvctoitbi()
    {
        return $this->it24_diasvctoitbi;
    }

    /**
     * @param mixed $it24_diasvctoitbi
     * @return Paritbi
     */
    public function setDiasvctoitbi($it24_diasvctoitbi)
    {
        $this->it24_diasvctoitbi = $it24_diasvctoitbi;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAlteraguialib()
    {
        return $this->it24_alteraguialib;
    }

    /**
     * @param mixed $it24_alteraguialib
     * @return Paritbi
     */
    public function setAlteraguialib($it24_alteraguialib)
    {
        $this->it24_alteraguialib = $it24_alteraguialib;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImpsituacaodeb()
    {
        return $this->it24_impsituacaodeb;
    }

    /**
     * @param mixed $it24_impsituacaodeb
     * @return Paritbi
     */
    public function setImpsituacaodeb($it24_impsituacaodeb)
    {
        $this->it24_impsituacaodeb = $it24_impsituacaodeb;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTaxabancaria()
    {
        return $this->it24_taxabancaria;
    }

    /**
     * @param mixed $it24_taxabancaria
     * @return Paritbi
     */
    public function setTaxabancaria($it24_taxabancaria)
    {
        $this->it24_taxabancaria = $it24_taxabancaria;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGrupopadraoconstrutivobenurbana()
    {
        return $this->it24_grupopadraoconstrutivobenurbana;
    }

    /**
     * @param mixed $it24_grupopadraoconstrutivobenurbana
     * @return Paritbi
     */
    public function setGrupopadraoconstrutivobenurbana($it24_grupopadraoconstrutivobenurbana)
    {
        $this->it24_grupopadraoconstrutivobenurbana = $it24_grupopadraoconstrutivobenurbana;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCgmobrigatorio()
    {
        return $this->it24_cgmobrigatorio;
    }

    /**
     * @param mixed $it24_cgmobrigatorio
     * @return Paritbi
     */
    public function setCgmobrigatorio($it24_cgmobrigatorio)
    {
        $this->it24_cgmobrigatorio = $it24_cgmobrigatorio;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getTransfautomatica()
    {
        return $this->it24_transfautomatica;
    }

    /**
     * @param mixed $it24_transfautomatica
     * @return Paritbi
     */
    public function setTransfautomatica($it24_transfautomatica)
    {
        $this->it24_transfautomatica = $it24_transfautomatica;
        return $this;
    }

}