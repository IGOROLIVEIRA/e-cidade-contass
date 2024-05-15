<?php

use Phinx\Migration\AbstractMigration;

class Oc13008 extends AbstractMigration
{
    public function change()
    {
        $arrInstits = $this->getInstituicaoByCnpj('18017426000113');

        if(!empty($arrInstits)){
            $this->_run();
        }
    }

    private function _run()
    {
        $this->execute("
        begin;
            delete from iptunaogeracarnesetqua where j67_naogeracarne = 6;
        commit;
        ");
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
