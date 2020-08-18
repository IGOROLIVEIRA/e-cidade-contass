<?php

require_once './model/configuracao/Instituicao.model.php';

use Classes\PostgresMigration;


class Oc12875 extends PostgresMigration
{
    public function up()
    {
        $arrInstits = $this->getInstituicaoByCnpj('23539463000121');

        if(!empty($arrInstits)){
            $this->_run();
        }

    }

    private function _run()
    {
        $this->execute("
        select fc_putsession('db_instit','1');
        begin;
            update arrecad set k00_tipo = 5 where k00_tipo = 95;
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

    public function down()
    {

    }
}
