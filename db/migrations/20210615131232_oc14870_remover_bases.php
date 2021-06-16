<?php

use Phinx\Migration\AbstractMigration;

class Oc14870RemoverBases extends AbstractMigration
{
    public function up()
    {
        $this->deleteBases();
    }

    public function down()
    {
        $this->execute("INSERT INTO bases (r08_anousu,r08_mesusu,r08_codigo,r08_descr,r08_calqua,r08_mesant,r08_pfixo,r08_instit) (SELECT r08_anousu,6 AS r08_mesusu,r08_codigo,r08_descr,r08_calqua,r08_mesant,r08_pfixo,r08_instit FROM bases WHERE r08_anousu = 2021 AND r08_mesusu = 5 AND r08_codigo IN ('B500','B501','B502') AND r08_instit NOT IN (SELECT r08_instit FROM bases WHERE r08_anousu = 2021 AND r08_mesusu = 6 AND r08_codigo IN ('B500','B501','B502')))");
    }

    private function deleteBases()
    {
        $aRowsInstit = $this->getInstit();
        foreach ($aRowsInstit as $aInstit) {
            if ($this->checkAnoMesFolha($aInstit['codigo'])) {
                $this->execute("DELETE FROM bases WHERE r08_anousu = 2021 AND r08_codigo IN ('B500','B501','B502') AND r08_mesusu = 6 AND r08_instit = {$aInstit['codigo']}");
            }
        }
    }

    private function getInstit()
    {
        return $this->fetchAll("SELECT codigo FROM db_config");
    }

    private function checkAnoMesFolha($iInstit)
    {
        $result = $this->fetchRow("SELECT r11_mesusu FROM cfpess WHERE r11_instit = {$iInstit} AND r11_anousu = 2021 AND r11_mesusu = 6");
        if (empty($result)) {
            return true;
        }
        return false; 
    }
}
