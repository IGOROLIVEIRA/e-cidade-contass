<?php

use Phinx\Migration\AbstractMigration;

class Oc12878 extends AbstractMigration
{

    public function up()
    {
        $this->addColumn();
        $this->addDicionarioDados();
    }

    public function down()
    {
        $this->deleteDicionarioDados();
        $this->removeColumn();
    }

    private function getCodCam()
    {
        $id = $this->fetchRow("SELECT codcam FROM configuracoes.db_syscampo WHERE nomecam = 'rh05_saldofgts'");
        return current($id);
    }

    private function addColumn()
    {
        $this->execute("ALTER TABLE pessoal.rhpesrescisao ADD COLUMN rh05_saldofgts float8");
    }

    private function addDicionarioDados()
    {
        $this->execute("INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 'rh05_saldofgts', 'float8', 'Saldo FGTS', '0', 'Saldo FGTS', 11, false, false, false, 4, 'text', 'Saldo FGTS')");
        $this->execute("INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (1161, (select codcam from configuracoes.db_syscampo where nomecam = 'rh05_saldofgts'), 15, 0)");
    }

    private function deleteDicionarioDados()
    {
        $codcam = $this->getCodCam();
        $this->execute("DELETE FROM configuracoes.db_sysarqcamp WHERE codcam = {$codcam}");
        $this->execute("DELETE FROM configuracoes.db_syscampo WHERE codcam = {$codcam}");
    }

    private function removeColumn()
    {
        $this->execute("ALTER TABLE pessoal.rhpesrescisao DROP COLUMN rh05_saldofgts");
    }

}