<?php

use Phinx\Migration\AbstractMigration;

class AlterarCamposEvt5001Consulta extends AbstractMigration
{

    public function up()
    {
        $this->changeFields();
        $this->changeDicionarioDados();
    }

    public function down()
    {
        $this->revertChangeFields();
        $this->revertChangeDicionarioDados();
    }

    private function changeFields()
    {
        $sql = "
        ALTER TABLE evt5001consulta DROP COLUMN rh218_indapuracao;
        ALTER TABLE evt5001consulta DROP COLUMN rh218_nrrecarqbase;
        ALTER TABLE evt5001consulta DROP COLUMN rh218_tpcr;
        ALTER TABLE evt5001consulta ADD COLUMN rh218_vlrbasecalc float8 NOT NULL default 0;
        ";

        $this->execute($sql);
    }

    private function getCodCam($nomecam)
    {
        $id = $this->fetchRow("SELECT codcam FROM db_syscampo WHERE nomecam = '{$nomecam}'");
        return current($id);
    }

    private function changeDicionarioDados()
    {
        $rh218_indapuracao = $this->getCodCam("rh218_indapuracao");
        $rh218_nrrecarqbase = $this->getCodCam("rh218_nrrecarqbase");
        $rh218_tpcr = $this->getCodCam("rh218_tpcr");
        $sql = "
        DELETE FROM db_sysarqcamp WHERE codcam = {$rh218_indapuracao};
        DELETE FROM db_sysarqcamp WHERE codcam = {$rh218_nrrecarqbase};
        DELETE FROM db_sysarqcamp WHERE codcam = {$rh218_tpcr};

        DELETE FROM db_syscampo WHERE codcam = {$rh218_indapuracao};
        DELETE FROM db_syscampo WHERE codcam = {$rh218_nrrecarqbase};
        DELETE FROM db_syscampo WHERE codcam = {$rh218_tpcr};
        
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh218_vlrbasecalc', 'float8', 'Base Calc Contrib Social', '0', 'Base Calc Contrib Social', 14, false, false, false, 4, 'text', 'Base Calc Contrib Social');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5001consulta'), (select codcam from db_syscampo where nomecam = 'rh218_vlrbasecalc'), 12, 0);
        ";

        $this->execute($sql);
    }

    private function revertChangeFields()
    {
        $sql = "
        ALTER TABLE evt5001consulta ADD COLUMN rh218_indapuracao int4 NOT NULL default 0;
        ALTER TABLE evt5001consulta ADD COLUMN rh218_nrrecarqbase varchar(100) NOT NULL;
        ALTER TABLE evt5001consulta ADD COLUMN rh218_tpcr varchar(10) NOT NULL;
        ALTER TABLE evt5001consulta DROP COLUMN rh218_vlrbasecalc;
        ";

        $this->execute($sql);
    }

    private function revertChangeDicionarioDados()
    {
        $rh218_vlrbasecalc = $this->getCodCam("rh218_vlrbasecalc");
        $sql = "
        DELETE FROM db_sysarqcamp WHERE codcam = {$rh218_vlrbasecalc};
        DELETE FROM db_syscampo WHERE codcam = {$rh218_vlrbasecalc};
        
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh218_indapuracao', 'int4', 'Tipo Período Apuração', '0', 'Tipo Período Apuração', 11, false, false, false, 1, 'text', 'Tipo Período Apuração');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh218_nrrecarqbase', 'varchar(100)', 'Recibo', '', 'Recibo', 100, false, true, false, 0, 'text', 'Recibo');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh218_tpcr', 'varchar(10)', 'Código de Receita', '', 'Código de Receita', 10, false, true, false, 0, 'text', 'Código de Receita');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5001consulta'), (select codcam from db_syscampo where nomecam = 'rh218_indapuracao'), 4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5001consulta'), (select codcam from db_syscampo where nomecam = 'rh218_nrrecarqbase'), 7, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'evt5001consulta'), (select codcam from db_syscampo where nomecam = 'rh218_tpcr'), 8, 0);
        ";

        $this->execute($sql);
    }
}
