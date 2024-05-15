<?php

use Phinx\Migration\AbstractMigration;

class Oc13410NewRec extends AbstractMigration
{
    public function up()
    {
      $sql = "
        BEGIN;

        /*NOVAS RECEITAS PARA 2021*/
        INSERT INTO conplanoorcamento
        SELECT nextval('conplanoorcamento_c60_codcon_seq') AS c60_codcon,
               2021 AS c60_anousu,
               estrut AS c60_estrut,
               substr(descr,1,50) AS c60_descr,
               finalidade AS c60_finali,
               0 AS c60_codsis,
               2 AS c60_codcla,
               0 AS c60_consistemaconta,
               'N' AS c60_identificadorfinanceiro,
               0 AS c60_naturezasaldo
        FROM receitas2021
        WHERE tipo = 'INC'
          AND estrut NOT IN
               (SELECT c60_estrut FROM conplanoorcamento
                WHERE c60_anousu = 2021);

        INSERT INTO conplanoorcamentoanalitica
        SELECT c60_codcon AS c61_codcon,
               2021 AS c61_anousu,
               nextval('conplanoorcamentoanalitica_c61_reduz_seq') AS c61_reduz,
               codigo as c61_instit,
               fonte::int4 AS c61_codigo,
               0 AS c61_contrapartida
        FROM conplanoorcamento
        JOIN receitas2021 ON (c60_estrut, 'INC') = (estrut, tipo)
        JOIN db_config ON prefeitura = 't'
        WHERE c60_anousu = 2021
          AND (fonte IS NOT NULL AND fonte != '0');

        INSERT INTO orcfontes
        SELECT c60_codcon,
               c60_anousu,
               c60_estrut,
               c60_descr,
               c60_finali
        FROM conplanoorcamento
        JOIN receitas2021 ON (c60_estrut, 'INC') = (estrut, tipo)
        WHERE c60_anousu = 2021
          AND substr(c60_estrut,1,1) = '4'
          AND (c60_codcon, c60_estrut) NOT IN
              (SELECT o57_codfon, o57_fonte FROM orcfontes
               WHERE o57_anousu = 2021);

        /*VINCULANDO NOVAS RECEITAS 2021 COM O PCASP*/
        INSERT INTO conplanoconplanoorcamento
        SELECT nextval('conplanoconplanoorcamento_c72_sequencial_seq') AS c72_sequencial,
               conplano.c60_codcon AS c72_conplano,
               conplanoorcamento.c60_codcon AS c72_conplanoorcamento,
               conplano.c60_anousu AS c72_anousu
        FROM receitas2021
        JOIN conplano ON (substr(conplano.c60_estrut,1,9), conplano.c60_anousu) = (vinc_pcasp, 2021)
        JOIN conplanoorcamento ON (conplanoorcamento.c60_estrut, conplanoorcamento.c60_anousu) = (estrut, 2021)
        WHERE tipo = 'INC'
          AND (conplano.c60_codcon, conplanoorcamento.c60_codcon) NOT IN
              (SELECT c72_conplano, c72_conplanoorcamento FROM conplanoconplanoorcamento
               WHERE c72_anousu = 2021);


        /*RECEITAS ALTERADAS PARA 2021*/

        UPDATE conplanoorcamento t1
        SET c60_finali = t2.finalidade,
            c60_descr = substr(t2.descr,1,50)
        FROM receitas2021 t2
        INNER JOIN conplanoorcamento t3 ON t3.c60_estrut = t2.estrut
        WHERE t1.c60_estrut = t2.estrut
          AND t1.c60_anousu = 2021
          AND t2.tipo = 'ALT';

        UPDATE orcfontes t1
        SET o57_finali = t2.finalidade,
            o57_descr = substr(t2.descr,1,50)
        FROM receitas2021 t2
        INNER JOIN orcfontes t3 ON t3.o57_fonte = t2.estrut
        WHERE t1.o57_fonte = t2.estrut
          AND t1.o57_anousu = 2021
          AND t2.tipo = 'ALT';


        /*RECEITAS EXCLUIDAS PARA 2021*/

        CREATE TEMP TABLE alter_descr ON COMMIT DROP AS
        SELECT * FROM conplanoorcamento
        WHERE (substr(c60_estrut,1,9) IN ('417180460', '417180461', '424180460', '424180461')
               OR substr(c60_estrut,1,11) IN ('41718046101', '41718046102', '42418046101'))
          AND c60_anousu = 2021
        UNION ALL
        SELECT conplanoorcamento.* FROM conplanoorcamento
        JOIN conplanoorcamentoanalitica ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu)
        WHERE (substr(c60_estrut,1,9), c61_codigo) = ('417189911', 162)
          AND c60_anousu = 2021
        UNION ALL
        SELECT conplanoorcamento.* FROM conplanoorcamento
        JOIN conplanoorcamentoanalitica ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu)
        WHERE substr(c60_estrut,1,11) IN ('42468011101', '42468012101', '42478011102', '42478012101')
          AND c61_codigo = 100
          AND c60_anousu = 2021
        ORDER BY c60_estrut;

        UPDATE conplanoorcamento t1
        SET c60_finali = 'DESATIVADO 2021',
            c60_descr = 'DESATIVADO 2021'
        FROM alter_descr t2
        INNER JOIN conplanoorcamento t3 ON t3.c60_estrut = t2.c60_estrut
        WHERE t1.c60_estrut = t2.c60_estrut
          AND t1.c60_anousu = 2021;

        DELETE FROM orcfontes
        WHERE o57_fonte IN (SELECT c60_estrut FROM alter_descr)
          AND o57_anousu = 2021;

        DELETE FROM conplanoconplanoorcamento
        WHERE c72_conplanoorcamento IN (SELECT c60_codcon FROM alter_descr)
          AND c72_anousu = 2021;

        COMMIT;
      ";

      $this->execute($sql);
    }
}
