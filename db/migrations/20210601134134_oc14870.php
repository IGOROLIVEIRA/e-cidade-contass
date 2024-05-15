<?php

use Phinx\Migration\AbstractMigration;

class Oc14870 extends AbstractMigration
{

    public function up()
    {
        if ($this->checkBases()) {
            $this->insertBases();
        }
    }

    public function down()
    {
        $this->execute("DELETE FROM bases WHERE r08_anousu = 2021 AND r08_codigo IN ('B500','B501','B502')");
    }

    private function insertBases()
    {
        $sSql = "";
        $aRowsInstit = $this->getInstit();
        for ($iMes=1; $iMes <= 6; $iMes++) { 
            foreach ($aRowsInstit as $aInstit) {
                $sSql .= "INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2021,{$iMes},'B500','Dedução Salário família INSS','f','f','f',{$aInstit['codigo']});";
                $sSql .= "INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2021,{$iMes},'B501','Dedução Salário Mat. INSS','f','f','f',{$aInstit['codigo']});";
                $sSql .= "INSERT INTO bases (r08_anousu, r08_mesusu, r08_codigo, r08_descr, r08_calqua, r08_mesant, r08_pfixo, r08_instit) VALUES (2021,{$iMes},'B502','Dedução 13º Salário Mat. INSS','f','f','f',{$aInstit['codigo']});";
            }
        }
        $this->execute($sSql);
    }

    private function getInstit()
    {
        return $this->fetchAll("SELECT codigo FROM db_config");
    }

    private function checkBases()
    {
        $result = $this->execute("SELECT * FROM bases WHERE r08_anousu = 2021 AND r08_codigo IN ('B500','B501','B502')");
        if (empty($result)) {
            return true;
        }
        return false; 
    }
}
