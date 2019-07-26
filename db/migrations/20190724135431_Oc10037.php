<?php

use Phinx\Migration\AbstractMigration;

class Oc10037 extends AbstractMigration
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

        CREATE TEMP TABLE fonte_rec_temp ON COMMIT DROP AS
        SELECT 159 AS fonte,
               'Transf.Rec.SUS - Bl.Cust. Acoes Serv. Publicos Saude' AS descr,
               '159' codtri,
               'Transferência de Recursos do Sistema Único de Saúde-SUS- Bloco Custeio das Ações e Serviços Públicos de Saúde' AS finali,
               2 tipo,
               '2099-12-31'::date datalimit,
               1::int4 estrut,
               12140000 codstn
        UNION ALL
        SELECT 105 fonte,
               'Taxa de Administração do RPPS' descr,
               '105' codtri,
               'Taxa de Administração do RPPS' finali,
               2 tipo,
               '2099-12-31'::date datalimit,
               1::int4 estrut,
               14300000 codstn
        UNION ALL
        SELECT 106 fonte,
               'Transf. Rec Programa Estadual de Transporte Escolar (PTE)' descr,
               '106' codtri,
               'Transferências de Recursos para o Programa Estadual de Transporte Escolar (PTE)' finali,
               2 tipo,
               '2099-12-31'::date datalimit,
               1::int4 estrut,
               11250000 codstn
        UNION ALL
        SELECT 107 fonte,
               'Precatórios do Fundef' descr,
               '107' codtri,
               'Precatórios do Fundef' finali,
               2 tipo,
               '2099-12-31'::date datalimit,
               1::int4 estrut,
               19800000 codstn
        UNION ALL
        SELECT 108 fonte,
               'Precatórios do Fundef' descr,
               '108' codtri,
               'Precatórios do Fundef' finali,
               2 tipo,
               '2099-12-31'::date datalimit,
               1::int4 estrut,
               19400000 codstn;

        UPDATE orctiporec
        SET o15_descr = (CASE
                             WHEN orctiporec.o15_codigo = t2.o15_codigo THEN t1.descr
                         END),
            o15_codtri = (CASE
                              WHEN orctiporec.o15_codigo = t2.o15_codigo THEN t1.codtri
                          END),
            o15_finali = (CASE
                              WHEN orctiporec.o15_codigo = t2.o15_codigo THEN t1.finali
                          END),
            o15_tipo = (CASE
                            WHEN orctiporec.o15_codigo = t2.o15_codigo THEN t1.tipo
                        END),
            o15_datalimite = (CASE
                                  WHEN orctiporec.o15_codigo = t2.o15_codigo THEN t1.datalimit
                              END),
            o15_codstn = (CASE
                              WHEN orctiporec.o15_codigo = t2.o15_codigo THEN t1.codstn
                          END)
        FROM orctiporec t2
        JOIN fonte_rec_temp t1 ON t1.fonte = t2.o15_codigo
        WHERE orctiporec.o15_codigo = t1.fonte;

        INSERT INTO orctiporec
        SELECT * FROM fonte_rec_temp
        WHERE fonte NOT IN
                (SELECT o15_codigo
                 FROM orctiporec);

        CREATE TEMP TABLE dotacoes ON COMMIT DROP AS
        SELECT o58_anousu,
               o58_coddot,
               o58_orgao,
               o58_unidade,
               o58_subfuncao,
               o58_projativ,
               o58_codigo,
               o58_funcao,
               o58_programa,
               o58_codele,
               o58_valor,
               o58_instit,
               o58_localizadorgastos,
               o58_datacriacao,
               o58_concarpeculiar
        FROM orcdotacao
        WHERE o58_anousu >= 2020
          AND o58_codigo IN (148, 149, 150, 151, 152)
        GROUP BY o58_anousu, o58_coddot, o58_orgao, o58_unidade, o58_funcao, o58_subfuncao, o58_programa, o58_codele, o58_valor, o58_projativ, o58_codigo, o58_instit, o58_localizadorgastos, o58_datacriacao, o58_concarpeculiar;

        UPDATE dotacoes
        SET o58_codigo = 159;

        CREATE TEMP TABLE dot_duplicada ON COMMIT DROP AS
        SELECT t1.o58_anousu,
               t1.o58_orgao,
               t1.o58_unidade,
               t1.o58_funcao,
               t1.o58_subfuncao,
               t1.o58_programa,
               t1.o58_codele,
               t1.o58_projativ,
               t1.o58_codigo,
               t1.o58_instit
        FROM dotacoes t1
        JOIN dotacoes t2 ON 
        (t1.o58_anousu, t1.o58_orgao, t1.o58_unidade, t1.o58_funcao, t1.o58_subfuncao, t1.o58_programa, t1.o58_codele, t1.o58_projativ, t1.o58_codigo, t1.o58_instit) = 
        (t2.o58_anousu, t2.o58_orgao, t2.o58_unidade, t2.o58_funcao, t2.o58_subfuncao, t2.o58_programa, t2.o58_codele, t2.o58_projativ, t2.o58_codigo, t2.o58_instit)
        WHERE 
        (t1.o58_anousu, t1.o58_orgao, t1.o58_unidade, t1.o58_funcao, t1.o58_subfuncao, t1.o58_programa, t1.o58_codele, t1.o58_projativ, t1.o58_codigo, t1.o58_instit) = 
        (t2.o58_anousu, t2.o58_orgao, t2.o58_unidade, t2.o58_funcao, t2.o58_subfuncao, t2.o58_programa, t2.o58_codele, t2.o58_projativ, t2.o58_codigo, t2.o58_instit)
        GROUP BY 
        t1.o58_anousu, t1.o58_orgao, t1.o58_unidade, t1.o58_funcao, t1.o58_subfuncao, t1.o58_programa, t1.o58_codele, t1.o58_projativ, t1.o58_codigo, t1.o58_instit
        HAVING count(*) > 1;

        CREATE TEMP TABLE dot_reagrupadas ON COMMIT DROP AS
        SELECT o58_anousu,
               o58_orgao,
               o58_unidade,
               o58_subfuncao,
               o58_projativ,
               o58_codigo,
               o58_funcao,
               o58_programa,
               o58_codele,
               sum(o58_valor) o58_valor,
               o58_instit,
               o58_localizadorgastos,
               o58_datacriacao,
               o58_concarpeculiar
        FROM
        (SELECT o58_anousu,
               o58_coddot,
               o58_orgao,
               o58_unidade,
               o58_subfuncao,
               o58_projativ,
               159 o58_codigo,
               o58_funcao,
               o58_programa,
               o58_codele,
               o58_valor,
               o58_instit,
               o58_localizadorgastos,
               o58_datacriacao,
               o58_concarpeculiar
        FROM orcdotacao
        WHERE (o58_anousu,o58_orgao,o58_unidade,o58_funcao,o58_subfuncao,o58_programa,o58_codele,o58_projativ,o58_instit) IN 
        (SELECT o58_anousu,o58_orgao,o58_unidade,o58_funcao,o58_subfuncao,o58_programa,o58_codele,o58_projativ,o58_instit FROM dot_duplicada)
        AND orcdotacao.o58_codigo IN (148, 149, 150, 151, 152)) a
        GROUP BY o58_anousu, o58_orgao, o58_unidade, o58_subfuncao, o58_projativ, o58_codigo, o58_funcao, o58_programa, o58_codele, o58_instit, o58_localizadorgastos, o58_datacriacao, o58_concarpeculiar;

        DELETE FROM dotacoes
        WHERE (o58_anousu,o58_orgao,o58_unidade,o58_funcao,o58_subfuncao,o58_programa,o58_codele,o58_projativ,o58_instit) IN 
        (SELECT o58_anousu,o58_orgao,o58_unidade,o58_funcao,o58_subfuncao,o58_programa,o58_codele,o58_projativ,o58_instit FROM dot_reagrupadas);

        INSERT INTO dotacoes
        SELECT DISTINCT ON (dot_reagrupadas.o58_valor)
               dot_reagrupadas.o58_anousu,
               orcdotacao.o58_coddot,
               dot_reagrupadas.o58_orgao,
               dot_reagrupadas.o58_unidade,
               dot_reagrupadas.o58_subfuncao,
               dot_reagrupadas.o58_projativ,
               dot_reagrupadas.o58_codigo,
               dot_reagrupadas.o58_funcao,
               dot_reagrupadas.o58_programa,
               dot_reagrupadas.o58_codele,
               dot_reagrupadas.o58_valor,
               dot_reagrupadas.o58_instit,
               dot_reagrupadas.o58_localizadorgastos,
               dot_reagrupadas.o58_datacriacao,
               dot_reagrupadas.o58_concarpeculiar
        FROM dot_reagrupadas
        JOIN orcdotacao ON 
        (orcdotacao.o58_anousu, orcdotacao.o58_orgao, orcdotacao.o58_unidade, orcdotacao.o58_funcao, orcdotacao.o58_subfuncao, orcdotacao.o58_programa, orcdotacao.o58_codele, orcdotacao.o58_projativ, orcdotacao.o58_instit) = 
        (dot_reagrupadas.o58_anousu, dot_reagrupadas.o58_orgao, dot_reagrupadas.o58_unidade, dot_reagrupadas.o58_funcao, dot_reagrupadas.o58_subfuncao, dot_reagrupadas.o58_programa, dot_reagrupadas.o58_codele, dot_reagrupadas.o58_projativ, dot_reagrupadas.o58_instit) 
        WHERE
        (orcdotacao.o58_anousu, orcdotacao.o58_orgao, orcdotacao.o58_unidade, orcdotacao.o58_funcao, orcdotacao.o58_subfuncao, orcdotacao.o58_programa, orcdotacao.o58_codele, orcdotacao.o58_projativ, orcdotacao.o58_instit) = 
        (dot_reagrupadas.o58_anousu, dot_reagrupadas.o58_orgao, dot_reagrupadas.o58_unidade, dot_reagrupadas.o58_funcao, dot_reagrupadas.o58_subfuncao, dot_reagrupadas.o58_programa, dot_reagrupadas.o58_codele, dot_reagrupadas.o58_projativ, dot_reagrupadas.o58_instit)
        AND orcdotacao.o58_codigo IN (148, 149, 150, 151, 152);

        DELETE FROM orcdotacao
        WHERE o58_anousu >= 2020
        AND (o58_orgao, o58_unidade, o58_subfuncao, o58_projativ, o58_funcao, o58_programa, o58_codele) IN 
        (SELECT o58_orgao, o58_unidade, o58_subfuncao, o58_projativ, o58_funcao, o58_programa, o58_codele FROM dotacoes)
        AND orcdotacao.o58_codigo IN (148, 149, 150, 151, 152);

        INSERT INTO orcdotacao
        SELECT o58_anousu,
               o58_coddot,
               o58_orgao,
               o58_unidade,
               o58_subfuncao,
               o58_projativ,
               o58_codigo,
               o58_funcao,
               o58_programa,
               o58_codele,
               o58_valor,
               o58_instit,
               o58_localizadorgastos,
               o58_datacriacao,
               o58_concarpeculiar
        FROM dotacoes;

        COMMIT;
SQL;
    
        $this->execute($sql);
    }
}
