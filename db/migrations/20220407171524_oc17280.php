<?php

use Phinx\Migration\AbstractMigration;

class Oc17280 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
            --inserindo menu cadastro de quadro de superavit e deficit financeiro
            INSERT INTO db_itensmenu VALUES((select max(id_item) + 1 from db_itensmenu), 'Quadro do Superávit / Déficit Financeiro', 'Quadro do Superávit / Déficit Financeiro', 'con1_quadrosuperavitdeficit001.php', 1, 1, 'Quadro do Superávit / Déficit Financeiro', 't');
            INSERT INTO db_menu VALUES(29, (select max(id_item) from db_itensmenu), 266, 209);
SQL;

        $sql = <<<SQL
        --inserindo menu cadastro de quadro de superavit e deficit financeiro
        CREATE TABLE "contabilidade"."quadrosuperavitdeficit" ("c241_fonte" int8, "c241_valor" numeric,"c241_anousu" int4);

        INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'fonte', 'Fonte de Recursos', 'c241', '2022-06-04', 'fonte', 0, false, false, false, false);

        INSERT INTO db_sysarqmod (codmod, codarq) VALUES (32, (select max(codarq) from db_sysarquivo));

        INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'valor', 'Valor', 'c241', '2022-06-04', 'valor', 0, false, false, false, false);

        INSERT INTO db_sysarqmod (codmod, codarq) VALUES (32, (select max(codarq) from db_sysarquivo));

        INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'ano', 'Ano', 'c241', '2022-06-04', 'ano', 0, false, false, false, false);

        INSERT INTO db_sysarqmod (codmod, codarq) VALUES (32, (select max(codarq) from db_sysarquivo));

        CREATE UNIQUE INDEX idx_fonte_anousu ON "contabilidade"."quadrosuperavitdeficit"(c241_fonte, c241_anousu);
SQL;

        $this->execute($sql);
    }

    public function down()
    {

    }
}
