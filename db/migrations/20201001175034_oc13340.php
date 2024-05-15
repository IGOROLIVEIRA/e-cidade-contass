<?php

use Phinx\Migration\AbstractMigration;

class Oc13340 extends AbstractMigration
{
    CONST PMPIRAPORA = '23539463000121';
    public function up()
    {
        $arrInstit = $this->getInstituicaoByCnpj(self::PMPIRAPORA);
        if(!empty($arrInstit)) {
            /**
             * 1. abatimentoutilizacaodestino (Guardar os numpres numa tabela temporaria para serem utilizados no passo 4)
             * 2. abatimentoutilizacao
             * 3. Arrepaga
             * 4. Arrecant -> Arrecad (os numpres estao na abatimentoutilizacaodestino)
             * 5. Atualiza o saldo da abatimento
             * 6. Arrehist
             *
             */
            $this->_removeCompensacao(13092);
        }
    }

    public function down()
    {

    }

    private function _removeCompensacao($iCodAbatimento)
    {
        $this->execute("select fc_putsession('db_instit','1')");
        $this->execute("begin");
        $this->execute("create temp table w_abatimentoutilizacaodestino_tmp on commit drop as select * from abatimentoutilizacaodestino where k170_utilizacao in (select k157_sequencial from abatimentoutilizacao where k157_abatimento = {$iCodAbatimento})");
        $this->execute("delete from abatimentoutilizacaodestino where k170_utilizacao in (select k157_sequencial from abatimentoutilizacao where k157_abatimento = {$iCodAbatimento})");
        $this->execute("delete from abatimentoutilizacao where k157_abatimento = {$iCodAbatimento}");
        $this->execute("delete from arrepaga where exists (select 1 from w_abatimentoutilizacaodestino_tmp where k170_numpre = k00_numpre and k170_numpar = k00_numpar)");
        $this->execute("insert into arrecad select * from arrecant where exists (select 1 from w_abatimentoutilizacaodestino_tmp where k170_numpre = k00_numpre and k170_numpar = k00_numpar)");
        $this->execute("delete from arrecant where exists (select 1 from w_abatimentoutilizacaodestino_tmp where k170_numpre = k00_numpre and k170_numpar = k00_numpar)");
        $this->execute("update abatimento set k125_valordisponivel = k125_valor where k125_sequencial = {$iCodAbatimento}");
        $this->execute("delete from arrehist where exists (select 1 from w_abatimentoutilizacaodestino_tmp where k170_numpre = k00_numpre and k170_numpar = k00_numpar)");
        $this->execute("commit");
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
