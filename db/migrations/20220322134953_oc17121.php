<?php

use Phinx\Migration\AbstractMigration;

class Oc17121 extends AbstractMigration
{
    public function up()
    {
        $sSql = "
        BEGIN;

        UPDATE orcelemento
        SET o56_elemento = (CASE
                                WHEN length(o56_elemento)::int4 < 13 THEN substr(o56_elemento||'0000000', 1, 13)
                                ELSE o56_elemento
                            END)
        WHERE o56_anousu >= 2022
          AND length(o56_elemento)::int4 < 13;


        INSERT INTO orcelemento
        SELECT c60_codcon,
               c60_anousu,
               substr(c60_estrut,1,13),
               c60_descr,
               c60_finali,
               't'::bool AS o56_orcado
        FROM conplanoorcamento
        WHERE c60_anousu >= 2022
          AND substr(c60_estrut,1,1) = '3'
          AND c60_codcon NOT IN
              (SELECT o56_codele FROM orcelemento
              WHERE o56_anousu = c60_anousu)
          AND substr(c60_estrut,1,13) NOT IN
              (SELECT o56_elemento FROM orcelemento
              WHERE o56_anousu = c60_anousu);
        
        COMMIT;
        ";

        $this->execute($sSql);
    }
}
