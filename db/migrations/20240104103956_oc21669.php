<?php

use Phinx\Migration\AbstractMigration;

class Oc21669 extends AbstractMigration
{
    public function up()
    {
        $sql = "INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'rh01_dtingressocargoefetivo', 'date', 'Data Ingresso Cargo Efetivo', null, 'Data Ingresso Cargo Efetivo', 8, FALSE, FALSE, FALSE, 0, 'text', 'Data Ingresso Cargo Efetivo');
        
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='infocomplementaresinstit' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh01_dtingressocargoefetivo'), 12, 0);

        ALTER TABLE rhpessoal ADD COLUMN rh01_dtingressocargoefetivo date;
        ";

        $this->execute($sql);
    }

    public function down()
    {
        $sql = "DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'rh01_dtingressocargoefetivo');
        DELETE FROM db_syscampo WHERE nomecam = 'rh01_dtingressocargoefetivo';
        ALTER TABLE rhpessoal DROP COLUMN rh01_dtingressocargoefetivo;";

        $this->execute($sql);
    }
}
