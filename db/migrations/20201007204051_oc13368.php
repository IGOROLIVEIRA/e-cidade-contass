<?php

use Classes\PostgresMigration;

class Oc13368 extends PostgresMigration
{

    public function up()
    {
        $table = $this->table('concur', array('schema' => 'recursoshumanos'));
        $table->addColumn('h06_fundamentacaolegal', 'string', array('limit' => 255, 'null' => true))
              ->save();

        $table = $this->table('concurcargo', array('schema' => 'recursoshumanos', 'id' => false, 'primary_key' => array('h82_sequencial')));
        $table->addColumn('h82_sequencial', 'integer')
              ->addColumn('h82_concur', 'integer')
              ->addColumn('h82_cargo', 'string', array('limit' => 255))
              ->addColumn('h82_vagas', 'integer', array('default' => 0))
              ->addColumn('h82_instit', 'integer')
              ->addForeignKey('h82_concur', 'concur', 'h06_refer', array('constraint' => 'concurcargo_concur_fk'))
              ->save();
        $this->createSequence();
        if ($this->checkDicionarioDados()) {
            $this->insertDicionarioDados();
        }
    }

    public function down() 
    {
        $table = $this->table('concur', array('schema' => 'recursoshumanos'));
        $table->removeColumn('h06_fundamentacaolegal')
              ->save();

        $this->table('concurcargo', array('schema' => 'recursoshumanos'))->drop();
        $this->dropSequence();
    }

    public function createSequence() {
        $this->execute("CREATE SEQUENCE concurcargo_h82_sequencial_seq");
    }

    private function dropSequence() 
    {
        $this->execute("DROP SEQUENCE concurcargo_h82_sequencial_seq");
    }

    private function checkDicionarioDados()
    {
        $result = $this->fetchRow("SELECT * FROM db_sysarquivo WHERE nomearq = 'concurcargo'");
        if (empty($result)) {
            return true;
        }
        return false;
    }

    private function insertDicionarioDados() 
    {
        $sql = <<<SQL
        -- INSERINDO db_sysarquivo
        INSERT INTO configuracoes.db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'concurcargo', 'Cadastro de Cargos para Concurso do Mod RH', 'h82', '2020-10-07', 'Cadastro de Cargos para Concurso', 0, false, false, false, false);
         
        -- INSERINDO db_sysarqmod
        INSERT INTO configuracoes.db_sysarqmod (codmod, codarq) VALUES (29, (select max(codarq) from db_sysarquivo));
         
        -- INSERINDO db_syscampo
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'h82_sequencial', 'int8', 'Código Sequencial', '0', 'Código Sequencial', 11, false, false, false, 1, 'text', 'Código Sequencial');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'h82_concur', 'int8', 'Código do Concurso', '0', 'Código do Concurso', 11, false, false, false, 1, 'text', 'Código do Concurso');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'h82_cargo', 'varchar(255)', 'Cargo', '', 'Cargo', 255, false, true, false, 0, 'text', 'Cargo');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'h82_vagas', 'int8', 'Vagas', '0', 'Vagas', 11, false, false, false, 1, 'text', 'Vagas');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'h82_instit', 'int8', 'Instituição', '0', 'Instituição', 11, false, false, false, 1, 'text', 'Instituição');
         
        -- INSERINDO db_syssequencia
        INSERT INTO configuracoes.db_syssequencia (codsequencia, nomesequencia, incrseq, minvalueseq, maxvalueseq, startseq, cacheseq) VALUES ((select max(codsequencia)+1 from db_syssequencia), 'concurcargo_h82_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
         
        -- INSERINDO db_sysarqcamp
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'concurcargo'), (select codcam from db_syscampo where nomecam = 'h82_sequencial'), 1, (select codsequencia from db_syssequencia where nomesequencia = 'concurcargo_h82_sequencial_seq'));
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'concurcargo'), (select codcam from db_syscampo where nomecam = 'h82_concur'), 2, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'concurcargo'), (select codcam from db_syscampo where nomecam = 'h82_cargo'), 3, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'concurcargo'), (select codcam from db_syscampo where nomecam = 'h82_vagas'), 4, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'concurcargo'), (select codcam from db_syscampo where nomecam = 'h82_instit'), 5, 0);
         
        -- INSERINDO db_sysforkey
        INSERT INTO configuracoes.db_sysforkey (codarq, codcam, sequen, referen, tipoobjrel) VALUES ((select codarq from db_sysarquivo where nomearq = 'concurcargo'), (select codcam from db_syscampo where nomecam = 'h82_concur'), 1, 539, 0);
         
        -- INSERINDO db_sysprikey
        INSERT INTO configuracoes.db_sysprikey (codarq, codcam, sequen, referen, camiden) VALUES ((select codarq from db_sysarquivo where nomearq = 'concurcargo'), (select codcam from db_syscampo where nomecam = 'h82_sequencial'), 1, (select codcam from db_syscampo where nomecam = 'h82_sequencial'), 0);


        -- INSERINDO db_syscampo
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'h06_fundamentacaolegal', 'varchar(255)', 'Fundamentação Legal', '', 'Fundamentação Legal', 255, false, true, false, 0, 'text', 'Fundamentação Legal');
        -- INSERINDO db_sysarqcamp
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'concur'), (select codcam from db_syscampo where nomecam = 'h06_fundamentacaolegal'), 11, 0);

SQL;
        $this->execute($sql);
    }
}
