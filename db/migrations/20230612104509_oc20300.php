<?php

use Phinx\Migration\AbstractMigration;

class Oc20300 extends AbstractMigration
{
    public function up()
    {
	$sql = "
		BEGIN;

	        -- Cria a tabela ignora_cgm_tomador, para incluso dos numcgm que sero ignorados na consulta na getDadosTomador.xml
              
        	CREATE TABLE IF NOT EXISTS issqn.ignora_cgm_tomador (numcgm int8 NOT NULL DEFAULT 0, CONSTRAINT ignora_cgm_tomador_numcgm_pk PRIMARY KEY (numcgm));

        
	        -- Inclui numcgms da entidade prefeitura na tabela ignora_cgm_tomador exceto o cgm da prefeitura do parametro db_config
              
        	INSERT INTO issqn.ignora_cgm_tomador (numcgm) 
	        SELECT z01_numcgm FROM cgm 
        	WHERE z01_cgccpf IN (SELECT cgc FROM db_config WHERE prefeitura = true)
        	AND NOT EXISTS (SELECT 1 FROM db_config WHERE prefeitura = true AND z01_numcgm = numcgm)
        	AND NOT EXISTS (SELECT 1 FROM ignora_cgm_tomador WHERE z01_numcgm = numcgm);                 
        
        	COMMIT;
	";
        
	$this->execute($sql);
    }
}
