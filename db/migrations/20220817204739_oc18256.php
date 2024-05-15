<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc18256 extends PostgresMigration
{
    public function up()
    {
        $sSqlFonte = "SELECT substr(o15_codigo,1,7) AS fonte,
                             o15_codigo
                      FROM orctiporec
                      WHERE length(o15_codigo::varchar) = 8
                        AND substr(reverse(o15_codigo::varchar), 1, 1) = '3'";

        $aFontes = $this->fetchAll($sSqlFonte);

        $sqlTriggerOff = "ALTER TABLE orctiporec DISABLE TRIGGER ALL";
        $this->execute($sqlTriggerOff);

        foreach ($aFontes as $fonte) {

            $newFonte = $fonte["fonte"] . 0;
            $this->updateOrctiporec($fonte["o15_codigo"], $newFonte);
        }

        $sqlTriggerOn = "ALTER TABLE orctiporec ENABLE TRIGGER ALL";
        $this->execute($sqlTriggerOn);

    }

    public function updateOrctiporec($oldFonte2023, $newFonte2023)
    {
        $aSource = array(15400003, 15420003, 25400003, 25420003);

        $sqlOrctiporec = "UPDATE orctiporec
                          SET o15_codigo = {$newFonte2023}
                          WHERE o15_codigo = {$oldFonte2023}";

        $this->execute($sqlOrctiporec);
        $this->updateFontes($oldFonte2023, $newFonte2023);

        if (in_array($oldFonte2023, $aSource)) {
            $sqlReplace = "UPDATE orctiporec
                           SET o15_descr = REPLACE(o15_descr, ' - 3', ''),
                               o15_finali = REPLACE(o15_finali, ' - 30', '')
                           WHERE o15_codigo = {$newFonte2023}";

            $this->execute($sqlReplace);
        }

    }

    public function updateFontes($oldFonte2023, $newFonte2023)
    {
        $sSqlDotacao = "UPDATE orcdotacao
                        SET o58_codigo = {$newFonte2023}
                        WHERE o58_anousu > 2022
                          AND o58_codigo = {$oldFonte2023}";

        $sSqlReceita = "UPDATE orcreceita
                        SET o70_codigo = {$newFonte2023}
                        WHERE o70_anousu > 2022
                          AND o70_codigo = {$oldFonte2023}";

        $sSqlPlanoOrc = "UPDATE conplanoorcamentoanalitica
                         SET c61_codigo = {$newFonte2023}
                         WHERE c61_anousu > 2022
                           AND c61_codigo = {$oldFonte2023}";

        $sSqlPcasp = "UPDATE conplanoreduz
                      SET c61_codigo = {$newFonte2023}
                      WHERE c61_anousu > 2022
                        AND c61_codigo = {$oldFonte2023}";

        $this->execute($sSqlDotacao);
        $this->execute($sSqlReceita);
        $this->execute($sSqlPlanoOrc);
        $this->execute($sSqlPcasp);
    }
}
