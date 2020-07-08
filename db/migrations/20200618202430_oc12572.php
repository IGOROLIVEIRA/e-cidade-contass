<?php

use Classes\PostgresMigration;

class Oc12572 extends PostgresMigration
{

    public function up()
    {
        $this->createMenu();
        $this->createTables();
        $this->insertDicionarioDados();
    }

    public function down()
    {
        $this->deleteMenu();
        $this->dropTables();
    }

    public function deleteMenu()
    {
        $idMenu = $this->getIdMenu();
        $sql = "
        DELETE FROM configuracoes.db_menu WHERE id_item_filho = {$idMenu};
        DELETE FROM configuracoes.db_itensmenu WHERE id_item = {$idMenu};
        ";

        $this->execute($sql);
    }

    private function getIdMenu()
    {
        $idMenu = $this->fetchRow("SELECT id_item FROM configuracoes.db_itensmenu WHERE funcao = 'pes1_guiarecolhimentorescisoriofgts001.php'");
        return $idMenu['id_item'];
    }

    public function createMenu()
    {
        $sql = "
        INSERT INTO configuracoes.db_itensmenu
        VALUES (
        (SELECT max(id_item)+1
        FROM configuracoes.db_itensmenu),'Gerar GRRF',
        'Gerar GRRF',
        'pes1_guiarecolhimentorescisoriofgts001.php',
        1,
        1,
        'Gerar GRRF',
        't');

        INSERT INTO configuracoes.db_menu
        VALUES(5098,
        (SELECT max(id_item)
        FROM configuracoes.db_itensmenu),2,
        952);
        ";

        $this->execute($sql);
    }

    private function createTables() 
    {
        $sql = "
        CREATE SEQUENCE pessoal.rhgrrf_rh168_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;


        CREATE SEQUENCE pessoal.rhgrrfcancela_rh169_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        CREATE TABLE pessoal.rhgrrf(
        rh168_sequencial        int8 NOT NULL default 0,
        rh168_anousu        int8 NOT NULL default 0,
        rh168_mesusu        int8 NOT NULL default 0,
        rh168_arquivo       oid NOT NULL ,
        rh168_id_usuario        int8 NOT NULL default 0,
        rh168_datagera      date NOT NULL default null,
        rh168_horagera      char(5) NOT NULL ,
        rh168_ativa     bool NOT NULL default 'f',
        rh168_instit        int8 default 0,
        CONSTRAINT rhgrrf_sequ_pk PRIMARY KEY (rh168_sequencial));

        CREATE TABLE pessoal.rhgrrfcancela(
        rh169_sequencial        int8 NOT NULL default 0,
        rh169_rhgrrf        int8 NOT NULL default 0,
        rh169_id_usuario        int8 NOT NULL default 0,
        rh169_data      date NOT NULL default null,
        rh169_hora      char(5) ,
        CONSTRAINT rhgrrfcancela_sequ_pk PRIMARY KEY (rh169_sequencial));

        ALTER TABLE pessoal.rhgrrfcancela
        ADD CONSTRAINT rhgrrfcancela_rhgrrf_fk FOREIGN KEY (rh169_rhgrrf)
        REFERENCES pessoal.rhgrrf;
        ";
        $this->execute($sql);
    }

    private function dropTables() 
    {
        $sql = "
        DROP TABLE IF EXISTS pessoal.rhgrrf CASCADE;
        DROP TABLE IF EXISTS pessoal.rhgrrfcancela CASCADE;

        DROP SEQUENCE IF EXISTS pessoal.rhgrrf_rh168_sequencial_seq;
        DROP SEQUENCE IF EXISTS pessoal.rhgrrfcancela_rh169_sequencial_seq;
        ";
        $this->execute($sql);
    }

    private function verifyDicionarioDados()
    {
        $id = $this->fetchRow("SELECT codarq FROM configuracoes.db_sysarquivo WHERE nomearq = 'rhgrrf'");
        return empty($id['codarq']);
    }

    private function insertDicionarioDados()
    {
        if (!$this->verifyDicionarioDados()) {
            return;
        }

        $sql = "
        INSERT INTO configuracoes.db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from configuracoes.db_sysarquivo), 'rhgrrf', 'Geração da GRRF', 'rh168', '2020-06-19', 'Geração da GRRF', 0, false, false, false, false);
 
        INSERT INTO configuracoes.db_sysarqmod (codmod, codarq) VALUES (29, (select max(codarq) from configuracoes.db_sysarquivo));
         
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh168_sequencial', 'int8', 'Código Sequencial', '0', 'Código Sequencial', 11, false, false, false, 1, 'text', 'Código Sequencial');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh168_anousu', 'int8', 'Exercício', '0', 'Exercício', 11, false, false, false, 1, 'text', 'Exercício');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh168_arquivo', 'oid', 'Arquivo GRRF', '', 'Arquivo GRRF', 11, false, false, false, 1, 'text', 'Arquivo GRRF');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh168_mesusu', 'int8', 'Mês', '0', 'Mês', 11, false, false, false, 1, 'text', 'Mês');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh168_id_usuario', 'int8', 'Usuário', '0', 'Usuário', 11, false, false, false, 1, 'text', 'Usuário');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh168_datagera', 'date', 'Data Geração ', 'null', 'Data Geração ', 10, false, false, false, 1, 'text', 'Data Geração ');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh168_horagera', 'char(5)', 'Hora Geração', '', 'Hora Geração', 5, false, true, false, 0, 'text', 'Hora Geração');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh168_ativa', 'bool', 'Ativa', 'f', 'Ativa', 1, false, false, false, 5, 'text', 'Ativa');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh168_instit', 'int8', 'Instituição', '0', 'Instituição', 11, false, false, false, 1, 'text', 'Instituição');
         
        INSERT INTO configuracoes.db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from configuracoes.db_syssequencia), 'rhgrrf_rh168_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
         
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from configuracoes.db_sysarquivo), (select codcam from configuracoes.db_syscampo where nomecam = 'rh168_sequencial'), 1, (select max(codsequencia) from configuracoes.db_syssequencia));
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from configuracoes.db_sysarquivo), (select codcam from configuracoes.db_syscampo where nomecam = 'rh168_anousu'), 2, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from configuracoes.db_sysarquivo), (select codcam from configuracoes.db_syscampo where nomecam = 'rh168_arquivo'), 4, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from configuracoes.db_sysarquivo), (select codcam from configuracoes.db_syscampo where nomecam = 'rh168_mesusu'), 3, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from configuracoes.db_sysarquivo), (select codcam from configuracoes.db_syscampo where nomecam = 'rh168_id_usuario'), 5, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from configuracoes.db_sysarquivo), (select codcam from configuracoes.db_syscampo where nomecam = 'rh168_datagera'), 6, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from configuracoes.db_sysarquivo), (select codcam from configuracoes.db_syscampo where nomecam = 'rh168_horagera'), 7, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from configuracoes.db_sysarquivo), (select codcam from configuracoes.db_syscampo where nomecam = 'rh168_ativa'), 8, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from configuracoes.db_sysarquivo), (select codcam from configuracoes.db_syscampo where nomecam = 'rh168_instit'), 9, 0);

        INSERT INTO configuracoes.db_sysprikey (codarq, codcam, sequen, referen, camiden) VALUES ((select max(codarq) from configuracoes.db_sysarquivo), (select codcam from configuracoes.db_syscampo where nomecam = 'rh168_sequencial'), 1, (select codcam from configuracoes.db_syscampo where nomecam = 'rh168_sequencial'), 0);


        INSERT INTO configuracoes.db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from configuracoes.db_sysarquivo), 'rhgrrfcancela', 'Cancelamento GRRF', 'rh169', '2020-06-23', 'rhgrrfcancela', 0, false, false, false, false);

        INSERT INTO configuracoes.db_sysarqmod (codmod, codarq) VALUES (29, (select max(codarq) from configuracoes.db_sysarquivo));

        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh169_sequencial', 'int8', 'Código Sequencial', '0', 'Código Sequencial', 11, false, false, false, 1, 'text', 'Código Sequencial');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh169_rhgrrf', 'int8', 'Código GRRF', '0', 'Código GRRF', 11, false, false, false, 1, 'text', 'Código GRRF');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh169_id_usuario', 'int8', 'Usuário', '0', 'Usuário', 11, false, false, false, 1, 'text', 'Usuário');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh169_data', 'date', 'Data Cancelamento', 'null', 'Data Cancelamento', 10, false, false, false, 1, 'text', 'Data Cancelamento');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh169_hora', 'char(5)', 'Hora Cancelamento', '', 'Hora Cancelamento', 5, false, false, false, 0, 'text', 'Hora Cancelamento');


        INSERT INTO configuracoes.db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from configuracoes.db_syssequencia), 'rhgrrfcancela_rh169_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from configuracoes.db_sysarquivo), (select codcam from configuracoes.db_syscampo where nomecam = 'rh169_sequencial'), 1, (select codsequencia from configuracoes.db_syssequencia where nomesequencia = 'rhgrrfcancela_rh169_sequencial_seq'));
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from configuracoes.db_sysarquivo), (select codcam from configuracoes.db_syscampo where nomecam = 'rh169_rhgrrf'), 2, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from configuracoes.db_sysarquivo), (select codcam from configuracoes.db_syscampo where nomecam = 'rh169_id_usuario'), 3, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from configuracoes.db_sysarquivo), (select codcam from configuracoes.db_syscampo where nomecam = 'rh169_data'), 4, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from configuracoes.db_sysarquivo), (select codcam from configuracoes.db_syscampo where nomecam = 'rh169_hora'), 5, 0);

        INSERT INTO configuracoes.db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select max(codarq) from configuracoes.db_sysarquivo), (select codcam from configuracoes.db_syscampo where nomecam = 'rh169_rhgrrf'), 1, (select codarq from configuracoes.db_sysarquivo where nomearq='rhgrrf'), 0);

        INSERT INTO configuracoes.db_sysprikey (codarq, codcam, sequen, referen, camiden) VALUES ((select max(codarq) from configuracoes.db_sysarquivo), (select codcam from configuracoes.db_syscampo where nomecam = 'rh169_sequencial'), 1, (select codcam from configuracoes.db_syscampo where nomecam = 'rh168_sequencial'), 0);
         ";
         $this->execute($sql);
    }
}
