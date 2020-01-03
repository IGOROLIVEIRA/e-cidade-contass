<?php

use Phinx\Migration\AbstractMigration;

class Oc11416 extends AbstractMigration
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
        SELECT fc_startsession();


        INSERT INTO db_estruturavalor
        VALUES (nextval('db_estruturavalor_db121_sequencial_seq'),
                5,
                '160',
                'Transf. da Uniao Bonus de Ass. Cont. de Partilha de Producao',
                0,
                1,
                1),
                (nextval('db_estruturavalor_db121_sequencial_seq'),
                5,
                '260',
                'Transf. da Uniao Bonus de Ass. Cont. de Partilha de Producao',
                0,
                1,
                1);

        INSERT INTO orctiporec
        VALUES (160,
                'Transf. da Uniao Bonus de Ass. Cont. de Partilha de Producao',
                '160',
                'Transferencia da Uniao da parcela dos Bonus de Assinatura de Contrato de Partilha de Producao',
                2,
                '2099-12-31',
                (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '160'),
                19900000), 
                (260,
                'Transf. da Uniao Bonus de Ass. Cont. de Partilha de Producao',
                '260',
                'Transferencia da Uniao da parcela dos Bonus de Assinatura de Contrato de Partilha de Producao',
                2,
                '2099-12-31',
                (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '260'),
                29900000);



        CREATE TEMP TABLE seq_cta_orcamento ON COMMIT DROP AS
        SELECT nextval('conplanoorcamento_c60_codcon_seq') AS codconta;

        CREATE TEMP TABLE seq_cta_orc_analitica ON COMMIT DROP AS
        SELECT nextval('conplanoorcamentoanalitica_c61_reduz_seq') AS reduzido;

        INSERT INTO conplanoorcamento
        SELECT codconta AS c60_codcon,
               c60_anousu,
               '417189911020000' AS c60_estrut,
               'TRANSF. CESSAO ONEROSA DO BONUS DE ASS. DO PRE-SAL' AS c60_descr,
               'TRANSFERENCIA DA CESSAO ONEROSA DO BONUS DE ASSINATURA DO PRE-SAL' AS c60_finali,
               c60_codsis,
               c60_codcla,
               c60_consistemaconta,
               c60_identificadorfinanceiro,
               c60_naturezasaldo,
               c60_funcao
        FROM conplanoorcamento
        JOIN seq_cta_orcamento ON 1 = 1
        WHERE c60_estrut = '417189911010000'
        AND c60_anousu >= 2019
        ORDER BY 2;

        INSERT INTO conplanoorcamentogrupo
        SELECT nextval('conplanoorcamentogrupo_c21_sequencial_seq') AS c21_sequencial,
               c60_anousu AS c21_anousu,
               c60_codcon AS c21_codcon,
               16 AS c21_congrupo,
               1 AS c21_instit
        FROM conplanoorcamento
        WHERE c60_estrut = '417189911020000'
        AND c60_anousu >= 2019;


        CREATE TEMP TABLE cta_orc_analitica ON COMMIT DROP AS
        SELECT DISTINCT c60_codcon AS c61_codcon,
               2019 AS c61_anousu,
               1 AS c61_reduz,
               1 AS c61_instit,
               160 AS c61_codigo
        FROM conplanoorcamento
        WHERE c60_estrut = '417189911020000';

        INSERT INTO conplanoorcamentoanalitica
        SELECT c60_codcon AS c61_codcon,
               c60_anousu AS c61_anousu,
               reduzido AS c61_reduz,
               c61_instit,
               c61_codigo
        FROM cta_orc_analitica
        JOIN conplanoorcamento ON c60_codcon = c61_codcon
        JOIN seq_cta_orc_analitica ON 1 = 1
        WHERE c60_estrut = '417189911020000'
        AND c60_anousu >= 2019;

        INSERT INTO orcfontes
        SELECT c61_codcon AS o57_codfon,
               c60_anousu AS o57_anousu,
               c60_estrut AS o57_fonte,
               c60_descr AS o57_descr,
               c60_finali AS o57_finali
        FROM cta_orc_analitica
        JOIN conplanoorcamento ON c60_codcon = c61_codcon
        WHERE c60_estrut = '417189911020000'
          AND c60_anousu >= 2019;

        INSERT INTO conplanoconplanoorcamento
        SELECT nextval('conplanoconplanoorcamento_c72_sequencial_seq') AS c72_sequencial,
               conplano.c60_codcon AS c72_conplano,
               conplanoorcamento.c60_codcon AS c72_conplanoorcamento,
               conplanoorcamento.c60_anousu AS c72_anousu
        FROM cta_orc_analitica
        JOIN conplanoorcamento ON conplanoorcamento.c60_codcon = c61_codcon
        JOIN conplano ON (substr(conplano.c60_estrut,1,9), conplano.c60_anousu, 1) = ('452139900', conplanoorcamento.c60_anousu, c61_instit)
        WHERE conplanoorcamento.c60_estrut = '417189911020000'
          AND conplanoorcamento.c60_anousu >= 2019;


        INSERT INTO conplanoconplanoorcamento
        SELECT nextval('conplanoconplanoorcamento_c72_sequencial_seq') AS c72_sequencial,
               CASE
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1128023101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('412219900', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1128029101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('412219900', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1718055101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('452130900', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1718056101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('452130900', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1718057101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('452130900', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1718058101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('452130900', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1718131101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('452339900', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1748012101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('453110100', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1748019101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('453119900', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1768012101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('456010000', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1768019101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('456010000', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1778012101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('457210400', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1778019101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('457210400', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '2418052101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('452339900', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '2418059101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('452339900', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '2448012101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('452359900', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '2448019101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('452359900', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '2468012101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('456010000', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '2468019101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('456010000', 2020))
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '2478012101' THEN
                            (SELECT c60_codcon FROM conplano
                             WHERE (substr(c60_estrut,1,9), c60_anousu) = ('452410000', 2020))
                   ELSE NULL
               END c72_conplano,
               CASE
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1128023101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1128029101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1718055101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1718056101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1718057101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1718058101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1718131101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1748012101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1748019101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1768012101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1768019101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1778012101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '1778019101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '2418052101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '2418059101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '2448012101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '2448019101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '2468012101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '2468019101' THEN conplanoorcamento.c60_codcon
                   WHEN substr(conplanoorcamento.c60_estrut,2,10) = '2478012101' THEN conplanoorcamento.c60_codcon
                   ELSE NULL
               END c72_conplanoorcamento,
               conplanoorcamento.c60_anousu c72_anousu
        FROM conplanoorcamento
        WHERE c60_anousu = 2020
          AND substr(c60_estrut,2,10) IN ('1128023101','1128029101', '1718055101', '1718056101', '1718057101', '1718058101', '1718131101', '1748012101', '1748019101', '1768012101', '1768019101',
                                          '1778012101', '1778019101', '2418052101', '2418059101', '2448012101', '2448019101', '2468012101', '2468019101', '2478012101')
          AND c60_codcon NOT IN
            (SELECT c72_conplanoorcamento FROM conplanoconplanoorcamento
             WHERE c72_anousu = 2020)
        ORDER BY 3;

        COMMIT;
        
SQL;
    
        $this->execute($sql);

    }
}
