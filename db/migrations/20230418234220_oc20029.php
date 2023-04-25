<?php

use Phinx\Migration\AbstractMigration;

class Oc20029 extends AbstractMigration
{
    public function up()
    {
        $arrEmpenhos = $this->fetchAll(
            "SELECT
                e60_numemp
            FROM
                (
                    SELECT
                        e60_numemp
                    FROM
                        empenho.empempenho
                        JOIN orcamento.orcdotacao ON e60_coddot = o58_coddot
                        and e60_anousu = o58_anousu
                        JOIN orcamento.orctiporec ON o58_codigo = o15_codigo
                    WHERE
                        (
                            e60_emendaparlamentar IS NULL
                            OR e60_emendaparlamentar IN (0, 3)
                        )
                        AND e60_anousu = 2023
                        AND substring(o15_codtri, 1, 4) = '1706'
                    UNION
                    SELECT
                        e60_numemp
                    FROM
                        empenho.empempenho
                        JOIN orcamento.orcdotacao ON e60_coddot = o58_coddot
                        and e60_anousu = o58_anousu
                        JOIN orcamento.orctiporec ON o58_codigo = o15_codigo
                    WHERE
                        (
                            e60_emendaparlamentar IS NULL
                            OR e60_emendaparlamentar IN (0, 3)
                        )
                        AND e60_anousu = 2023
                        AND substring(o15_codtri, 1, 4) = '1710'
                ) as x");
                
         foreach ($arrEmpenhos as $empenho) {
            $this->execute("update empenho.empempenho set e60_emendaparlamentar = 1 where e60_numemp = " . $empenho['e60_numemp']);
        }
    }
}