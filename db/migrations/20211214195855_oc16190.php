<?php

use Phinx\Migration\AbstractMigration;

class Oc16190 extends AbstractMigration
{
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();

        ALTER TABLE contabancaria ADD COLUMN db83_dataassinaturacop varchar(30);
        
        ALTER TABLE contabancaria ADD COLUMN db83_numerocontratooc  date;

        INSERT INTO db_syscampo
        ( codcam,nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
        VALUES
        ('2012669','db83_numerocontratooc', 'varchar(30)', 'Nº do Contrato da Operação de Crédito', '0', 'Nº do Contrato da Operação de Crédito', 30, false, false, false, 1, 'text', 'Nº do Contrato da Operação de Crédito');

        INSERT INTO db_syscampo
        ( codcam,nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
        VALUES
        ('2012670','db83_dataassinaturacop', 'date', 'Data de Assinatura do Contrato OP', '0', 'Data de Assinatura do Contrato OP,', 10, false, false, false, 1, 'text', 'Data de Assinatura do Contrato OP');

        INSERT INTO db_sysarqcamp 
        (codarq, codcam, seqarq, codsequencia) 
        VALUES 
        ('2740','2012670','15','0');

        INSERT INTO db_sysarqcamp 
        (codarq, codcam, seqarq, codsequencia) 
        VALUES 
        ('2740','2012669','14','0');


          COMMIT;

SQL;
        $this->execute($sql);
    }
}
