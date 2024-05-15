<?php

use Phinx\Migration\AbstractMigration;

class Oc16879 extends AbstractMigration
{
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();
       
        UPDATE configuracoes.db_syscampo
        SET descricao='Código STN Anterior' , rotulo = 'Código STN Anterior', rotulorel = 'Código STN Anterior'
        WHERE nomecam = 'o15_codstn';
	
        ALTER TABLE orctiporec ADD COLUMN o15_codstnnovo int4;	

        INSERT INTO db_syscampo
                (codcam,nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
                VALUES
                ((select max(codcam)+1 from db_syscampo),'o15_codstnnovo', 'int', 'Código STN', '0', 'Código STN', 4, false, false, false, 1, 'text', 'Código STN');   
                
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES (
            (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('o15_codigo') limit 1) order by codarq limit 1)
            , (select codcam from db_syscampo where nomecam = 'o15_codstnnovo')
            , (select max(seqarq)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('o15_codigo') limit 1) order by codarq limit 1))
            , (select max(codsequencia)+1 from db_sysarqcamp where codarq = (select codarq from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam in ('o15_codigo') limit 1) order by codarq limit 1)));
 
        COMMIT;

SQL;
        $this->execute($sql);
    } 
}
