<?php

use Phinx\Migration\AbstractMigration;

class Oc16820 extends AbstractMigration
{
    
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();

        alter table contabancaria disable trigger all;
        update contabancaria set db83_codigoopcredito = 0 where db83_codigoopcredito is null;
        alter table contabancaria enable trigger all;

        ALTER TABLE contabancaria 
        ALTER COLUMN db83_codigoopcredito TYPE INT USING db83_codigoopcredito::integer;
        
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