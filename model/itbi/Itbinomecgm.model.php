<?php

class Itbinomecgm {

    public $it21_sequencial;
    public $it21_itbinome;
    public $it21_numcgm;

    /**
     * Retorna o objeto instanciado pelo it21_itbinome
     * @param int $it21_itbinome
     * @author Rodrigo Cabral <rodrigo.cabral@contassconsultoria.com.br>
     * @return Itbinomecgm
     */
    public function getIntanceByItbinome($it21_itbinome)
    {
        $oItbinomecgm = db_utils::getDao('itbinomecgm');
        $oItbinomecgm = current(db_utils::getCollectionByRecord($oItbinomecgm->sql_record($oItbinomecgm->sql_query(null, "*", null, "it21_itbinome = {$it21_itbinome}"))));
        $this->it21_sequencial = $oItbinomecgm->it21_sequencial;
        $this->it21_itbinome = $oItbinomecgm->it21_itbinome;
        $this->it21_numcgm = $oItbinomecgm->it21_numcgm;
        return $this;
    }
}