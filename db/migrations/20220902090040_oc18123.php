<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc18123 extends PostgresMigration
{
    const TIPO_ISENCAO = 0;
    const TIPO_IMUNIDADE = 1;

    public function up()
    {
        $this->createIsstipoisenTable();
        $this->createIssisenTable();
        $this->insertMenus();
        $this->insertDicionarioDados();
        $this->updateFunctions();
        $this->insertNewErrorMessage();
    }

    public function down()
    {
        $this->dropTables();
        $this->dropMenus();
        $this->dropDicionarioDados();
        $this->rollbackFunctions();
        $this->dropNewErrorMessage();
    }

    private function createIsstipoisenTable()
    {
        $table = $this->table('isstipoisen',
            array
            (
                'id' => false,
                'primary_key' => array('q147_tipo'),
                'schema' => 'issqn'
            )
        );
        $table->addColumn('q147_tipo','integer');
        $table->addColumn('q147_descr','text');
        $table->addColumn('q147_tipoisen','integer', array('default' => self::TIPO_ISENCAO));
        $table->create();

        $sqlSequence = 'CREATE SEQUENCE isstipoisen_q147_tipo_seq
                        INCREMENT BY 1
                        MINVALUE 2
                        MAXVALUE 9223372036854775807';

        $this->execute($sqlSequence);

        $columns = array('q147_tipo', 'q147_descr', 'q147_tipoisen');
        $values = array(
            array(1, 'ISENÇÃO', self::TIPO_ISENCAO),
            array(2, 'IMUNIDADE', self::TIPO_IMUNIDADE),
        );

        $table->insert($columns, $values)->saveData();
    }

    private function createIssisenTable()
    {
        $refTableTipoIsen = $this->table('isstipoisen',
            array
            (
                'id' => false,
                'primary_key' => array('q147_tipo'),
                'schema' => 'issqn'
            )
        );

        $refTableReceita = $this->table('tabrec',
            array
            (
                'id' => false,
                'primary_key' => array('k02_codigo'),
                'schema' => 'caixa'
            )
        );

        $refTableUsers = $this->table('db_usuarios',
            array
            (
                'id' => false,
                'primary_key' => array('id_usuario'),
                'schema' => 'configuracoes'
            )
        );

        $refTableIsseBase = $this->table('issbase',
            array
            (
                'id' => false,
                'primary_key' => array('q02_inscr'),
                'schema' => 'issqn'
            )
        );

        $table = $this->table('issisen',
            array
            (
                'id' => false,
                'primary_key' => array('q148_codigo'),
                'schema' => 'issqn'
            )
        );
        $table->addColumn('q148_codigo','integer');
        $table->addColumn('q148_inscr','integer');
        $table->addColumn('q148_tipo','integer');
        $table->addColumn('q148_dtini','date');
        $table->addColumn('q148_dtfim','date');
        $table->addColumn('q148_perc','decimal', array('default' => 0));
        $table->addColumn('q148_receit','integer');
        $table->addColumn('q148_dtinc','date');
        $table->addColumn('q148_idusu','integer');
        $table->addColumn('q148_hist','text');
        $table->addForeignKey('q148_tipo', $refTableTipoIsen, 'q147_tipo');
        $table->addForeignKey('q148_receit', $refTableReceita, 'k02_codigo');
        $table->addForeignKey('q148_idusu', $refTableUsers, 'id_usuario');
        $table->addForeignKey('q148_inscr', $refTableIsseBase, 'q02_inscr');
        $table->create();

        $sqlSequence = 'CREATE SEQUENCE issisen_q148_codigo_seq
                        INCREMENT BY 1
                        MINVALUE 1
                        MAXVALUE 9223372036854775807';

        $this->execute($sqlSequence);
    }

    private function dropTables()
    {
        $this->table('issisen',
            array
            (
                'id' => false,
                'primary_key' => array('q147_tipo'),
                'schema' => 'issqn'
            )
        )->drop();

        $this->table('isstipoisen',
            array
            (
                'id' => false,
                'primary_key' => array('q147_tipo'),
                'schema' => 'issqn'
            )
        )->drop();

        $this->execute('drop sequence issisen_q148_codigo_seq');
        $this->execute('drop sequence isstipoisen_q147_tipo_seq');
    }

    private function insertMenus()
    {
        $sql = <<<SQL
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu),'Isenção', 'Isenção de Taxa de Alvará','iss4_issisen001.php',1,1,'','t');

        INSERT INTO db_menu VALUES (32,(SELECT max(id_item) FROM db_itensmenu),(SELECT max(menusequencia)+1 FROM db_menu WHERE id_item = 32 AND modulo = 40),40);

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu),'Isentos de Alvará', 'Inscrições Isentas de Taxa de Alvará','iss2_relisentos001.php',1,1,'','t');

        INSERT INTO db_menu VALUES (228029,(SELECT max(id_item) FROM db_itensmenu),(SELECT max(menusequencia)+1 FROM db_menu WHERE id_item = 228029 AND modulo = 40),40);
SQL;
        $this->execute($sql);

    }

    private function insertDicionarioDados()
    {
        $sql = <<<SQL
        INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'issisen             ', 'Isenção de Taxas de Alvará', 'q148', '2022-09-05', 'Isenção de Taxas de Alvará', 0, false, false, false, false);

        INSERT INTO db_sysarqmod (codmod, codarq) VALUES (3, (select max(codarq) from db_sysarquivo));

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'q148_codigo                              ', 'int8                                    ', 'Código Sequencial', '0', 'Código Sequencial', 11, false, false, false, 1, 'text', 'Código Sequencial');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'q148_inscr                               ', 'int4                                    ', 'Inscrição Municipal', '0', 'Inscrição Municipal', 11, false, false, false, 1, 'text', 'Inscrição Municipal');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'q148_tipo                                ', 'int4                                    ', 'Tipo da Isenção', '', 'Tipo da Isenção', 11, false, true, false, 0, 'text', 'Tipo da Isenção');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'q148_idusu                               ', 'int4                                    ', 'Código do Usuário', '', 'Código do Usuário', 11, false, true, false, 0, 'text', 'Código do Usuário');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'q148_receit                              ', 'int4                                    ', 'Código da Receita', '', 'Código da Receita', 11, false, true, false, 0, 'text', 'Código da Receita');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'q148_dtini                               ', 'date                                    ', 'Data de Início', '', 'Data de Início', 10, false, false, false, 1, 'text', 'Data de Início');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'q148_dtfim                               ', 'date                                    ', 'Data de Término', '', 'Data de Término', 10, false, false, false, 1, 'text', 'Data de Término');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'q148_dtinc                               ', 'date                                    ', 'Data de Inclusão', '', 'Data de Inclusão', 10, false, false, false, 1, 'text', 'Data de Inclusão');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'q148_hist                                ', 'varchar(200)                            ', 'Histórico', '', 'Histórico', 200, false, true, false, 0, 'text', 'Histórico');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'q148_perc                                ', 'float4                                  ', 'Percentual', '', 'Percentual', 15, false, false, false, 4, 'text', 'Percentual');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'q148_codigo'), 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'q148_inscr'), 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'q148_tipo'), 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'q148_idusu'), 4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'q148_dtini'), 5, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'q148_dtfim'), 6, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'q148_dtinc'), 7, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'q148_hist'), 8, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'q148_perc'), 9, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'q148_receit'), 10, 0);

        INSERT INTO db_sysprikey (codarq, codcam, sequen, referen, camiden) VALUES ((select codarq from db_sysarquivo where nomearq = 'issisen'), (select codcam from db_syscampo where nomecam = 'q148_inscr'), 1, 0, 0);

        INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'isstipoisen             ', 'Tipos de Isenção de Taxas de Alvará', 'q147', '2022-09-05', 'Tipos de Isenção de Taxas de Alvará', 0, false, false, false, false);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'q147_tipo                              ', 'int8                                    ', 'Código Sequencial', '0', 'Código Sequencial', 11, false, false, false, 1, 'text', 'Código Sequencial');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'q147_descr                             ', 'varchar(200)                            ', 'Descrição', '', 'Descrição', 200, false, true, false, 0, 'text', 'Descrição');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'q147_tipoisen                          ', 'int4                                    ', 'Tipo da Isenção', '1', 'Tipo da Isenção', 11, false, true, false, 0, 'text', 'Tipo da Isenção');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'q147_tipo'), 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'q147_descr'), 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'q147_tipoisen'), 3, 0);

SQL;
        $this->execute($sql);
    }

    private function dropMenus()
    {
        $this->execute("delete from db_menu where id_item_filho in (select id_item from db_itensmenu where funcao = 'iss1_issisen001.php')");
        $this->execute("delete from db_itensmenu where funcao = 'iss1_issisen001.php'");

        $this->execute("delete from db_menu where id_item_filho in (select id_item from db_itensmenu where funcao = 'iss2_relisentos001.php')");
        $this->execute("delete from db_itensmenu where funcao = 'iss2_relisentos001.php'");
    }

    private function dropDicionarioDados()
    {
        $fields = array(
            'q148_codigo',
            'q148_inscr',
            'q148_tipo',
            'q148_idusu',
            'q148_receit',
            'q148_dtini',
            'q148_dtfim',
            'q148_dtinc',
            'q148_hist',
            'q148_perc',
            'q147_tipo',
            'q147_descr',
            'q147_tipoisen');

        $this->execute("delete from db_sysarqcamp where codarq in (select codarq from db_sysarquivo where nomearq = 'issisen')");
        $this->execute("delete from db_sysarqcamp where codarq in (select codarq from db_sysarquivo where nomearq = 'isstipoisen')");

        foreach ($fields as $field) {
            $this->execute("delete from db_syscampo where nomecam = '{$field}'");
        }
        $this->execute("delete from db_sysarqmod where codmod = 3 and codarq in (select codarq from db_sysarquivo where nomearq = 'issisen')");
        $this->execute("delete from db_sysarqmod where codmod = 3 and codarq in (select codarq from db_sysarquivo where nomearq = 'isstipoisen')");
        $this->execute("delete from db_sysarquivo where nomearq = 'issisen'");
        $this->execute("delete from db_sysarquivo where nomearq = 'isstipoisen'");

    }

    public function updateFunctions()
    {
        $this->execute(
            file_get_contents(__DIR__ . '/sqls/functions/public.fc_issqn-2022-10-14.sql')
        );

        $this->execute(
            file_get_contents(__DIR__ . '/sqls/functions/public.fc_vistorias-2022-09-15.sql')
        );
    }

    public function rollbackFunctions()
    {
        $this->execute(
            file_get_contents(__DIR__ . '/sqls/functions/public.fc_issqn-2022-01-01.sql')
        );

        $this->execute(
            file_get_contents(__DIR__ . '/sqls/functions/public.fc_vistorias-2022-01-01.sql')
        );
    }

    public function insertNewErrorMessage()
    {
        $this->execute("insert into vistretornocalc values (50, '50-INSCRICAO 100% ISENTO OU IMUNE.')");
    }
    public function dropNewErrorMessage()
    {
        $this->execute("delete from vistretornocalc where y04_codmsg = 50;");
    }
}
