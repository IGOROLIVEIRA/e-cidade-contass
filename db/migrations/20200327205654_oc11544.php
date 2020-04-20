<?php

use Classes\PostgresMigration;

class Oc11544 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        ALTER TABLE naturdessiops DROP CONSTRAINT naturdessiops_c226_natdespecidade_c226_natdespsiops;

        CREATE UNIQUE INDEX naturdessiope_index ON naturdessiope(c222_natdespecidade,c222_natdespsiope,c222_anousu,c222_previdencia);
    
        DROP INDEX naturdessiops_index;

        CREATE UNIQUE INDEX naturdessiops_index ON naturdessiops(c226_natdespecidade, c226_natdespsiops, c226_anousu);
        
        CREATE UNIQUE INDEX eledessiope_index ON eledessiope(c223_eledespecidade, c223_anousu);
        
        ALTER TABLE naturrecsiope DROP CONSTRAINT naturrecsiope_c224_natrececidade_c224_natrecsiope;

        DROP INDEX naturrecsiope_index;
        
        CREATE UNIQUE INDEX naturrecsiope_index ON naturrecsiope(c224_natrececidade,c224_natrecsiope,c224_anousu);

        CREATE UNIQUE INDEX elerecsiope_index ON elerecsiope(c225_elerececidade,c225_anousu);

        CREATE UNIQUE INDEX eledessiops_index ON eledessiops(c227_eledespsiops,c227_anousu);
        
        CREATE UNIQUE INDEX nomearqdessiops_index ON nomearqdessiops(c228_codplanilha,c228_anousu);
        
        CREATE UNIQUE INDEX elerecsiops_index ON elerecsiops(c231_elerecsiops,c231_anousu);
    
        -- REALIZA VIRADA DOS ITENS 2019 PARA 2020
        
        SELECT fc_duplica_exercicio('naturdessiope', 'c222_anousu', 2019, 2020,null);

        SELECT fc_duplica_exercicio('eledessiope', 'c223_anousu', 2019, 2020,null);
        
        SELECT fc_duplica_exercicio('naturrecsiope', 'c224_anousu', 2019, 2020,null);   
        
        SELECT fc_duplica_exercicio('elerecsiope', 'c225_anousu', 2019, 2020,null);   
        
        SELECT fc_duplica_exercicio('naturdessiops', 'c226_anousu', 2019, 2020,null);
        
        SELECT fc_duplica_exercicio('eledessiops', 'c227_anousu', 2019, 2020,null);

        SELECT fc_duplica_exercicio('nomearqdessiops', 'c228_anousu', 2019, 2020,null);
        
        SELECT fc_duplica_exercicio('naturrecsiops', 'c230_anousu', 2019, 2020,null);
        
        SELECT fc_duplica_exercicio('elerecsiops', 'c231_anousu', 2019, 2020,null);

        COMMIT;

SQL;
        $this->execute($sql);
    }

}