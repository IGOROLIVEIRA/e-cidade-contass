<?php

use Classes\PostgresMigration;

class Oc14765 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        INSERT INTO contrans (c45_seqtrans, c45_anousu, c45_coddoc, c45_instit)
		SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
        	   2021,
            	704,
		        (SELECT codigo
		          FROM db_config
		          WHERE prefeitura = 't')
		WHERE NOT EXISTS
		        (SELECT 1
		         FROM contrans
		         WHERE c45_anousu = 2021
		             AND c45_coddoc = 704
		             AND c45_instit =
		                 (SELECT codigo
		                  FROM db_config
		                  WHERE prefeitura = 't'));


        INSERT INTO conhist (c50_codhist, c50_compl, c50_descr)
            SELECT 	9701,
                    'f',
                    'BAIXA DE BENS PATRIMONIAIS'
                    WHERE NOT EXISTS (SELECT 1 FROM conhist WHERE c50_codhist = 9701);

        INSERT INTO contranslan (c46_seqtranslan, c46_seqtrans, c46_codhist, c46_obs, c46_valor, c46_obrigatorio, c46_evento, c46_descricao, c46_ordem)
                SELECT nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                    (SELECT c45_seqtrans FROM contrans
                        WHERE c45_coddoc = 704
                        AND c45_anousu = 2021
                        LIMIT 1), 
                    9701,
                    'PRIMEIRO LANCAMENTO',
                    0,
                    FALSE,
                    0,
                    'PRIMEIRO LANCAMENTO',
                    1;

               
        COMMIT;

SQL;

        $this->execute($sql);
    }

}