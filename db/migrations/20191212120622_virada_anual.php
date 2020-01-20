<?php

use Phinx\Migration\AbstractMigration;

class ViradaAnual extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        
        /* Atualizando/inserindo dados para 2020 */

        CREATE TEMP TABLE plano_contas ON COMMIT DROP AS
        SELECT * FROM conplano
        WHERE c60_anousu = 2019;

        UPDATE conplano
        SET c60_tipolancamento = plano_contas.c60_tipolancamento,
            c60_desdobramneto = plano_contas.c60_desdobramneto,
            c60_subtipolancamento = plano_contas.c60_subtipolancamento,
            c60_cgmpessoa = plano_contas.c60_cgmpessoa,
            c60_naturezadareceita = plano_contas.c60_naturezadareceita,
            c60_infcompmsc = plano_contas.c60_infcompmsc,
            c60_nregobrig = plano_contas.c60_nregobrig
        FROM plano_contas
        JOIN conplano t1 ON (t1.c60_codcon, t1.c60_anousu) = (plano_contas.c60_codcon, 2020)
        WHERE conplano.c60_codcon = plano_contas.c60_codcon
          AND conplano.c60_anousu = 2020;


        INSERT INTO conplanocontacorrente
        SELECT nextval('conplanocontacorrente_c18_sequencial_seq') AS c18_sequencial,
               c18_codcon,
               2020 c18_anousu,
               c18_contacorrente
        FROM conplanocontacorrente
        WHERE c18_anousu = 2019
          AND c18_codcon NOT IN
          (SELECT c18_codcon FROM conplanocontacorrente WHERE c18_anousu = 2020)
          AND c18_codcon IN
            (SELECT c60_codcon FROM conplano WHERE c60_anousu = 2020);


        INSERT INTO conplanocontabancaria
        SELECT (nextval('conplanocontabancaria_c56_sequencial_seq')) AS c56_sequencial,
               c56_contabancaria,
               c56_codcon,
               2020 AS c56_anousu
        FROM conplanocontabancaria
        WHERE c56_anousu = 2019
          AND c56_codcon NOT IN
            (SELECT c56_codcon FROM conplanocontabancaria WHERE c56_anousu = 2020)
          AND c56_codcon IN
            (SELECT c60_codcon FROM conplano WHERE c60_anousu = 2020);


        INSERT INTO conplanoorcamentogrupo
        SELECT nextval('conplanoorcamentogrupo_c21_sequencial_seq') AS c21_sequencial,
               2020 AS c21_anousu,
               c21_codcon,
               c21_congrupo,
               c21_instit
        FROM conplanoorcamentogrupo
        WHERE c21_anousu = 2019
          AND c21_codcon NOT IN 
            (SELECT c21_codcon FROM conplanoorcamentogrupo WHERE c21_anousu = 2020)
          AND c21_codcon IN 
            (SELECT c60_codcon FROM conplanoorcamento WHERE c60_anousu = 2020);


        INSERT INTO orcfontesdes
        SELECT o60_codfon,
               2020 AS o60_anousu,
               o60_perc
        FROM orcfontesdes
        WHERE o60_anousu = 2019
          AND o60_codfon NOT IN
              (SELECT o60_codfon FROM orcfontesdes
               WHERE o60_anousu = 2020)
          AND o60_codfon IN
              (SELECT o57_codfon FROM orcfontes
               WHERE o57_anousu = 2020);

        ALTER TABLE taborc DISABLE TRIGGER ALL;

        INSERT INTO taborc
        SELECT k02_codigo,
               2020 k02_anousu,
               k02_codrec,
               k02_estorc
        FROM taborc
        WHERE k02_anousu = 2019
          AND k02_codrec NOT IN
            (SELECT k02_codrec FROM taborc WHERE k02_anousu = 2020)
          AND (k02_codrec, k02_estorc) IN
            (SELECT o70_codrec, o57_fonte FROM orcreceita
             JOIN orcfontes ON (o70_codfon, o70_anousu) = (o57_codfon, o57_anousu)
             WHERE o70_anousu = 2020);

        ALTER TABLE taborc ENABLE TRIGGER ALL;
        
        INSERT INTO acordogruponumeracao
        SELECT nextval('acordogruponumeracao_ac03_sequencial_seq') AS ac03_sequencial,
              ac03_acordogrupo,
              2020 AS ac03_anousu,
              0 AS ac03_numero,
              ac03_instit
        FROM acordogruponumeracao
        WHERE ac03_anousu = 2019;
        

        INSERT INTO numeracaotipoproc
        SELECT nextval('numeracaotipoproc_p200_codigo_seq') AS p200_codigo,
               2020 AS p200_ano,
               0 AS p200_numeracao,
               p200_tipoproc
        FROM numeracaotipoproc
        WHERE p200_ano = 2019;        
        
        /* Atualizando/inserindo dados para 2021*/
        
        CREATE TEMP TABLE plano_contas1 ON COMMIT DROP AS
        SELECT * FROM conplano
        WHERE c60_anousu = 2020;

        UPDATE conplano
        SET c60_tipolancamento = plano_contas1.c60_tipolancamento,
            c60_desdobramneto = plano_contas1.c60_desdobramneto,
            c60_subtipolancamento = plano_contas1.c60_subtipolancamento,
            c60_cgmpessoa = plano_contas1.c60_cgmpessoa,
            c60_naturezadareceita = plano_contas1.c60_naturezadareceita,
            c60_infcompmsc = plano_contas1.c60_infcompmsc,
            c60_nregobrig = plano_contas1.c60_nregobrig
        FROM plano_contas1
        JOIN conplano t1 ON (t1.c60_codcon, t1.c60_anousu) = (plano_contas1.c60_codcon, 2021)
        WHERE conplano.c60_codcon = plano_contas1.c60_codcon
          AND conplano.c60_anousu = 2021;


        INSERT INTO conplanocontacorrente
        SELECT nextval('conplanocontacorrente_c18_sequencial_seq') AS c18_sequencial,
               c18_codcon,
               2021 c18_anousu,
               c18_contacorrente
        FROM conplanocontacorrente
        WHERE c18_anousu = 2020
          AND c18_codcon NOT IN
          (SELECT c18_codcon FROM conplanocontacorrente WHERE c18_anousu = 2021)
          AND c18_codcon IN
            (SELECT c60_codcon FROM conplano WHERE c60_anousu = 2021);


        INSERT INTO conplanocontabancaria
        SELECT (nextval('conplanocontabancaria_c56_sequencial_seq')) AS c56_sequencial,
               c56_contabancaria,
               c56_codcon,
               2021 AS c56_anousu
        FROM conplanocontabancaria
        WHERE c56_anousu = 2020
          AND c56_codcon NOT IN
            (SELECT c56_codcon FROM conplanocontabancaria WHERE c56_anousu = 2021)
          AND c56_codcon IN
            (SELECT c60_codcon FROM conplano WHERE c60_anousu = 2021);


        INSERT INTO conplanoorcamentogrupo
        SELECT nextval('conplanoorcamentogrupo_c21_sequencial_seq') AS c21_sequencial,
               2021 AS c21_anousu,
               c21_codcon,
               c21_congrupo,
               c21_instit
        FROM conplanoorcamentogrupo
        WHERE c21_anousu = 2020
          AND c21_codcon NOT IN 
            (SELECT c21_codcon FROM conplanoorcamentogrupo WHERE c21_anousu = 2021)
          AND c21_codcon IN 
            (SELECT c60_codcon FROM conplanoorcamento WHERE c60_anousu = 2021);


        INSERT INTO orcfontesdes
        SELECT o60_codfon,
               2021 AS o60_anousu,
               o60_perc
        FROM orcfontesdes
        WHERE o60_anousu = 2020
          AND o60_codfon NOT IN
              (SELECT o60_codfon FROM orcfontesdes
               WHERE o60_anousu = 2021)
          AND o60_codfon IN
              (SELECT o57_codfon FROM orcfontes
               WHERE o57_anousu = 2021);

        ALTER TABLE taborc DISABLE TRIGGER ALL;

        INSERT INTO taborc
        SELECT k02_codigo,
               2021 k02_anousu,
               k02_codrec,
               k02_estorc
        FROM taborc
        WHERE k02_anousu = 2020
          AND k02_codrec NOT IN
            (SELECT k02_codrec FROM taborc WHERE k02_anousu = 2021)
          AND (k02_codrec, k02_estorc) IN
            (SELECT o70_codrec, o57_fonte FROM orcreceita
             JOIN orcfontes ON (o70_codfon, o70_anousu) = (o57_codfon, o57_anousu)
             WHERE o70_anousu = 2021);

        ALTER TABLE taborc ENABLE TRIGGER ALL;

        COMMIT;
SQL;

        $this->execute($sql);
    }
}
