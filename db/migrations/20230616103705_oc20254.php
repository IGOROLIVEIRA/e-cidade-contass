<?php

use Phinx\Migration\AbstractMigration;

class Oc20254 extends AbstractMigration
{
    const PMPEDRAS = '25209156000108';
    const PMSAOFRANCISCO = '22679153000140';
    const PMJURAMENTO = '18017368000128';

    public function up()
    {
        $this->createColumnCodTab();
        $this->createPrevidencia();
        $this->duplicateData(self::PMSAOFRANCISCO);
        $this->duplicateData(self::PMJURAMENTO);
    }

    public function createPrevidencia()
    {
        $arrInstit = $this->getInstituicaoByCnpj(self::PMPEDRAS);
        if (!empty($arrInstit)) {
            $this->execute("UPDATE pessoal.rhvinculodotpatronais SET rh171_codtab = '2'");
        }  
    }

    public function duplicateData($cnpj)
    {
        $arrInstit = $this->getInstituicaoByCnpj($cnpj);
        if (!empty($arrInstit)) {
            $sSql = " SELECT * FROM pessoal.rhvinculodotpatronais ";
            $arrRhVinculoDotPatronais = $this->fetchAll($sSql);
            foreach ($arrRhVinculoDotPatronais as $arrRhVinculoDotPatronal) {
                $sSql = " INSERT INTO pessoal.rhvinculodotpatronais (
                    rh171_sequencial,
                    rh171_orgaoorig, 
                    rh171_orgaonov,
                    rh171_unidadeorig,
                    rh171_unidadenov,
                    rh171_projativorig,
                    rh171_projativnov,
                    rh171_recursoorig,
                    rh171_recursonov,
                    rh171_mes,
                    rh171_anousu,
                    rh171_instit,
                    rh171_programaorig,
                    rh171_programanov,
                    rh171_funcaoorig,
                    rh171_funcaonov,
                    rh171_subfuncaoorig,
                    rh171_subfuncaonov,
                    rh171_codtab
                ) VALUES ( 
                    nextval('rhvinculodotpatronais_rh171_sequencial_seq'), 
                    " . $arrRhVinculoDotPatronal['rh171_orgaoorig'] . " , 
                    " . $arrRhVinculoDotPatronal['rh171_orgaonov'] . " , 
                    " . $arrRhVinculoDotPatronal['rh171_unidadeorig'] . " , 
                    " . $arrRhVinculoDotPatronal['rh171_unidadenov'] . " , 
                    " . $arrRhVinculoDotPatronal['rh171_projativorig'] . " , 
                    " . $arrRhVinculoDotPatronal['rh171_projativnov'] . " , 
                    " . $arrRhVinculoDotPatronal['rh171_recursoorig'] . " , 
                    " . $arrRhVinculoDotPatronal['rh171_recursonov'] . " , 
                    " . $arrRhVinculoDotPatronal['rh171_mes'] . " , 
                    " . $arrRhVinculoDotPatronal['rh171_anousu'] . " , 
                    " . $arrRhVinculoDotPatronal['rh171_instit'] . " , 
                    " . $arrRhVinculoDotPatronal['rh171_programaorig'] . " , 
                    " . $arrRhVinculoDotPatronal['rh171_programanov'] . " , 
                    " . $arrRhVinculoDotPatronal['rh171_funcaoorig'] . " , 
                    " . $arrRhVinculoDotPatronal['rh171_funcaonov'] . " , 
                    " . $arrRhVinculoDotPatronal['rh171_subfuncaoorig'] . " , 
                    " . $arrRhVinculoDotPatronal['rh171_subfuncaonov'] . " , 
                    2); ";
                $this->execute($sSql);
            }
        }
    }

    public function createColumnCodTab()
    {
        $sSql = "BEGIN;
            ALTER TABLE pessoal.rhvinculodotpatronais
            ADD COLUMN rh171_codtab int4 NOT NULL DEFAULT 1;
            COMMIT;
        ";

        $this->execute($sSql);
    }

    /**
     * Verifica se existe uma instituição
     * @param string $cnpj
     * @return Array
     */
    public function getInstituicaoByCnpj($sCnpj)
    {
        $arr = array();
        if ($sCnpj) {
            $sSql = "select codigo from db_config where cgc = '{$sCnpj}'";
            $arr = $this->fetchAll($sSql);
        }
        return $arr;
    }
}
