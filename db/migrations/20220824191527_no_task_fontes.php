<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class NoTaskFontes extends PostgresMigration
{
    public function up()
    {
        $jsonDados = file_get_contents('db/migrations/20220726193020_oc18021.json');
        $aDados = json_decode($jsonDados);

        foreach ($aDados->fontes as $fonte) {

            $fonte2022 = $fonte->FONTE_2022;
            $fonte2023 = $fonte->FONTE_2023;

            if (!empty($fonte2022)) {
                $this->updateFontes($fonte2022, $fonte2023);
            }
        }

        $sSqlOrcfontes = "UPDATE orcfontes
                          SET o57_descr = c60_descr, o57_finali = c60_finali
                          FROM conplanoorcamento
                          WHERE (c60_estrut, c60_anousu) = (o57_fonte, o57_anousu)
                            AND o57_anousu < 2023
                            AND o57_descr != c60_descr
                            AND o57_descr LIKE '%2023%'";

        $this->execute($sSqlOrcfontes);

    }

    public function updateFontes($fonte22, $fonte23)
    {
        $sSqlFonte = "UPDATE conplanoorcamentoanalitica
                      SET c61_codigo = {$fonte22}
                      WHERE c61_codigo = {$fonte23}
                        AND c61_anousu < 2023";

        $this->execute($sSqlFonte);
    }
}
