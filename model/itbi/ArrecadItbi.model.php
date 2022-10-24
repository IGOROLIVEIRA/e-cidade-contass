<?php

class ArrecadItbi
{
    public $k00_numpre;
    public $it01_guia;

    /**
     * @param $numpre
     * @return ArrecadItbi | null
     */
    public function getInstanceByNumpre($numpre)
    {
        if(empty($numpre) === true) {
            throw new LogicException('Numpre não informado ao obter ArrecadItbi.');
        }

        $arrecadItbi = db_utils::getDao('arrecad_itbi');
        $arrecadItbi = current(db_utils::getCollectionByRecord($arrecadItbi->sql_record($arrecadItbi->sql_query_file(null, "*", null, "k00_numpre = {$numpre}"))));

        if(empty($arrecadItbi) === true) {
            return null;
        }

        $this->k00_numpre = $arrecadItbi->k00_numpre;
        $this->it01_guia = $arrecadItbi->it01_guia;

        return $this;
    }

    public function getInstanceByGuia($guiaIbti)
    {
        if(empty($guiaIbti) === true) {
            throw new LogicException('Guia de ITBI não informado ao obter ArrecadItbi.');
        }
        $arrecadItbi = db_utils::getDao('arrecad_itbi');
        $arrecadItbi = current(db_utils::getCollectionByRecord($arrecadItbi->sql_record($arrecadItbi->sql_query(null, "*", null, "it01_guia = {$guiaIbti}"))));

        $this->k00_numpre = $arrecadItbi->k00_numpre;
        $this->it01_guia = $arrecadItbi->it01_guia;

        return $this;
    }
}
