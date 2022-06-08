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
        ((select max(codcam)+1 from db_syscampo),'db83_numerocontratooc', 'varchar(30)', 'Nº do Contrato da Operação de Crédito', '0', 'Nº do Contrato da Operação de Crédito', 30, false, false, false, 1, 'text', 'Nº do Contrato da Operação de Crédito');

        INSERT INTO db_syscampo
        ( codcam,nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
        VALUES
        ((select max(codcam)+1 from db_syscampo),'db83_dataassinaturacop', 'date', 'Data de Assinatura do Contrato OP', '0', 'Data de Assinatura do Contrato OP,', 10, false, false, false, 1, 'text', 'Data de Assinatura do Contrato OP');

        INSERT INTO db_sysarqcamp 
        (codarq, codcam, seqarq, codsequencia) 
        VALUES 
        ('2740',(select codcam from db_syscampo where nomecam = 'db83_numerocontratooc'),'14','0');

        INSERT INTO db_sysarqcamp 
        (codarq, codcam, seqarq, codsequencia) 
        VALUES 
        ('2740',(select codcam from db_syscampo where nomecam = 'db83_dataassinaturacop'),'15','0');


          COMMIT;

SQL;
        $this->execute($sql);
    }
}
