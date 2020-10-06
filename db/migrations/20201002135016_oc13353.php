<?php

use Classes\PostgresMigration;

class Oc13353 extends PostgresMigration
{

    public function up()
    {
        $this->addColumnsOid();
        if ($this->verifyDicionarioDados()) {
            $this->insertDicionarioDados();
        }
    }

    public function down()
    {
        $this->dropColumnsOid();
    }

    private function addColumnsOid() 
    {
        $sql = "
        ALTER TABLE pessoal.rhpessoalmov ADD COLUMN rh02_laudodeficiencia oid NULL;
        ALTER TABLE pessoal.rhpessoalmov ADD COLUMN rh02_laudoportadormolestia oid NULL;
        ALTER TABLE pessoal.rhdepend ADD COLUMN rh31_laudodependente oid NULL;
        ";
        $this->execute($sql);
    }

    private function insertDicionarioDados() 
    {
        $sql = "
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh02_laudodeficiencia', 'oid', 'Laudo Médico', '', 'Laudo Médico', 11, false, false, false, 1, 'text', 'Laudo Médico');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh02_laudoportadormolestia', 'oid', 'Laudo Médico', '', 'Laudo Médico', 11, false, false, false, 1, 'text', 'Laudo Médico');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh31_laudodependente', 'oid', 'Laudo Médico', '', 'Laudo Médico', 11, false, false, false, 1, 'text', 'Laudo Médico');

        
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhpessoalmov'), (select codcam from db_syscampo where nomecam = 'rh02_laudodeficiencia'), 101, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhpessoalmov'), (select codcam from db_syscampo where nomecam = 'rh02_laudoportadormolestia'), 102, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'rhdepend'), (select codcam from db_syscampo where nomecam = 'rh31_laudodependente'), 9, 0);
        ";

        $this->execute($sql);
    }

    private function verifyDicionarioDados()
    {
        $id = $this->fetchRow("SELECT codcam FROM configuracoes.db_syscampo WHERE nomecam = 'rh02_laudodeficiencia'");
        return empty($id['codcam']);
    }

    private function dropColumnsOid()
    {
        $sql = "
        ALTER TABLE pessoal.rhpessoalmov DROP COLUMN rh02_laudodeficiencia;
        ALTER TABLE pessoal.rhpessoalmov DROP COLUMN rh02_laudoportadormolestia;
        ALTER TABLE pessoal.rhdepend DROP COLUMN rh31_laudodependente;
        ";
        $this->execute($sql);
    }
}
