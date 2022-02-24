<?php

use Phinx\Migration\AbstractMigration;

class Oc16820 extends AbstractMigration 
{
    
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();
        
        CREATE TEMP TABLE temp_contabancaria ON COMMIT DROP AS
        SELECT db83_sequencial,
        CASE
           WHEN db83_codigoopcredito = '' THEN NULL
           ELSE db83_codigoopcredito::int4
        END AS db83_codigoopcredito
        FROM contabancaria;

        ALTER TABLE contabancaria DISABLE TRIGGER ALL;

        UPDATE contabancaria t1
        SET db83_codigoopcredito = t2.db83_codigoopcredito
        FROM temp_contabancaria t2
        JOIN contabancaria t3 ON t2.db83_sequencial = t3.db83_sequencial
        WHERE t1.db83_sequencial = t2.db83_sequencial;

        ALTER TABLE contabancaria ENABLE TRIGGER ALL;

        ALTER TABLE contabancaria ALTER COLUMN db83_codigoopcredito TYPE int4 USING db83_codigoopcredito::int4;
        
        ALTER TABLE contabancaria 
        DROP COLUMN db83_dataassinaturacop ;  
      
        ALTER TABLE contabancaria 
        DROP COLUMN db83_numerocontratooc ;           
              
        ALTER TABLE db_operacaodecredito add unique(op01_sequencial);  
     
        ALTER TABLE contabancaria
        add constraint db83_codigoopcredito foreign key (db83_codigoopcredito)
        references db_operacaodecredito(op01_sequencial);     
        
        INSERT INTO db_syscampo
                (codcam,nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
                VALUES
                ((select max(codcam)+1 from db_syscampo),'db83_codigoopcredito', 'int', 'Operação de Crédito', '0', 'Operação de Crédito', 11, false, false, false, 1, 'text', 'Operação de Crédito');            

        COMMIT;

SQL;
        $this->execute($sql);
    } 
}