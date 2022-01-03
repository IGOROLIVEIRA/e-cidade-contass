<?php

use Phinx\Migration\AbstractMigration;

class AddEscalaJornada extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        INSERT INTO jornadadetrabalho (jt_sequencial,jt_nome,jt_descricao) VALUES
	 (5,'JORNADA I','DE SEGUNDA A SEXTA 08:00 AS 11:30 E DE 13:00 AS 18:00'),
	 (6,'JORNADA II','DE SEGUNDA A SEXTA 07:00 AS 12:00'),
	 (7,'JORNADA III','DE SEGUNDA A SEXTA DE 12:00 AS 18:00'),
	 (8,'JORNADA IV','DE SEGUNDA A SEXTA 13:00 AS 18:00');

        COMMIT;

SQL;
        $this->execute($sql);
    }
}
