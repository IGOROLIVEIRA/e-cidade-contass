<?php

use Phinx\Migration\AbstractMigration;

class AddCampoAmbienteEnvio extends AbstractMigration
{
    
    public function up()
    {
        $sql = "
        ALTER TABLE esocialenvio ADD COLUMN rh213_ambienteenvio int4;

        INSERT INTO configuracoes.db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh213_ambienteenvio', 'int4', 'Ambiente de Envio', 0, 'Ambiente de Envio', 10, false, false, false, 1, 'text', 'Ambiente de Envio');

        INSERT INTO configuracoes.db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'esocialenvio'), (select codcam from db_syscampo where nomecam = 'rh213_ambienteenvio'), 10, 0);
        ";

        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        ALTER TABLE esocialenvio DROP COLUMN rh213_ambienteenvio;

        DELETE FROM configuracoes.db_sysarqcamp WHERE codcam = (select codcam from db_syscampo where nomecam = 'rh213_ambienteenvio');

        DELETE FROM configuracoes.db_syscampo where nomecam = 'rh213_ambienteenvio';
        ";

        $this->execute($sql);
    }
}
