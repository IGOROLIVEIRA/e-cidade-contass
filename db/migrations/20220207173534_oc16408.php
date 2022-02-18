<?php

use Phinx\Migration\AbstractMigration;

class Oc16408 extends AbstractMigration
{
    public function up()
    { 

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession(); 

        ALTER TABLE emphist ADD COLUMN e40_historico varchar(500);

        ALTER TABLE empempenho ADD COLUMN e60_informacaoop text;

        INSERT INTO db_syscampo
                (codcam,nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
                VALUES
                ((select max(codcam)+1 from db_syscampo),'e40_historico', 'varchar(500)', 'Histórico', '0', 'Histórico', 500, false, true, false, 0, 'text', 'Histórico');

        INSERT INTO db_sysarqcamp 
                (codarq, codcam, seqarq, codsequencia) 
                VALUES 
                ((select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam = 'e40_codhist')),(select codcam from db_syscampo where nomecam = 'e40_historico'),'3','0');
               

        UPDATE db_syscampo 
                SET descricao = 'Cód. Histórico', rotulo = 'Cód. Histórico',rotulorel = 'Cód. Histórico'
                WHERE nomecam = 'e40_codhist';
                
        
        COMMIT;    

SQL;
        $this->execute($sql);
    }
}
