<?php

use Classes\PostgresMigration;

class Oc12913 extends PostgresMigration
{

    public function up()
    {
        $this->addColumns();
        $this->insertDicionarioDados();
    }

    public function down()
    {
        $this->removeColumns();
        $this->deleteDicionarioDados();
    }

    private function addColumns()
    {
        $this->table('cfpess', array('schema' => 'pessoal'))
             ->addColumn('r11_avisoprevio13', 'string', array('limit' => 4,'null' => true))
             ->addColumn('r11_avisoprevioferias', 'string', array('limit' => 4,'null' => true))
             ->addColumn('r11_avisoprevio13ferias', 'string', array('limit' => 4,'null' => true))
             ->update();
    }

    private function insertDicionarioDados()
    {
        $sql = "
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'r11_avisoprevio13', 'varchar(4)', '13º Sal s/aviso prévio', '', '13º Sal s/aviso prévio', 4, true, true, false, 0, 'text', '13º Sal s/aviso prévio');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'r11_avisoprevioferias', 'varchar(4)', 'Férias s/aviso prévio', '', 'Férias s/aviso prévio', 4, true, true, false, 0, 'text', 'Férias s/aviso prévio');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'r11_avisoprevio13ferias', 'varchar(4)', '1/3 de Férias s/aviso prévio', '', '1/3 de Férias s/aviso prévio', 4, true, true, false, 0, 'text', '1/3 de Férias s/aviso prévio');

        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from configuracoes.db_sysarquivo where nomearq = 'cfpess'), (select codcam from configuracoes.db_syscampo where nomecam = 'r11_avisoprevio13'), 90, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from configuracoes.db_sysarquivo where nomearq = 'cfpess'), (select codcam from configuracoes.db_syscampo where nomecam = 'r11_avisoprevioferias'), 91, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from configuracoes.db_sysarquivo where nomearq = 'cfpess'), (select codcam from configuracoes.db_syscampo where nomecam = 'r11_avisoprevio13ferias'), 92, 0);
        ";

        $this->execute($sql);
    }

    private function removeColumns()
    {
        $this->table('cfpess', array('schema' => 'pessoal'))
             ->removeColumn('r11_avisoprevio13')
             ->removeColumn('r11_avisoprevioferias')
             ->removeColumn('r11_avisoprevio13ferias')
             ->save();
    }

    private function getIdCampo($nomecam)
    {
        $result = $this->fetchRow("SELECT codcam FROM configuracoes.db_syscampo WHERE nomecam = '{$nomecam}'");
        return current($result);
    }

    private function deleteDicionarioDados()
    {
        $sql = "
        DELETE FROM configuracoes.db_sysarqcamp WHERE codcam = {$this->getIdCampo('r11_avisoprevio13')};
        DELETE FROM configuracoes.db_sysarqcamp WHERE codcam = {$this->getIdCampo('r11_avisoprevioferias')};
        DELETE FROM configuracoes.db_sysarqcamp WHERE codcam = {$this->getIdCampo('r11_avisoprevio13ferias')};
        
        DELETE FROM configuracoes.db_syscampo WHERE codcam = {$this->getIdCampo('r11_avisoprevio13')};
        DELETE FROM configuracoes.db_syscampo WHERE codcam = {$this->getIdCampo('r11_avisoprevioferias')};
        DELETE FROM configuracoes.db_syscampo WHERE codcam = {$this->getIdCampo('r11_avisoprevio13ferias')};
        ";

        $this->execute($sql);
    }
}
