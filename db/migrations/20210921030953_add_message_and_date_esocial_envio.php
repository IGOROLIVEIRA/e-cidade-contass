<?php

use Classes\PostgresMigration;

class AddMessageAndDateEsocialEnvio extends PostgresMigration
{
    
    public function up()
    {
        $sql = "
        ALTER TABLE esocialenvio ADD COLUMN rh213_msgretorno text;
        ALTER TABLE esocialenvio ADD COLUMN rh213_dataprocessamento timestamp default null;

        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh213_msgretorno', 'text', 'Mensagem de Retorno', '', 'Mensagem de Retorno', 10, false, true, false, 0, 'text', 'Mensagem de Retorno');
        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh213_dataprocessamento', 'date', 'Data Processamento', 'null', 'Data Processamento', 10, false, false, false, 1, 'text', 'Data Processamento');

        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'esocialenvio'), (select codcam from db_syscampo where nomecam = 'rh213_msgretorno'), 8, 0);
        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'esocialenvio'), (select codcam from db_syscampo where nomecam = 'rh213_dataprocessamento'), 9, 0);
        ";

        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        ALTER TABLE esocialenvio DROP COLUMN rh213_msgretorno;
        ALTER TABLE esocialenvio DROP COLUMN rh213_dataprocessamento;

        DELETE FROM configuracoes.db_sysarqcamp WHERE codcam = (select codcam from db_syscampo where nomecam = 'rh213_msgretorno');
        DELETE FROM configuracoes.db_sysarqcamp WHERE codcam = (select codcam from db_syscampo where nomecam = 'rh213_dataprocessamento');

        DELETE FROM db_syscampo where nomecam = 'rh213_msgretorno';
        DELETE FROM db_syscampo where nomecam = 'rh213_dataprocessamento';
        ";

        $this->execute($sql);
    }
}
