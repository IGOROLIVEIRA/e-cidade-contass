<?php

use Phinx\Migration\AbstractMigration;

class Oc13198 extends AbstractMigration
{
    CONST PMPIRAPORA = '23539463000121';

    public function up()
    {
        $arrInstit = $this->getInstituicaoByCnpj(self::PMPIRAPORA);
        if(!empty($arrInstit)) {
            $this->execute("update discla set dtaute = dtcla where codcla in (3122) and dtaute is null");
        }
    }

    public function down()
    {
        $arrInstit = $this->getInstituicaoByCnpj(self::PMPIRAPORA);
        if(!empty($arrInstit)) {
            $this->execute("update discla set dtaute = null where codcla in (3122) and dtaute = dtcla");
        }
    }

    /**
     * Verifica se existe uma instituição para o codcli
     * @param string $cnpj
     * @return Array
     */
    public function getInstituicaoByCnpj($cnpj = NULL)
    {
        $arr = array();
        if($cnpj){
            $sSql = "select codigo from db_config where cgc = '{$cnpj}'";
            $arr = $this->fetchAll($sSql);
        }
        return $arr;
    }
}
